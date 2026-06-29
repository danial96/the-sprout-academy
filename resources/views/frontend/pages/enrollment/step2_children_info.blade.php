@extends('frontend.partials.master')

@section('title', 'Enrollment - Children Info - ' . $locationData['name'])

@section('content')
    @include('frontend.components.form_header', [
        'title' => 'THE SPROUT ACADEMY - ' . $locationData['name'],
    ])

    <!-- Enrollment Form Section -->
    <section class="enrollment-form-section">
        <div class="container">
            <div class="enrollment-form-wrapper">
                <!-- Progress Bar -->
                @include('frontend.components.enrollment.progress-bar', ['currentStep' => $currentStep])

                <!-- Form -->
                <form id="enrollmentStep2Form" class="enrollment-form site_form" method="POST"
                    action="{{ route('enrollment.saveStep2', ['location' => $location]) }}" enctype="multipart/form-data">
                    @csrf
                    <div id="formMessage" class="form-message" style="display: none;"></div>

                    <!-- Child Info -->
                    <div class="enrollment-section" id="enrollment-form-primary-account-person">
                        <div class="section-header-wrapper">
                            <div class="section-header">
                                <i class="far fa-user section-icon"></i>
                                <h2 class="section-title-inner">Child Info</h2>
                            </div>
                            <div class="section-required-note">
                                <span class="required-asterisk">*</span> Indicates Required Field
                            </div>
                        </div>

                        <div id="childrenFieldsContainer">
                            @if (isset($children) && count($children) > 0)
                                @foreach ($children as $index => $child)
                                    <div class="child-field-group" data-child-index="{{ $index }}">
                                        <div class="form-grid">
                                            <div class="form-field">
                                                <label>First Name*</label>
                                                <input type="text" name="child_first_name[]" class="form-input"
                                                    value="{{ $child->first_name }}" placeholder="Johnathan" required />
                                            </div>
                                            <div class="form-field">
                                                <label>M.I.</label>
                                                <input type="text" name="child_middle_initial[]" class="form-input"
                                                    value="{{ $child->middle_initial ?? '' }}" maxlength="1" />
                                            </div>
                                            <div class="form-field">
                                                <label>Last Name*</label>
                                                <input type="text" name="child_last_name[]" class="form-input"
                                                    value="{{ $child->last_name }}" placeholder="smith" required />
                                            </div>
                                            <div class="form-field">
                                                <label>Gender</label>
                                                <select name="child_gender[]" class="form-select">
                                                    <option value="">Select Gender</option>
                                                    <option value="male" {{ $child->gender == 'male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="female"
                                                        {{ $child->gender == 'female' ? 'selected' : '' }}>Female</option>
                                                    <option value="other"
                                                        {{ $child->gender == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-field">
                                                <label>Date Of Birth</label>
                                                <input type="date" name="child_date_of_birth[]" class="form-input"
                                                    value="{{ $child->date_of_birth ? $child->date_of_birth->format('Y-m-d') : '' }}" />
                                            </div>
                                        </div>

                                        <!-- Profile Picture -->
                                        <div class="profile-section">
                                            @include('frontend.components.enrollment.profile-picture', [
                                                'imageUrl' => $child->profile_image
                                                    ? \Illuminate\Support\Facades\Storage::url(
                                                        $child->profile_image)
                                                    : asset(
                                                        'frontend/assets/home_page_images/enroll-avatar.png'),
                                                'name' => $child->first_name . ' ' . $child->last_name,
                                                'fieldName' => 'child_profile_image[]',
                                                'showChangeButton' => true,
                                            ])
                                        </div>

                                        @if ($index > 0)
                                            <button type="button" class="btn-remove-child"
                                                onclick="removeChildField(this)">Remove Child</button>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="child-field-group" data-child-index="0">
                                    <div class="form-grid">
                                        <div class="form-field">
                                            <label>First Name*</label>
                                            <input type="text" name="child_first_name[]" class="form-input" required />
                                        </div>
                                        <div class="form-field">
                                            <label>M.I.</label>
                                            <input type="text" name="child_middle_initial[]" class="form-input"
                                                maxlength="1" />
                                        </div>
                                        <div class="form-field">
                                            <label>Last Name*</label>
                                            <input type="text" name="child_last_name[]" class="form-input" required />
                                        </div>
                                        <div class="form-field">
                                            <label>Gender</label>
                                            <select name="child_gender[]" class="form-select">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-field">
                                            <label>Date Of Birth</label>
                                            <input type="date" name="child_date_of_birth[]" class="form-input" />
                                        </div>
                                    </div>

                                    <!-- Profile Picture -->
                                    <div class="profile-section">
                                        @include('frontend.components.enrollment.profile-picture', [
                                            'imageUrl' => asset(
                                                'frontend/assets/home_page_images/enroll-avatar.png'),
                                            'name' => '',
                                            'fieldName' => 'child_profile_image[]',
                                            'showChangeButton' => true,
                                        ])
                                    </div>
                                </div>
                            @endif
                        </div>                       
                    </div>

                    <!-- Action Buttons -->
                    <div class="enrollment-actions">
                        <button type="submit" class="btn-enrollment btn-step3" data-action="step3">
                            SAVE & GO TO STEP 3
                        </button>
                        <div
                            style="display: flex; justify-content: flex-end; align-items: center; gap: 10px; margin-top: 15px;">
                            <i class="fas fa-plus btn-add-phone-icon" onclick="addChildField()"></i>
                            <button type="button" class="btn-add-phone-text" onclick="addChildField()">
                                Save & Add Next Child
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/assets/js/enrollment-form.js') }}"></script>
    <script>
        let childIndex = {{ isset($children) && count($children) > 0 ? count($children) : 1 }};

        function addChildField() {
            const container = document.getElementById('childrenFieldsContainer');
            const index = childIndex++;
            const newGroup = document.createElement('div');
            newGroup.className = 'child-field-group';
            newGroup.setAttribute('data-child-index', index);
            newGroup.innerHTML = `
            <div class="form-grid">
                <div class="form-field">
                    <label>First Name*</label>
                    <input type="text" name="child_first_name[]" class="form-input" placeholder="Johnathan" required />
                </div>
                <div class="form-field">
                    <label>M.I.</label>
                    <input type="text" name="child_middle_initial[]" class="form-input" maxlength="1" />
                </div>
                <div class="form-field">
                    <label>Last Name*</label>
                    <input type="text" name="child_last_name[]" class="form-input" placeholder="smith" required />
                </div>
                <div class="form-field">
                    <label>Gender</label>
                    <select name="child_gender[]" class="form-select">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-field">
                    <label>Date Of Birth</label>
                    <input type="date" name="child_date_of_birth[]" class="form-input" />
                </div>
            </div>
            <div class="profile-section">
                <div class="profile-picture-wrapper">
                    <div class="profile-picture-container">
                        <img src="{{ asset('frontend/assets/home_page_images/enroll-avatar.png') }}" alt=""
                            class="profile-picture" />
                        <input type="file" name="child_profile_image[]" accept="image/*" class="profile-picture-input" style="display: none;" />
                    </div>
                    <button type="button" class="btn-change-image" onclick="this.previousElementSibling.querySelector('input').click()">Change Image</button>
                </div>
            </div>
            <button type="button" class="btn-remove-child" onclick="removeChildField(this)">Remove Child</button>
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

        function removeChildField(button) {
            button.closest('.child-field-group').remove();
        }
    </script>
@endpush
