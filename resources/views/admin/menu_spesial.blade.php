{{-- resources/views/admin/menu_spesial.blade.php --}}
@extends('admin.layouts.sidebar')

@section('title', 'Menu Spesial')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/menu_spesial.css') }}">
@endpush

@section('content')
<div>
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-title">
            <h1>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                Menu Spesial
            </h1>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-number">{{ $spesialMenus->count() }}</div>
                <div class="stat-label">Total Menu</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $spesialMenus->where('is_featured', true)->count() }}</div>
                <div class="stat-label">Menu Unggulan</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $spesialMenus->where('is_available', true)->count() }}</div>
                <div class="stat-label">Tersedia</div>
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
    
    <!-- Table Section -->
    <div class="table-container">
        <table class="menu-table">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="10%">Gambar</th>
                    <th width="20%">Nama Menu</th>
                    <th width="20%">Deskripsi</th>
                    <th width="10%">Harga</th>
                    <th width="10%">Badge</th>
                    <th width="10%">Status</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($spesialMenus as $menu)
                <tr>
                    <td>#{{ $menu->id }}</td>
                    <td>
                        <div class="menu-image-wrapper">
                            @if($menu->image)
                                <img src="{{ asset($menu->image) }}" class="menu-image" alt="{{ $menu->name }}" onerror="this.src='/uploads/default/default-menu.jpg'">
                            @else
                                <div class="no-image">No Image</div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <strong style="color: var(--wood);">{{ $menu->name }}</strong>
                        @if($menu->is_featured)
                            <div style="margin-top: 0.25rem;">
                                <span class="badge-menu">⭐ Unggulan</span>
                            </div>
                        @endif
                    </td>
                    <td class="desc-text" title="{{ $menu->description }}">{{ Str::limit($menu->description, 60) ?? '-' }}</td>
                    <td class="price">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td>
                        @if($menu->badge)
                            <span class="active-badge" style="background: linear-gradient(135deg, var(--accent) 0%, var(--wood) 100%);">
                                {{ $menu->badge }}
                            </span>
                        @else
                            <span class="badge-menu">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="{{ $menu->is_available ? 'active-badge' : 'inactive-badge' }}">
                            {{ $menu->is_available ? '● Tersedia' : '○ Tidak Tersedia' }}
                        </span>
                    </td>
                    <td class="action-buttons">
                        <button class="btn-featured" onclick="toggleFeatured({{ $menu->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            {{ $menu->is_featured ? 'Hapus Unggulan' : 'Jadikan Unggulan' }}
                        </button>
                        <button class="btn-toggle" onclick="toggleStatus({{ $menu->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            {{ $menu->is_available ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            <p>Belum ada menu spesial</p>
                            <a href="{{ route('admin.menu.index') }}" class="btn-add" style="margin-top: 1rem; display: inline-flex; text-decoration: none;">+ Tambah Menu Spesial di Kelola Menu</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleFeatured(id) {
        if(confirm('Ubah status unggulan menu ini?')) {
            fetch(`/admin/menu-spesial/${id}/toggle-featured`, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    }
    
    function toggleStatus(id) {
        if(confirm('Ubah status ketersediaan menu ini?')) {
            fetch(`/admin/menu-spesial/${id}/toggle-status`, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    }
</script>
@endsection