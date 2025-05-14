@extends("layouts.app")
@section('title', $viewData['title'])
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .login {
            display: grid;
            place-items: center;
            padding: 2rem;
        }
        .login__title {
            color: var(--title-color);
            font-size: 1.5rem;
            font-weight: var(--font-bold);
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .login__group {
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .login__label {
            display: block;
            color: var(--title-color);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .login__input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background-color: var(--body-color);
            color: var(--text-color);
        }
        .login__input:focus {
            border-color: var(--first-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 128, 0, 0.1);
        }
        .login__signup {
            color: var(--text-color);
            font-size: 0.9rem;
        }
        .login__signup a {
            color: var(--first-color);
            text-decoration: none;
            font-weight: var(--font-medium);
        }
        .login__forgot {
            display: block;
            color: var(--text-color);
            font-size: 0.9rem;
            text-decoration: none;
            margin-top: 0.5rem;
        }
        .login__button {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--first-color);
            color: var(--white-color);
            border: none;
            border-radius: 0.5rem;
            font-weight: var(--font-semi-bold);
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        .login__button:hover {
            background-color: var(--title-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .google-btn {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--container-color);
            color: var(--text-color);
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            font-weight: var(--font-semi-bold);
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .google-btn:hover {
            background-color: var(--body-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .google-btn svg {
            width: 1.25rem;
            height: 1.25rem;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: var(--text-color);
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid var(--border-color);
        }
        .divider span {
            padding: 0 1rem;
            font-size: 0.9rem;
            opacity: 0.8;
        }
    </style>
@endsection

@section("content")
    <!-- <div class="container-fluid mb-3 bgcolor">
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
            </div> -->

    <!-- login -->
    <div style="margin-top: 80px;" class="login grid" id="login">

     <!-- Display Error Messages -->
     @if ($errors->any())
        <div style="color: red; font-size: 0.9rem; margin-bottom: 1rem;">
            <ul style="padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="/login" method="post">
            @csrf
            <h3 class="login__title">
                Log In
            </h3>

            <a href="{{ route('google.login') }}" class="google-btn">
                <svg viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                </svg>
                Continue with Google
            </a>

            <div class="divider">
                <span>Or</span>
            </div>

            <div class="login__group grid">
                <div>
                    <label for="email" class="login__label">Email</label>
                    <input name="email" type="email" class="login__input" id="login-email" placeholder="Write your email">
                </div>
                <div>
                    <label for="password" class="login__label">Password</label>
                    <input name="password" type="password" class="login__input" id="login-password">
                </div>
            </div>
            <div>
                <span class="login__signup">
                    You do not have an account? <a href="/signup">Sign up</a>
                </span>
                <a href="" class="login__forgot">You forgot your password</a>
            </div>
            <button type="submit" class="login__button button"> Log In</button>
        </form>
    </div>


@endsection
