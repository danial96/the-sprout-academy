@extends('frontend.partials.master')

@section('title', 'Maintenance Work Order Form')

@section('content')

    @include('frontend.components.form_header', [
        'title' => 'Maintenance Work Order Form',
        'text' => 'Fill out form for a repair work order.',
    ])
    {{-- Form Section --}}
    <section class="form-section form-section-gradient">
        <div class="container">
            <div class="site_form site_form_maintenance_work_order">
                <form id="maintenanceWorkOrderForm" method="POST" action="{{ route('form.maintenanceWorkOrder') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-wrapper">
                        <!-- Left Form Section -->
                        <div class="form-left">
                            {{-- Success/Error Messages --}}
                            <div id="formMessage" class="form-message" style="display: none;"></div>

                            <div class="form-grid">

                                {{-- Date Field using Component --}}
                                @include('frontend.components.form_components.date-split-field', [
                                    'fieldId' => 'todaysDate',
                                    'label' => 'Today\'s Date',
                                    'required' => true,
                                    'defaultDate' => 'today',
                                    'minDate' => null,
                                ])

                                @include('frontend.components.form_components.date-split-field', [
                                    'fieldId' => 'completionDate',
                                    'label' => 'Date of Completion Needed*',
                                    'required' => true,
                                    'defaultDate' => 'today',
                                    'minDate' => null,
                                ])

                                {{-- Hidden date inputs for form submission --}}
                                <input type="hidden" id="todaysDateFormatted" name="todays_date" />
                                <input type="hidden" id="completionDateFormatted" name="completion_date" />

                                {{-- First Name / Last Name --}}
                                <div class="form-field">
                                    <label for="firstName">First Name*</label>
                                    <input type="text" id="firstName" name="first_name" class="form-input" required />
                                </div>

                                <div class="form-field">
                                    <label for="lastName">Last Name*</label>
                                    <input type="text" id="lastName" name="last_name" class="form-input" required />
                                </div>

                                {{-- Phone Number / Email --}}
                                <div class="form-field">
                                    <label for="phoneNumber">Phone Number*</label>
                                    <input type="tel" id="phoneNumber" name="phone_number" class="form-input"
                                        required />
                                </div>

                                <div class="form-field">
                                    <label for="email">Email*</label>
                                    <input type="email" id="email" name="email" class="form-input" required />
                                </div>

                                {{-- Location --}}
                                <div class="form-field form-field-full">
                                    <label for="location">Location*</label>
                                    <select id="location" name="location" class="form-select" required>
                                        <option value="">Select Your Center</option>
                                        <option value="seminole">Seminole</option>
                                        <option value="pinellas_park">Pinellas Park</option>
                                        <option value="largo">Largo</option>
                                        <option value="st_petersburg">St. Petersburg</option>
                                        <option value="montessori">Montessori</option>
                                    </select>
                                </div>

                                {{-- Description Of Work Needed --}}
                                <div class="form-field form-field-full">
                                    <label for="description">Description Of Work Needed:</label>
                                    <div class="textarea-wrapper">
                                        <textarea id="description" name="description" class="form-textarea" placeholder="Type here"></textarea>
                                    </div>
                                </div>

                                {{-- Attach A File / Area Repair Needed --}}
                                <div class="form-field">
                                    <label for="attachFile">Attach A File*</label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" id="attachFile" name="attach_file" class="form-file-input" />
                                        <label for="attachFile" class="form-file-label">
                                            <span class="file-upload-text" id="fileUploadText">Choose a File to
                                                Upload</span>
                                        </label>
                                        <div class="file-upload-icon" id="fileUploadIcon">
                                            <img src="{{ asset('frontend/assets/home_page_images/fil-icon.png') }}" alt="Upload file" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <label for="areaRepair">Area Repair Needed*</label>
                                    <select id="areaRepair" name="area_repair" class="form-select" required>
                                        <option value="">Select area of repair</option>
                                        <option value="plumbing">Plumbing</option>
                                        <option value="electrical">Electrical</option>
                                        <option value="hvac">HVAC</option>
                                        <option value="painting">Painting</option>
                                        <option value="carpentry">Carpentry</option>
                                        <option value="other">Other</option>
                                    </select>
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
                // File upload handler
                const attachFileInput = document.getElementById('attachFile');
                const fileUploadText = document.getElementById('fileUploadText');
                const fileUploadIcon = document.getElementById('fileUploadIcon');

                if (attachFileInput && fileUploadText && fileUploadIcon) {
                    // Click on icon opens file picker
                    fileUploadIcon.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        attachFileInput.click();
                    });

                    // Click on label also opens file picker
                    const fileLabel = document.querySelector('.form-file-label');
                    if (fileLabel) {
                        fileLabel.addEventListener('click', function(e) {
                            e.preventDefault();
                            attachFileInput.click();
                        });
                    }

                    attachFileInput.addEventListener('change', function(e) {
                        if (e.target.files && e.target.files.length > 0) {
                            fileUploadText.textContent = e.target.files[0].name;
                        } else {
                            fileUploadText.textContent = 'Choose a File to Upload';
                        }
                    });
                }

                // Form submission with AJAX
                const form = document.getElementById('maintenanceWorkOrderForm');
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

                        // Combine date fields (MM, DD, YY) into formatted dates
                        const todayMonth = document.getElementById('todaysDateMonth').value;
                        const todayDay = document.getElementById('todaysDateDay').value;
                        const todayYear = document.getElementById('todaysDateYear').value;
                        const completionMonth = document.getElementById('completionDateMonth').value;
                        const completionDay = document.getElementById('completionDateDay').value;
                        const completionYear = document.getElementById('completionDateYear').value;

                        // Convert YY to YYYY (assuming 20XX for years)
                        const todayFullYear = '20' + todayYear;
                        const completionFullYear = '20' + completionYear;

                        // Format as YYYY-MM-DD
                        const todayFormatted =
                            `${todayFullYear}-${todayMonth.padStart(2, '0')}-${todayDay.padStart(2, '0')}`;
                        const completionFormatted =
                            `${completionFullYear}-${completionMonth.padStart(2, '0')}-${completionDay.padStart(2, '0')}`;

                        document.getElementById('todaysDateFormatted').value = todayFormatted;
                        document.getElementById('completionDateFormatted').value = completionFormatted;

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

                                    // Reset file upload text
                                    if (fileUploadText) {
                                        fileUploadText.textContent = 'Choose a File to Upload';
                                    }

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
