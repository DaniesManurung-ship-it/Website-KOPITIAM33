{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Home - Café Kopitiam33')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    :root {
        --sage: #8BA888;
        --cream: #F5EFE6;
        --wood: #A67B5B;
        --accent: #D97642;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background: #F5EFE6;
    }
    
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* Hero Section */
    .hero-section {
        position: relative;
        height: 100vh;
        overflow: hidden;
        background-color: #2a2a2a;
    }
    
    .swiper-hero {
        height: 100%;
        width: 100%;
        position: relative;
    }
    
    .swiper-wrapper {
        display: flex;
        height: 100%;
        width: 100%;
        transition: transform 0.5s ease;
        cursor: grab;
    }
    
    .swiper-wrapper:active {
        cursor: grabbing;
    }
    
    .swiper-slide {
        position: relative;
        flex-shrink: 0;
        width: 100%;
        height: 100%;
    }
    
    .slide-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 10;
    }
    
    .slide-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .slide-content {
        position: absolute;
        inset: 0;
        z-index: 20;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0 1rem;
    }
    
    .slide-text {
        max-width: 768px;
    }
    
    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1.5rem;
    }
    
    .hero-title span {
        color: var(--accent);
    }
    
    .hero-subtitle {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .hero-btn {
        display: inline-block;
        background: var(--accent);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .hero-btn:hover {
        background: var(--wood);
    }
    
    /* Pagination Dots */
    .swiper-pagination {
        position: absolute;
        bottom: 20px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 10px;
        z-index: 30;
    }
    
    .pagination-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .pagination-dot.active {
        background: var(--accent);
        width: 12px;
        height: 12px;
    }
    
    /* About Preview */
    .about-preview {
        padding: 4rem 0;
        background: rgba(139, 168, 136, 0.1);
    }
    
    .about-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
        align-items: center;
    }
    
    @media (min-width: 1024px) {
        .about-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    .about-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.25rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 1.5rem;
    }
    
    .about-text {
        color: #374151;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    
    .about-btn {
        display: inline-flex;
        align-items: center;
        background: var(--wood);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .about-btn:hover {
        background: var(--sage);
    }
    
    .about-btn svg {
        width: 20px;
        height: 20px;
        margin-left: 0.5rem;
    }
    
    .about-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        /* Hilangkan efek fade/transition biar langsung muncul */
    }
    
    /* Touch indicator */
    .swipe-indicator {
        position: absolute;
        bottom: 80px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 30;
        text-align: center;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.75rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }
    
    @media (min-width: 768px) {
        .swipe-indicator { display: none; }
    }
    
    @media (max-width: 640px) {
        .hero-title { font-size: 2rem; }
        .hero-subtitle { font-size: 1rem; }
        .about-title { font-size: 1.75rem; }
        .about-image { height: 250px; }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section" id="heroSection">
    <div class="swiper-hero">
        <div class="swiper-wrapper" id="swiperWrapper">
            
            <!-- Slide 1: Gambar pertama prioritas tinggi -->
            <div class="swiper-slide">
                <div class="slide-overlay"></div>
                <img src="{{ asset('images/makanan.jpeg') }}" alt="Kopi Nusantara" class="slide-image" fetchpriority="high">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 class="hero-title">Cita Rasa <span>Kopitiam33</span></h1>
                        <p class="hero-subtitle">Menyajikan kehangatan dan kelezatan dalam setiap sajian. Dari biji kopi pilihan hingga hidangan tradisional dengan sentuhan modern.</p>
                        <a href="{{ route('menu') }}" class="hero-btn">Jelajahi Menu</a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <div class="slide-overlay"></div>
                <img src="{{ asset('images/nikmat.jpeg') }}" alt="Makanan Tradisional" class="slide-image" loading="eager">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 class="hero-title">Warisan <span>Kuliner</span></h1>
                        <p class="hero-subtitle">Setiap hidangan adalah cerita. Kami menghadirkan resep turun-temurun dengan inovasi yang mengikuti zaman.</p>
                        <a href="{{ route('menu') }}" class="hero-btn">Lihat Spesial Hari Ini</a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <div class="slide-overlay"></div>
                <img src="{{ asset('images/suasana.jpeg') }}" alt="Suasana Café" class="slide-image" loading="eager">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 class="hero-title">Suasana <span>Hangat</span></h1>
                        <p class="hero-subtitle">Tempat di mana cerita bertemu kopi. Nikmati momen terbaik Anda dalam suasana yang cozy dan penuh inspirasi.</p>
                        <a href="{{ route('reservasi') }}" class="hero-btn">Kunjungi Kami</a>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="swiper-pagination" id="paginationDots">
            <div class="pagination-dot active" onclick="goToSlide(0)"></div>
            <div class="pagination-dot" onclick="goToSlide(1)"></div>
            <div class="pagination-dot" onclick="goToSlide(2)"></div>
        </div>
        
        <div class="swipe-indicator">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
            </svg>
            <span>Geser untuk melihat</span>
        </div>
    </div>
</section>

<!-- About Preview - GAMBAR BAWAH LANGSUNG DIMUAT -->
<section class="about-preview">
    <div class="container">
        <div class="about-grid">
            <div>
                <h2 class="about-title">Cerita Kami</h2>
                <p class="about-text">
                    Café Kopitiam33 lahir dari kecintaan terhadap warisan kuliner Indonesia. Didirikan pada tahun 2020, kami berkomitmen untuk menghadirkan cita rasa autentik dengan sentuhan modern yang sesuai dengan selera masa kini.
                </p>
                <p class="about-text">
                    Setiap hidangan yang kami sajikan adalah hasil dari penelitian mendalam tentang resep tradisional, dipadukan dengan teknik penyajian terkini. Kami percaya bahwa makanan tidak hanya memuaskan lidah, tetapi juga menghubungkan kita dengan budaya dan kenangan.
                </p>
                <a href="{{ route('about') }}" class="about-btn">
                    Kenali Kami Lebih Dekat
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
            <div>
                <!-- GANTI: loading="lazy" DIHAPUS, ganti dengan fetchpriority dan eager -->
                <img src="{{ asset('images/home/depan.jpeg') }}" 
                     alt="Interior Café" 
                     class="about-image" 
                     fetchpriority="high"
                     loading="eager">
            </div>
        </div>
    </div>
</section>

<script>
    // JS MURNI STANDAR TANPA OVER-ENGINEERING
    (function() {
        const swiperWrapper = document.getElementById('swiperWrapper');
        const dots = document.querySelectorAll('.pagination-dot');
        const totalSlides = 3;
        
        let currentIndex = 0;
        let slideInterval;
        
        if (!swiperWrapper) return;
        
        function updateSliderPosition() {
            swiperWrapper.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
            
            dots.forEach(function(dot, index) {
                if (index === currentIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }
        
        window.goToSlide = function(index) {
            currentIndex = index;
            updateSliderPosition();
            resetAutoSlide();
        };
        
        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSliderPosition();
        }
        
        function startAutoSlide() {
            if (slideInterval) clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, 5000);
        }
        
        function resetAutoSlide() {
            clearInterval(slideInterval);
            startAutoSlide();
        }
        
        updateSliderPosition();
        startAutoSlide();
    })();
</script>
@endsection