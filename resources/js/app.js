import './bootstrap';

document.addEventListener("DOMContentLoaded", () => {

    initCountdown();
    initFadeIn();
    initMonthlyCelebration();

});


/* ======================================
   COUNTDOWN TO NEXT 28
====================================== */
function initCountdown() {

    const daysEl = document.getElementById("days");
    const hoursEl = document.getElementById("hours");
    const minutesEl = document.getElementById("minutes");
    const secondsEl = document.getElementById("seconds");

    if (!daysEl || !hoursEl || !minutesEl || !secondsEl) return;

    function getNext28() {
        const now = new Date();
        const next = new Date(now.getFullYear(), now.getMonth(), 28, 0, 0, 0);

        if (now.getDate() >= 28) {
            next.setMonth(next.getMonth() + 1);
        }

        return next.getTime();
    }

    let targetDate = getNext28();

    setInterval(() => {

        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance < 0) {
            targetDate = getNext28();
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((distance / (1000 * 60)) % 60);
        const seconds = Math.floor((distance / 1000) % 60);

        daysEl.textContent = days;
        hoursEl.textContent = hours;
        minutesEl.textContent = minutes;
        secondsEl.textContent = seconds;

    }, 1000);
}


/* ======================================
   FADE IN SCROLL ANIMATION
====================================== */
function initFadeIn() {

    const faders = document.querySelectorAll('.fade-in');
    if (!faders.length) return;

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('show');
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.25 });

    faders.forEach(el => observer.observe(el));
}


/* ======================================
   MONTHLY CELEBRATION SYSTEM
====================================== */
function initMonthlyCelebration() {

    const celebrationBox = document.getElementById("monthlyCelebration");
    if (!celebrationBox) return;

    const today = new Date();
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear();
    const storageKey = `celebration-${currentYear}-${currentMonth}`;

    const isAfter28 = today.getDate() >= 28; 
    // GANTI jadi === 28 kalau mau cuma muncul tepat tanggal 28

    if (isAfter28 && !localStorage.getItem(storageKey)) {
        celebrationBox.style.display = "flex";
        localStorage.setItem(storageKey, "shown");
        launchConfetti();
    } else {
        celebrationBox.style.display = "none";
    }

    window.closeCelebration = () => {
        celebrationBox.style.display = "none";
    };
}


/* ======================================
   CONFETTI EFFECT (UPGRADED)
====================================== */
function launchConfetti() {

    const colors = ["#ff8fab", "#ff5d8f", "#ffd6e7", "#d4af37", "#ffffff"];

    for (let i = 0; i < 70; i++) {

        const confetti = document.createElement("div");
        confetti.className = "confetti";

        confetti.style.left = Math.random() * 100 + "vw";
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.animationDuration = (Math.random() * 3 + 2) + "s";
        confetti.style.opacity = Math.random();

        document.body.appendChild(confetti);

        setTimeout(() => confetti.remove(), 5000);
    }
}

/* ======================================
   NAVBAR SCROLL EFFECT
====================================== */

window.addEventListener("scroll", function () {
    const navbar = document.getElementById("mainNavbar");
    if (!navbar) return;

    if (window.scrollY > 50) {
        navbar.classList.add("navbar-scrolled");
    } else {
        navbar.classList.remove("navbar-scrolled");
    }
});

/* ======================================
   MOBILE TOGGLE
====================================== */

window.toggleMenu = function () {
    const menu = document.getElementById("mobileMenu");
    menu.classList.toggle("show");
};