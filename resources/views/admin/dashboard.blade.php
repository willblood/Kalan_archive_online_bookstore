@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard container " style="margin-top: 100px; margin-bottom: 100px;">
    <h1 class="dashboard-title">Admin Dashboard</h1>

    <!-- Statistics Section -->
    <div class="dashboard-grid">
        <!-- Total Sales -->
        <div class="dashboard-card">
            <h5 class="card-title">Total Sales</h5>
            <p class="card-value">{{ number_format($data['totalSales'], 0, '.', ',') }} FCFA</p>
        </div>
        <!-- Total Orders -->
        <div class="dashboard-card">
            <h5 class="card-title">Total Orders</h5>
            <p class="card-value">{{ $data['totalOrders'] }}</p>
        </div>
        <!-- Total Users -->
        <div class="dashboard-card">
            <h5 class="card-title">Total Users</h5>
            <p class="card-value">{{ $data['totalUsers'] }}</p>
        </div>
        <!-- Total Products -->
        <div class="dashboard-card">
            <h5 class="card-title">Total Products</h5>
            <p class="card-value">{{ $data['totalProducts'] }}</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div style="margin-top: 10px;" class="dashboard-grid mt-5">
        <!-- Sales Overview -->
        <div class="dashboard-card">
            <h5 class="card-title">Sales Overview</h5>
            <canvas id="salesChart"></canvas>
        </div>
        <!-- Top Products -->
        <div class="dashboard-card">
            <h5 class="card-title">Top Products</h5>
            <canvas id="topProductsChart"></canvas>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="dashboard-grid " style="margin-top: 5px; margin-bottom: 105px;">
        <div class="dashboard-card action-card">
            <h5 class="card-title">Manage Orders</h5>
            <p class="card-description">View and process customer orders.</p>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-light">Go to Orders</a>
        </div>
        <div class="dashboard-card action-card">
            <h5 class="card-title">Manage Products</h5>
            <p class="card-description">Add, edit, or delete products.</p>
            <a href="{{ route('admin.books.index') }}" class="btn btn-light">Go to Products</a>
        </div>
        <div class="dashboard-card action-card">
            <h5 class="card-title">Manage Users</h5>
            <p class="card-description">View and manage user accounts.</p>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light">Go to Users</a>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* General Styles */
.admin-dashboard {
    font-family: 'Arial', sans-serif;
}

.dashboard-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    text-align: center;
    margin-bottom: 2rem;
}

/* Grid Layout */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

/* Dashboard Cards */
.dashboard-card {
    background: white
    color: white;
    border: none;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.card-value {
    font-size: 1.8rem;
    font-weight: bold;
    margin-top: 0.5rem;
}

.card-description {
    font-size: 1rem;
    margin-bottom: 1rem;
}

.action-card .btn {
    background-color: white;
    color:rgb(26, 223, 114);
    font-weight: bold;
    border: 1px solid rgb(26, 223, 114);
    border-radius: 5px;
    padding: 0.5rem 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.action-card .btn:hover {
    background-color:rgb(17, 203, 169);
    color: white;
}

/* Chart Styles */
canvas {
    max-width: 100%;
    height: auto;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($data['salesLabels']) !!},
                datasets: [{
                    label: 'Sales',
                    data: {!! json_encode($data['salesData']) !!},
                    backgroundColor: 'rgba(106, 17, 203, 0.2)',
                    borderColor: '#6a11cb',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Top Products Chart
        const productsCtx = document.getElementById('topProductsChart').getContext('2d');
        const colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
        ]; // Array of colors for the bars

        new Chart(productsCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data['topProductsLabels']) !!},
                datasets: [{
                    label: 'Top Products',
                    data: {!! json_encode($data['topProductsData']) !!},
                    backgroundColor: colors.slice(0, {!! json_encode(count($data['topProductsLabels'])) !!}), // Assign different colors
                    borderColor: colors.slice(0, {!! json_encode(count($data['topProductsLabels'])) !!}),
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection

