{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Home - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section" id="heroSection">
    <div class="swiper-hero">
        <div class="swiper-wrapper" id="swiperWrapper">
            
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <div class="slide-overlay"></div>
                <img src="{{ asset('images/menu kita.jpeg') }}" alt="Kopi Nusantara" class="slide-image" fetchpriority="high">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 class="hero-title">Cita Rasa <span>Kopitiam33</span></h1>
                        <p class="hero-subtitle">Nikmati harmoni antara keaslian rasa lokal dan inovasi modern dalam setiap hidangan yang kami sajikan dengan penuh perhatian.</p>
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
                        <p class="hero-subtitle">Setiap hidangan menghadirkan perpaduan cita rasa lokal yang akrab dengan inovasi modern yang mengikuti selera masa kini.</p>
                        <a href="{{ route('menu') }}" class="hero-btn">Lihat Spesial Hari Ini</a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 - Dipersingkat teksnya agar sama tinggi -->
            <div class="swiper-slide">
                <div class="slide-overlay"></div>
                <img src="{{ asset('images/suasana.jpeg') }}" alt="Suasana Café" class="slide-image" loading="eager">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 class="hero-title">Suasana <span>Hangat</span></h1>
                        <p class="hero-subtitle">Hadirkan kenyamanan dalam setiap momen. Tempat terbaik untuk bersantai, berbagi cerita, dan menikmati cita rasa.</p>
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

<!-- About Preview -->
<section class="about-preview">
    <div class="container">
        <div class="about-grid">
            <div>
                <h2 class="about-title">Cerita Kami</h2>
                <p class="about-text">
                    Kopitiam33 lahir dari keinginan untuk menghadirkan pengalaman kuliner yang menggabungkan kehangatan cita rasa lokal dengan sentuhan inovasi modern. Berdiri sejak tahun 2025, kami berkomitmen menyajikan hidangan yang tidak hanya lezat, tetapi juga relevan dengan selera masa kini dan tetap terjangkau bagi semua kalangan.
                </p>
                <p class="about-text">
                Setiap menu kami dikembangkan melalui eksplorasi resep tradisional yang dipadukan dengan pendekatan modern, sehingga menghasilkan cita rasa yang unik namun tetap akrab di lidah. Bagi kami, makanan bukan sekadar sajian, melainkan bagian dari momen kebersamaan—tempat di mana cerita, tawa, dan kenangan tercipta.
                </p>
                <a href="{{ route('about') }}" class="about-btn">
                    Kenali Kami Lebih Dekat
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                    </svg>
                </a>
            </div>
            <div>
                <img src="{{ asset('images/dashboard/depan.jpeg') }}" 
                     alt="Interior Café" 
                     class="about-image" 
                     fetchpriority="high"
                     loading="eager">
            </div>
        </div>
    </div>
</section>

<script>
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

@include('components.promo_popup')
@endsection