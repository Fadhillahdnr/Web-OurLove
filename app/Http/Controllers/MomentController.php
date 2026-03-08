<?php

namespace App\Http\Controllers;

use App\Models\Moment;
use App\Models\MomentMedia;
use App\Models\AnniversaryLog;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MomentController extends Controller
{
    private $startDate;

    public function __construct()
    {
        // tanggal jadian
        $this->startDate = Carbon::createFromDate(2024, 9, 28)->startOfDay();
    }

    /* =====================================================
       INDEX
    ===================================================== */
    public function index()
    {
        $moments = Moment::latest()->get();
        $anniversaries = AnniversaryLog::latest()->get();

        return view('moments.index', compact('moments', 'anniversaries'));
    }

    /* =====================================================
       CREATE (SHOW FORM FOR NEW MOMENT)
    ===================================================== */
    public function create()
    {
        return view('moments.create');
    }

    /* =====================================================
       STORE MOMENT (UPLOAD CLOUDINARY)
    ===================================================== */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:5120',
            'date' => 'required|date',
            'media.*' => 'nullable|file|max:20000'
        ]);

        $slug = $this->generateUniqueSlug($request->title);

        /* =========================
           Upload Thumbnail
        ========================= */
        $thumbnailUpload = cloudinary()->uploadApi()->upload(
            $request->file('image')->getRealPath(),
            [
                'folder' => 'love-website/moments',
                'transformation' => [
                    'quality' => 'auto',
                    'fetch_format' => 'auto',
                    'width' => 1200,
                    'crop' => 'limit'
                ]
            ]
        );

        $moment = Moment::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'image_url' => $thumbnailUpload['secure_url'] ?? $thumbnailUpload['url'],
            'image_public_id' => $thumbnailUpload['public_id'] ?? null,
            'date' => $request->date,
        ]);

        /* =========================
           Upload Multiple Media
        ========================= */
        if ($request->hasFile('media')) {

            foreach ($request->file('media') as $file) {

                $isVideo = str_contains($file->getMimeType(), 'video');

                $upload = cloudinary()->uploadApi()->upload(
                    $file->getRealPath(),
                    [
                        'folder' => 'love-website/moments/media',
                        'resource_type' => $isVideo ? 'video' : 'image',
                        'transformation' => $isVideo ? [] : [
                            'quality' => 'auto',
                            'fetch_format' => 'auto',
                            'width' => 1200,
                            'crop' => 'limit'
                        ]
                    ]
                );

                MomentMedia::create([
                    'moment_id' => $moment->id,
                    'secure_url' => $upload['secure_url'] ?? $upload['url'],
                    'public_id' => $upload['public_id'] ?? null,
                    'resource_type' => $isVideo ? 'video' : 'image',
                    'format' => $upload['format'] ?? null,
                    'bytes' => $upload['bytes'] ?? null,
                ]);
            }
        }

        return redirect()->route('moments.show', $moment->slug)
            ->with('success', 'Moment berhasil ditambahkan 💕');
    }

    /* =====================================================
       SHOW
    ===================================================== */
    public function show($identifier)
    {
        $moment = Moment::with('media')
            ->where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();

        if (empty($moment->slug)) {
            $moment->slug = $this->generateUniqueSlug($moment->title, $moment->id);
            $moment->save();
        }

        return view('moments.show', compact('moment'));
    }

    /* =====================================================
       DELETE MOMENT
    ===================================================== */
    public function destroy(Moment $moment)
    {
        if ($moment->image_public_id) {
            Cloudinary::destroy($moment->image_public_id);
        }

        foreach ($moment->media as $media) {
            if ($media->public_id) {
                Cloudinary::destroy($media->public_id);
            }
        }

        $moment->media()->delete();
        $moment->delete();

        return redirect()->route('moments.index')
            ->with('success', 'Moment berhasil dihapus 💔');
    }

    /* =====================================================
    CELEBRATE MONTHVERSARY (FORM POPUP)
    ===================================================== */
    public function celebrate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'message' => 'nullable|string'
        ]);

        $date = Carbon::parse($request->date)->startOfDay();

        if ($date->day != 28) {
            return redirect()->back()
                ->with('error', 'Monthversary hanya bisa dirayakan tanggal 28 💕');
        }

        
        $monthCount = $this->startDate->diffInMonths($date);

        if ($monthCount < 1) {
            return redirect()->back()
                ->with('error', 'Monthversary pertama dimulai tanggal 28 Oktober 2024 💖');
        }

        
        if (AnniversaryLog::where('month_number', $monthCount)->exists()) {
            return redirect()->back()
                ->with('error', 'Monthversary bulan ini sudah dirayakan 💖');
        }

        AnniversaryLog::create([
            'date' => $date->toDateString(),
            'month_number' => $monthCount,
            'message' => $request->message
                ?? $this->generateAnniversaryMessage($monthCount)
        ]);

        return redirect('/')
            ->with('success', 'Happy Monthversary ke-' . $monthCount . ' 💖');
    }

    /* =====================================================
       GENERATE SLUG
    ===================================================== */
    private function generateUniqueSlug($title, $ignoreId = null)
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Moment::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    /* =====================================================
       DEFAULT ANNIVERSARY MESSAGE
    ===================================================== */
    private function generateAnniversaryMessage($month)
    {
        return "$month bulan sejak 28 September 2024 💖 dan aku masih memilih kamu setiap hari.";
    }
}