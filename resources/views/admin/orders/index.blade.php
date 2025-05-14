@extends('layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="orders-container">
    <h1 class="orders-title">Manage Orders</h1>
    <table class="orders-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ number_format($order->total_amount, 0, '.', ',') }} FCFA</td>
                    <td>
                        <!-- Dynamically assign status badge color -->
                        <span class="status-badge {{ strtolower($order->status) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('styles')
<style>
/* General Styles */
.orders-container {
    margin-top: 100px;
    padding: 2rem;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.orders-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    text-align: center;
    margin-bottom: 2rem;
}

/* Table Styles */
.orders-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.orders-table th,
.orders-table td {
    padding: 1rem;
    text-align: left;
    font-size: 0.9rem;
    color: #555;
    border-bottom: 1px solid #ddd;
}

.orders-table th {
    background-color: #f4f4f4;
    font-weight: bold;
    color: #333;
}

.orders-table tr:hover {
    background-color: #f9f9f9;
    transition: background-color 0.3s ease;
}

.orders-table td:last-child {
    text-align: center;
}

/* Status Badge Styles */
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

/* Button Styles */
.btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

.btn-primary:active {
    background-color: #003f7f;
    transform: scale(0.95);
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .orders-table th,
    .orders-table td {
        font-size: 0.8rem;
        padding: 0.8rem;
    }

    .orders-title {
        font-size: 1.5rem;
    }
}
</style>
@endsection
