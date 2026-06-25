@extends('admin.layouts.sidebar')

@section('title', 'Kelola Pop-up Promo')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/popup_promo.css') }}">
@endpush

@section('content')
<div class="admin-page">
<div class="page-header">
    <div class="header-title">
        <h1><span>🎁</span> Kelola Pop-up Promo</h1>
        <button class="btn-add" onclick="openModal('addModal')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pop-up
        </button>
    </div>
    <div class="header-stats">
        <div class="stat-card">
            <div class="stat-number">{{ $promos->count() }}</div>
            <div class="stat-label">Total Promo</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $promos->where('is_active', true)->count() }}</div>
            <div class="stat-label">Aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $promos->where('is_active', false)->count() }}</div>
            <div class="stat-label">Tidak Aktif</div>
        </div>
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

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Info Promo</th>
                    <th>Periode</th>
                    <th>Voucher & Diskon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promos as $promo)
                @php
                    $now = \Carbon\Carbon::now();
                    $start = \Carbon\Carbon::parse($promo->start_date);
                    $end = \Carbon\Carbon::parse($promo->end_date)->endOfDay();
                    if ($now->lt($start)) {
                        $periodStatus = 'upcoming';
                        $periodLabel = 'Akan Datang';
                    } elseif ($now->gt($end)) {
                        $periodStatus = 'expired';
                        $periodLabel = 'Berakhir';
                    } else {
                        $periodStatus = 'ongoing';
                        $periodLabel = 'Berlangsung';
                    }
                @endphp
                <tr>
                    <td>
                        <div class="promo-img-wrapper">
                            @if($promo->image)
                                <img src="{{ asset($promo->image) }}" class="promo-img" alt="{{ $promo->title }}"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="no-image" style="display:none;">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16l5-5a2 2 0 012.83 0l4.17 4.17M14 13l1.17-1.17a2 2 0 012.83 0L21 14M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="no-image">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16l5-5a2 2 0 012.83 0l4.17 4.17M14 13l1.17-1.17a2 2 0 012.83 0L21 14M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="promo-title">{{ $promo->title }}</div>
                        <div class="promo-desc">{{ Str::limit($promo->description, 50) }}</div>
                    </td>
                    <td>
                        <div class="period-dates">
                            {{ \Carbon\Carbon::parse($promo->start_date)->format('d M Y') }}
                            <span class="period-arrow">→</span>
                            {{ \Carbon\Carbon::parse($promo->end_date)->format('d M Y') }}
                        </div>
                        <span class="period-status period-{{ $periodStatus }}">{{ $periodLabel }}</span>
                    </td>
                    <td>
                        <button type="button" class="voucher-code" onclick="copyVoucher(this, '{{ $promo->voucher_code }}')" title="Klik untuk menyalin kode">
                            {{ $promo->voucher_code }}
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                        <br>
                        <span class="discount-tag">{{ $promo->discount_percent }}% OFF</span>
                    </td>
                    <td>
                        <span class="status-badge {{ $promo->is_active ? 'status-active' : 'status-inactive' }}" id="status-{{ $promo->id }}">
                            {{ $promo->is_active ? '● Aktif' : '○ Tidak Aktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-toggle" onclick="toggleStatus({{ $promo->id }})">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                                Toggle
                            </button>
                            <button class="btn-edit" onclick="editPromo({{ json_encode($promo) }})">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </button>
                            <form action="{{ route('admin.popup-promo.destroy', $promo->id) }}" method="POST" onsubmit="return window.customConfirmForm(this, event, 'Hapus popup promo ini?');" class="inline-form">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 80px; height: 80px; margin-bottom: 15px; color: #cbd5e1;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.59 13.41L11 3.83A2 2 0 009.59 3.24L3.24 9.59A2 2 0 003.83 11l9.58 9.58a2 2 0 002.82 0l4.36-4.36a2 2 0 000-2.81zM7 7h.01"/>
                            </svg>
                            <p>Belum ada pop-up promo</p>
                            <button class="btn-add" onclick="openModal('addModal')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Pop-up
                            </button>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Pop-up Promo</h2>
            <button type="button" class="close-modal" onclick="closeModal('addModal')" aria-label="Tutup modal">✕</button>
        </div>
        <form action="{{ route('admin.popup-promo.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Judul Promo <span class="required">*</span></label>
                <input type="text" name="title" class="form-control" required placeholder="Contoh: Promo Akhir Bulan">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat untuk pop-up..."></textarea>
            </div>

            <div class="form-row">
                <div class="form-group form-col">
                    <label class="form-label">Kode Voucher <span class="required">*</span></label>
                    <input type="text" name="voucher_code" class="form-control" required placeholder="Contoh: KOPITIAM50">
                </div>
                <div class="form-group form-col">
                    <label class="form-label">Diskon (%) <span class="required">*</span></label>
                    <input type="number" name="discount_percent" class="form-control" required min="1" max="100" placeholder="Contoh: 20">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group form-col">
                    <label class="form-label">Tanggal Mulai <span class="required">*</span></label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="form-group form-col">
                    <label class="form-label">Tanggal Selesai <span class="required">*</span></label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Gambar Pop-up</label>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'addImagePreview')">
                <img id="addImagePreview" class="preview-image">
            </div>

            <div class="form-group form-check">
                <input type="checkbox" name="is_active" id="isActive" value="1">
                <label for="isActive">Aktifkan Pop-up ini? (Akan menonaktifkan yang lain)</label>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn-primary">Simpan Promo</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Pop-up Promo</h2>
            <button type="button" class="close-modal" onclick="closeModal('editModal')" aria-label="Tutup modal">✕</button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Judul Promo <span class="required">*</span></label>
                <input type="text" name="title" id="edit_title" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-row">
                <div class="form-group form-col">
                    <label class="form-label">Kode Voucher <span class="required">*</span></label>
                    <input type="text" name="voucher_code" id="edit_voucher_code" class="form-control" required>
                </div>
                <div class="form-group form-col">
                    <label class="form-label">Diskon (%) <span class="required">*</span></label>
                    <input type="number" name="discount_percent" id="edit_discount_percent" class="form-control" required min="1" max="100">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group form-col">
                    <label class="form-label">Tanggal Mulai <span class="required">*</span></label>
                    <input type="date" name="start_date" id="edit_start_date" class="form-control" required>
                </div>
                <div class="form-group form-col">
                    <label class="form-label">Tanggal Selesai <span class="required">*</span></label>
                    <input type="date" name="end_date" id="edit_end_date" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ganti Gambar Pop-up (Opsional)</label>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'editImagePreview')">
                <img id="editImagePreview" class="preview-image">
            </div>

            <div class="form-group form-check">
                <input type="checkbox" name="is_active" id="edit_isActive" value="1">
                <label for="edit_isActive">Aktifkan Pop-up ini? (Akan menonaktifkan yang lain)</label>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn-primary">Update Promo</button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.add('show');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    // Klik di luar konten modal untuk menutup
    document.querySelectorAll('.modal').forEach(function(modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal(modal.id);
        });
    });

    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function copyVoucher(btn, code) {
        navigator.clipboard.writeText(code).then(function() {
            const original = btn.innerHTML;
            btn.classList.add('copied');
            btn.innerHTML = '✓ Disalin';
            setTimeout(function() {
                btn.innerHTML = original;
                btn.classList.remove('copied');
            }, 1500);
        });
    }

    function editPromo(promo) {
        document.getElementById('edit_title').value = promo.title;
        document.getElementById('edit_description').value = promo.description || '';
        document.getElementById('edit_voucher_code').value = promo.voucher_code;
        document.getElementById('edit_discount_percent').value = promo.discount_percent;
        document.getElementById('edit_start_date').value = promo.start_date.split('T')[0];
        document.getElementById('edit_end_date').value = promo.end_date.split('T')[0];
        document.getElementById('edit_isActive').checked = promo.is_active;
        document.getElementById('editImagePreview').style.display = 'none';

        document.getElementById('editForm').action = `/admin/popup-promo/${promo.id}`;
        openModal('editModal');
    }

    function toggleStatus(id) {
        window.customConfirmAction('Ubah status aktif pop-up promo ini? (Akan menonaktifkan yang lain)', () => {
            fetch(`/admin/popup-promo/${id}/toggle`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal mengubah status');
                }
            })
            .catch(err => console.error(err));
        });
    }
</script>
@endsection