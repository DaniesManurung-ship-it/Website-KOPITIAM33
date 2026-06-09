@extends('layouts.app')

@section('title', 'Edit Reservasi - Café Kopitiam33')

@push('styles')
<style>
    .edit-container {
        max-width: 900px;
        margin: 2rem auto;
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .edit-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--cream);
    }
    
    .edit-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    
    .edit-header p {
        color: var(--gray);
        font-size: 0.875rem;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    
    .form-label span {
        color: #ef4444;
    }
    
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        background: var(--white);
        border: 2px solid var(--border);
        border-radius: 0.75rem;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: var(--sage);
        box-shadow: 0 0 0 3px rgba(139, 168, 136, 0.2);
    }
    
    /* Style untuk input yang readonly */
    .form-input[readonly] {
        background: #f3f4f6;
        cursor: not-allowed;
        border-color: #e5e7eb;
        color: #6b7280;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 0;
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
        
        .edit-container {
            margin: 1rem;
            padding: 1.5rem;
        }
        
        .edit-header h1 {
            font-size: 1.5rem;
        }
    }
    
    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        color: white;
        padding: 0.875rem;
        border: none;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(139, 168, 136, 0.4);
    }
    
    .btn-back {
        background: linear-gradient(135deg, var(--gray) 0%, #4b5563 100%);
        margin-top: 0.5rem;
        display: block;
        text-align: center;
        text-decoration: none;
    }
    
    .btn-back:hover {
        background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(107, 114, 128, 0.4);
    }
    
    /* Info login */
    .login-info {
        background: #E8F0E6;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.85rem;
        color: var(--wood);
    }
    
    .login-info svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        color: var(--sage);
    }
</style>
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
                <label class="form-label">Tipe Meja</label>
                <select name="table_type" class="form-select">
                    <option value="">Pilih tipe meja</option>
                    <option value="reguler" {{ $reservation->table_type == 'reguler' ? 'selected' : '' }}>🪑 Reguler (2-4 orang)</option>
                    <option value="family" {{ $reservation->table_type == 'family' ? 'selected' : '' }}>👨‍👩‍👧‍👦 Family (4-10 orang)</option>
                    <option value="vip" {{ $reservation->table_type == 'vip' ? 'selected' : '' }}>⭐ VIP (6-8 orang)</option>
                    <option value="outdoor" {{ $reservation->table_type == 'outdoor' ? 'selected' : '' }}>🌿 Outdoor (2-4 orang)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Pilih Lantai</label>
                <select name="floor" class="form-select">
                    <option value="">Pilih lantai</option>
                    <option value="1" {{ $reservation->floor == '1' ? 'selected' : '' }}>🏢 Lantai 1</option>
                    <option value="2" {{ $reservation->floor == '2' ? 'selected' : '' }}>🏢 Lantai 2</option>
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