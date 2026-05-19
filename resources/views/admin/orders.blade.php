{{-- resources/views/admin/orders.blade.php --}}
@extends('admin.layouts.sidebar')

@section('title', 'Kelola Pesanan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/orders.css') }}">
@endpush

@section('content')
<div>
    <h1 style="font-family: 'Playfair Display', serif; font-size: 1.75rem; color: var(--wood); margin-bottom: 1.5rem;">Kelola Pesanan</h1>
    
    <div class="stats-grid">
        <div class="stat-card"><div class="stat-number">{{ $statusCount['total'] ?? 0 }}</div><div class="stat-label">Total Pesanan</div></div>
        <div class="stat-card"><div class="stat-number">{{ $statusCount['pending'] ?? 0 }}</div><div class="stat-label">Menunggu</div></div>
        <div class="stat-card"><div class="stat-number">{{ $statusCount['processed'] ?? 0 }}</div><div class="stat-label">Diproses</div></div>
        <div class="stat-card"><div class="stat-number">{{ $statusCount['completed'] ?? 0 }}</div><div class="stat-label">Selesai</div></div>
    </div>
    
    @if(session('success'))
    <div class="alert-success" style="background: #d1fae5; color: #065f46; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem;">{{ session('success') }}</div>
    @endif
    
    <div class="order-table">
        <table>
            <thead>
                <tr><th>ID</th><th>No. Order</th><th>Customer</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->customer_name }}<br><small>{{ $order->customer_email }}</small></td>
                    <td>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                    <td><span class="status-{{ $order->status }}">
                        @if($order->status == 'pending') Menunggu
                        @elseif($order->status == 'processed') Diproses
                        @elseif($order->status == 'completed') Selesai
                        @endif
                    </span></td>
                    <td class="action-buttons">
                        @if($order->status == 'pending')
                            <button class="btn-process" onclick="updateStatus({{ $order->id }}, 'processed')">Proses</button>
                            <button class="btn-cancel" onclick="updateStatus({{ $order->id }}, 'cancelled')">Batalkan</button>
                        @elseif($order->status == 'processed')
                            <button class="btn-complete" onclick="updateStatus({{ $order->id }}, 'completed')">Selesai</button>
                        @endif
                        <button class="btn-delete" onclick="deleteOrder({{ $order->id }})">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align: center;">Belum ada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function updateStatus(id, status) {
        if(confirm(`Ubah status pesanan menjadi ${status}?`)) {
            fetch(`/admin/orders/${id}/status`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ status: status })
            }).then(() => location.reload());
        }
    }
    
    function deleteOrder(id) {
        if(confirm('Yakin ingin menghapus pesanan ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/orders/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection