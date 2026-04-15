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
    
    /* Color Variables */
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
    
    /* Container */
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
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
        animation: bounce 2s infinite;
    }
    
    .swipe-indicator svg {
        width: 24px;
        height: 24px;
    }
    
    @keyframes bounce {
        0%, 100% {
            transform: translateX(-50%) translateY(0);
        }
        50% {
            transform: translateX(-50%) translateY(10px);
        }
    }
    
    @media (min-width: 768px) {
        .swipe-indicator {
            display: none;
        }
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .about-title {
            font-size: 1.75rem;
        }
        
        .about-image {
            height: 250px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section" id="heroSection">
    <div class="swiper-hero">
        <div class="swiper-wrapper" id="swiperWrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <div class="slide-overlay"></div>
                <img src="{{ asset('images/menu kita.jpeg') }}" alt="Kopi Nusantara" class="slide-image">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 class="hero-title">Cita Rasa <span>Kopitiam33</span></h1>
                        <p class="hero-subtitle">
                            Menyajikan kehangatan dan kelezatan dalam setiap sajian. Dari biji kopi pilihan hingga hidangan tradisional dengan sentuhan modern.
                        </p>
                        <a href="{{ route('menu') }}" class="hero-btn">Jelajahi Menu</a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <div class="slide-overlay"></div>
                <img src="{{ asset('images/nikmat.jpeg') }}" alt="Makanan Tradisional" class="slide-image">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 class="hero-title">Warisan <span>Kuliner</span></h1>
                        <p class="hero-subtitle">
                            Setiap hidangan adalah cerita. Kami menghadirkan resep turun-temurun dengan inovasi yang mengikuti zaman.
                        </p>
                        <a href="{{ route('menu') }}" class="hero-btn">Lihat Spesial Hari Ini</a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <div class="slide-overlay"></div>
                <img src="{{ asset('images/suasana.jpeg') }}" alt="Suasana Café" class="slide-image">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 class="hero-title">Suasana <span>Hangat</span></h1>
                        <p class="hero-subtitle">
                            Tempat di mana cerita bertemu kopi. Nikmati momen terbaik Anda dalam suasana yang cozy dan penuh inspirasi.
                        </p>
                        <a href="{{ route('reservasi') }}" class="hero-btn">Kunjungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pagination Dots -->
        <div class="swiper-pagination" id="paginationDots"></div>
        
        <!-- Swipe Indicator (Mobile only) -->
        <div class="swipe-indicator">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    Café Kopitiam33 lahir dari kecintaan terhadap warisan kuliner Indonesia. Didirikan pada tahun 2020, kami berkomitmen untuk menghadirkan cita rasa autentik dengan sentuhan modern yang sesuai dengan selera masa kini.
                </p>
                <p class="about-text">
                    Setiap hidangan yang kami sajikan adalah hasil dari penelitian mendalam tentang resep tradisional, dipadukan dengan teknik penyajian terkini. Kami percaya bahwa makanan tidak hanya memuaskan lidah, tetapi juga menghubungkan kita dengan budaya dan kenangan.
                </p>
                <a href="{{ route('about') }}" class="about-btn">
                    Kenali Kami Lebih Dekat
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
            <div>
                <img src="{{ asset('images/home/depan.jpeg') }}" alt="Interior Café" class="about-image">
            </div>
        </div>
    </div>
</section>

<script>
    // Hero Slider Data
    const slides = [
        {
            title: 'Cita Rasa <span style="color: var(--accent)">Kopitiam33</span>',
            subtitle: 'Menyajikan kehangatan dan kelezatan dalam setiap sajian. Dari biji kopi pilihan hingga hidangan tradisional dengan sentuhan modern.',
            btnText: 'Jelajahi Menu',
            btnLink: '{{ route("menu") }}',
            image: '{{ asset("images/menu kita.jpeg") }}'
        },
        {
            title: 'Warisan <span style="color: var(--accent)">Kuliner</span>',
            subtitle: 'Setiap hidangan adalah cerita. Kami menghadirkan resep turun-temurun dengan inovasi yang mengikuti zaman.',
            btnText: 'Lihat Spesial Hari Ini',
            btnLink: '{{ route("menu") }}',
            image: '{{ asset("images/nikmat.jpeg") }}'
        },
        {
            title: 'Suasana <span style="color: var(--accent)">Hangat</span>',
            subtitle: 'Tempat di mana cerita bertemu kopi. Nikmati momen terbaik Anda dalam suasana yang cozy dan penuh inspirasi.',
            btnText: 'Kunjungi Kami',
            btnLink: '{{ route("reservasi") }}',
            image: '{{ asset("images/suasana.jpeg") }}'
        }
    ];
    
    // Slider Variables
    let currentIndex = 0;
    let slideInterval;
    const totalSlides = slides.length;
    
    // Touch/Swipe Variables
    let touchStartX = 0;
    let touchEndX = 0;
    let isDragging = false;
    let dragStartX = 0;
    let dragCurrentX = 0;
    
    // DOM Elements
    let swiperWrapper;
    let paginationDots;
    
    function renderSlider() {
        swiperWrapper = document.getElementById('swiperWrapper');
        paginationDots = document.getElementById('paginationDots');
        
        if (!swiperWrapper) return;
        
        // Clear existing content
        swiperWrapper.innerHTML = '';
        paginationDots.innerHTML = '';
        
        // Create slides
        slides.forEach((slide, index) => {
            const slideDiv = document.createElement('div');
            slideDiv.className = 'swiper-slide';
            slideDiv.innerHTML = `
                <div class="slide-overlay"></div>
                <img src="${slide.image}" alt="Slide ${index + 1}" class="slide-image">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 class="hero-title">${slide.title}</h1>
                        <p class="hero-subtitle">${slide.subtitle}</p>
                        <a href="${slide.btnLink}" class="hero-btn">${slide.btnText}</a>
                    </div>
                </div>
            `;
            swiperWrapper.appendChild(slideDiv);
            
            // Create pagination dot
            const dot = document.createElement('div');
            dot.className = 'pagination-dot';
            if (index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(index));
            paginationDots.appendChild(dot);
        });
        
        updateSliderPosition();
        
        // Add touch events for swipe
        initTouchEvents();
        
        startAutoSlide();
    }
    
    function initTouchEvents() {
        // Mouse events for desktop drag
        swiperWrapper.addEventListener('mousedown', onDragStart);
        window.addEventListener('mousemove', onDragMove);
        window.addEventListener('mouseup', onDragEnd);
        
        // Touch events for mobile swipe
        swiperWrapper.addEventListener('touchstart', onTouchStart);
        swiperWrapper.addEventListener('touchmove', onTouchMove);
        swiperWrapper.addEventListener('touchend', onTouchEnd);
    }
    
    function onDragStart(e) {
        isDragging = true;
        dragStartX = e.clientX;
        swiperWrapper.style.transition = 'none';
        e.preventDefault();
    }
    
    function onDragMove(e) {
        if (!isDragging) return;
        dragCurrentX = e.clientX;
        const diff = dragCurrentX - dragStartX;
        const offset = -currentIndex * 100 + (diff / swiperWrapper.offsetWidth) * 100;
        swiperWrapper.style.transform = `translateX(${offset}%)`;
    }
    
    function onDragEnd(e) {
        if (!isDragging) {
            resetAutoSlide();
            return;
        }
        isDragging = false;
        swiperWrapper.style.transition = 'transform 0.5s ease';
        
        const diff = dragCurrentX - dragStartX;
        const threshold = 50;
        
        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                prevSlide();
            } else {
                nextSlide();
            }
        } else {
            updateSliderPosition();
        }
        
        resetAutoSlide();
    }
    
    function onTouchStart(e) {
        touchStartX = e.touches[0].clientX;
        swiperWrapper.style.transition = 'none';
        resetAutoSlide();
    }
    
    function onTouchMove(e) {
        if (!touchStartX) return;
        touchEndX = e.touches[0].clientX;
        const diff = touchEndX - touchStartX;
        const offset = -currentIndex * 100 + (diff / swiperWrapper.offsetWidth) * 100;
        swiperWrapper.style.transform = `translateX(${offset}%)`;
    }
    
    function onTouchEnd() {
        swiperWrapper.style.transition = 'transform 0.5s ease';
        
        if (touchStartX && touchEndX) {
            const diff = touchEndX - touchStartX;
            const threshold = 50;
            
            if (Math.abs(diff) > threshold) {
                if (diff > 0) {
                    prevSlide();
                } else {
                    nextSlide();
                }
            } else {
                updateSliderPosition();
            }
        }
        
        touchStartX = 0;
        touchEndX = 0;
        resetAutoSlide();
    }
    
    function updateSliderPosition() {
        if (!swiperWrapper) return;
        const offset = -currentIndex * 100;
        swiperWrapper.style.transform = `translateX(${offset}%)`;
        swiperWrapper.style.transition = 'transform 0.5s ease';
        
        // Update active dot
        const dots = document.querySelectorAll('.pagination-dot');
        dots.forEach((dot, index) => {
            if (index === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }
    
    function goToSlide(index) {
        currentIndex = index;
        updateSliderPosition();
        resetAutoSlide();
    }
    
    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSliderPosition();
        resetAutoSlide();
    }
    
    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateSliderPosition();
        resetAutoSlide();
    }
    
    function startAutoSlide() {
        slideInterval = setInterval(() => {
            nextSlide();
        }, 5000);
    }
    
    function resetAutoSlide() {
        clearInterval(slideInterval);
        startAutoSlide();
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        renderSlider();
    });
</script>
@endsection