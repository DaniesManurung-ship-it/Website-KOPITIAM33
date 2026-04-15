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
            <p>Daftar Akun Admin</p>
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
                Sudah punya akun admin?
                <a href="{{ route('login') }}" class="register-link-btn">Login di sini</a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const type = field.type === 'password' ? 'text' : 'password';
        field.type = type;
    }
</script>
@endsection