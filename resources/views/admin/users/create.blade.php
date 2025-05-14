@extends('layouts.app')

@section('title', 'Add New User')

@section('content')
<div style="margin-top: 100px" class="container create-user-container">
    <h1 class="create-user-title">Add New User</h1>
    <form action="{{ route('admin.users.store') }}" method="POST" class="create-user-form">
        @csrf
        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="is_admin" class="form-label">Role</label>
            <select name="is_admin" id="is_admin" class="form-select">
                <option value="0">User</option>
                <option value="1">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Add User</button>
    </form>
</div>
@endsection

@section('styles')
<style>
    /* General Page Styling */
    .create-user-container {
        max-width: 600px;
        margin: 2rem auto;
        background: #fff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .create-user-title {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: bold;
        color: #555;
        display: block;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 0.5rem;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        outline: none;
    }

    .btn {
        padding: 0.5rem 1rem;
        font-size: 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-success {
        background-color: #28a745;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    .btn-success:active {
        transform: scale(0.95);
    }
</style>
@endsection
