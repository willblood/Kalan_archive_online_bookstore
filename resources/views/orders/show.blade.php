@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <div style="margin-top: 100px; margin-bottom: 30px;" class="order-details-container container my-5">
        <div class="order-header text-center mb-4">
            <h1 class="order-title">Order #{{ $order->id }}</h1>
            <p class="order-status {{ $order->status === 'completed' ? 'text-success' : 'text-warning' }}">
                <strong>Status:</strong> {{ ucfirst($order->status) }}
            </p>
        </div>

        <div class="order-summary mb-5">
            <h3 class="section-title">Order Summary</h3>
            <div class="summary-details">
                <p><strong>Total Amount:</strong> {{ number_format($order->total_amount, 0, '.', ',') }} FCFA</p>
                <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Customer Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Customer Phone:</strong> {{ $order->customer_phone }}</p>
            </div>
        </div>

        <div class="order-items">
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
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .order-details-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .order-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 1rem;
        }

        .order-title {
            font-size: 2rem;
            color: var(--first-color);
            margin-bottom: 0.5rem;
        }

        .order-status {
            font-size: 1rem;
            font-weight: bold;
        }

        .order-summary {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            color: var(--first-color);
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--first-color);
            display: inline-block;
            padding-bottom: 0.5rem;
        }

        .summary-details p {
            margin: 0.5rem 0;
            font-size: 1rem;
            color: #333;
        }

        .order-items-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #ddd;
        }

        .book-image {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .item-details {
            flex: 1;
        }

        .item-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #000;
            margin-bottom: 0.5rem;
        }

        .item-title .ebook-badge {
            background: var(--first-color);
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
            color: var(--first-color);
        }

        .ebook-badge {
            display: inline-block;
            background-color: #007bff; /* Blue background */
            color: #fff; /* White text */
            font-size: 0.8rem;
            font-weight: bold;
            padding: 0.2rem 0.5rem;
            border-radius: 0.3rem;
            margin-left: 0.5rem;
            text-transform: uppercase;
        }
    </style>
@endsection
