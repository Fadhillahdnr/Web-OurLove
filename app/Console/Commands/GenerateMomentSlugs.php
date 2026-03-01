<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Moment;
use Illuminate\Support\Str;

class GenerateMomentSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moments:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate missing slugs for existing moments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scanning for moments without slug...');

        $count = Moment::whereNull('slug')->count();

        if ($count === 0) {
            $this->info('All moments already have slugs.');
            return 0;
        }

        Moment::whereNull('slug')->get()->each(function ($moment) {
            $baseSlug = Str::slug($moment->title);
            $slug = $baseSlug;
            $counter = 1;

            while (Moment::where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$counter;
                $counter++;
            }

            $moment->slug = $slug;
            $moment->save();
            $this->line("-> Generated slug \"{$slug}\" for moment ID {$moment->id}");
        });

        $this->info("Done. Generated slugs for {$count} moments.");

        return 0;
    }
}
