@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container order-details-container" style="margin-top: 100px; margin-bottom: 100px;">
    <h1 class="order-title">Order #{{ $order->id }}</h1>
    <div class="order-info">
        <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
        <p><strong>Customer Phone:</strong> {{ $order->customer_phone }}</p>
        <p><strong>Customer Email:</strong> {{ $order->customer_email }}</p>
        <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
        <p><strong>Total Amount:</strong> {{ number_format($order->total_amount, 0, '.', ',') }} FCFA</p>
        <p><strong>Status:</strong>
            <span class="status-badge {{ strtolower($order->status) }}">
                {{ ucfirst($order->status) }}
            </span>
        </p>
    </div>

    <h3 class="section-title">Order Items</h3>
    <ul class="order-items-list">
        @foreach ($order->orderItems as $item)
            <li class="order-item">
                <img src="{{ asset($item->book->image) }}" alt="{{ $item->book->title }}" class="book-image">
                <div class="item-details">
                    <p class="item-title">
                        <strong>{{ $item->book->title }}</strong>
                        @if ($item->book->e_book)
                            <span class="ebook-badge">E-Book</span>
                        @endif
                    </p>
                    <p class="item-quantity">Quantity: x{{ $item->quantity }}</p>
                    <p class="item-price">{{ number_format($item->price, 0, '.', ',') }} FCFA</p>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="order-actions">
        @if ($order->status === 'pending')
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="delivered">
                <button type="submit" class="btn btn-success">Mark as Delivered</button>
            </form>
            <form style="margin-top: 20px;" action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="btn btn-danger">Cancel Order</button>
            </form>
        @else
            <p class="text-muted">This order is {{ $order->status }} and cannot be updated.</p>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
/* General Styles */
.order-details-container {
    max-width: 800px;
    margin: 0 auto;
    background: #f9f9f9;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.order-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    text-align: center;
    margin-bottom: 1.5rem;
}

.order-info p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 0.5rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

/* Order Items List */
.order-items-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.order-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    padding: 1rem;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.book-image {
    width: 50px;
    height: 70px;
    object-fit: cover;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.item-details {
    flex: 1;
}

.item-title {
    font-size: 1rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 0.5rem;
}

.item-title .ebook-badge {
    background: #007bff;
    color: #fff;
    font-size: 0.8rem;
    padding: 0.2rem 0.5rem;
    border-radius: 5px;
    margin-left: 0.5rem;
}

.item-quantity,
.item-price {
    font-size: 0.9rem;
    color: #555;
}

.item-price {
    font-weight: bold;
    color: #28a745;
}

/* Status Badge */
.status-badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    font-size: 0.8rem;
    font-weight: bold;
    border-radius: 5px;
    color: #fff;
    text-transform: capitalize;
}

.status-badge.pending {
    background-color: #ffc107; /* Yellow for pending */
}

.status-badge.delivered {
    background-color: #28a745; /* Green for delivered */
}

.status-badge.cancelled {
    background-color: #dc3545; /* Red for cancelled */
}

/* Order Actions */
.order-actions {
    margin-top: 2rem;
    text-align: center;
}

.order-actions .btn {
    padding: 0.5rem 1rem;
    font-size: 1rem;
    font-weight: bold;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.order-actions .btn-success {
    background-color: #28a745;
    color: #fff;
    border: none;
}

.order-actions .btn-success:hover {
    background-color: #218838;
    transform: scale(1.05);
}

.order-actions .btn-danger {
    background-color: #dc3545;
    color: #fff;
    border: none;
}

.order-actions .btn-danger:hover {
    background-color: #c82333;
    transform: scale(1.05);
}
</style>
@endsection
