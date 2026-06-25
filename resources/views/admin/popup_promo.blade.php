@extends('admin.layouts.sidebar')

@section('title', 'Kelola Pop-up Promo')

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        background: white;
        padding: 20px 24px;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .page-header h1 {
        font-size: 1.5rem;
        color: var(--wood);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }

    .btn-primary {
        background: var(--sage);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: var(--matcha);
        transform: translateY(-1px);
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        padding: 24px;
        margin-bottom: 24px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        background: var(--cream);
        color: var(--wood);
        font-weight: 600;
        padding: 12px 16px;
        text-align: left;
    }

    .table td {
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }

    .promo-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-active { background: #dcfce7; color: #166534; }
    .status-inactive { background: #f3f4f6; color: #4b5563; }

    .action-btns {
        display: flex;
        gap: 8px;
    }

    .btn-edit { background: #fef08a; color: #854d0e; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; }
    .btn-delete { background: #fecaca; color: #991b1b; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; }
    .btn-toggle { background: #e0e7ff; color: #3730a3; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
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
        border-radius: 12px;
        width: 100%;
        max-width: 600px;
        padding: 24px;
        max-height: 90vh;
        overflow-y: auto;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: var(--wood);
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-family: inherit;
    }

    .form-row {
        display: flex;
        gap: 16px;
    }
    .form-col {
        flex: 1;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>
        <span>🎁</span> Kelola Pop-up Promo
    </h1>
    <button class="btn-primary" onclick="openModal('addModal')">
        <span>+</span> Tambah Pop-up
    </button>
</div>

@if(session('success'))
<div style="background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
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
                <tr>
                    <td>
                        @if($promo->image)
                            <img src="{{ asset($promo->image) }}" class="promo-img" alt="Promo" onerror="this.onerror=null; this.style.display='none';">
                        @else
                            <div class="promo-img" style="background:#eee;display:flex;align-items:center;justify-content:center;color:#999;font-size:0.8rem;">No Image</div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600;color:var(--wood);">{{ $promo->title }}</div>
                        <div style="font-size:0.85rem;color:#666;">{{ Str::limit($promo->description, 50) }}</div>
                    </td>
                    <td style="font-size:0.9rem;">
                        {{ \Carbon\Carbon::parse($promo->start_date)->format('d M Y') }} - <br>
                        {{ \Carbon\Carbon::parse($promo->end_date)->format('d M Y') }}
                    </td>
                    <td>
                        <div style="font-weight:bold;color:var(--sage);">KODE: {{ $promo->voucher_code }}</div>
                        <div style="font-size:0.9rem;">Diskon: {{ $promo->discount_percent }}%</div>
                    </td>
                    <td>
                        <span class="status-badge {{ $promo->is_active ? 'status-active' : 'status-inactive' }}" id="status-{{ $promo->id }}">
                            {{ $promo->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-toggle" onclick="toggleStatus({{ $promo->id }})">Toggle</button>
                            <button class="btn-edit" onclick="editPromo({{ json_encode($promo) }})">Edit</button>
                            <form action="{{ route('admin.popup-promo.destroy', $promo->id) }}" method="POST" onsubmit="return confirm('Hapus popup promo ini?');" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:24px;color:#666;">Belum ada pop-up promo.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal" id="addModal">
    <div class="modal-content">
        <h2 style="margin-top:0;margin-bottom:20px;color:var(--wood);">Tambah Pop-up Promo</h2>
        <form action="{{ route('admin.popup-promo.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Judul Promo *</label>
                <input type="text" name="title" class="form-control" required placeholder="Contoh: Promo Akhir Bulan">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat untuk pop-up..."></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group form-col">
                    <label class="form-label">Kode Voucher *</label>
                    <input type="text" name="voucher_code" class="form-control" required placeholder="Contoh: KOPITIAM50">
                </div>
                <div class="form-group form-col">
                    <label class="form-label">Diskon (%) *</label>
                    <input type="number" name="discount_percent" class="form-control" required min="1" max="100" placeholder="Contoh: 20">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group form-col">
                    <label class="form-label">Tanggal Mulai *</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="form-group form-col">
                    <label class="form-label">Tanggal Selesai *</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Gambar Pop-up</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="form-group" style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="is_active" id="isActive" value="1" style="width:18px;height:18px;">
                <label for="isActive" style="font-weight:600;color:var(--wood);cursor:pointer;">Aktifkan Pop-up ini? (Akan menonaktifkan yang lain)</label>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:24px;">
                <button type="button" class="btn-delete" onclick="closeModal('addModal')" style="padding:10px 20px;">Batal</button>
                <button type="submit" class="btn-primary">Simpan Promo</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <h2 style="margin-top:0;margin-bottom:20px;color:var(--wood);">Edit Pop-up Promo</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Judul Promo *</label>
                <input type="text" name="title" id="edit_title" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group form-col">
                    <label class="form-label">Kode Voucher *</label>
                    <input type="text" name="voucher_code" id="edit_voucher_code" class="form-control" required>
                </div>
                <div class="form-group form-col">
                    <label class="form-label">Diskon (%) *</label>
                    <input type="number" name="discount_percent" id="edit_discount_percent" class="form-control" required min="1" max="100">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group form-col">
                    <label class="form-label">Tanggal Mulai *</label>
                    <input type="date" name="start_date" id="edit_start_date" class="form-control" required>
                </div>
                <div class="form-group form-col">
                    <label class="form-label">Tanggal Selesai *</label>
                    <input type="date" name="end_date" id="edit_end_date" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ganti Gambar Pop-up (Opsional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="form-group" style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="is_active" id="edit_isActive" value="1" style="width:18px;height:18px;">
                <label for="edit_isActive" style="font-weight:600;color:var(--wood);cursor:pointer;">Aktifkan Pop-up ini? (Akan menonaktifkan yang lain)</label>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:24px;">
                <button type="button" class="btn-delete" onclick="closeModal('editModal')" style="padding:10px 20px;">Batal</button>
                <button type="submit" class="btn-primary">Update Promo</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.add('show');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function editPromo(promo) {
        document.getElementById('edit_title').value = promo.title;
        document.getElementById('edit_description').value = promo.description || '';
        document.getElementById('edit_voucher_code').value = promo.voucher_code;
        document.getElementById('edit_discount_percent').value = promo.discount_percent;
        document.getElementById('edit_start_date').value = promo.start_date.split('T')[0];
        document.getElementById('edit_end_date').value = promo.end_date.split('T')[0];
        document.getElementById('edit_isActive').checked = promo.is_active;
        
        document.getElementById('editForm').action = `/admin/popup-promo/${promo.id}`;
        openModal('editModal');
    }

    function toggleStatus(id) {
        if(confirm('Ubah status aktif pop-up promo ini? (Akan menonaktifkan yang lain)')) {
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
                if(data.success) {
                    location.reload();
                } else {
                    alert('Gagal mengubah status');
                }
            })
            .catch(err => console.error(err));
        }
    }
</script>
@endsection
