@extends('admin.layouts.sidebar')

@section('title', 'Reservasi Masuk')

@section('content')
<div>
    <h1 style="font-family: 'Playfair Display', serif; font-size: 1.75rem; color: var(--wood); margin-bottom: 1.5rem;">Reservasi Masuk</h1>
    <p>Halaman reservasi masuk akan ditampilkan di sini</p>
</div>


@push('styles')
<style>
    .reservasi-table { width: 100%; background: white; border-radius: 1rem; overflow: hidden; }
    .reservasi-table th, .reservasi-table td { padding: 1rem; text-align: left; border-bottom: 1px solid #f3f4f6; }
    .reservasi-table th { background: var(--cream); }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #d1fae5; color: #065f46; }
    .status-badge { padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.75rem; }
    .btn-confirm { background: #10b981; color: white; padding: 0.25rem 0.5rem; border: none; border-radius: 0.375rem; cursor: pointer; }
</style>
@endpush

@section('content')
<div>
    <h1 style="font-family: 'Playfair Display', serif; font-size: 1.75rem; color: var(--wood); margin-bottom: 1.5rem;">Reservasi Masuk</h1>
    
    <table class="reservasi-table">
        <thead>
            <tr><th>ID</th><th>Nama</th><th>Email</th><th>Telepon</th><th>Tanggal</th><th>Jam</th><th>Orang</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($reservasiMasuk as $reservasi)
            <tr>
                <td>{{ $reservasi->id }}</td>
                <td>{{ $reservasi->name }}</td>
                <td>{{ $reservasi->email }}</td>
                <td>{{ $reservasi->phone }}</td>
                <td>{{ $reservasi->date }}</td>
                <td>{{ $reservasi->time }}</td>
                <td>{{ $reservasi->people }}</td>
                <td><span class="status-badge status-{{ $reservasi->status }}">{{ ucfirst($reservasi->status) }}</span></td>
                <td><button class="btn-confirm" onclick="confirmReservasi({{ $reservasi->id }})">Konfirmasi</button></td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align: center;">Belum ada reservasi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function confirmReservasi(id) {
        fetch(`/admin/reservasi-masuk/${id}/confirm`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(() => location.reload());
    }
</script>
@endsection