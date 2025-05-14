<!-- filepath: resources/views/orders/success.blade.php -->
@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
    <div style="margin-top: 150px;" class="success-container text-center">
        <h1>Order Placed Successfully!</h1>
        <p>Thank you for your purchase. Your order has been placed successfully.</p>
        <button onclick="window.location='{{ route('home.index') }}'" class="btn btn-primary mt-3">Return to Home</button>
    </div>
@endsection

@section('styles')
    <style>
        .success-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--container-color);
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .success-container h1 {
            color: var(--first-color);
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .success-container p {
            color: var(--text-color);
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .success-container .btn {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            background-color: var(--first-color);
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .success-container .btn:hover {
            background-color: var(--first-color-alt);
            transform: scale(1.05);
        }

        .success-container .btn:active {
            transform: scale(0.95);
        }
    </style>
@endsection
