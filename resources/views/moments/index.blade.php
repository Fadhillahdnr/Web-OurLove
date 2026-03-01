@extends('layouts.app')

@section('title', 'Relationship Moments')

@section('content')

{{-- ==============================
   MONTHLY CELEBRATION
================================ --}}
@if(now()->day >= 28)
<div id="monthlyCelebration" class="monthly-celebration">
    <div class="celebration-box">
        <h2>🎉 Happy Monthly Anniversary 💖</h2>
        <p class="mt-3">
            Selamat tanggal 28 sayang 💕 <br>
            Terima kasih sudah terus bertahan sejauh ini. <br>
            Semoga kita selalu bersama setiap bulan dan selamanya 🌸
        </p>
        <button onclick="closeCelebration()" class="btn btn-romantic mt-4">
            Tutup 💗
        </button>
    </div>
</div>
@endif

{{-- ==============================
   HERO SECTION (CINEMATIC)
================================ --}}
<section class="hero">
    <div class="hero-content">
        @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
        @endif
        <h4 class="date-text mb-3">28 September</h4>
        <h1 class="main-title mb-3">Our Love Story</h1>
        <p class="subtitle mb-4">Every month, every year, always you 💖</p>

        <a href="#content" class="btn btn-romantic">
            See Our Moments
        </a>
    </div>
</section>

@include('pages.love-letter')

{{-- ==============================
   CONTENT
================================ --}}
<section id="content" class="section container text-center">

    {{-- Countdown Premium --}}
    <div class="fade-in romantic-countdown-section text-center py-5">

        <h2 class="section-title mb-2">
            💗 Menuju Tanggal 28 Berikutnya 💗
        </h2>

        <p class="text-muted mb-4">
            Waktu terus berjalan menuju hari spesial kita ✨
        </p>

        <div class="row justify-content-center mt-4 g-4">

            @foreach(['days'=>'Hari','hours'=>'Jam','minutes'=>'Menit','seconds'=>'Detik'] as $id => $label)
            <div class="col-md-2 col-6">
                <div class="countdown-card">
                    <div id="{{ $id }}" class="count-number">00</div>
                    <small>{{ $label }}</small>
                </div>
            </div>
            @endforeach

        </div>

    </div>

    @include('pages.our-moment')

    <div class="text-center my-5">
        <form action="{{ route('celebrate') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-lg btn-romantic shadow">
                💖 Ucapkan Monthversary
            </button>
        </form>
    </div>

    @include('pages.riwayat-month')
    
</section>


{{-- ==============================
   FLOATING BUTTON
================================ --}}
<a href="/create" class="upload-btn-pink">
    💖 Tambah Moment
</a>


{{-- ==============================
   SCRIPT
================================ --}}
<script>
function closeCelebration() {
    document.getElementById('monthlyCelebration').style.display = 'none';
}

/* Fade In On Scroll */
document.addEventListener("scroll", function() {
    document.querySelectorAll(".fade-in").forEach(el => {
        if (el.getBoundingClientRect().top < window.innerHeight - 100) {
            el.classList.add("show");
        }
    });
});

function getNext28th() {
    const now = new Date();
    let next = new Date(now.getFullYear(), now.getMonth(), 28, 0, 0, 0);

    if (now.getDate() >= 28) {
        next.setMonth(next.getMonth() + 1);
    }

    return next;
}

let nextDate = getNext28th();

function updateCountdown() {

    const now = new Date().getTime();
    const distance = nextDate - now;

    if (distance <= 0) {
        nextDate = getNext28th();
        return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
    const minutes = Math.floor((distance / 1000 / 60) % 60);
    const seconds = Math.floor((distance / 1000) % 60);

    animateNumber("days", days);
    animateNumber("hours", hours);
    animateNumber("minutes", minutes);
    animateNumber("seconds", seconds);
}

function animateNumber(id, value) {
    const el = document.getElementById(id);

    if (el.innerHTML != value) {
        el.classList.add("flip");

        setTimeout(() => {
            el.innerHTML = String(value).padStart(2, '0');
            el.classList.remove("flip");
        }, 150);
    }
}

setInterval(updateCountdown, 1000);
updateCountdown();
</script>

@endsection