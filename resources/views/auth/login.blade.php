@extends('frontend.partials.master')

@section('title', 'Login')

@section('content')
    <section class="location-enrollment-form-section">
        <div class="location-enrollment-container">
            <div class="location-enrollment-card">
                <div class="location-enrollment-logo">
                    <img src="{{ asset('frontend/assets/home_page_images/small-tree.png') }}" alt="The Sprout Academy">
                </div>

                <div class="location-enrollment-form-content">
                    <p class="location-enrollment-instruction">Log in with your account to access the dashboard or employee forms.</p>

                    @if (session('status'))
                        <div class="form-message success" style="display: block;">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="form-message error" style="display: block;">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div id="formMessage" class="form-message error" style="display: none;"></div>

                    <form id="adminLoginForm" method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        <div class="form-field location-enrollment-email-field">
                            <label for="emailAddress">Email Address*</label>
                            <input type="email" id="emailAddress" name="email"
                                class="form-input location-enrollment-input" placeholder="Johnsmith@gmail.com" required
                                value="{{ old('email') }}" aria-label="Email address">
                        </div>

                        <div class="form-field location-enrollment-password-field">
                            <label for="password">Password*</label>
                            <input type="password" id="password" name="password"
                                class="form-input location-enrollment-input" placeholder="********" required
                                aria-label="Password">
                        </div>
                </div>

                <button type="submit" class="btn location-enrollment-submit-btn mt-5" id="submitBtn">
                    Login
                </button>
                </form>

            </div>
        </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('adminLoginForm');
            const formMessage = document.getElementById('formMessage');
            const submitBtn = document.getElementById('submitBtn');

            if (!form) {
                return;
            }

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                formMessage.style.display = 'none';
                formMessage.innerHTML = '';
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...';

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        window.location.href = data.redirect_url;
                        return;
                    }

                    let errorMessage = data.message || 'An error occurred. Please try again.';

                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join('<br>');
                    }

                    formMessage.innerHTML = errorMessage;
                    formMessage.style.display = 'block';
                } catch (error) {
                    formMessage.innerHTML = 'An error occurred. Please try again later.';
                    formMessage.style.display = 'block';
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Login';
                }
            });
        });
    </script>
@endpush
