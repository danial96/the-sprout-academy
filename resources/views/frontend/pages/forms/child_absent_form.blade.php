@extends('frontend.partials.master')

@section('title', 'Child Absent Form')

@section('content')

    @include('frontend.components.form_header', [
        'title' => 'Child Absent Form',
        'text' => 'If you child is going to be absent for the day Sprout Academy needs to be notified at a minimum within an hour of your drop off time.',
    ])
    {{-- Form Section --}}
    <section class="form-section form-section-gradient">
        <div class="container">
            <div class="site_form site_form_child_absent">
                <form id="childAbsentForm" method="POST" action="{{ route('frontend.childAbsentForm') }}" novalidate>
                    @csrf
                    <div class="form-wrapper">
                        <!-- Left Form Section -->
                        <div class="form-left">
                            {{-- Success/Error Messages --}}
                            <div id="formMessage" class="form-message" style="display: none;"></div>

                            <div class="form-grid">
                                {{-- First Name / Last Name --}}
                                <div class="form-field">
                                    <label for="firstName">Parent/Guardian Name *</label>
                                    <input type="text" id="firstName" name="first_name" class="form-input" placeholder="First" required />
                                </div>

                                <div class="form-field">
                                    <label for="lastName" class="invisible">Last Name*</label>
                                    <input type="text" id="lastName" name="last_name" class="form-input" placeholder="Last" required />
                                </div>

                                {{-- Child Name --}}
                                <div class="form-field">
                                    <label for="childFirstName">Child's Name *</label>
                                    <input type="text" id="childFirstName" name="child_first_name" class="form-input" placeholder="First" required />
                                </div>

                                <div class="form-field">
                                    <label for="childLastName" class="invisible">Child's Name *</label>
                                    <input type="text" id="childLastName" name="child_last_name" class="form-input" placeholder="Last" required />
                                </div>

                              
                                @include('frontend.components.form_components.date-split-field', [
                                    'fieldId' => 'datesubmission',
                                    'label' => 'Date',
                                    'required' => true,
                                    'defaultDate' => null,
                                    'minDate' => null,
                                ])
                                <input type="hidden" id="datesubmissionFormatted" name="date_submission" />

                               
                                @include('frontend.components.form_components.date-split-field', [
                                    'fieldId' => 'dateOfExpectedReturn',
                                    'label' => 'Date of Expected Return',
                                    'required' => true,
                                    'defaultDate' => null,
                                    'minDate' => null,
                                ])

                                
                                <input type="hidden" id="dateOfExpectedReturnFormatted" name="date_of_expected_return" />

                                <div class="form-field form-field-full">
                                    <label for="phoneNumber">Phone Number*</label>
                                    <input type="tel" id="phoneNumber" name="phone_number" class="form-input" placeholder="XXX-XXX-XXXX"
                                        pattern="^\d{3}-\d{3}-\d{4}$" required />
                                </div>

                                {{-- Location --}}
                                <div class="form-field form-field-full">
                                    <label for="location">Select a Location *</label>
                                    <select id="location" name="location" class="form-select" required>
                                        <option value="seminole">Seminole</option>
                                        <option value="pinellas-park">Pinellas Park</option>
                                        <option value="montessori">Montessori</option>
                                        <option value="largo">Largo</option>
                                        <option value="st-petersburg">St. Petersburg</option>
                                    </select>
                                </div>

                              

                                {{-- Reason --}}
                                <div class="form-field form-field-full">
                                    <label for="reason">Reason for Child's Absence:</label>
                                    <div class="textarea-wrapper">
                                        <textarea id="reason" name="reason" class="form-textarea" placeholder="Type Reason Here"></textarea>
                                    </div>
                                </div>


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
                const form = document.getElementById('childAbsentForm');
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

                        // Combine date_submission fields (MM, DD, YY) into formatted date
                        const submissionMonth = document.getElementById('datesubmissionMonth').value.trim();
                        const submissionDay = document.getElementById('datesubmissionDay').value.trim();
                        const submissionYear = document.getElementById('datesubmissionYear').value.trim();

                        if (submissionMonth && submissionDay && submissionYear && 
                            !isNaN(parseInt(submissionMonth)) && !isNaN(parseInt(submissionDay)) && !isNaN(parseInt(submissionYear))) {
                            const monthNum = parseInt(submissionMonth);
                            const dayNum = parseInt(submissionDay);
                            const yearNum = parseInt(submissionYear);
                            
                            // Validate ranges
                            if (monthNum >= 1 && monthNum <= 12 && dayNum >= 1 && dayNum <= 31 && yearNum >= 0 && yearNum <= 99) {
                                // Convert YY to YYYY (assuming 20XX for years)
                                const dateFullYear = '20' + String(yearNum).padStart(2, '0');
                                // Format as YYYY-MM-DD
                                const dateFormatted = `${dateFullYear}-${String(monthNum).padStart(2, '0')}-${String(dayNum).padStart(2, '0')}`;
                                document.getElementById('datesubmissionFormatted').value = dateFormatted;
                            } else {
                                document.getElementById('datesubmissionFormatted').value = '';
                            }
                        } else {
                            document.getElementById('datesubmissionFormatted').value = '';
                        }

                        // Combine date_of_expected_return fields (MM, DD, YY) into formatted date
                        const returnMonth = document.getElementById('dateOfExpectedReturnMonth').value.trim();
                        const returnDay = document.getElementById('dateOfExpectedReturnDay').value.trim();
                        const returnYear = document.getElementById('dateOfExpectedReturnYear').value.trim();

                        if (returnMonth && returnDay && returnYear && 
                            !isNaN(parseInt(returnMonth)) && !isNaN(parseInt(returnDay)) && !isNaN(parseInt(returnYear))) {
                            const monthNum = parseInt(returnMonth);
                            const dayNum = parseInt(returnDay);
                            const yearNum = parseInt(returnYear);
                            
                            // Validate ranges
                            if (monthNum >= 1 && monthNum <= 12 && dayNum >= 1 && dayNum <= 31 && yearNum >= 0 && yearNum <= 99) {
                            // Convert YY to YYYY (assuming 20XX for years)
                                const dateFullYear = '20' + String(yearNum).padStart(2, '0');
                            // Format as YYYY-MM-DD
                                const dateFormatted = `${dateFullYear}-${String(monthNum).padStart(2, '0')}-${String(dayNum).padStart(2, '0')}`;
                            document.getElementById('dateOfExpectedReturnFormatted').value = dateFormatted;
                            } else {
                                document.getElementById('dateOfExpectedReturnFormatted').value = '';
                            }
                        } else {
                            document.getElementById('dateOfExpectedReturnFormatted').value = '';
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
                            .then(response => response.json())
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
                                formMessage.textContent =
                                    'An error occurred while submitting the form. Please try again later.';
                                formMessage.className = 'form-message error';
                                formMessage.style.display = 'block';

                                console.error('Error:', error);
                            });
                    });
                }
            });
        </script>
    @endpush
@endsection
