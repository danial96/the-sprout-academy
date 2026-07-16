@extends('frontend.partials.master')

@section('title', 'Employee Sign Up')

@section('content')
    <section class="location-enrollment-form-section">
        <div class="location-enrollment-container">
            <div class="location-enrollment-card">
                <div class="location-enrollment-logo">
                    <img src="{{ asset('frontend/assets/home_page_images/small-tree.png') }}" alt="The Sprout Academy">
                </div>

                <div class="location-enrollment-form-content">
                    <h2 style="text-align:center; color:#007b9a; font-size:22px; margin-bottom:6px;">Create Employee Account</h2>
                    <p class="location-enrollment-instruction">Enter your work email and we'll send you a verification code.</p>

                    @if ($errors->any())
                        <div class="form-message error" style="display: block;">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('employee.signup.send-otp') }}">
                        @csrf

                        <div class="form-field location-enrollment-email-field">
                            <label for="email">Email Address <span style="color:red">*</span></label>
                            <input type="email" id="email" name="email"
                                class="form-input location-enrollment-input"
                                placeholder="yourname@example.com"
                                value="{{ old('email') }}" required>
                        </div>

                        <button type="submit" class="btn location-enrollment-submit-btn mt-4">
                            Send Verification Code
                        </button>
                    </form>
                </div>

                <div style="text-align:center; margin-top:18px; font-size:14px; color:#666;">
                    Already have an account? <a href="{{ route('login') }}" style="color:#007b9a; font-weight:600;">Log In</a>
                </div>
            </div>
        </div>
    </section>
@endsection
