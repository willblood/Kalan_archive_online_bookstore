@extends("layouts.app")
@section('title', $viewData['title'])
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section("content")
<div class="container-fluid mb-3 bgcolor">
        <div class="container">
            <div class="forms-container">
                <div class="signin-signup">
                    <form action="/login" method="post" class="sign-in-form">
                        @csrf
                        <h5 class="text-uppercase text-center mb-4">Login</h5>
                        <p class="text-muted">1. Email</p>
                        <div class="input-field">
                            <i class='bx bxs-envelope'></i>
                            <input name="email" type="email" placeholder="Enter Email" required />
                        </div>
                        <p class="text-muted mt-3">2. Password</p>
                        <div class="input-field">
                            <i class='bx bxs-lock-alt'></i>
                            <input name="password" type="password" placeholder="Password" required />
                        </div>
                        <p class="text-muted">Forgot <a href="/reset-form">password?</a></p>
                        <button type="submit" class="btn btn-success p-3 mt-3">Login</button>
                        <p class="text-muted text-center mt-3">Don't have an account? <a href="/sign-up-form">Sign up</a></p>
                    </form>
                </div>
            </div>

            <div class="panels-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h2>Welcome to Kalan Archive</h2>
                        <p class="fw-lighter fs-5">
                            Get Access to a large number of books!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
