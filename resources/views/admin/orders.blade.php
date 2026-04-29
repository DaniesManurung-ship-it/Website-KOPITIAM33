{{-- resources/views/admin/orders.blade.php --}}
@extends('admin.layouts.sidebar')

@section('title', 'Kelola Pesanan')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: var(--cream);
        border-radius: 0.75rem;
        padding: 1rem;
        text-align: center;
    }
    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--wood);
    }
    .order-table {
        width: 100%;
        background: white;
        border-radius: 1rem;
        overflow-x: auto;
    }
    .order-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .order-table th, .order-table td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #f3f4f6;
    }
    .order-table th {
        background: var(--cream);
    }
    .status-pending { background: #fef3c7; color: #92400e; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem; display: inline-block; }
    .status-processed { background: #dbeafe; color: #1e40af; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem; display: inline-block; }
    .status-completed { background: #d1fae5; color: #065f46; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem; display: inline-block; }
    .status-cancelled { background: #fee2e2; color: #991b1b; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem; display: inline-block; }
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .btn-process, .btn-complete, .btn-cancel, .btn-delete {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        border: none;
        cursor: pointer;
        font-size: 0.7rem;
    }
    .btn-process { background: #3b82f6; color: white; }
    .btn-complete { background: #10b981; color: white; }
    .btn-cancel { background: #ef4444; color: white; }
    .btn-delete { background: #6b7280; color: white; }
</style>
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