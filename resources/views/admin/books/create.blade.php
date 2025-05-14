@extends('layouts.app')

@section('title', 'Create New Book')

@section('content')
<div class="container create-book-container">
    <h1 class="create-book-title">Create New Book</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="create-book-form">
        @csrf

        <!-- Title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <!-- Author -->
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" name="author" id="author" class="form-control" required>
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>

        <!-- Stock -->
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <!-- eBook -->
        <div class="form-group">
            <label for="e_book">Is this an eBook?</label>
            <select name="e_book" id="e_book" class="form-control" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <!-- Category -->
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" onchange="toggleNewCategoryField()">
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-link mt-2">Add a new category</a>
        </div>

        <div class="form-group" id="new-category-field" style="display: none;">
            <label for="new_category">New Category</label>
            <input type="text" name="new_category" id="new_category" class="form-control" placeholder="Enter new category name">
        </div>

        <!-- Image -->
        <div class="form-group">
            <label for="image">Book Image (Optional)</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Book</button>
        </div>
    </form>
</div>

<script>
    function toggleNewCategoryField() {
        const categorySelect = document.getElementById('category_id');
        const newCategoryField = document.getElementById('new-category-field');
        if (categorySelect.value === 'new') {
            newCategoryField.style.display = 'block';
        } else {
            newCategoryField.style.display = 'none';
        }
    }
</script>
@endsection

@section('styles')
<style>
/* General Styles */
.create-book-container {
    margin-top: 100px;
    padding: 2rem;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.create-book-title {
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

.form-control,
.form-control-file {
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
