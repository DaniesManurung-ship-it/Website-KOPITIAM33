{{-- resources/views/testimonial_history.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Testimoni - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/testimonials_history.css') }}">
<style>
    /* Toast Notification Style */
    .toast-notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #10b981;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 9999;
        animation: slideInRight 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .toast-notification.error {
        background: #ef4444;
    }
    
    .toast-notification.warning {
        background: #f59e0b;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
</style>
@endpush

@section('content')
<section class="testimonial-header" style="background: #8BA888 !important; background-color: #8BA888 !important;">
    <div class="container">
        <h1>💬 Riwayat Testimoni</h1>
        <p>Lihat, edit, atau hapus testimoni yang telah Anda berikan</p>
    </div>
</section>

<div class="history-container">
    @if(session('success'))
    <div class="alert-success">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    
    @if($testimonials->count() > 0)
        @foreach($testimonials as $testimonial)
        @php
            $createdAt = \Carbon\Carbon::parse($testimonial->created_at)->setTimezone('Asia/Jakarta');
        @endphp
        <div class="testimonial-card" data-id="{{ $testimonial->id }}">
            <div class="testimonial-header-card">
                <div>
                    <div class="rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating) ★ @else ☆ @endif
                        @endfor
                    </div>
                    <div class="testimonial-date">
                        {{ $createdAt->translatedFormat('d F Y') }} • {{ $createdAt->format('H:i') }} WIB
                    </div>
                </div>
            </div>
            
            <div class="testimonial-message">
                {{ $testimonial->message }}
            </div>
            
            <div class="action-buttons">
                <button class="btn-edit" onclick="openEditModal({{ $testimonial->id }}, '{{ addslashes($testimonial->message) }}', {{ $testimonial->rating }})">
                    ✏️ Edit Testimoni
                </button>
                <button class="btn-delete" onclick="deleteTestimonial({{ $testimonial->id }})">
                    🗑️ Hapus Testimoni
                </button>
            </div>
        </div>
        @endforeach
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            <h3>📭 Belum Ada Testimoni</h3>
            <p>Anda belum memberikan testimoni untuk Kopitiam33</p>
            <small>Klik tombol 💬 di pojok kiri bawah untuk memberikan testimoni</small>
        </div>
    @endif
</div>

<!-- Modal Edit Testimoni -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Edit Testimoni</h3>
        <form id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id" name="id">
            <div class="rating-input">
                <label>Rating:</label>
                <select id="edit_rating" name="rating" style="width: 100%; padding: 0.5rem; margin: 0.5rem 0; border-radius: 0.5rem; border: 1px solid var(--border);">
                    <option value="5">★★★★★ (5)</option>
                    <option value="4">★★★★☆ (4)</option>
                    <option value="3">★★★☆☆ (3)</option>
                    <option value="2">★★☆☆☆ (2)</option>
                    <option value="1">★☆☆☆☆ (1)</option>
                </select>
            </div>
            <textarea id="edit_message" name="message" rows="4" placeholder="Tulis testimoni Anda..." required></textarea>
            <div class="modal-buttons">
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showNotification(message, type = 'success') {
        // Hapus notifikasi yang sudah ada
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) {
            existingToast.remove();
        }
        
        // Buat elemen notifikasi baru
        const toast = document.createElement('div');
        toast.className = `toast-notification ${type === 'success' ? '' : type}`;
        if (type === 'success') {
            toast.innerHTML = `
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>${message}</span>
            `;
        } else if (type === 'error') {
            toast.innerHTML = `
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>${message}</span>
            `;
        } else {
            toast.innerHTML = `
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>${message}</span>
            `;
        }
        
        document.body.appendChild(toast);
        
        // Auto hide setelah 3 detik
        setTimeout(() => {
            toast.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => {
                if (toast.parentNode) toast.remove();
            }, 300);
        }, 3000);
    }
    
    function deleteTestimonial(id) {
        window.customConfirmAction('Apakah Anda yakin ingin menghapus testimoni ini?', () => {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/testimonial/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        });
    }
    
    function openEditModal(id, message, rating) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_message').value = message;
        document.getElementById('edit_rating').value = rating;
        document.getElementById('editModal').classList.add('show');
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.remove('show');
    }
    
    // PERBAIKAN: Edit Form Submission dengan notifikasi
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const id = document.getElementById('edit_id').value;
        const rating = document.getElementById('edit_rating').value;
        const message = document.getElementById('edit_message').value;
        
        // Validasi message minimal 10 karakter
        if (message.trim().length < 10) {
            showNotification('Testimoni minimal 10 karakter!', 'warning');
            return;
        }
        
        // Disable button sementara
        const submitBtn = document.querySelector('#editForm .btn-save');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '⏳ Menyimpan...';
        
        fetch(`/testimonial/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ rating: rating, message: message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tampilkan notifikasi sukses
                showNotification(data.message || 'Testimoni berhasil diupdate!', 'success');
                
                // Tutup modal
                closeEditModal();
                
                // Reload halaman setelah 1 detik agar perubahan terlihat
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showNotification(data.message || 'Gagal mengupdate testimoni', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan: ' + error.message, 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target === modal) {
            closeEditModal();
        }
    }
</script>
@endsection