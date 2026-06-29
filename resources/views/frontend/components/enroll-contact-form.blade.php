{{-- Dynamic contact form for /enroll — locations from $locations (Location::active()) --}}
@php
    $contactLocations = $locations ?? collect();
@endphp

<div class="enroll-contact-form-block">
    <h2 id="enroll-contact-heading" class="enroll-contact-form-title">Send us a message!</h2>

    <form id="enrollContactForm" class="enroll-contact-form" method="post"
        action="{{ route('frontend.enroll.contactMessage') }}" novalidate>
        @csrf

        <div id="enrollContactFormAlert" class="enroll-contact-form-alert" role="alert" hidden></div>

        <div class="enroll-contact-form-row">
            <div class="enroll-contact-field">
                <label class="enroll-contact-label" for="enrollContactName">Enter your name <span
                        class="text-danger" aria-hidden="true">*</span></label>
                <input type="text" id="enrollContactName" name="name" class="enroll-contact-input" required
                    maxlength="255" autocomplete="name" placeholder="Your name" />
            </div>
            <div class="enroll-contact-field">
                <label class="enroll-contact-label" for="enrollContactEmail">Enter email address <span
                        class="text-danger" aria-hidden="true">*</span></label>
                <input type="email" id="enrollContactEmail" name="email" class="enroll-contact-input" required
                    maxlength="255" autocomplete="email" placeholder="you@example.com" />
            </div>
        </div>

        @if ($contactLocations->isNotEmpty())
            <fieldset class="enroll-contact-locations">
                {{-- <legend class="enroll-contact-label enroll-contact-locations-legend">Location(s) <span
                        class="text-danger" aria-hidden="true">*</span></legend>
                <p id="enrollContactLocationsHint" class="enroll-contact-locations-hint">Select one or more
                    locations.</p> --}}
                <div class="enroll-contact-location-chips" role="group" aria-describedby="enrollContactLocationsHint">
                    @foreach ($contactLocations as $location)
                        <label class="enroll-contact-location-option">
                            <input type="checkbox" name="locations[]" value="{{ $location->slug }}"
                                class="enroll-contact-location-input" />
                            <span class="enroll-contact-location-box" aria-hidden="true"></span>
                            <span class="enroll-contact-location-text">{{ $location->name }}</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>
        @endif

        <div class="enroll-contact-field">
            <label class="enroll-contact-label" for="enrollContactMessage">Message here <span class="text-danger"
                    aria-hidden="true">*</span></label>
            <div class="enroll-contact-textarea-wrap">
                <span class="enroll-contact-textarea-icon" aria-hidden="true"><i class="fas fa-edit"></i></span>
                <textarea id="enrollContactMessage" name="message" class="enroll-contact-textarea" required
                    maxlength="10000" rows="5" placeholder="Type here"></textarea>
            </div>
        </div>

        <button type="submit" class="enroll-contact-submit" id="enrollContactSubmit">
            <span class="enroll-contact-submit-text">Submit now</span>
            <span class="enroll-contact-submit-spinner" hidden><i class="fas fa-spinner fa-spin"
                    aria-hidden="true"></i></span>
        </button>
    </form>
</div>

@push('scripts')
    <script>
        (function() {
            var form = document.getElementById('enrollContactForm');
            if (!form) return;

            var alertEl = document.getElementById('enrollContactFormAlert');
            var submitBtn = document.getElementById('enrollContactSubmit');
            var textSpan = submitBtn ? submitBtn.querySelector('.enroll-contact-submit-text') : null;
            var spinSpan = submitBtn ? submitBtn.querySelector('.enroll-contact-submit-spinner') : null;

            function showAlert(type, message) {
                if (!alertEl) return;
                alertEl.hidden = false;
                alertEl.textContent = message;
                alertEl.className = 'enroll-contact-form-alert enroll-contact-form-alert--' + type;
                alertEl.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }

            function hideAlert() {
                if (!alertEl) return;
                alertEl.hidden = true;
                alertEl.textContent = '';
                alertEl.className = 'enroll-contact-form-alert';
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                hideAlert();

                var locationInputs = form.querySelectorAll('input[name="locations[]"]:checked');
                if (form.querySelector('input[name="locations[]"]') && locationInputs.length === 0) {
                    showAlert('error', 'Please select at least one location.');
                    return;
                }

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                var fd = new FormData(form);
                var token = document.querySelector('meta[name="csrf-token"]');
                if (submitBtn) submitBtn.disabled = true;
                if (textSpan) textSpan.hidden = true;
                if (spinSpan) spinSpan.hidden = false;

                fetch(form.action, {
                        method: 'POST',
                        body: fd,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token ? token.getAttribute('content') : ''
                        },
                        credentials: 'same-origin'
                    })
                    .then(function(r) {
                        return r.json().then(function(data) {
                            return {
                                ok: r.ok,
                                data: data
                            };
                        });
                    })
                    .then(function(res) {
                        if (res.ok && res.data.success) {
                            showAlert('success', res.data.message || 'Thank you! Your message has been sent.');
                            form.reset();
                        } else {
                            var msg = (res.data && res.data.message) ? res.data.message :
                                'Something went wrong.';
                            if (res.data && res.data.errors) {
                                var errs = res.data.errors;
                                var lines = [];
                                Object.keys(errs).forEach(function(k) {
                                    if (Array.isArray(errs[k])) lines.push(errs[k].join(' '));
                                });
                                if (lines.length) msg = lines.join(' ');
                            }
                            showAlert('error', msg);
                        }
                    })
                    .catch(function() {
                        showAlert('error', 'Network error. Please try again.');
                    })
                    .finally(function() {
                        if (submitBtn) submitBtn.disabled = false;
                        if (textSpan) textSpan.hidden = false;
                        if (spinSpan) spinSpan.hidden = true;
                    });
            });
        })();
    </script>
@endpush
