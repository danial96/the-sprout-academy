@extends('frontend.partials.master')

@section('title', 'Employment Application Form')

@section('content')
    @include('frontend.components.form_header', [
        'title' => 'SPROUT ACADEMY - EMPLOYMENT 
         APPLICATION',
    ])

    {{-- Form Section --}}
    <section class="form-section form-section-gradient">
        <div class="container">
            <div class="site_form site_form_employment_application">
                <form id="employmentApplicationForm" method="POST" action="{{ route('form.employmentApplication') }}"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="form-wrapper">
                        <!-- Left Form Section -->
                        <div class="form-left">
                            {{-- Success/Error Messages --}}
                            <div id="formMessage" class="form-message" style="display: none;"></div>

                            <div class="form-grid">
                                {{-- Position --}}
                                <div class="form-field">
                                    <label for="position">Which Position Are You Applying For? *</label>
                                    <select id="position" name="position" class="form-select" required>                                      
                                        <option value="teacher" selected>Teacher</option>
                                        <option value="assistant_teacher">Assistant Teacher</option>
                                        <option value="director">Director</option>
                                        <option value="substitute">Substitute</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                {{-- Location --}}
                                <div class="form-field">
                                    <label for="location">Select A Location *</label>
                                    <select id="location" name="location" class="form-select" required>                                       
                                        <option value="seminole" selected>Seminole</option>
                                        <option value="pinellas_park">Pinellas Park</option>
                                        <option value="largo">Largo</option>
                                        <option value="st_petersburg">St. Petersburg</option>
                                        <option value="montessori">Montessori</option>
                                    </select>
                                </div>

                                {{-- When Can You Start & Resume Upload in One Row --}}
                                <div class="form-field">
                                    <label for="startDate">When Can You Start?</label>
                                    <div class="date-input-wrapper">
                                        <input type="date" id="startDate" name="start_date" class="form-input" />
                                    </div>
                                </div>

                                <div class="form-field">
                                    <label for="resume">Attach A Copy Of Your Resume *</label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" id="resume" name="resume" class="form-file-input"
                                            accept=".pdf,.doc,.docx" />
                                        <label for="resume" class="form-file-label">
                                            <span class="file-upload-text" id="resumeUploadText">Choose a File to
                                                Upload</span>
                                        </label>
                                        <div class="file-upload-icon" id="resumeUploadIcon">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="17 8 12 3 7 8"></polyline>
                                                <line x1="12" y1="3" x2="12" y2="15"></line>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                              
                                <div class="form-field">
                                    <label for="salaryDollars">Salary Request Per Hour </label>
                                    <div class="salary-fields-wrapper">
                                        <select id="salaryDollars" name="salary_dollars" class="form-select salary-dollars-field" required>
                                            <option value="">$Dollars</option>
                                            @for ($i = 10; $i <= 50; $i++)
                                                <option value="{{ $i }}">${{ $i }}</option>
                                            @endfor
                                        </select>
                                        <select id="salaryCents" name="salary_cents" class="form-select salary-cents-field" required>
                                            <option value="">$Cents</option>
                                            @for ($i = 0; $i <= 99; $i++)
                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}¢</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                {{-- Contact Information Section Header --}}
                                <div class="form-field form-field-full" style="margin-top: 20px;">
                                    <h3 style="font-size: 18px; font-weight: 600; color: #333; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        YOUR CONTACT INFORMATION
                                    </h3>
                                </div>

                                {{-- First Name / Last Name --}}
                                <div class="form-field">
                                    <label for="firstName">First Name *</label>
                                    <input type="text" id="firstName" name="first_name" class="form-input"
                                        placeholder="First Name" required />
                                </div>

                                <div class="form-field">
                                    <label for="lastName">Last Name *</label>
                                    <input type="text" id="lastName" name="last_name" class="form-input"
                                        placeholder="Last Name" required />
                                </div>

                                {{-- Email / Phone --}}
                                <div class="form-field">
                                    <label for="email">Email Address *</label>
                                    <input type="email" id="email" name="email" class="form-input"
                                        placeholder="Johnsmith@gmail.com" required />
                                </div>

                                <div class="form-field">
                                    <label for="phone">Phone *</label>
                                    <input type="tel" id="phone" name="phone" class="form-input"
                                        placeholder="XXX" required pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" />
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
                const form = document.getElementById('employmentApplicationForm');
                const submitBtn = document.getElementById('submitBtn');
                const btnText = submitBtn.querySelector('.btn-text');
                const btnSpinner = submitBtn.querySelector('.btn-spinner');
                const formMessage = document.getElementById('formMessage');

                // File upload handler
                const resumeInput = document.getElementById('resume');
                const resumeUploadText = document.getElementById('resumeUploadText');
                const resumeUploadIcon = document.getElementById('resumeUploadIcon');

                if (resumeInput && resumeUploadText && resumeUploadIcon) {
                    // Click on icon opens file picker
                    resumeUploadIcon.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        resumeInput.click();
                    });

                    // Update text when file is selected
                    resumeInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            resumeUploadText.textContent = file.name;
                        } else {
                            resumeUploadText.textContent = 'Choose a File to Upload';
                        }
                    });
                }

                // Set minimum date to today
                const startDateInput = document.getElementById('startDate');
                if (startDateInput) {
                    const today = new Date();
                    const year = today.getFullYear();
                    const month = String(today.getMonth() + 1).padStart(2, '0');
                    const day = String(today.getDate()).padStart(2, '0');
                    startDateInput.setAttribute('min', `${year}-${month}-${day}`);
                }

                // Form submission
                if (form) {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();

                        // Hide previous messages
                        formMessage.style.display = 'none';
                        formMessage.className = 'form-message';

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
                                if (!response.ok) {
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
                                    resumeUploadText.textContent = 'Choose a File to Upload';

                                    // Redirect to thank you page after 2 seconds
                                    setTimeout(() => {
                                        window.location.href = '{{ route('frontend.thankYou') }}';
                                    }, 2000);
                                } else {
                                    // Show error message
                                    let errorMessage = data.message || 'An error occurred. Please try again.';

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

