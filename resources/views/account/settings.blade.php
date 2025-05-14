@extends('layouts.app')

@section('title', 'Account Settings')

@section('styles')
<style>
    .settings-container {
        background-color: var(--container-color);
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 5rem; /* Avoid collapsing with navbar */
        margin-bottom: 5rem; /* Avoid collapsing with navmenu */
    }

    .settings-header {
        color: var(--first-color);
        font-weight: bold;
        margin-bottom: 2rem;
        text-align: center;
    }

    .settings-preview {
        background-color: var(--white-color);
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .settings-preview h5 {
        color: var(--title-color);
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .settings-preview p {
        color: var(--text-color);
        margin-bottom: 0.5rem;
    }

    .form-label {
        color: var(--title-color);
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 1px solid var(--border-color);
        border-radius: 5px;
        padding: 0.75rem;
        margin-bottom: 1.5rem; /* Add spacing between input fields */
    }

    .form-control:focus {
        border-color: var(--first-color);
        box-shadow: 0 0 0 3px rgba(0, 128, 0, 0.1);
    }

    .btn-primary {
        background-color: var(--first-color);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 5px;
        font-weight: bold;
        color: var(--white-color);
        transition: background-color 0.3s ease;
        width: 100%; /* Make the button full-width on mobile */
    }

    .btn-primary:hover {
        background-color: var(--first-color-alt);
    }

    .alert-banner {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: var(--first-color);
        color: var(--white-color);
        text-align: center;
        padding: 1rem;
        z-index: 1000;
        display: none; /* Initially hidden */
    }

    @media (max-width: 768px) {
        .settings-container {
            padding: 1.5rem;
        }

        .btn-primary {
            width: 100%; /* Ensure button is full-width on smaller screens */
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Alert Banner -->
    <div class="alert-banner" id="alert-banner">
        Information updated successfully!
    </div>

    <div class="settings-container">
        <h1 class="settings-header">Account Settings</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- User Info Preview -->
        <div class="settings-preview">
            <h5>Current Information</h5>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}</p>
        </div>

        <!-- Edit Form -->
        <form action="{{ route('account.settings.update') }}" method="POST">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Automatically hide the success message after 3 seconds
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = document.getElementById('success-message');
        const alertBanner = document.getElementById('alert-banner');

        if (successMessage) {
            // Show the alert banner
            alertBanner.style.display = 'block';

            // Hide the success message and alert banner after 3 seconds
            setTimeout(() => {
                successMessage.style.display = 'none';
                alertBanner.style.display = 'none';
            }, 3000); // 3 seconds
        }
    });
</script>
@endsection
