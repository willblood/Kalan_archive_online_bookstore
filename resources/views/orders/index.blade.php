@extends('layouts.app')

@section('title', 'Order History')

@section('content')
    <div style="margin-top: 100px; margin-bottom: 100px;" class="order-history-container container my-5">
        <h1 class="text-center mb-4">Order History</h1>

        @if($orders->isEmpty())
            <div class="text-center">
                <p class="text-muted">You have not placed any orders yet.</p>
                <a href="{{ route('product.index') }}" class="btn btn-primary">Browse Books</a>
            </div>
        @else
            <div class="order-list">
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <h5>Order #{{ $order->id }}</h5>
                            <span class="order-date">{{ $order->created_at->format('F d, Y') }}</span>
                        </div>
                        <div class="order-body">
                            <p><strong>Status:</strong>
                                <span class="badge
                                    {{ $order->status === 'delivered' ? 'badge-green' :
                                       ($order->status === 'pending' ? 'badge-blue' :
                                       ($order->status === 'cancelled' ? 'badge-red' : '')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p><strong>Total Amount:</strong> {{ number_format($order->total_amount, 0, '.', ',') }} FCFA</p>
                            <p><strong>Items:</strong></p>
                            <ul>
                                @foreach($order->orderItems as $item)
                                    <li>
                                        <img src="{{ asset($item->book->image) }}" alt="{{ $item->book->title }}" class="book-image">
                                        {{ $item->book->title }} (x{{ $item->quantity }}) -
                                        {{ number_format($item->price, 0, '.', ',') }} FCFA
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="order-footer">
                            <form action="{{ route('orders.show', $order->id) }}" method="GET" class="d-inline">
                                <button type="submit" class="custom-button">View Details</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('styles')
    <style>
        .order-history-container {
            max-width: 900px;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .order-header h5 {
            margin: 0;
            font-size: 1.2rem;
            color: var(--first-color);
        }

        .order-header .order-date {
            font-size: 0.9rem;
            color: var(--text-color);
        }

        .order-body p {
            margin: 0.5rem 0;
            color: #333;
        }

        .order-body ul {
            padding-left: 1.5rem;
            margin: 0.5rem 0;
        }

        .order-body ul li {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.9rem;
            color: #555;
        }

        .book-image {
            width: 50px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .order-footer {
            text-align: right;
        }

        .order-footer .btn {
            font-size: 0.9rem;
        }

        .badge {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
            border-radius: 0.5rem;
            color: #fff;
            font-weight: bold;
            display: inline-block;
        }

        .badge-blue {
            background-color: #007bff; /* Blue for pending */
        }

        .badge-red {
            background-color: #dc3545; /* Red for cancelled */
        }

        .badge-green {
            background-color: #28a745; /* Green for delivered */
        }

        .custom-button {
            background-color: #007bff; /* Primary blue color */
            color: #fff; /* White text */
            padding: 0.5rem 1rem; /* Padding for the button */
            font-size: 1rem; /* Font size */
            font-weight: bold; /* Bold text */
            border: none; /* Remove border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth transitions */
        }

        .custom-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
            transform: scale(1.05); /* Slightly enlarge the button */
        }

        .custom-button:active {
            background-color: #003f7f; /* Even darker blue on click */
            transform: scale(0.95); /* Slightly shrink the button on click */
        }

        .custom-button:focus {
            outline: none; /* Remove focus outline */
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5); /* Add a focus ring */
        }
    </style>
@endsection
