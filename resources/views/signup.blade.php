@extends("layouts.app")
@section("title", $viewData['title'])
@section("content")
    <section class="signup-section"
        style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: var(--container-color); padding-top: 5rem; padding-bottom: 2rem;">
        <div class="signup-container"
            style="width: 100%; max-width: 400px; background-color: var(--white-color); padding: 2rem; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <h2 class="text-center" style="color: var(--first-color); font-weight: bold; margin-bottom: 1.5rem;">Sign Up
            </h2>

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

            <form action="/register" method="post">
                @csrf
                <!-- Full Name -->
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="name" style="color: var(--text-color); font-weight: 600;">Full Name</label>
                    <input name="name" type="text" id="name" class="form-control"
                        style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px;"
                        placeholder="Enter your full name" value="{{ old('name') }}" required>
                    @error('name')
                        <div style="color: red; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Email -->
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="email" style="color: var(--text-color); font-weight: 600;">Email</label>
                    <input name="email" type="email" id="email" class="form-control"
                        style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px;"
                        placeholder="Enter your email" value="{{ old('email') }}" required>
                    @error('email')
                        <div style="color: red; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Password -->
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="password" style="color: var(--text-color); font-weight: 600;">Password</label>
                    <input name="password" type="password" id="password" class="form-control"
                        style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px;"
                        placeholder="Enter your password" required>
                    @error('password')
                        <div style="color: red; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Repeat Password -->
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="repeatPassword" style="color: var(--text-color); font-weight: 600;">Repeat Password</label>
                    <input name="repeatPassword" type="password" id="repeatPassword" class="form-control"
                        style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px;"
                        placeholder="Repeat your password" required>
                    @error('repeatPassword')
                        <div style="color: red; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Terms of Service -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <input type="checkbox" id="terms" required>
                    <label for="terms" style="color: var(--text-color); font-size: 0.9rem;">I agree to the <a href="#!"
                            style="color: var(--first-color-alt); text-decoration: underline;">Terms of Service</a></label>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn"
                    style="width: 100%; padding: 0.75rem; background-color: var(--first-color); color: var(--white-color); border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">Register</button>
            </form>
            <div class="divider" style="margin: 1.5rem 0; text-align: center; color: var(--text-color); font-size: 0.9rem;">
                OR</div>
            <!-- Google Signup -->
            <a href="{{ route('google.login') }}" class="btn-google"
                style="display: block; width: 100%; padding: 0.75rem; background-color: var(--first-color); color: var(--white-color); border: none; border-radius: 5px; font-weight: bold; text-align: center; text-decoration: none; cursor: pointer;">
                <i class="ri-google-line" style="margin-right: 0.5rem;"></i> Sign Up with Google
            </a>
            <!-- Already have an account -->
            <p class="text-center" style="margin-top: 1.5rem; color: var(--text-color); font-size: 0.9rem;">Already have an
                account? <a href="/login" style="color: var(--first-color-alt); text-decoration: underline;">Log In</a></p>
        </div>
    </section>
@endsection
