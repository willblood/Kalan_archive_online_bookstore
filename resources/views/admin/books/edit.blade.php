@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
<div class="container edit-book-container">
    <h1 class="edit-book-title">Edit Book</h1>
    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data" class="edit-book-form">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $book->title) }}" required>
        </div>

        <!-- Author -->
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $book->author) }}" required>
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="price">Price (FCFA)</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $book->price) }}" required>
        </div>

        <!-- Stock -->
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $book->stock) }}" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $book->description) }}</textarea>
        </div>

        <!-- eBook -->
        <div class="form-group">
            <label for="e_book">Is this an eBook?</label>
            <select name="e_book" id="e_book" class="form-control">
                <option value="1" {{ old('e_book', $book->e_book) == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('e_book', $book->e_book) == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <!-- Category -->
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" onchange="toggleNewCategoryField()">
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
                <option value="new">Add New Category</option>
            </select>
        </div>

        <div class="form-group" id="new-category-field" style="display: none;">
            <label for="new_category">New Category</label>
            <input type="text" name="new_category" id="new_category" class="form-control" placeholder="Enter new category name">
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Book</button>
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
.edit-book-container {
    margin-top: 100px;
    padding: 2rem;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.edit-book-title {
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
