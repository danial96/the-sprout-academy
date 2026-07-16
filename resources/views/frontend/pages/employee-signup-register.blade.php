@extends('frontend.partials.master')

@section('title', 'Create Account')

@section('content')
    <section class="location-enrollment-form-section">
        <div class="location-enrollment-container">
            <div class="location-enrollment-card">
                <div class="location-enrollment-logo">
                    <img src="{{ asset('frontend/assets/home_page_images/small-tree.png') }}" alt="The Sprout Academy">
                </div>

                <div class="location-enrollment-form-content">
                    <h2 style="text-align:center; color:#007b9a; font-size:22px; margin-bottom:6px;">Almost Done!</h2>
                    <p class="location-enrollment-instruction">
                        Email verified: <strong>{{ session('signup_email_verified') }}</strong><br>
                        Now set your name and password.
                    </p>

                    @if ($errors->any())
                        <div class="form-message error" style="display: block;">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('employee.signup.register') }}">
                        @csrf

                        <div class="form-field location-enrollment-email-field">
                            <label for="name">Full Name <span style="color:red">*</span></label>
                            <input type="text" id="name" name="name"
                                class="form-input location-enrollment-input"
                                placeholder="Jane Smith"
                                value="{{ old('name') }}" required>
                        </div>

                        <div class="form-field location-enrollment-password-field" style="margin-top:14px;">
                            <label for="password">Password <span style="color:red">*</span></label>
                            <input type="password" id="password" name="password"
                                class="form-input location-enrollment-input"
                                placeholder="Minimum 8 characters" required minlength="8">
                        </div>

                        <div class="form-field location-enrollment-password-field" style="margin-top:14px;">
                            <label for="password_confirmation">Confirm Password <span style="color:red">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-input location-enrollment-input"
                                placeholder="Repeat password" required>
                        </div>

                        <button type="submit" class="btn location-enrollment-submit-btn mt-4">
                            Create Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
