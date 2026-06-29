<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'The Sprout Academy develops the whole child by meeting social, emotional, physical, and intellectual needs through learning and growing every day.')">

    <title>@yield('title', 'The Sprout Academy') - The Sprout Academy</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/forms-style.css') }}">

    @stack('styles')
</head>

@php
    $currentRoute = Route::currentRouteName();
    $pageSlug = $currentRoute ? str_replace(['frontend.', '.'], ['', '-'], $currentRoute) : 'default';
@endphp

<body class="page-{{ $pageSlug }}">
    <div class="d-flex flex-column min-vh-100">
        @include('frontend.partials.header')

        <main id="main-content" class="flex-grow-1">
            @yield('content')
        </main>

        @php
            // Check if current route is a form page or thank you page
            $isFormPage = request()->routeIs([
                'form.timeOffRequestForm',
                'form.maintenanceWorkOrder',
                'form.supplyOrder',
                'form.snackOrder',
                'form.suggestion',
                'form.timeClockChangeRequest',
                'form.standardTShirtOrder',
                'form.specialtyTShirtOrder',
                'form.employmentApplication',
                'frontend.childAbsentForm',
                'enrollment.form',
                'enrollment.step2',
                'enrollment.step3',
                'enrollment.step4',
                'frontend.thankYou',
                'enrollment.thankYou',
                'frontend.employeeLogin',
                'login',
                'enrollment.start',
            ]);
        @endphp

        @if ($isFormPage)
            @include('frontend.partials.footer_copyright')
        @else
            @include('frontend.partials.footer')
        @endif
    </div>

    <!-- Floating Chat Button -->
    <button class="floating-chat-btn" aria-label="Open chat support">
        <img src="{{ asset('frontend/assets/home_page_images/chat-icon.png') }}" alt="Chat" width="26"
            height="26" loading="lazy">
    </button>

    <!-- jQuery (required for Slick - must load first) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <!-- Slick Slider JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- SimpleMasonry Web Component -->
    <script src="{{ asset('frontend/assets/js/simple-masonry.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('frontend/assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('frontend/assets/js/form-fields.js') }}"></script>
    <script>
        // Set today's date
        const today = new Date();
        const todayFormatted = (today.getMonth() + 1) + '/' + today.getDate() + '/' + today.getFullYear();
        const todayEl = document.getElementById('today');
        if (todayEl) todayEl.value = todayFormatted;

        // Initialize main calendar
        const calendarEl = document.querySelector('#calendar');
        const calendarInstance = calendarEl ? flatpickr(calendarEl, {
            inline: true,
            defaultDate: '2024-02-02',
            dateFormat: 'm/d/Y',
            onChange: function(selectedDates, dateStr) {
                if (selectedDates.length > 0) {
                    const date = selectedDates[0];
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const year = date.getFullYear();

                    // Update displays
                    const shortDate = month + '/' + day;
                    const fullDate = month + '/' + day + '/' + year;
                    const timeDisplayEl = document.getElementById('timeDisplay');
                    const time = timeDisplayEl ? timeDisplayEl.value : '';

                    const dateDisplayEl = document.getElementById('dateDisplay');
                    const dateTimeDisplayEl = document.getElementById('dateTimeDisplay');
                    const startDateEl = document.getElementById('startDate');
                    const endDateEl = document.getElementById('endDate');

                    if (dateDisplayEl) dateDisplayEl.value = fullDate;
                    if (dateTimeDisplayEl) dateTimeDisplayEl.value = shortDate + ' ' + time;
                    if (startDateEl) startDateEl.value = fullDate;
                    if (endDateEl) endDateEl.value = fullDate;
                }
            }
        }) : null;

        // Time picker for time display field
        const timeDisplayEl = document.querySelector('#timeDisplay');
        const timePickerInstance = timeDisplayEl ? flatpickr(timeDisplayEl, {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'h:i K',
            defaultDate: '10:39 PM',
            onChange: function(selectedDates, timeStr) {
                const dateDisplayEl = document.getElementById('dateDisplay');
                const dateTimeDisplayEl = document.getElementById('dateTimeDisplay');
                const dateVal = dateDisplayEl ? dateDisplayEl.value : '';
                const shortDate = dateVal ? dateVal.substring(0, 5) : '';
                if (dateTimeDisplayEl) dateTimeDisplayEl.value = shortDate + ' ' + timeStr;
            }
        }) : null;

        // Start date picker
        const startDateEl = document.querySelector('#startDate');
        const startDatePicker = startDateEl ? flatpickr(startDateEl, {
            dateFormat: 'm/d/Y',
            defaultDate: '2024-02-02',
            onChange: function(selectedDates, dateStr) {
                // Optionally sync with main calendar
            }
        }) : null;

        // End date picker
        const endDateEl = document.querySelector('#endDate');
        const endDatePicker = endDateEl ? flatpickr(endDateEl, {
            dateFormat: 'm/d/Y',
            defaultDate: '2024-02-02',
            onChange: function(selectedDates, dateStr) {
                // Optionally sync with main calendar
            }
        }) : null;

        // Submit button handler
        // document.getElementById('submitBtn').addEventListener('click', function(e) {
        //     e.preventDefault();

        //     const name = document.getElementById('name').value.trim();
        //     const email = document.getElementById('email').value.trim();
        //     const location = document.getElementById('location').value.trim();
        //     const startDate = document.getElementById('startDate').value.trim();
        //     const endDate = document.getElementById('endDate').value.trim();

        //     if (!name || !email) {
        //         alert('Please fill in Name and Email fields');
        //         return;
        //     }

        //     if (!location) {
        //         alert('Please select a Location');
        //         return;
        //     }

        //     if (!startDate || !endDate) {
        //         alert('Please select Start and End dates');
        //         return;
        //     }

        //     // Simulate director signature after submission
        //     document.getElementById('directorSignature').value = 'Director Approved - ' + new Date()
        //         .toLocaleDateString();
        //     // alert('Form submitted successfully!');
        // });
    </script>

    @stack('scripts')
</body>

</html>
