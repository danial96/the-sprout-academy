@extends('frontend.partials.master')

@section('title', 'Verify Email')

@section('content')
    <section class="location-enrollment-form-section">
        <div class="location-enrollment-container">
            <div class="location-enrollment-card">
                <div class="location-enrollment-logo">
                    <img src="{{ asset('frontend/assets/home_page_images/small-tree.png') }}" alt="The Sprout Academy">
                </div>

                <div class="location-enrollment-form-content">
                    <h2 style="text-align:center; color:#007b9a; font-size:22px; margin-bottom:6px;">Check Your Email</h2>
                    <p class="location-enrollment-instruction">
                        We sent a 6-digit code to <strong>{{ session('signup_email') }}</strong>. Enter it below to continue.
                    </p>

                    @if (session('resent'))
                        <div class="form-message success" style="display: block;">{{ session('resent') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="form-message error" style="display: block;">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('employee.signup.verify') }}">
                        @csrf

                        <div class="form-field location-enrollment-email-field">
                            <label for="otp">Verification Code <span style="color:red">*</span></label>
                            <input type="text" id="otp" name="otp"
                                class="form-input location-enrollment-input"
                                placeholder="000000"
                                maxlength="6"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                style="letter-spacing:8px; font-size:24px; text-align:center;"
                                required>
                            <small style="color:#888; font-size:12px;">Code expires in 10 minutes</small>
                        </div>

                        <button type="submit" class="btn location-enrollment-submit-btn mt-4">
                            Verify Code
                        </button>
                    </form>

                    <form method="POST" action="{{ route('employee.signup.resend') }}" style="margin-top:14px; text-align:center;">
                        @csrf
                        <button type="submit" style="background:none; border:none; color:#007b9a; font-size:14px; cursor:pointer; text-decoration:underline;">
                            Didn't receive it? Resend Code
                        </button>
                    </form>

                    <div style="text-align:center; margin-top:10px; font-size:13px;">
                        <a href="{{ route('employee.signup') }}" style="color:#888;">Use a different email</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
