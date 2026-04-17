{{-- resources/views/reservasi.blade.php --}}
@extends('layouts.app')

@section('title', 'Reservasi - Café Kopitiam33')

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
    
    /* Container */
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* Header Section */
    .reservasi-header {
        background: var(--sage);
        color: white;
        padding: 3rem 0;
        text-align: center;
        position: relative;
    }
    
    /* Tombol Riwayat di Header */
    .history-btn {
        position: absolute;
        top: 50%;
        right: 2rem;
        transform: translateY(-50%);
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }
    
    .history-btn:hover {
        background: rgba(255,255,255,0.3);
    }
    
    @media (max-width: 768px) {
        .history-btn {
            position: static;
            transform: none;
            display: inline-flex;
            margin-top: 1rem;
            justify-content: center;
        }
        
        .reservasi-header .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    }
    
    .reservasi-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .reservasi-header p {
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
        opacity: 0.9;
    }
    
    /* Section Styles */
    .section {
        padding: 4rem 0;
    }
    
    .section-cream {
        background: var(--cream);
    }
    
    .section-white {
        background: white;
    }
    
    /* Status Info Card */
    .status-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .status-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .status-icon {
        width: 48px;
        height: 48px;
        background: rgba(139, 168, 136, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .status-icon svg {
        width: 24px;
        height: 24px;
        color: var(--sage);
    }
    
    .status-title {
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 0.25rem;
    }
    
    .status-text {
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .hours-list {
        margin-top: 0.5rem;
    }
    
    .hours-row {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 0.25rem;
    }
    
    .hours-day {
        font-weight: 500;
        color: var(--wood);
    }
    
    .hours-time {
        color: var(--accent);
        font-weight: 500;
    }
    
    .badge {
        background: rgba(139, 168, 136, 0.1);
        color: var(--sage);
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
    }
    
    /* Form Container */
    .form-wrapper {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .form-header {
        background: linear-gradient(to right, var(--sage), var(--wood));
        padding: 1.5rem 2rem;
    }
    
    .form-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
    }
    
    .form-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    /* Form Styles */
    .form-body {
        padding: 2rem;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .form-grid, .form-grid-3 {
            grid-template-columns: 1fr;
        }
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    
    .required {
        color: #ef4444;
    }
    
    .input-wrapper {
        position: relative;
    }
    
    .input-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }
    
    .input-icon svg {
        width: 20px;
        height: 20px;
        color: var(--sage);
    }
    
    .input-icon-top {
        top: 0.75rem;
        transform: none;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        transition: all 0.2s;
    }
    
    .form-input:focus {
        outline: none;
        border-color: var(--sage);
        box-shadow: 0 0 0 2px rgba(139, 168, 136, 0.2);
    }
    
    .form-input.error {
        border-color: #ef4444;
        background-color: #fef2f2;
    }
    
    textarea.form-input {
        padding-top: 0.75rem;
    }
    
    select.form-input {
        appearance: none;
        background: white;
        cursor: pointer;
    }
    
    /* Error Message */
    .error-message {
        color: #ef4444;
        font-size: 0.7rem;
        margin-top: 0.25rem;
        display: none;
    }
    
    .error-message.show {
        display: block;
    }
    
    /* Alert Success */
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    /* Alert Error */
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    /* Info Box */
    .info-box {
        background: rgba(139, 168, 136, 0.05);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .info-box-content {
        display: flex;
        gap: 1rem;
    }
    
    .info-icon svg {
        width: 24px;
        height: 24px;
        color: var(--sage);
    }
    
    .info-title {
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    
    .info-list {
        list-style: none;
        padding: 0;
    }
    
    .info-list li {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    
    .info-list li::before {
        content: "";
        width: 6px;
        height: 6px;
        background: var(--sage);
        border-radius: 50%;
        margin-right: 0.5rem;
    }
    
    /* Checkbox */
    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        margin-bottom: 1.5rem;
    }
    
    .checkbox-wrapper input {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
    
    .checkbox-wrapper input.error {
        outline: 2px solid #ef4444;
        outline-offset: 2px;
    }
    
    .checkbox-label {
        font-size: 0.875rem;
        color: #374151;
    }
    
    .checkbox-link {
        color: var(--sage);
        text-decoration: none;
        font-weight: 600;
    }
    
    .checkbox-link:hover {
        text-decoration: underline;
    }
    
    /* Submit Button - SAMA UNTUK SEMUA USER (TIDAK ADA PERBEDAAN) */
    .submit-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        color: white;
        padding: 0.9rem 2rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        box-shadow: 0 2px 8px rgba(139, 168, 136, 0.3);
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(139, 168, 136, 0.4);
    }
    
    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-submit svg {
        width: 18px;
        height: 18px;
        stroke: white;
    }
    
    .required-text {
        font-size: 0.75rem;
        color: #9ca3af;
    }
    
    .required-text span {
        color: #ef4444;
    }
    
    /* Contact Section */
    .contact-grid {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }
    
    .contact-card {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .contact-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    .contact-icon {
        width: 40px;
        height: 40px;
        background: rgba(139, 168, 136, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .contact-icon svg {
        width: 20px;
        height: 20px;
        color: var(--sage);
    }
    
    .contact-icon.whatsapp svg {
        color: #25D366;
    }
    
    .contact-text {
        font-weight: 600;
        color: var(--wood);
    }
    
    /* Text Center */
    .text-center {
        text-align: center;
    }
    
    /* Error State */
    .input-error {
        border-color: #ef4444;
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .reservasi-header h1 {
            font-size: 1.75rem;
        }
        
        .reservasi-header p {
            font-size: 0.9rem;
        }
        
        .form-body {
            padding: 1.5rem;
        }
        
        .form-header {
            padding: 1rem 1.5rem;
        }
        
        .hours-row {
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .btn-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<!-- Reservasi Header -->
<section class="reservasi-header">
    <div class="container">
        <h1>📅 Reservasi Meja</h1>
        <p>Pesan meja sekarang dan nikmati pengalaman kuliner Nusantara yang autentik bersama kami</p>
        @auth
        <a href="{{ route('reservasi.history') }}" class="history-btn">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Riwayat Reservasi
        </a>
        @endauth
    </div>
</section>

<!-- Reservasi Form Section -->
<section class="section section-cream">
    <div class="container">
        <div class="form-wrapper" style="max-width: 1152px; margin: 0 auto;">
            <!-- Status Info -->
            <div class="status-card">
                <div class="status-info">
                    <div class="status-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="status-title">Jam Operasional</h3>
                        <div class="hours-list">
                            <div class="hours-row">
                                <span class="hours-day">Senin - Kamis</span>
                                <span class="hours-time">07:00 - 21:00 WIB</span>
                            </div>
                            <div class="hours-row">
                                <span class="hours-day">Jumat - Minggu</span>
                                <span class="hours-time">07:00 - 22:00 WIB</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="badge">Reservasi minimal H-1</span>
                </div>
            </div>

            @if(session('success'))
            <div class="alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $errors->first() }}
            </div>
            @endif

            <!-- Main Form -->
            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Form Reservasi</h2>
                    <p>Isi data dengan lengkap untuk memudahkan konfirmasi</p>
                </div>

                <form class="form-body" id="reservationForm" method="POST" action="{{ route('reservasi.store') }}">
                    @csrf
                    <div class="form-grid">
                        <!-- Nama Lengkap -->
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="name" id="nama" class="form-input" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="error-message" id="error-nama">Nama lengkap harus diisi</div>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" placeholder="email@example.com" required>
                            </div>
                            <div class="error-message" id="error-email">Email harus diisi dengan format yang benar</div>
                        </div>
                    </div>

                    <div class="form-grid">
                        <!-- Nomor Telepon -->
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon/WA <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <input type="tel" name="phone" id="telepon" class="form-input" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" required>
                            </div>
                            <div class="error-message" id="error-telepon">Nomor telepon harus diisi (minimal 10 digit)</div>
                        </div>

                        <!-- Tanggal Reservasi -->
                        <div class="form-group">
                            <label class="form-label">Tanggal Reservasi <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="date" name="date" id="tanggal" class="form-input" value="{{ old('date') }}" required>
                            </div>
                            <div class="error-message" id="error-tanggal">Tanggal reservasi harus diisi (minimal H-1)</div>
                            <p class="status-text mt-1">Reservasi minimal H-1</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <!-- Jam Reservasi - Menggunakan input type time -->
                        <div class="form-group">
                            <label class="form-label">Jam Reservasi <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <input type="time" name="time" id="jam" class="form-input" value="{{ old('time') }}" min="07:00" max="22:00" step="60" required>
                            </div>
                            <div class="error-message" id="error-jam">Jam reservasi harus diisi (07:00 - 22:00 WIB)</div>
                        </div>

                        <!-- Jumlah Orang -->
                        <div class="form-group">
                            <label class="form-label">Jumlah Orang <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <input type="number" name="people" id="jumlah" class="form-input" value="{{ old('people') }}" placeholder="Contoh: 4" min="1" max="20" required>
                            </div>
                            <div class="error-message" id="error-jumlah">Jumlah orang harus diisi (minimal 1, maksimal 20)</div>
                        </div>
                    </div>

                    <div class="form-grid-3">
                        <!-- Tipe Meja -->
                        <div class="form-group">
                            <label class="form-label">Tipe Meja</label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <select name="table_type" id="tipe_meja" class="form-input">
                                    <option value="">Pilih tipe meja</option>
                                    <option value="reguler">Reguler (2-4 orang)</option>
                                    <option value="family">Family (4-6 orang)</option>
                                    <option value="vip">VIP (6-8 orang)</option>
                                    <option value="outdoor">Outdoor (2-4 orang)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Lantai -->
                        <div class="form-group">
                            <label class="form-label">Pilih Lantai</label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <select name="floor" id="lantai" class="form-input">
                                    <option value="">Pilih lantai</option>
                                    <option value="1">Lantai 1</option>
                                    <option value="2">Lantai 2</option>
                                </select>
                            </div>
                        </div>

                        <!-- Catatan Khusus -->
                        <div class="form-group">
                            <label class="form-label">Catatan Khusus</label>
                            <div class="input-wrapper">
                                <div class="input-icon input-icon-top">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <textarea name="notes" id="catatan" rows="2" class="form-input" style="padding-left: 2.5rem;" placeholder="Contoh: Meja dekat jendela, request kursi bayi, alergi makanan, dll."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Info Tambahan -->
                    <div class="info-box">
                        <div class="info-box-content">
                            <div class="info-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="info-title">Informasi Penting:</h4>
                                <ul class="info-list">
                                    <li>Reservasi akan hangus jika tidak hadir lebih dari 30 menit dari jam kedatangan</li>
                                    <li>Konfirmasi akan dikirim dalam 1x24 jam</li>
                                    <li>Pembatalan reservasi maksimal H-2 jam sebelum jam kedatangan</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions - WAJIB DICENTANG -->
                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="terms" id="terms" value="1">
                        <label for="terms" class="checkbox-label">
                            Saya menyetujui <a href="#" class="checkbox-link">syarat dan ketentuan</a> yang berlaku <span class="required">*</span>
                        </label>
                    </div>
                    <div class="error-message" id="error-terms">Anda harus menyetujui syarat dan ketentuan</div>

                    <!-- Submit Button - SAMA UNTUK SEMUA USER (TIDAK ADA PERBEDAAN) -->
                    <div class="submit-section">
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Kirim Reservasi
                        </button>
                        <p class="required-text"><span>*</span> Wajib diisi</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section section-cream">
    <div class="container">
        <div class="text-center" style="max-width: 896px; margin: 0 auto;">
            <h2 class="status-title" style="font-size: 1.875rem; font-family: 'Playfair Display', serif; margin-bottom: 1.5rem;">Butuh Bantuan?</h2>
            <p class="status-text" style="margin-bottom: 2rem;">Jika Anda mengalami kesulitan dalam melakukan reservasi online, silakan hubungi kami melalui:</p>
            
            <div class="contact-grid">
                <a href="https://wa.me/6282160095549" class="contact-card">
                    <div class="contact-icon whatsapp">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824z"/>
                        </svg>
                    </div>
                    <span class="contact-text">+62 821 6009 5549</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date for reservation (H-1)
        const dateInput = document.getElementById('tanggal');
        if (dateInput) {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const formattedDate = tomorrow.toISOString().split('T')[0];
            dateInput.min = formattedDate;
        }
        
        // Validasi form sebelum submit
        const form = document.getElementById('reservationForm');
        
        if (form) {
            form.addEventListener('submit', function(event) {
                let isValid = true;
                
                // Reset error styles
                document.querySelectorAll('.form-input').forEach(input => {
                    input.classList.remove('error');
                });
                document.querySelectorAll('.error-message').forEach(msg => {
                    msg.classList.remove('show');
                });
                document.getElementById('terms')?.classList.remove('error');
                
                // Validasi Nama
                const nama = document.getElementById('nama');
                if (!nama.value.trim()) {
                    nama.classList.add('error');
                    document.getElementById('error-nama').classList.add('show');
                    isValid = false;
                }
                
                // Validasi Email
                const email = document.getElementById('email');
                const emailRegex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
                if (!email.value.trim() || !emailRegex.test(email.value)) {
                    email.classList.add('error');
                    document.getElementById('error-email').classList.add('show');
                    isValid = false;
                }
                
                // Validasi Telepon
                const telepon = document.getElementById('telepon');
                if (!telepon.value.trim() || telepon.value.length < 10) {
                    telepon.classList.add('error');
                    document.getElementById('error-telepon').classList.add('show');
                    isValid = false;
                }
                
                // Validasi Tanggal
                const tanggal = document.getElementById('tanggal');
                if (!tanggal.value) {
                    tanggal.classList.add('error');
                    document.getElementById('error-tanggal').classList.add('show');
                    isValid = false;
                }
                
                // Validasi Jam
                const jam = document.getElementById('jam');
                if (!jam.value) {
                    jam.classList.add('error');
                    document.getElementById('error-jam').classList.add('show');
                    isValid = false;
                }
                
                // Validasi Jumlah Orang
                const jumlah = document.getElementById('jumlah');
                if (!jumlah.value || jumlah.value < 1 || jumlah.value > 20) {
                    jumlah.classList.add('error');
                    document.getElementById('error-jumlah').classList.add('show');
                    isValid = false;
                }
                
                // Validasi Terms & Conditions
                const terms = document.getElementById('terms');
                if (!terms.checked) {
                    terms.classList.add('error');
                    document.getElementById('error-terms').classList.add('show');
                    isValid = false;
                }
                
                if (!isValid) {
                    event.preventDefault();
                    document.querySelector('.form-body').scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        }
    });
</script>
@endpush