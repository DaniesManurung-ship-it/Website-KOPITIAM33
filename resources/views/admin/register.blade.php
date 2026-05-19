@extends('layouts.app')

@section('title', 'Daftar Admin - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')
<div class="register-container">
    <div class="register-header">
        <div class="shine-effect"></div>
        <div class="logo-wrapper">
            <div class="logo-circle">
                <span class="logo-text">CK</span>
            </div>
            <h1>Café Kopitiam33</h1>
            <p>Daftar Akun</p>
        </div>
    </div>
    
    <div class="register-body">
        @if($errors->any())
        <div class="alert alert-error">
            <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="form-input" placeholder="Masukkan nama lengkap" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="form-input" placeholder="email@example.com" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password"
                           class="form-input" placeholder="Minimal 6 karakter" required>
                    <button type="button" onclick="togglePassword('password')" class="password-toggle">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-input" placeholder="Ulangi password" required>
                    <button type="button" onclick="togglePassword('password_confirmation')" class="password-toggle">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="register-btn">Daftar Sekarang</button>
        </form>
        
        <div class="register-link">
            <p class="register-text">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="register-link-btn">Login di sini</a>
            </p>
        </div>
    </div>
</div>

<style>
    /* Perbaikan hanya pada bagian register-link */
    .register-link {
        margin-top: 1.75rem;
        padding-top: 1.25rem;
        text-align: center;
        border-top: 1px solid rgba(139, 168, 136, 0.2);
        position: relative;
    }
    
    .register-text {
        color: #6B7280;
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .register-link-btn {
        color: #D97642;
        text-decoration: none;
        font-weight: 600;
        padding: 0.4rem 1rem;
        border-radius: 30px;
        background: rgba(217, 118, 66, 0.1);
        transition: all 0.3s ease;
        display: inline-block;
        font-size: 0.85rem;
    }
    
    .register-link-btn:hover {
        background: #D97642;
        color: white;
        transform: translateX(3px);
        box-shadow: 0 2px 8px rgba(217, 118, 66, 0.3);
    }
    
    /* Responsive Mobile */
    @media (max-width: 768px) {
        .register-text {
            font-size: 0.8rem;
            flex-direction: column;
            gap: 0.6rem;
        }
        
        .register-link-btn {
            padding: 0.35rem 1rem;
            font-size: 0.8rem;
            width: auto;
            min-width: 120px;
        }
    }
    
    @media (max-width: 480px) {
        .register-link {
            margin-top: 1.5rem;
            padding-top: 1rem;
        }
        
        .register-text {
            font-size: 0.75rem;
        }
        
        .register-link-btn {
            padding: 0.3rem 0.9rem;
            font-size: 0.75rem;
            min-width: 110px;
        }
    }
</style>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const type = field.type === 'password' ? 'text' : 'password';
        field.type = type;
    }
</script>
@endsection