{{-- resources/views/testimonial_history.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Testimoni - Café Kopitiam33')

@push('styles')
<style>
    .testimonial-header {
        background: #8BA888 !important;
        background-color: #8BA888 !important;
        color: white !important;
        padding: 3rem 0 !important;
        text-align: center !important;
    }
    
    .testimonial-header h1 {
        font-family: 'Playfair Display', serif !important;
        font-size: 2.5rem !important;
        font-weight: 700 !important;
        margin-bottom: 0.5rem !important;
        color: white !important;
    }
    
    .testimonial-header p {
        font-size: 1rem !important;
        max-width: 600px !important;
        margin: 0 auto !important;
        opacity: 0.9 !important;
        color: white !important;
    }
    
    .testimonial-header::before,
    .testimonial-header::after {
        display: none !important;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    :root {
        --sage: #8BA888;
        --cream: #F5EFE6;
        --wood: #A67B5B;
        --accent: #D97642;
        --border: #E5E7EB;
        --dark: #4A3728;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background: #F5EFE6;
    }
    
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .history-container {
        max-width: 900px;
        margin: 3rem auto;
        padding: 0 1rem;
    }
    
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        border-left: 4px solid #10b981;
    }
    
    .alert-success svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }
    
    .testimonial-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
    }
    
    .testimonial-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        border-color: var(--sage);
    }
    
    .testimonial-header-card {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    
    .rating {
        color: #fbbf24;
        font-size: 1rem;
        letter-spacing: 2px;
    }
    
    .testimonial-date {
        font-size: 0.7rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    
    .testimonial-message {
        color: #374151;
        line-height: 1.6;
        margin-bottom: 1.25rem;
        font-size: 0.9rem;
        font-style: italic;
        background: var(--cream);
        padding: 1rem;
        border-radius: 0.75rem;
        position: relative;
    }
    
    .testimonial-message::before {
        content: '"';
        font-size: 2rem;
        color: var(--sage);
        opacity: 0.3;
        position: absolute;
        top: 0.5rem;
        left: 0.75rem;
        font-family: serif;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }
    
    .btn-edit, .btn-delete {
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-edit {
        background: var(--sage);
        color: white;
    }
    
    .btn-edit:hover {
        background: var(--wood);
        transform: translateY(-1px);
    }
    
    .btn-delete {
        background: #ef4444;
        color: white;
    }
    
    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
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
    
    /* Modal Edit */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    
    .modal.show {
        display: flex;
    }
    
    .modal-content {
        background: white;
        border-radius: 1rem;
        max-width: 500px;
        width: 90%;
        padding: 1.5rem;
    }
    
    .modal-content h3 {
        font-size: 1.25rem;
        color: var(--wood);
        margin-bottom: 1rem;
    }
    
    .modal-content textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 1rem;
    }
    
    .modal-content select {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .modal-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }
    
    .modal-buttons button {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
    }
    
    .btn-save {
        background: var(--sage);
        color: white;
    }
    
    .btn-cancel {
        background: #e5e7eb;
        color: #374151;
    }
    
    @media (max-width: 768px) {
        .testimonial-header h1 {
            font-size: 1.75rem !important;
        }
        
        .testimonial-header p {
            font-size: 0.85rem !important;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-edit, .btn-delete {
            justify-content: center;
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
        <div class="testimonial-card" data-id="{{ $testimonial->id }}">
            <div class="testimonial-header-card">
                <div>
                    <div class="rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating) ★ @else ☆ @endif
                        @endfor
                    </div>
                    <div class="testimonial-date">
                        {{ $testimonial->created_at->translatedFormat('d F Y H:i') }}
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
    function deleteTestimonial(id) {
        if(confirm('Apakah Anda yakin ingin menghapus testimoni ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/testimonial/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
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
    
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('edit_id').value;
        const rating = document.getElementById('edit_rating').value;
        const message = document.getElementById('edit_message').value;
        
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
            if(data.success) {
                location.reload();
            } else {
                alert(data.message || 'Gagal mengupdate testimoni');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
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