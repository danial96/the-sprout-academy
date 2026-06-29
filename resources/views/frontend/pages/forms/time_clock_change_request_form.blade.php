@extends('frontend.partials.master')

@section('title', 'Time Clock Change Request Form')

@section('content')

    @include('frontend.components.form_header', [
        'title' => 'Time Clock Change Request Form',
    ])
    {{-- Form Section --}}
    <section class="form-section form-section-gradient">
        <div class="container">
            <div class="site_form site_form_time_clock_change_request">
                <form id="timeClockChangeRequestForm" method="POST" action="{{ route('form.timeClockChangeRequest') }}"
                    novalidate>
                    @csrf
                    <div class="form-wrapper">
                        <!-- Left Form Section -->
                        <div class="form-left">
                            {{-- Success/Error Messages --}}
                            <div id="formMessage" class="form-message" style="display: none;"></div>

                            <div class="form-grid">
                              
                                <div class="form-field">
                                    <label for="firstName">Employee print name *</label>
                                    <input type="text" id="firstName" name="first_name" class="form-input" placeholder="Fist Name" required />
                                </div>

                                <div class="form-field">
                                    <label for="lastName" class="invisible">Last Name*</label>
                                    <input type="text" id="lastName" name="last_name" class="form-input" placeholder="Last Name" required />
                                </div>

                                {{-- Location --}}
                                <div class="form-field form-field-full">
                                    <label for="location">Center Location *</label>
                                    <select id="location" name="location" class="form-select" required>
                                        <option value="seminole" selected>Seminole</option>
                                        <option value="pinellas_park">Pinellas Park</option>
                                        <option value="largo">Largo</option>
                                        <option value="st_petersburg">St. Petersburg</option>
                                        <option value="montessori">Montessori</option>
                                    </select>
                                </div>

                                {{-- Date Field using Component --}}
                                @include('frontend.components.form_components.date-split-field', [
                                    'fieldId' => 'dateToBeChanged',
                                    'label' => 'Date to be changed',
                                    'required' => true,
                                    'defaultDate' => 'today',
                                    'minDate' => null,
                                ])

                                {{-- Hidden date input for form submission --}}
                                <input type="hidden" id="dateToBeChangedFormatted" name="date_to_be_changed" />

                                {{-- Time Field using Component --}}
                                @include('frontend.components.form_components.time-split-field', [
                                    'fieldId' => 'clockIn',
                                    'label' => 'Clock in time',
                                    'required' => true,
                                    'autoFill' => true,
                                ])

                                {{-- Hidden time inputs for form submission --}}
                                <input type="hidden" id="clockInFormatted" name="clock_in_time" />
                                <input type="hidden" id="clockOutLunchFormatted" name="clock_out_for_lunch" />
                                <input type="hidden" id="clockInLunchFormatted" name="clock_in_from_lunch" />
                                <input type="hidden" id="clockOutFormatted" name="clock_out_time" />

                                {{-- Time Fields using Components --}}
                                @include('frontend.components.form_components.time-split-field', [
                                    'fieldId' => 'clockOutLunch',
                                    'label' => 'Clock out for lunch',
                                    'required' => false,
                                    'autoFill' => false,
                                ])

                                @include('frontend.components.form_components.time-split-field', [
                                    'fieldId' => 'clockInLunch',
                                    'label' => 'Clock in from lunch',
                                    'required' => false,
                                    'autoFill' => false,
                                ])

                                @include('frontend.components.form_components.time-split-field', [
                                    'fieldId' => 'clockOut',
                                    'label' => 'Clock out time',
                                    'required' => false,
                                    'autoFill' => false,
                                ])

                                <div class="form-field form-field-full">
                                    <label for="reasonForChange">Reason for change of time request *</label>
                                    <select id="reasonForChange" name="reason_for_change" class="form-select" required>
                                        <option value="">Select reason</option>
                                        <option value="forgot_to_clock_in">Forgot to clock in</option>
                                        <option value="forgot_to_clock_out">Forgot to clock out</option>
                                        <option value="incorrect_time">Incorrect time entered</option>
                                        <option value="system_error">System error</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>


                                {{-- E-Signature Fields - TEMPORARILY REMOVED --}}
                                {{-- <div class="form-field">
                                    <label for="supervisorFirstName">E-Signature *</label>
                                    <input type="text" id="supervisorFirstName" name="supervisor_first_name"
                                        class="form-input" placeholder="First Name" required/>
                                </div>

                                <div class="form-field">
                                    <label for="supervisorLastName" class="invisible">Supervisor Last Name</label>
                                    <input type="text" id="supervisorLastName" name="supervisor_last_name"
                                        class="form-input" placeholder="Last Name" required/>
                                </div> --}}
                            </div>

                            <button type="submit" class="submit-btn" id="submitBtn">
                                <span class="btn-text">Submit Now</span>
                                <span class="btn-spinner" style="display: none;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 12a9 9 0 11-6.219-8.56" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Form submission with AJAX
                const form = document.getElementById('timeClockChangeRequestForm');
                const submitBtn = document.getElementById('submitBtn');
                const btnText = submitBtn.querySelector('.btn-text');
                const btnSpinner = submitBtn.querySelector('.btn-spinner');
                const formMessage = document.getElementById('formMessage');

                if (form) {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();

                        // Hide previous messages
                        formMessage.style.display = 'none';
                        formMessage.className = 'form-message';

                        // Combine date fields (MM, DD, YY) into formatted date
                        const dateMonth = document.getElementById('dateToBeChangedMonth').value;
                        const dateDay = document.getElementById('dateToBeChangedDay').value;
                        const dateYear = document.getElementById('dateToBeChangedYear').value;

                        if (dateMonth && dateDay && dateYear) {
                            // Convert YY to YYYY (assuming 20XX for years)
                            const dateFullYear = '20' + dateYear;
                            // Format as YYYY-MM-DD
                            const dateFormatted =
                                `${dateFullYear}-${dateMonth.padStart(2, '0')}-${dateDay.padStart(2, '0')}`;
                            document.getElementById('dateToBeChangedFormatted').value = dateFormatted;
                        }

                        // Combine time fields (HH, MM, AM/PM) into formatted times
                        function formatTime(fieldId) {
                            const hour = document.getElementById(fieldId + 'Hour').value;
                            const minute = document.getElementById(fieldId + 'Minute').value;
                            const period = document.getElementById(fieldId + 'Period').value;

                            if (hour && minute && period) {
                                let hour24 = parseInt(hour);
                                if (period === 'PM' && hour24 !== 12) {
                                    hour24 += 12;
                                } else if (period === 'AM' && hour24 === 12) {
                                    hour24 = 0;
                                }
                                return `${hour24.toString().padStart(2, '0')}:${minute.padStart(2, '0')}`;
                            }
                            return null;
                        }

                        const clockInTime = formatTime('clockIn');
                        if (clockInTime) {
                            document.getElementById('clockInFormatted').value = clockInTime;
                        }

                        const clockOutLunchTime = formatTime('clockOutLunch');
                        if (clockOutLunchTime) {
                            document.getElementById('clockOutLunchFormatted').value = clockOutLunchTime;
                        }

                        const clockInLunchTime = formatTime('clockInLunch');
                        if (clockInLunchTime) {
                            document.getElementById('clockInLunchFormatted').value = clockInLunchTime;
                        }

                        const clockOutTime = formatTime('clockOut');
                        if (clockOutTime) {
                            document.getElementById('clockOutFormatted').value = clockOutTime;
                        }

                        // Show spinner and disable button
                        btnText.style.display = 'none';
                        btnSpinner.style.display = 'inline-block';
                        submitBtn.disabled = true;

                        // Create FormData
                        const formData = new FormData(form);

                        // AJAX submission
                        fetch(form.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                // Check if response is ok
                                if (!response.ok) {
                                    // Try to parse JSON error response
                                    return response.json().then(data => {
                                        throw { data, status: response.status };
                                    }).catch(() => {
                                        throw { message: 'Server error occurred', status: response.status };
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Hide spinner and enable button
                                btnText.style.display = 'inline-block';
                                btnSpinner.style.display = 'none';
                                submitBtn.disabled = false;

                                if (data.success) {
                                    // Show success message
                                    formMessage.textContent = data.message;
                                    formMessage.className = 'form-message success';
                                    formMessage.style.display = 'block';

                                    // Reset form
                                    form.reset();

                                    // Redirect to thank you page after 2 seconds
                                    setTimeout(() => {
                                        window.location.href = '{{ route('frontend.thankYou') }}';
                                    }, 2000);
                        } else {
                                    // Show error message
                                    let errorMessage = data.message ||
                                        'An error occurred. Please try again.';

                                    // Add validation errors if present
                                    if (data.errors) {
                                        const errorList = Object.values(data.errors).flat().join('<br>');
                                        errorMessage += '<br>' + errorList;
                                    }

                                    formMessage.innerHTML = errorMessage;
                                    formMessage.className = 'form-message error';
                                    formMessage.style.display = 'block';

                                    // Scroll to message
                                    formMessage.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'nearest'
                                    });
                                }
                            })
                            .catch(error => {
                                // Hide spinner and enable button
                                btnText.style.display = 'inline-block';
                                btnSpinner.style.display = 'none';
                                submitBtn.disabled = false;

                                // Show error message
                                let errorMessage = 'An error occurred while submitting the form. Please try again later.';
                                
                                if (error.data) {
                                    if (error.data.message) {
                                        errorMessage = error.data.message;
                                    }
                                    if (error.data.errors) {
                                        const errorList = Object.values(error.data.errors).flat().join('<br>');
                                        errorMessage += '<br>' + errorList;
                                    }
                                }

                                formMessage.innerHTML = errorMessage;
                                formMessage.className = 'form-message error';
                                formMessage.style.display = 'block';

                                // Scroll to message
                                formMessage.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'nearest'
                                });

                                console.error('Error:', error);
                            });
                    });
                }
            });
        </script>
    @endpush
@endsection
