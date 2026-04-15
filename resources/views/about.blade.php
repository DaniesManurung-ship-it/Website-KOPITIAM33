{{-- resources/views/gallery.blade.php --}}
@extends('layouts.app')

@section('title', 'Galeri - Café Kopitiam33')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-overlay"></div>
    <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
         alt="Café Interior" 
         class="hero-image">
    
    <div class="container hero-content">
        <h1 class="hero-title">Cerita di Balik Setiap Cangkir</h1>
        <p class="hero-subtitle">
            Sebuah perjalanan rasa yang dimulai dari kecintaan pada warisan kuliner Indonesia
        </p>
    </div>
</section>

<!-- Our Story -->
<section class="section section-white">
    <div class="container max-w-4xl">
        <div class="section-header">
            <h2 class="section-title">Visi & Misi Kami</h2>
            <p class="section-subtitle">
                Menjadi wadah yang menghubungkan tradisi dengan modernitas melalui pengalaman kuliner yang autentik
            </p>
        </div>
        
        <div class="grid-2">
            <!-- Visi Card -->
            <div class="card">
                <div class="card-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
                <h3 class="card-title">Visi</h3>
                <p class="card-text">
                    Menjadi café terdepan yang melestarikan dan memodernisasi kuliner Indonesia, menciptakan pengalaman bersantap yang mengedukasi sekaligus memanjakan.
                </p>
            </div>
            
            <!-- Misi Card -->
            <div class="card">
                <div class="card-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="card-title">Misi</h3>
                <ul class="mission-list">
                    <li>• Menggunakan bahan lokal berkualitas terbaik</li>
                    <li>• Melestarikan resep tradisional dengan sentuhan modern</li>
                    <li>• Menciptakan lingkungan yang nyaman dan inspiratif</li>
                    <li>• Mendukung petani dan produsen lokal</li>
                </ul>
            </div>
        </div>
        
        <!-- Timeline -->
        <div class="timeline">
            <h3 class="section-title" style="font-size: 1.875rem; text-align: center; margin-bottom: 2rem;">Perjalanan Kami</h3>
            
            <div class="space-y-8">
                <div class="timeline-item">
                    <div class="timeline-year">2018</div>
                    <div class="timeline-content">
                        <h4 class="timeline-title">Awal Mula</h4>
                        <p class="timeline-text">
                            Café Kopitiam33 didirikan oleh tiga sahabat yang memiliki kecintaan sama pada kopi dan kuliner Indonesia. Dimulai dari kedai kecil di Kemang dengan 10 meja saja.
                        </p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year sage">2019</div>
                    <div class="timeline-content">
                        <h4 class="timeline-title">Ekspansi Menu</h4>
                        <p class="timeline-text">
                            Mulai memperkenalkan menu makanan berat dengan resep turun-temurun dari berbagai daerah Indonesia. Menerima penghargaan "Best New Café" dari Jakarta Food Guide.
                        </p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year wood">2022</div>
                    <div class="timeline-content">
                        <h4 class="timeline-title">Renovasi & Digitalisasi</h4>
                        <p class="timeline-text">
                            Melakukan renovasi besar-besaran dan meluncurkan sistem pemesanan digital. Konsep "modern Indonesian café" semakin matang dengan desain interior yang lebih hangat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="section section-cream">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Nilai-nilai Kami</h2>
            <p class="section-subtitle">
                Prinsip yang selalu kami pegang dalam setiap langkah dan keputusan
            </p>
        </div>
        
        <div class="grid-3">
            <!-- Cinta -->
            <div class="value-card">
                <div class="value-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="value-title">Cinta</h3>
                <p class="value-text">
                    Setiap hidangan dibuat dengan cinta dan perhatian penuh, karena kami percaya cinta adalah bumbu terbaik.
                </p>
            </div>
            
            <!-- Kualitas -->
            <div class="value-card">
                <div class="value-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <h3 class="value-title">Kualitas</h3>
                <p class="value-text">
                    Hanya bahan terbaik yang kami gunakan. Setiap biji kopi dan setiap rempah dipilih dengan teliti.
                </p>
            </div>
            
            <!-- Keaslian -->
            <div class="value-card">
                <div class="value-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="value-title">Keaslian</h3>
                <p class="value-text">
                    Kami menghormati resep asli dan teknik tradisional, sambil berinovasi dalam penyajian dan pengalaman.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection