@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div style="margin-top: 100px; margin-bottom: 100px;" class="container">
    <h1 class="page-title">Manage Users</h1>
    <div class="actions">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
        <form action="{{ route('admin.users.index') }}" method="GET" class="search-form">
            <input type="text" name="search" class="search-input" placeholder="Search users..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">Search</button>
        </form>
    </div>
    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->is_admin ? 'badge-admin' : 'badge-user' }}">
                            {{ $user->is_admin ? 'Admin' : 'User' }}
                        </span>
                    </td>
                    <td>
                        <a style="margin-bottom: 10px;" href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                        <button class="btn btn-danger delete-btn" data-id="{{ $user->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal hidden">
    <div class="modal-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this user?</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
            <button type="button" class="btn btn-secondary close-modal">Cancel</button>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* General Page Styling */


    .page-title {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .search-form {
        display: flex;
        gap: 0.5rem;
    }

    .search-input {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        font-size: 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #fff;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* Table Styling */
    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .user-table th,
    .user-table td {
        text-align: center;
        padding: 0.75rem;
        border: 1px solid #ddd;
    }

    .user-table th {
        background-color: #333;
        color: #fff;
        font-weight: bold;
    }

    .user-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .user-table tr:hover {
        background-color: #f1f1f1;
    }

    /* Badge Styling */
    .badge {
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-size: 0.9rem;
        color: #fff;
    }

    .badge-admin {
        background-color: #28a745;
    }

    .badge-user {
        background-color: #6c757d;
    }

    /* Modal Styling */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal.hidden {
        display: none;
    }

    .modal-content {
        background: #fff;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-content h3 {
        margin-bottom: 1rem;
    }

    .modal-content p {
        margin-bottom: 1.5rem;
    }

    /* Pagination Styling */
    .pagination {
        margin-top: 1.5rem;
        text-align: center;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        margin: 0 0.25rem;
        padding: 0.5rem 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #007bff;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .pagination a:hover {
        background-color: #007bff;
        color: #fff;
    }

    .pagination .active span {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const closeModalButtons = document.querySelectorAll('.close-modal');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');
                deleteForm.setAttribute('action', `/admin/users/${userId}`);
                deleteModal.classList.remove('hidden');
            });
        });

        closeModalButtons.forEach(button => {
            button.addEventListener('click', function () {
                deleteModal.classList.add('hidden');
            });
        });
    });
</script>
@endsection
