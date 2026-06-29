@extends('frontend.partials.master')

@section('title', 'Enrollment - Emergency Contacts - ' . $locationData['name'])

@section('content')
    <!-- Form Header -->
    @include('frontend.components.form_header', [
        'title' => 'THE SPROUT ACADEMY - ' . $locationData['name'],
    ])


    <!-- Enrollment Form Section -->
    <section class="enrollment-form-section">
        <div class="container">
            <div class="enrollment-form-wrapper">
                <!-- Progress Bar -->
                @include('frontend.components.enrollment.progress-bar', ['currentStep' => $currentStep])

                <!-- Instructions -->
                <div class="section-header mt-5">
                    <h2 class="section-title-inner">First Contact Person (Yourself)</h2>
                </div>
                <div class="enrollment-instructions">
                    <ol>
                        <li>Choose How You Are Related To Each Child (Below) And Select "Yes" If:
                            <ul>
                                <li>The Child Lives With You</li>
                                <li>You Are An Emergency Contact.</li>
                                <li>You Are An Authorized Pickup.</li>
                            </ul>
                        </li>
                        <li>To Add Additional People (Spouse, Relative, Neighbor, Doctor) Choose Add Next Contact.</li>
                    </ol>
                </div>

                <!-- Form -->
                <form id="enrollmentStep3Form" class="enrollment-form site_form" method="POST"
                    action="{{ route('enrollment.saveStep3', ['location' => $location]) }}" enctype="multipart/form-data">
                    @csrf
                    <div id="formMessage" class="form-message" style="display: none;"></div>

                    <!-- First Contact Person (Yourself) -->
                    <div class="enrollment-section">
                        <div class="section-header-wrapper">
                            <div class="section-header">
                                <h2 class="section-title-inner">First Contact Person (Yourself)</h2>
                            </div>
                            <div class="section-required-note">
                                <span class="required-asterisk">*</span> Indicates Required Field
                            </div>
                        </div>

                        <div id="contactsFieldsContainer">
                            @if (isset($contacts) && count($contacts) > 0)
                                @foreach ($contacts as $index => $contact)
                                    <div class="contact-field-group" data-contact-index="{{ $index }}">
                                        <!-- Contact Info -->
                                        <div class="contact-info-section">
                                            <div class="section-header">
                                                <i class="far fa-user section-icon"></i>
                                                <h3 class="section-subtitle">Contact Info</h3>
                                            </div>
                                            <div class="form-grid">
                                                <div class="form-field">
                                                    <label>First Name*</label>
                                                    <input type="text" name="contact_first_name[]" class="form-input"
                                                        value="{{ $contact->first_name }}" placeholder="Johnathan" required />
                                                </div>
                                                <div class="form-field">
                                                    <label>M.I.</label>
                                                    <input type="text" name="contact_middle_initial[]" class="form-input"
                                                        value="{{ $contact->middle_initial ?? '' }}" maxlength="1" />
                                                </div>
                                                <div class="form-field">
                                                    <label>Last Name*</label>
                                                    <input type="text" name="contact_last_name[]" class="form-input"
                                                        value="{{ $contact->last_name }}" placeholder="smith" required />
                                                </div>
                                                <div class="form-field">
                                                    <label>Gender</label>
                                                    <select name="contact_gender[]" class="form-select">
                                                        <option value="">Select Gender</option>
                                                        <option value="male"
                                                            {{ $contact->gender == 'male' ? 'selected' : '' }}>Male</option>
                                                        <option value="female"
                                                            {{ $contact->gender == 'female' ? 'selected' : '' }}>Female
                                                        </option>
                                                        <option value="other"
                                                            {{ $contact->gender == 'other' ? 'selected' : '' }}>Other
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-field">
                                                    <label>Date Of Birth</label>
                                                    <input type="date" name="contact_date_of_birth[]" class="form-input"
                                                        value="{{ $contact->date_of_birth ? $contact->date_of_birth->format('Y-m-d') : '' }}" />
                                                </div>
                                                @if ($index > 0)
                                                    <div class="form-field">
                                                        <button type="button" class="btn-remove-contact"
                                                            onclick="removeContactField(this)">Remove Contact</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Relationship To Children -->
                                        <div class="relationship-section">
                                            <div class="section-header">
                                                <i class="far fa-users section-icon"></i>
                                                <h3 class="section-subtitle">Relationship To Children</h3>
                                            </div>

                                            <div class="relationship-content">
                                                <!-- Profile Display -->
                                                <div class="contact-profile-display">
                                                    @include(
                                                        'frontend.components.enrollment.profile-picture',
                                                        [
                                                            'imageUrl' => $contact->profile_image
                                                                ? \Illuminate\Support\Facades\Storage::url(
                                                                    $contact->profile_image)
                                                                : asset(
                                                                    'frontend/assets/home_page_images/enroll-avatar.png'),
                                                            'name' =>
                                                                $contact->first_name . ' ' . $contact->last_name,
                                                            'fieldName' => 'contact_profile_image[]',
                                                            'showChangeButton' => true,
                                                        ]
                                                    )
                                                </div>

                                                <!-- Relationship Fields -->
                                                <div class="relationship-fields">
                                                    <div class="form-field">
                                                        <label>Relationship Type*</label>
                                                        <select name="contact_relationship_type[]" class="form-select"
                                                            required>
                                                            <option value="">Select Relationship</option>
                                                            <option value="parent"
                                                                {{ $contact->relationship_type == 'parent' ? 'selected' : '' }}>
                                                                Parent</option>
                                                            <option value="guardian"
                                                                {{ $contact->relationship_type == 'guardian' ? 'selected' : '' }}>
                                                                Guardian</option>
                                                            <option value="relative"
                                                                {{ $contact->relationship_type == 'relative' ? 'selected' : '' }}>
                                                                Relative</option>
                                                            <option value="neighbor"
                                                                {{ $contact->relationship_type == 'neighbor' ? 'selected' : '' }}>
                                                                Neighbor</option>
                                                            <option value="doctor"
                                                                {{ $contact->relationship_type == 'doctor' ? 'selected' : '' }}>
                                                                Doctor</option>
                                                            <option value="other"
                                                                {{ $contact->relationship_type == 'other' ? 'selected' : '' }}>
                                                                Other</option>
                                                        </select>
                                                    </div>

                                                    <div class="toggle-group">
                                                        @include(
                                                            'frontend.components.enrollment.toggle-switch',
                                                            [
                                                                'name' => 'contact_lives_with[]',
                                                                'label' => 'Lives With',
                                                                'value' => $contact->lives_with ?? false,
                                                                'id' => 'livesWith' . $index,
                                                            ]
                                                        )
                                                        @include(
                                                            'frontend.components.enrollment.toggle-switch',
                                                            [
                                                                'name' => 'contact_is_emergency[]',
                                                                'label' => 'Emergency',
                                                                'value' => $contact->is_emergency_contact ?? false,
                                                                'id' => 'isEmergency' . $index,
                                                            ]
                                                        )
                                                        @include(
                                                            'frontend.components.enrollment.toggle-switch',
                                                            [
                                                                'name' => 'contact_is_pickup[]',
                                                                'label' => 'Pickup',
                                                                'value' => $contact->is_authorized_pickup ?? false,
                                                                'id' => 'isPickup' . $index,
                                                            ]
                                                        )
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="contact-field-group" data-contact-index="0">
                                    <!-- Contact Info -->
                                    <div class="contact-info-section">
                                        <div class="section-header">
                                            <i class="far fa-user section-icon"></i>
                                            <h3 class="section-subtitle">Contact Info</h3>
                                        </div>
                                        <div class="form-grid">
                                            <div class="form-field">
                                                <label>First Name*</label>
                                                <input type="text" name="contact_first_name[]" class="form-input"
                                                    required />
                                            </div>
                                            <div class="form-field">
                                                <label>M.I.</label>
                                                <input type="text" name="contact_middle_initial[]" class="form-input"
                                                    maxlength="1" />
                                            </div>
                                            <div class="form-field">
                                                <label>Last Name*</label>
                                                <input type="text" name="contact_last_name[]" class="form-input"
                                                    required />
                                            </div>
                                            <div class="form-field">
                                                <label>Gender</label>
                                                <select name="contact_gender[]" class="form-select">
                                                    <option value="">Select Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="form-field">
                                                <label>Date Of Birth</label>
                                                <input type="date" name="contact_date_of_birth[]"
                                                    class="form-input" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="enrollment-section-divider"></div>

                                    <!-- Relationship To Children -->
                                    <div class="relationship-section">
                                        <div class="section-header">
                                            <i class="far fa-users section-icon"></i>
                                            <h3 class="section-subtitle">Relationship To Children</h3>
                                        </div>

                                        <div class="relationship-content">
                                            <div class="contact-profile-display">
                                                @include('frontend.components.enrollment.profile-picture', [
                                                    'imageUrl' => asset(
                                                        'frontend/assets/home_page_images/enroll-avatar.png'),
                                                    'name' => '',
                                                    'fieldName' => 'contact_profile_image[]',
                                                    'showChangeButton' => true,
                                                ])
                                            </div>

                                            <div class="relationship-fields">
                                                <div class="form-field">
                                                    <label>Relationship Type*</label>
                                                    <select name="contact_relationship_type[]" class="form-select"
                                                        required>
                                                        <option value="">Select Relationship</option>
                                                        <option value="parent">Parent</option>
                                                        <option value="guardian">Guardian</option>
                                                        <option value="relative">Relative</option>
                                                        <option value="neighbor">Neighbor</option>
                                                        <option value="doctor">Doctor</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>

                                                <div class="toggle-group">
                                                    @include(
                                                        'frontend.components.enrollment.toggle-switch',
                                                        [
                                                            'name' => 'contact_lives_with[]',
                                                            'label' => 'Lives With',
                                                            'value' => false,
                                                            'id' => 'livesWith0',
                                                        ]
                                                    )
                                                    @include(
                                                        'frontend.components.enrollment.toggle-switch',
                                                        [
                                                            'name' => 'contact_is_emergency[]',
                                                            'label' => 'Emergency',
                                                            'value' => false,
                                                            'id' => 'isEmergency0',
                                                        ]
                                                    )
                                                    @include(
                                                        'frontend.components.enrollment.toggle-switch',
                                                        [
                                                            'name' => 'contact_is_pickup[]',
                                                            'label' => 'Pickup',
                                                            'value' => false,
                                                            'id' => 'isPickup0',
                                                        ]
                                                    )
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                       
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="enrollment-actions">
                    <div
                            style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-top: 15px;">
                            <i class="fas fa-plus btn-add-phone-icon" onclick="addContactField()"></i>
                            <button type="button" class="btn-add-phone-text" onclick="addContactField()">
                                Add Next Contact
                            </button>
                        <button type="submit" class="btn-enrollment btn-step4" data-action="step4">
                            SAVE & GO TO STEP 4
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/assets/js/enrollment-form.js') }}"></script>
    <script>
        let contactIndex = {{ isset($contacts) && count($contacts) > 0 ? count($contacts) : 1 }};

        function addContactField() {
            const container = document.getElementById('contactsFieldsContainer');
            const index = contactIndex++;
            const newGroup = document.createElement('div');
            newGroup.className = 'contact-field-group';
            newGroup.setAttribute('data-contact-index', index);
            newGroup.innerHTML = `
            <div class="contact-info-section">
                <div class="section-header">
                    <i class="far fa-user section-icon"></i>
                    <h3 class="section-subtitle">Contact Info</h3>
                </div>
                <div class="form-grid">
                    <div class="form-field">
                        <label>First Name*</label>
                        <input type="text" name="contact_first_name[]" class="form-input" placeholder="Johnathan" required />
                    </div>
                    <div class="form-field">
                        <label>M.I.</label>
                        <input type="text" name="contact_middle_initial[]" class="form-input" maxlength="1" />
                    </div>
                    <div class="form-field">
                        <label>Last Name*</label>
                        <input type="text" name="contact_last_name[]" class="form-input" placeholder="smith" required />
                    </div>
                    <div class="form-field">
                        <label>Gender</label>
                        <select name="contact_gender[]" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label>Date Of Birth</label>
                        <input type="date" name="contact_date_of_birth[]" class="form-input" />
                    </div>
                    <div class="form-field">
                        <button type="button" class="btn-remove-contact" onclick="removeContactField(this)">Remove Contact</button>
                    </div>
                </div>
            </div>
            <div class="relationship-section">
                <div class="section-header">
                    <i class="far fa-users section-icon"></i>
                    <h3 class="section-subtitle">Relationship To Children</h3>
                </div>
                <div class="relationship-content">
                    <div class="contact-profile-display">
                        <div class="profile-picture-wrapper">
                            <div class="profile-picture-container">
                                <img src="{{ asset('frontend/assets/home_page_images/enroll-avatar.png') }}" alt="" class="profile-picture" />
                                <input type="file" name="contact_profile_image[]" accept="image/*" class="profile-picture-input" style="display: none;" />
                            </div>
                            <button type="button" class="btn-change-image" onclick="this.previousElementSibling.querySelector('input').click()">Change Image</button>
                        </div>
                    </div>
                    <div class="relationship-fields">
                        <div class="form-field">
                            <label>Relationship Type*</label>
                            <select name="contact_relationship_type[]" class="form-select" required>
                                <option value="">Select Relationship</option>
                                <option value="parent">Parent</option>
                                <option value="guardian">Guardian</option>
                                <option value="relative">Relative</option>
                                <option value="neighbor">Neighbor</option>
                                <option value="doctor">Doctor</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="toggle-group">
                            <div class="toggle-switch-wrapper">
                                <label class="toggle-switch-label">Lives With</label>
                                <div class="toggle-switch">
                                    <input type="checkbox" name="contact_lives_with[]" id="livesWith${index}" value="1" class="toggle-input">
                                    <label for="livesWith${index}" class="toggle-label">
                                        <span class="toggle-slider">
                                            <span class="toggle-text-yes">YES</span>
                                            <span class="toggle-text-no">NO</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="toggle-switch-wrapper">
                                <label class="toggle-switch-label">Emergency</label>
                                <div class="toggle-switch">
                                    <input type="checkbox" name="contact_is_emergency[]" id="isEmergency${index}" value="1" class="toggle-input">
                                    <label for="isEmergency${index}" class="toggle-label">
                                        <span class="toggle-slider">
                                            <span class="toggle-text-yes">YES</span>
                                            <span class="toggle-text-no">NO</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="toggle-switch-wrapper">
                                <label class="toggle-switch-label">Pickup</label>
                                <div class="toggle-switch">
                                    <input type="checkbox" name="contact_is_pickup[]" id="isPickup${index}" value="1" class="toggle-input">
                                    <label for="isPickup${index}" class="toggle-label">
                                        <span class="toggle-slider">
                                            <span class="toggle-text-yes">YES</span>
                                            <span class="toggle-text-no">NO</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
            container.appendChild(newGroup);

            // Attach image preview event listener to the new file input
            const newFileInput = newGroup.querySelector('input[type="file"][accept="image/*"]');
            if (newFileInput) {
                newFileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const container = newFileInput.closest('.profile-picture-container');
                            if (container) {
                                const img = container.querySelector('.profile-picture');
                                if (img) {
                                    img.src = e.target.result;
                                }
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        function removeContactField(button) {
            button.closest('.contact-field-group').remove();
        }
    </script>
@endpush
