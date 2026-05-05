@extends('layouts.app')

@section('title', 'Testimoni Customer - Café Kopitiam33')

@section('content')
<style>
    /* ==================== COLOR VARIABLES ==================== */
    :root {
        --sage: #8BA888;
        --sage-dark: #6B8A6B;
        --sage-light: #E8F0E6;
        --wood: #A67B5B;
        --wood-dark: #8B5E3C;
        --accent: #D97642;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #2C1810;
        --gray: #6B7280;
        --light: #F5EFE6;
        --white: #FFFFFF;
        --border: #E5E7EB;
        --yellow: #fbbf24;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background: var(--light);
    }
    
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* ==================== HEADER SECTION ==================== */
    .testimonial-header {
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        padding: 3rem 0;
        text-align: center;
        color: white;
    }
    
    .testimonial-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .testimonial-header p {
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
        opacity: 0.9;
    }
    
    /* ==================== ALERT ==================== */
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-left: 4px solid var(--success);
    }
    
    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-left: 4px solid var(--danger);
    }
    
    /* ==================== TESTIMONI GRID ==================== */
    .testimoni-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    .testimoni-card {
        background: var(--white);
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid var(--border);
    }
    
    .testimoni-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        border-color: var(--sage);
    }
    
    /* Rating Bar */
    .rating-bar {
        height: 4px;
        background: linear-gradient(90deg, var(--yellow), var(--yellow) var(--rating), #e5e7eb var(--rating));
        border-radius: 2px;
        margin-bottom: 1rem;
    }
    
    /* User Info */
    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .user-avatar {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    .user-details h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 0.25rem;
    }
    
    .user-date {
        font-size: 0.7rem;
        color: var(--gray);
    }
    
    /* Rating Stars */
    .rating-stars {
        display: flex;
        gap: 0.25rem;
        margin-bottom: 0.75rem;
    }
    
    .star {
        font-size: 1rem;
        color: #d1d5db;
    }
    
    .star.active {
        color: var(--yellow);
    }
    
    /* Message */
    .testimoni-message {
        color: var(--gray);
        line-height: 1.6;
        font-size: 0.85rem;
        font-style: italic;
        margin-top: 0.5rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border);
    }
    
    /* ==================== PAGINATION ==================== */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .pagination a, .pagination span {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        color: var(--wood);
        background: white;
        border: 1px solid var(--border);
        transition: all 0.2s;
        font-size: 0.85rem;
    }
    
    .pagination a:hover {
        background: var(--sage);
        color: white;
        border-color: var(--sage);
    }
    
    .pagination .active span {
        background: var(--sage);
        color: white;
        border-color: var(--sage);
    }
    
    /* ==================== EMPTY STATE ==================== */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-top: 2rem;
    }
    
    .empty-state svg {
        width: 80px;
        height: 80px;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    
    .empty-state h3 {
        font-size: 1.25rem;
        color: var(--wood);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .empty-state p {
        color: #6b7280;
        margin-bottom: 1rem;
    }
    
    .btn-primary {
        background: var(--sage);
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary:hover {
        background: var(--wood);
        transform: translateY(-2px);
    }
    
    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 768px) {
        .testimonial-header h1 {
            font-size: 1.75rem;
        }
        
        .testimoni-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Header Section -->
<section class="testimonial-header">
    <div class="container">
        <h1>💬 Testimoni Customer</h1>
        <p>Apa kata mereka tentang Café Kopitiam33</p>
    </div>
</section>

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
@endsection