@extends('frontend.partials.master')

@section('title', 'Employee Forms')

@section('content')
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-emp-frm.png'),
        'title' => 'EMPLOYEE FORMS',
        'subtitle' => 'The Sprout Academy',
        'showButton' => false,
    ])

    {{-- Employee Forms Section --}}
    <section class="employee-forms-section">
        <div class="container">
            @auth
            <div class="employee-forms-hi-tab">
                <span class="employee-forms-hi-text">Hi, {{ auth()->user()->name ?? auth()->user()->email }}</span>
                <a href="{{ route('logout') }}" class="employee-forms-logout-link" onclick="event.preventDefault(); document.getElementById('employee-logout-form').submit();">Logout</a>
                <form id="employee-logout-form" action="{{ route('logout') }}" method="POST" class="employee-logout-form">
                    @csrf
                </form>
            </div>
            @endauth
            <div class="employee-forms-grid">
                {{-- Form Card 1: Time Of Request --}}
                <a href="{{ route('form.timeOffRequestForm') }}" class="employee-form-card">
                    <div class="employee-form-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/emp-frm-8.png') }}" alt="Time Of Request">
                    </div>
                    <div class="employee-form-label">Time Of Request</div>
                </a>

                {{-- Form Card 2: Maintenance Work Order Form --}}
                <a href="{{ route('form.maintenanceWorkOrder') }}" class="employee-form-card">
                    <div class="employee-form-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/emp-frm-7.png') }}"
                            alt="Maintenance Work Order Form">
                    </div>
                    <div class="employee-form-label">Maintenance Work Order Form</div>
                </a>

                {{-- Form Card 3: Supply Order Form --}}
                <a href="{{ route('form.supplyOrder') }}" class="employee-form-card">
                    <div class="employee-form-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/emp-frm-6.png') }}" alt="Supply Order Form">
                    </div>
                    <div class="employee-form-label">Supply Order Form</div>
                </a>

                {{-- Form Card 4: Snack Order Form --}}
                <a href="{{ route('form.snackOrder') }}" class="employee-form-card">
                    <div class="employee-form-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/emp-frm-5.png') }}" alt="Snack Order Form">
                    </div>
                    <div class="employee-form-label">Snack Order Form</div>
                </a>

                {{-- Form Card 5: Suggestion Form --}}
                <a href="{{ route('form.suggestion') }}" class="employee-form-card">
                    <div class="employee-form-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/emp-frm-4.png') }}" alt="Suggestion Form">
                    </div>
                    <div class="employee-form-label">Suggestion Form</div>
                </a>

                {{-- Form Card 6: Time Clock Change Request --}}
                <a href="{{ route('form.timeClockChangeRequest') }}" class="employee-form-card">
                    <div class="employee-form-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/emp-frm-3.png') }}"
                            alt="Time Clock Change Request">
                    </div>
                    <div class="employee-form-label">Time Clock Change Request</div>
                </a>

                {{-- Form Card 7: Standard Sprout T-Shirt Order --}}
                <a href="{{ route('form.standardTShirtOrder') }}" class="employee-form-card">
                    <div class="employee-form-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/emp-frm-2.png') }}"
                            alt="Standard Sprout T-Shirt Order">
                    </div>
                    <div class="employee-form-label">Standard Sprout T-Shirt Order</div>
                </a>

                {{-- Form Card 8: Specialty Sprout T-Shirt Order --}}
                <a href="{{ route('form.specialtyTShirtOrder') }}" class="employee-form-card">
                    <div class="employee-form-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/emp-frm-1.png') }}"
                            alt="Specialty Sprout T-Shirt Order">
                    </div>
                    <div class="employee-form-label">Specialty Sprout T-Shirt Order</div>
                </a>
            </div>
        </div>
    </section>
@endsection
