@extends('layouts.app')

@section('title', 'Edit Reservasi - Café Kopitiam33')

@push('styles')
<style>
    .edit-container {
        max-width: 800px;
        margin: 3rem auto;
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .edit-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .edit-header h1 {
        font-family: 'Playfair Display', serif;
        color: var(--wood);
        font-size: 1.75rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--wood);
        margin-bottom: 0.25rem;
    }
    
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-family: 'Poppins', sans-serif;
    }
    
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: var(--sage);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .btn-submit {
        width: 100%;
        background: var(--accent);
        color: white;
        padding: 0.75rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1rem;
    }
    
    .btn-submit:hover {
        background: var(--wood);
    }
    
    .btn-back {
        background: #6b7280;
        margin-top: 0.5rem;
    }
    
    .btn-back:hover {
        background: #4b5563;
    }
    
    @media (max-width: 640px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .edit-container {
            padding: 1.5rem;
            margin: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="edit-container">
    <div class="edit-header">
        <h1>Edit Reservasi</h1>
        <p>Perbarui data reservasi Anda</p>
    </div>
    
    <form method="POST" action="{{ route('reservasi.update', $reservation->id) }}">
        @csrf
        @method('PUT')
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $reservation->name) }}" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-input" value="{{ old('email', $reservation->email) }}" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Nomor Telepon/WA *</label>
                <input type="tel" name="phone" class="form-input" value="{{ old('phone', $reservation->phone) }}" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Reservasi *</label>
                <input type="date" name="date" class="form-input" value="{{ old('date', $reservation->date) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Jam Reservasi *</label>
                <select name="time" class="form-select" required>
                    <option value="">Pilih jam</option>
                    <option value="10:00" {{ $reservation->time == '10:00' ? 'selected' : '' }}>10:00 WIB</option>
                    <option value="11:00" {{ $reservation->time == '11:00' ? 'selected' : '' }}>11:00 WIB</option>
                    <option value="12:00" {{ $reservation->time == '12:00' ? 'selected' : '' }}>12:00 WIB</option>
                    <option value="13:00" {{ $reservation->time == '13:00' ? 'selected' : '' }}>13:00 WIB</option>
                    <option value="14:00" {{ $reservation->time == '14:00' ? 'selected' : '' }}>14:00 WIB</option>
                    <option value="15:00" {{ $reservation->time == '15:00' ? 'selected' : '' }}>15:00 WIB</option>
                    <option value="16:00" {{ $reservation->time == '16:00' ? 'selected' : '' }}>16:00 WIB</option>
                    <option value="17:00" {{ $reservation->time == '17:00' ? 'selected' : '' }}>17:00 WIB</option>
                    <option value="18:00" {{ $reservation->time == '18:00' ? 'selected' : '' }}>18:00 WIB</option>
                    <option value="19:00" {{ $reservation->time == '19:00' ? 'selected' : '' }}>19:00 WIB</option>
                    <option value="20:00" {{ $reservation->time == '20:00' ? 'selected' : '' }}>20:00 WIB</option>
                    <option value="21:00" {{ $reservation->time == '21:00' ? 'selected' : '' }}>21:00 WIB</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Jumlah Orang *</label>
                <input type="number" name="people" class="form-input" value="{{ old('people', $reservation->people) }}" min="1" max="20" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Tipe Meja</label>
                <select name="table_type" class="form-select">
                    <option value="">Pilih tipe meja</option>
                    <option value="reguler" {{ $reservation->table_type == 'reguler' ? 'selected' : '' }}>Reguler (2-4 orang)</option>
                    <option value="family" {{ $reservation->table_type == 'family' ? 'selected' : '' }}>Family (4-6 orang)</option>
                    <option value="vip" {{ $reservation->table_type == 'vip' ? 'selected' : '' }}>VIP (6-8 orang)</option>
                    <option value="outdoor" {{ $reservation->table_type == 'outdoor' ? 'selected' : '' }}>Outdoor (2-4 orang)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Pilih Lantai</label>
                <select name="floor" class="form-select">
                    <option value="">Pilih lantai</option>
                    <option value="1" {{ $reservation->floor == '1' ? 'selected' : '' }}>Lantai 1</option>
                    <option value="2" {{ $reservation->floor == '2' ? 'selected' : '' }}>Lantai 2</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Catatan Khusus</label>
            <textarea name="notes" class="form-textarea" rows="3" placeholder="Contoh: Meja dekat jendela, request kursi bayi, alergi makanan, dll.">{{ old('notes', $reservation->notes) }}</textarea>
        </div>
        
        <button type="submit" class="btn-submit">Simpan Perubahan</button>
        <a href="{{ route('reservasi.history') }}" class="btn-submit btn-back" style="display: block; text-align: center; text-decoration: none;">Kembali</a>
    </form>
</div>
@endsection