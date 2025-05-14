@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<div class="container books-container">
    <h1 class="books-title">Manage Books</h1>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary add-book-btn">Add New Book</a>
    <table class="table books-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ number_format($book->price, 0, '.', ',') }} FCFA</td>
                    <td>{{ $book->stock }}</td>
                    <td>
                        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-container">
        {{ $books->links() }}
    </div>
</div>
@endsection

@section('styles')
<style>
/* General Styles */
.books-container {
    margin-top: 100px;
    padding: 2rem;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.books-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    text-align: center;
    margin-bottom: 2rem;
}

.add-book-btn {
    display: inline-block;
    margin-bottom: 1rem;
    font-size: 1rem;
    font-weight: bold;
    padding: 0.5rem 1rem;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.add-book-btn:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* Table Styles */
.books-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.books-table th,
.books-table td {
    padding: 1rem;
    text-align: left;
    font-size: 0.9rem;
    color: #555;
    border-bottom: 1px solid #ddd;
}

.books-table th {
    background-color: #f4f4f4;
    font-weight: bold;
    color: #333;
}

.books-table tr:hover {
    background-color: #f9f9f9;
    transition: background-color 0.3s ease;
}

.books-table td:last-child {
    text-align: center;
}

/* Button Styles */
.btn {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-warning {
    background-color: #ffc107;
    color: #fff;
    border: none;
}

.btn-warning:hover {
    background-color: #e0a800;
    transform: scale(1.05);
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
    border: none;
}

.btn-danger:hover {
    background-color: #c82333;
    transform: scale(1.05);
}

/* Pagination Styles */
.pagination-container {
    margin-top: 1.5rem;
    text-align: center;
}

.pagination-container .pagination {
    display: inline-flex;
    list-style: none;
    padding: 0;
}

.pagination-container .pagination li {
    margin: 0 0.25rem;
}

.pagination-container .pagination li a,
.pagination-container .pagination li span {
    display: inline-block;
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
    color: #007bff;
    text-decoration: none;
    border: 1px solid #ddd;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.pagination-container .pagination li a:hover {
    background-color: #007bff;
    color: #fff;
}

.pagination-container .pagination li.active span {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .books-table th,
    .books-table td {
        font-size: 0.8rem;
        padding: 0.8rem;
    }

    .books-title {
        font-size: 1.5rem;
    }
}
</style>
@endsection
