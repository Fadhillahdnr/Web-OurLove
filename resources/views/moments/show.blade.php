@extends('layouts.app')

@section('title', $moment->title)

@section('content')

<style>

/* =============================
   BACKGROUND
============================= */
.romantic-bg {
    background: linear-gradient(180deg, #fff 0%, #fff6fa 100%);
    min-height: 100vh;
}

/* =============================
   HERO SECTION (CINEMATIC)
============================= */
.hero-moment {
    position: relative;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.12);
}

.hero-moment img {
    width: 100%;
    height: 480px;
    object-fit: cover;
    transition: transform 0.8s ease;
    filter: brightness(0.9);
}

.hero-moment:hover img {
    transform: scale(1.05);
}

.hero-overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 60px 40px 40px;
    background: linear-gradient(to top, rgba(0,0,0,0.65), transparent);
    color: white;
}

.hero-overlay h1 {
    font-weight: 700;
    font-size: 2.3rem;
    letter-spacing: 0.5px;
}

.hero-overlay p {
    opacity: 0.9;
}

/* =============================
   GLASS DESCRIPTION
============================= */
.glass-card {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    box-shadow: 0 20px 50px rgba(232, 62, 140, 0.08);
}

.glass-card h4 {
    font-weight: 600;
    color: #e83e8c;
}

.glass-card p {
    color: #555;
    line-height: 1.8;
}

/* =============================
   GALLERY GRID
============================= */
.media-box {
    position: relative;
    overflow: hidden;
    border-radius: 22px;
    transition: all 0.4s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.media-box img,
.media-box video {
    width: 100%;
    height: 280px;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.media-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.media-box:hover img,
.media-box:hover video {
    transform: scale(1.07);
}

/* =============================
   BUTTON
============================= */
.btn-romantic-back {
    border-radius: 40px;
    padding: 12px 35px;
    font-weight: 500;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-romantic-back:hover {
    background-color: #e83e8c;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(232,62,140,0.3);
}

</style>


<div class="romantic-bg py-5">

    <div class="container">

        {{-- HERO --}}
        <div class="hero-moment mb-5">

            <img src="{{ $moment->image_url }}" alt="{{ $moment->title }}">

            <div class="hero-overlay">
                <h1>{{ $moment->title }} 💖</h1>
                <p>
                    {{ \Carbon\Carbon::parse($moment->date)->translatedFormat('d F Y') }}
                </p>
            </div>

        </div>


        {{-- DESCRIPTION --}}
        <div class="glass-card p-5 mb-5 text-center">
            <h4 class="mb-3">Cerita Moment Ini ✨</h4>
            <p class="fs-5 mb-0">
                {{ $moment->description }}
            </p>
        </div>


        {{-- GALLERY --}}
        @if($moment->media->count() > 0)
        <div class="mb-5">

            <h3 class="text-center fw-bold mb-4" style="color:#e83e8c;">
                Galeri Kenangan 📸
            </h3>

            <div class="row g-4">
                @foreach($moment->media as $media)

                <div class="col-lg-4 col-md-6">
                    <div class="media-box">

                        @if($media->resource_type === 'image')
                            <img src="{{ $media->secure_url }}" alt="">
                        @else
                            <video controls>
                                <source src="{{ $media->secure_url }}">
                            </video>
                        @endif

                    </div>
                </div>

                @endforeach
            </div>

        </div>
        @endif


        {{-- BACK BUTTON --}}
        <div class="text-center mt-5">
            <a href="{{ url('/') }}" 
               class="btn btn-outline-danger btn-romantic-back">
               ⬅ Kembali ke Semua Moment
            </a>
        </div>

    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const videos = document.querySelectorAll("video");

    videos.forEach(video => {
        video.addEventListener("play", function () {

            videos.forEach(otherVideo => {
                if (otherVideo !== video) {
                    otherVideo.pause();
                    otherVideo.currentTime = 0; // reset ke awal
                }
            });

        });
    });

});
</script>

@endsection