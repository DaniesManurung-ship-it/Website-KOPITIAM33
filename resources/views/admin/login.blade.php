{{-- resources/views/admin/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Login - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div x-data="loginManager()" x-init="init" class="login-container">
    <div class="login-header">
        <div class="shine-effect"></div>
        <div class="logo-wrapper">
            <div class="logo-circle">
                <span class="logo-text">CK</span>
            </div>
            <h1>Café Kopitiam33</h1>
            <p>Login</p>
        </div>
    </div>
    
    <div class="login-body">
        @if($errors->any())
        <div class="alert alert-error">
            <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="form-input" placeholder="email@example.com" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password"
                           class="form-input" placeholder="••••••••" required>
                    <button type="button" onclick="togglePassword()" class="password-toggle">
                        <svg id="eyeIcon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="remember-section">
                <div class="checkbox-wrapper">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" class="checkbox-label">Ingat saya</label>
                </div>
                <a href="#" class="forgot-link">Lupa password?</a>
            </div>
            
            <button type="submit" class="login-btn">Login</button>
        </form>
        
        <div class="register-link">
            <p class="register-text">
                Belum punya akun?
                <a href="{{ route('register') }}" class="register-link-btn">Daftar di sini</a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const type = password.type === 'password' ? 'text' : 'password';
        password.type = type;
    }
</script>
@endsection