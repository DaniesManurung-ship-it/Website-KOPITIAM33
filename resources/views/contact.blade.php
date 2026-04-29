{{-- resources/views/contact.blade.php --}}
@extends('layouts.app')

@section('title', 'Kontak & Lokasi - Café Kopitiam33')

@push('styles')
<style>
    /* ==================== CONTACT PAGE STYLES ==================== */
    
    /* Header */
    .contact-header {
        background: var(--sage);
        color: white;
        padding: 3rem 0;
        text-align: center;
    }
    
    .contact-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .contact-header p {
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
        opacity: 0.9;
    }
    
    /* Section */
    .section {
        padding: 3rem 0;
    }
    
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* Contact Grid */
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    @media (min-width: 1024px) {
        .contact-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    /* Contact Info */
    .contact-info-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 1.5rem;
    }
    
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .info-item {
        display: flex;
        gap: 1rem;
        background: white;
        padding: 1.25rem;
        border-radius: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .info-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    .info-icon {
        width: 48px;
        height: 48px;
        background: var(--cream);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .info-icon svg {
        width: 24px;
        height: 24px;
        color: var(--sage);
    }
    
    .info-content {
        flex: 1;
    }
    
    .info-content h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    
    .info-content p {
        font-size: 0.875rem;
        color: #6b7280;
        line-height: 1.5;
    }
    
    /* Hours List - PERBAIKAN */
    .hours-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .hours-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.875rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px dashed #f3f4f6;
    }
    
    .hours-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .hours-day {
        font-weight: 500;
        color: var(--wood);
    }
    
    .hours-time {
        font-weight: 500;
        color: var(--accent);
        background: rgba(217, 118, 66, 0.1);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
    }
    
    /* Contact Details */
    .contact-details {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .contact-detail {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        color: #6b7280;
        padding: 0.5rem 0;
        border-bottom: 1px dashed #f3f4f6;
    }
    
    .contact-detail:last-child {
        border-bottom: none;
    }
    
    .contact-detail svg {
        width: 18px;
        height: 18px;
        color: var(--sage);
        flex-shrink: 0;
    }
    
    .contact-detail a {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .contact-detail a:hover {
        color: var(--accent);
    }
    
    /* Social Icons */
    .social-icons {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }
    
    .social-link {
        width: 36px;
        height: 36px;
        background: var(--cream);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    
    .social-link svg {
        width: 18px;
        height: 18px;
        color: var(--wood);
    }
    
    .social-link:hover {
        background: var(--sage);
        transform: translateY(-2px);
    }
    
    .social-link:hover svg {
        color: white;
    }
    
    /* Map Card */
    .map-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .map-container {
        position: relative;
        height: 300px;
        overflow: hidden;
    }
    
    .map-container iframe {
        width: 100%;
        height: 100%;
    }
    
    .map-info {
        padding: 1.25rem;
    }
    
    .map-info h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 0.75rem;
    }
    
    .transport-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .transport-list li {
        font-size: 0.8rem;
        color: #6b7280;
        padding: 0.25rem 0;
    }
    
    .transport-list .transport-label {
        font-weight: 600;
        color: var(--wood);
        min-width: 80px;
        display: inline-block;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .contact-header h1 {
            font-size: 1.75rem;
        }
        
        .contact-info-title {
            font-size: 1.5rem;
        }
        
        .info-item {
            padding: 1rem;
        }
        
        .hours-row {
            font-size: 0.75rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .hours-time {
            font-size: 0.7rem;
        }
        
        .map-container {
            height: 250px;
        }
        
        .contact-detail {
            font-size: 0.75rem;
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@section('content')
<!-- Contact Header -->
<section class="contact-header">
    <div class="container">
        <h1>📍 Kontak & Lokasi</h1>
        <p>Temukan kami, hubungi kami, atau kunjungi langsung untuk pengalaman terbaik</p>
    </div>
</section>

<!-- Contact & Map -->
<section class="section">
    <div class="container">
        <div class="contact-grid">
            
            <!-- Contact Information -->
            <div>
                <h2 class="contact-info-title">Informasi Kontak</h2>
                
                <div class="info-list">
                    <!-- Address -->
                    <div class="info-item">
                        <div class="info-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h3>Alamat</h3>
                            <p>
                                Jl. Patuan Nagari No.5, Sangkar<br>
                                Nihuta, Kec. Balige, Toba,<br>
                                Sumatera Utara 22312
                            </p>
                        </div>
                    </div>
                    
                    <!-- Hours - DIPERBAIKI -->
                    <div class="info-item">
                        <div class="info-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h3>Jam Operasional</h3>
                            <div class="hours-list">
                                <div class="hours-row">
                                    <span class="hours-day">Senin - Kamis</span>
                                    <span class="hours-time">07:00 - 21:00</span>
                                </div>
                                <div class="hours-row">
                                    <span class="hours-day">Jumat - Minggu</span>
                                    <span class="hours-time">07:00 - 22:00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact -->
                    <div class="info-item">
                        <div class="info-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h3>Kontak</h3>
                            <div class="contact-details">
                                <div class="contact-detail">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <a href="tel:+6212112345678">Telepon: (021) 1234-5678</a>
                                </div>
                                <div class="contact-detail">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <a href="mailto:hello@kopitiam33.id">Email: hello@kopitiam33.id</a>
                                </div>
                                <div class="contact-detail">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <a href="https://wa.me/6282160095549">WhatsApp: 0821-6009-5549</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div class="info-item">
                        <div class="info-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h3>Media Sosial</h3>
                            <div class="social-icons">
                                <a href="https://www.instagram.com/kopitiam33_balige/" class="social-link">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Map -->
            <div>
                <div class="map-card">
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3993.422540444156!2d99.05918500271856!3d2.3339716534016244!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e05007a128991%3A0x8bb38c04a1ed9e0d!2sKopitiam%2033!5e0!3m2!1sid!2sid!4v1776233287814!5m2!1sid!2sid" 
                            width="100%" 
                            height="300" 
                            style="border:0; display: block;" 
                            allowfullscreen="" 
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <div class="map-info">
                        <h3>Akses Transportasi</h3>
                        <ul class="transport-list">
                            <li> <span class="transport-label">Parkir:</span> Tersedia area parkir untuk mobil</li>
                            <li> <span class="transport-label">Motor:</span> Area parkir motor di depan café</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection