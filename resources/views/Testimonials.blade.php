@extends('layouts.app')

@section('title', 'Testimoni Customer - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/testimonials.css') }}">
@endpush

@section('content')
<!-- HEADER - SAMA PERSIS DENGAN CART (background solid #8BA888 dengan !important) -->
<section class="testimonial-header">
    <div class="container">
        <h1>💬 Testimoni Customer</h1>
        <p>Apa kata mereka tentang Café Kopitiam33</p>
    </div>
</section>

<!-- SECTION CONTENT -->
<section class="testimonial-section">
    <div class="container">
        @if(session('success'))
        <div class="alert-success">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert-error">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif
        
        @if($testimonials->count() > 0)
        <div class="testimoni-grid">
            @foreach($testimonials as $testimonial)
            @php
                $createdAt = \Carbon\Carbon::parse($testimonial->created_at)->setTimezone('Asia/Jakarta');
                $ratingPercent = ($testimonial->rating / 5) * 100;
            @endphp
            <div class="testimoni-card">
                <div class="rating-bar" style="--rating: {{ $ratingPercent }}%"></div>
                
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <h4>{{ $testimonial->name }}</h4>
                        <div class="user-date">
                            {{ $createdAt->translatedFormat('d F Y') }} • {{ $createdAt->format('H:i') }} WIB
                        </div>
                    </div>
                </div>
                
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $testimonial->rating ? 'active' : '' }}">★</span>
                    @endfor
                </div>
                
                <p class="testimoni-message">"{{ $testimonial->message }}"</p>
            </div>
            @endforeach
        </div>
        
        <div class="pagination">
            {{ $testimonials->links() }}
        </div>
        @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <h3>Belum Ada Testimoni</h3>
            <p>Saat ini belum ada testimoni dari customer. Kunjungi Café Kopitiam33 dan bagikan pengalaman Anda!</p>
        </div>
        @endif
    </div>
</section>
@endsection