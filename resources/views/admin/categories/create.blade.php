@extends('layouts.app')

@section('title', 'Create New Category')

@section('content')
<div class="container create-category-container">
    <h1 class="create-category-title">Create New Category</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('admin.categories.store') }}" method="POST" class="create-category-form">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description (Optional)</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Category</button>
        </div>
    </form>

    <a href="{{ route('admin.books.create') }}" class="btn btn-link mt-3">Back to Create Book</a>
</div>
@endsection

@section('styles')
<style>
/* General Styles */
.create-category-container {
    margin-top: 100px;
    padding: 2rem;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.create-category-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    text-align: center;
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: bold;
    color: #555;
    display: block;
    margin-bottom: 0.5rem;
}

.form-control {
    width: 100%;
    padding: 0.5rem;
    font-size: 1rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    outline: none;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}
</style>
@endsection
