@extends('layouts.app')

@section('title', 'Edit Reservasi - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reservasi_edit.css') }}">
@endpush

@section('content')
<div class="edit-container">
    <div class="edit-header">
        <h1>✏️ Edit Reservasi</h1>
        <p>Perbarui data reservasi Anda</p>
    </div>
    
    <!-- Info Login -->
    <div class="login-info">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        <span>Anda mengedit reservasi atas nama: <strong>{{ $reservation->name }}</strong></span>
    </div>
    
    <form method="POST" action="{{ route('reservasi.update', $reservation->id) }}">
        @csrf
        @method('PUT')
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Nama Lengkap <span>*</span></label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $reservation->name) }}" readonly disabled>
            </div>
            
            <div class="form-group">
                <label class="form-label">Email <span>*</span></label>
                <input type="email" name="email" class="form-input" value="{{ old('email', $reservation->email) }}" readonly disabled>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Nomor Telepon/WA <span>*</span></label>
                <input type="tel" name="phone" class="form-input" value="{{ old('phone', $reservation->phone) }}" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Reservasi <span>*</span></label>
                <input type="date" name="date" class="form-input" value="{{ old('date', $reservation->date) }}" min="{{ date('Y-m-d') }}" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Jam Reservasi <span>*</span></label>
                <!-- PERBAIKAN: Menggunakan input type time seperti halaman reservasi -->
                <input type="time" name="time" class="form-input" value="{{ old('time', $reservation->time) }}" min="07:00" max="22:00" required>
                <small style="color: var(--gray); font-size: 0.7rem; display: block; margin-top: 0.25rem;">
                    ⏰ Jam operasional: 07:00 - 22:00 WIB
                </small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Jumlah Orang <span>*</span></label>
                <input type="number" name="people" class="form-input" value="{{ old('people', $reservation->people) }}" min="1" max="20" required>
                <small style="color: var(--gray); font-size: 0.7rem; display: block; margin-top: 0.25rem;">
                    👥 Maksimal 20 orang per reservasi
                </small>
            </div>
        </div>
        
        <div class="form-row">            
            <div class="form-group">
                <label class="form-label">Pilih Lantai</label>
                <select name="floor" class="form-select">
                    <option value="">Pilih lantai</option>
                    <option value="1" {{ $reservation->floor == '1' ? 'selected' : '' }}> Lantai 1</option>
                    <option value="2" {{ $reservation->floor == '2' ? 'selected' : '' }}> Lantai 2</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Catatan Khusus</label>
            <textarea name="notes" class="form-textarea" rows="3" placeholder="Contoh: Meja dekat jendela, request kursi bayi, alergi makanan, dll.">{{ old('notes', $reservation->notes) }}</textarea>
        </div>
        
        <button type="submit" class="btn-submit">💾 Simpan Perubahan</button>
        <a href="{{ route('reservasi.history') }}" class="btn-submit btn-back">← Kembali ke Riwayat</a>
    </form>
</div>
@endsection