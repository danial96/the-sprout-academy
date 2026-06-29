@extends('frontend.partials.master')

@section('title', 'Time Off Request Form')

@section('content')
    @include('frontend.components.form_header', [
        'title' => 'TIME OFF REQUEST FORM',
        'text' =>
            'Time Off Requests Must Be Submitted Three (3) Weeks In Advance Of The Date Being Requested Off. All Requests Are On A First Come First Serve Basis. Business Needs May Prohibit Request For Time Off To Being Approved. You Will Be Notified By Your Director If Your Request Has Been Approved.',
    ])

    {{-- Form Section --}}
    <section class="form-section form-section-gradient">
        <div class="container">
            <div class="site_form site_form_time_off_request">
                <form id="timeOffRequestForm" method="POST" action="{{ route('form.timeOffRequestForm') }}"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="form-wrapper">
                        <!-- Left Form Section -->
                        <div class="form-left">
                            {{-- Success/Error Messages --}}
                            <div id="formMessage" class="form-message" style="display: none;"></div>

                            <div class="form-grid">
                                {{-- Name --}}
                                <div class="form-field">
                                    <label for="name">Name{{ auth()->check() ? '' : '*' }}</label>
                                    <input type="text" id="name" name="name" class="form-input"
                                        value="{{ auth()->check() ? auth()->user()->name : '' }}"
                                        {{ auth()->check() ? 'readonly' : 'required' }} />
                                    @if (auth()->check())
                                        <small class="form-text text-muted">Pre-filled from your account</small>
                                    @endif
                                </div>

                                {{-- Email --}}
                                <div class="form-field">
                                    <label for="email">Your Email{{ auth()->check() ? '' : '*' }}</label>
                                    <input type="email" id="email" name="email" class="form-input"
                                        value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                        {{ auth()->check() ? 'readonly' : 'required' }} />
                                    @if (auth()->check())
                                        <small class="form-text text-muted">Pre-filled from your account</small>
                                    @endif
                                </div>

                                {{-- Location --}}
                                <div class="form-field">
                                    <label for="location">Location*</label>
                                    <select id="location" name="location" class="form-select" required>
                                        <option value="seminole" selected>Seminole</option>
                                        <option value="pinellas_park">Pinellas Park</option>
                                        <option value="largo">Largo</option>
                                        <option value="st_petersburg">St. Petersburg</option>
                                        <option value="montessori">Montessori</option>
                                    </select>
                                </div>

                                {{-- Today's Date --}}
                                <div class="form-field">
                                    <label for="today">Todays Date*</label>
                                    <input type="date" id="today" name="todays_date" class="form-input" required />
                                </div>

                                {{-- Start Date --}}
                                <div class="form-field">
                                    <label for="startDate">Start Of Date Requested Off*</label>
                                    <input type="date" id="startDate" name="start_date" class="form-input" required />
                                </div>

                                {{-- End Date --}}
                                <div class="form-field">
                                    <label for="endDate">End Of Date Requested Off*</label>
                                    <input type="date" id="endDate" name="end_date" class="form-input" required />
                                </div>

                                {{-- Paid Or Unpaid --}}
                                <div class="form-field form-field-full">
                                    <label for="paidUnpaid">Paid Or Unpaid?*</label>
                                    <select id="paidUnpaid" name="paid_unpaid" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="paid">Paid</option>
                                        <option value="unpaid">Unpaid</option>
                                    </select>
                                </div>

                                {{-- Reason --}}
                                <div class="form-field form-field-full">
                                    <label for="reason">Reason Time Off Is Needed:</label>
                                    <div class="textarea-wrapper">
                                        <textarea id="reason" name="reason" class="form-textarea" placeholder="Type Reason Here"></textarea>
                                    </div>
                                </div>

                                {{-- Director Signature (Disabled) - TEMPORARILY REMOVED --}}
                                {{-- <div class="form-field form-field-full">
                                    <label for="directorSignature">Director Signature (After It Is Submitted)</label>
                                    <input type="text" id="directorSignature" name="director_signature"
                                        class="form-input" disabled />
                                </div> --}}
                            </div>

                            <button type="submit" class="submit-btn" id="submitBtn">Submit Now</button>
                        </div>

                        <!-- Right Calendar Widget Section -->
                        <div class="form-right">
                            <div class="calendar-widget">
                                <!-- Label outside the white card -->
                                <div class="calendar-header">
                                    <label>Date</label>
                                    <span class="info-icon">i</span>
                                </div>

                                <!-- White Card containing all calendar elements -->
                                <div class="calendar-card">
                                    <!-- Calendar Grid -->
                                    <div id="calendarWidget"></div>

                                    <!-- Bottom Date and Time Inputs -->
                                <div class="calendar-footer">
                                    <div class="calendar-footer-item">
                                        <label>Date</label>
                                            <input type="text" id="calendarDateDisplay"
                                                class="form-input calendar-footer-input" readonly />
                                    </div>
                                    <div class="calendar-footer-item">
                                        <label>Time</label>
                                            <input type="text" id="calendarTimeDisplay"
                                                class="form-input calendar-footer-input" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            // ========================================
            // CALENDAR WIDGET INITIALIZATION (Right Side)
            // ========================================
            let calendarWidgetInstance = null;
            let timePickerInstance = null;

            // Function to make all calendar days non-clickable (but allow hover for tooltips)
            function makeDaysNonClickable(instance) {
                if (!instance || !instance.calendarContainer) return;
                
                const allDays = instance.calendarContainer.querySelectorAll('.flatpickr-day');
                allDays.forEach(day => {
                    // Allow hover events but prevent click selection
                    day.style.cursor = 'default';
                    // Prevent flatpickr from selecting dates on click
                    day.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        e.stopImmediatePropagation();
                        // Remove selected class if it gets added
                        day.classList.remove('selected');
                        return false;
                    }, true);
                    
                    // Also prevent mousedown which flatpickr uses
                    day.addEventListener('mousedown', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        e.stopImmediatePropagation();
                        return false;
                    }, true);
                });
            }

            // Initialize calendar widget
            const now = new Date();
            const defaultDate = now;
            const defaultTime = now.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });

            // Function to fetch and display time off requests on calendar
            function loadTimeOffRequests(month, year) {
                const location = document.getElementById('location')?.value || '';
                const apiUrl = "{{ route('form.timeOffRequests.calendar') }}";

                fetch(`${apiUrl}?location=${location}&month=${month}&year=${year}`)
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(requests => {

                        // Clear existing tooltips and indicators
                        document.querySelectorAll('.flatpickr-day .time-off-tooltip').forEach(el => el
                            .remove());
                        document.querySelectorAll('.flatpickr-day .time-off-indicator').forEach(el => el
                            .remove());
                        document.querySelectorAll('.flatpickr-day').forEach(day => {
                            day.classList.remove('has-time-off');
                        });

                        if (!requests || requests.length === 0) {
                            console.log('No approved requests found for this month');
                            return;
                        }

                        // Group requests by date
                        const requestsByDate = {};

                        requests.forEach(request => {
                            if (!request.start_date || !request.end_date) {
                                console.warn('Invalid request data:', request);
                                return;
                            }

                            const startDate = new Date(request.start_date + 'T00:00:00');
                            const endDate = new Date(request.end_date + 'T00:00:00');

                            // Get all dates in the range
                            const currentDate = new Date(startDate);
                            while (currentDate <= endDate) {
                                const dateYear = currentDate.getFullYear();
                                const dateMonth = currentDate.getMonth() + 1;
                                const dateDay = currentDate.getDate();

                                // Only show for dates in the current calendar month
                                if (dateYear == year && dateMonth == parseInt(month)) {
                                    const dateKey =
                                        `${dateYear}-${String(dateMonth).padStart(2, '0')}-${String(dateDay).padStart(2, '0')}`;
                                    if (!requestsByDate[dateKey]) {
                                        requestsByDate[dateKey] = [];
                                    }
                                    if (request.name) {
                                        requestsByDate[dateKey].push(request.name);
                                    }
                                }

                                currentDate.setDate(currentDate.getDate() + 1);
                            }
                        });

                        // Add tooltip and indicator to calendar days
                        // Use a small delay to ensure calendar is fully rendered
                        setTimeout(() => {
                            // Ensure all days are non-clickable
                            if (calendarWidgetInstance) {
                                makeDaysNonClickable(calendarWidgetInstance);
                            }
                            Object.keys(requestsByDate).forEach(dateKey => {
                                const [y, m, d] = dateKey.split('-');
                                const dateDay = parseInt(d);
                                const dateMonth = parseInt(m);
                                const dateYear = parseInt(y);

                                // Create target date for comparison
                                const targetDate = new Date(dateYear, dateMonth - 1, dateDay);
                                const targetDateStr =
                                    `${dateYear}-${String(dateMonth).padStart(2, '0')}-${String(dateDay).padStart(2, '0')}`;

                                // Find day element by matching date
                                const allDays = document.querySelectorAll(
                                    '.flatpickr-day:not(.prevMonthDay):not(.nextMonthDay)');

                                allDays.forEach(dayElement => {
                                    const dayText = dayElement.textContent.trim();
                                    const dayNum = parseInt(dayText);

                                    if (dayNum === dateDay) {
                                        // Get date from aria-label or try to construct from calendar context
                                        const ariaLabel = dayElement.getAttribute(
                                            'aria-label') || '';

                                        // Try to extract date from aria-label (format: "January 15, 2024")
                                        let isMatch = false;

                                        if (ariaLabel) {
                                            // Parse aria-label to get the date
                                            const ariaDateMatch = ariaLabel.match(
                                                /(\w+)\s+(\d+),\s+(\d+)/);
                                            if (ariaDateMatch) {
                                                const monthNames = ['january',
                                                    'february', 'march', 'april',
                                                    'may', 'june',
                                                    'july', 'august', 'september',
                                                    'october', 'november',
                                                    'december'
                                                ];
                                                const monthName = ariaDateMatch[1]
                                                    .toLowerCase();
                                                const monthIndex = monthNames.indexOf(
                                                    monthName);
                                                const ariaDay = parseInt(ariaDateMatch[
                                                    2]);
                                                const ariaYear = parseInt(ariaDateMatch[
                                                    3]);

                                                if (monthIndex === dateMonth - 1 &&
                                                    ariaDay === dateDay && ariaYear ===
                                                    dateYear) {
                                                    isMatch = true;
                                                }
                                            } else {
                                                // Fallback: check if year and month are mentioned
                                                if (ariaLabel.includes(dateYear
                                                        .toString()) &&
                                                    (ariaLabel.includes(dateMonth
                                                            .toString()) ||
                                                        ariaLabel.toLowerCase()
                                                        .includes(['january',
                                                                'february', 'march',
                                                                'april', 'may',
                                                                'june', 'july',
                                                                'august', 'september',
                                                                'october', 'november',
                                                                'december'
                                                            ][dateMonth - 1]
                                                            .toLowerCase()))) {
                                                    isMatch = true;
                                                }
                                            }
                                        } else {
                                            // If no aria-label, try to match by calendar context
                                            // Check if calendar instance is available and get date from it
                                            if (calendarWidgetInstance) {
                                                const calendarDate =
                                                    calendarWidgetInstance.parseDate(
                                                        dayElement);
                                                if (calendarDate) {
                                                    const calYear = calendarDate
                                                        .getFullYear();
                                                    const calMonth = calendarDate
                                                        .getMonth() + 1;
                                                    const calDay = calendarDate
                                                        .getDate();

                                                    if (calYear === dateYear &&
                                                        calMonth === dateMonth &&
                                                        calDay === dateDay) {
                                                        isMatch = true;
                                                    }
                                                }
                                            }
                                        }

                                        if (isMatch) {
                                            // Mark day as having time off - adds dark blue background
                                            dayElement.classList.add('has-time-off');

                                            // Remove existing tooltip if any
                                            const existingTooltip = dayElement
                                                .querySelector('.time-off-tooltip');
                                            if (existingTooltip) {
                                                existingTooltip.remove();
                                            }

                                            // Make day non-clickable but allow hover
                                            dayElement.style.cursor = 'default';

                                            // Prevent flatpickr from handling clicks on this day
                                            dayElement.addEventListener('click',
                                                function(e) {
                                                    e.preventDefault();
                                                    e.stopPropagation();
                                                    e.stopImmediatePropagation();
                                                    // Remove selected class
                                                    dayElement.classList.remove('selected');
                                                    return false;
                                                }, true);
                                            
                                            // Also prevent mousedown
                                            dayElement.addEventListener('mousedown',
                                                function(e) {
                                                    e.preventDefault();
                                                    e.stopPropagation();
                                                    e.stopImmediatePropagation();
                                                    return false;
                                                }, true);

                                            // Create tooltip that will be appended to body to avoid clipping
                                            const namesList = requestsByDate[dateKey]
                                                .join(', ');
                                            dayElement.setAttribute(
                                                'data-time-off-names', namesList);

                                            // Create a global tooltip element (reused for all days) - create once
                                            if (!window.timeOffGlobalTooltip) {
                                                window.timeOffGlobalTooltip = document
                                                    .createElement('div');
                                                window.timeOffGlobalTooltip.id =
                                                    'time-off-global-tooltip';
                                                window.timeOffGlobalTooltip.className =
                                                    'time-off-global-tooltip';
                                                document.body.appendChild(window
                                                    .timeOffGlobalTooltip);
                                            }

                                            // Function to update tooltip position
                                            const updateTooltipPosition = function() {
                                                const rect = dayElement
                                                    .getBoundingClientRect();
                                                window.timeOffGlobalTooltip
                                                    .textContent = namesList;
                                                window.timeOffGlobalTooltip.style
                                                    .left = (rect.left + rect
                                                        .width / 2) + 'px';
                                                window.timeOffGlobalTooltip.style
                                                    .top = (rect.top - 10) + 'px';
                                                window.timeOffGlobalTooltip.style
                                                    .transform =
                                                    'translate(-50%, -100%)';
                                            };

                                            // Add hover event listeners
                                            dayElement.addEventListener('mouseenter',
                                                function(e) {
                                                    e.stopPropagation();
                                                    updateTooltipPosition();
                                                    window.timeOffGlobalTooltip
                                                        .style.display = 'block';
                                                }, true);

                                            dayElement.addEventListener('mouseleave',
                                                function(e) {
                                                    e.stopPropagation();
                                                    window.timeOffGlobalTooltip
                                                        .style.display = 'none';
                                                }, true);

                                            // Update position on scroll/resize for this day
                                            const updateOnScroll = function() {
                                                if (window.timeOffGlobalTooltip
                                                    .style.display === 'block' &&
                                                    dayElement.matches(':hover')) {
                                                    updateTooltipPosition();
                                                }
                                            };

                                            window.addEventListener('scroll',
                                                updateOnScroll, true);
                                            window.addEventListener('resize',
                                                updateOnScroll);

                                            // Prevent click from removing the has-time-off class and prevent selection
                                            // Use MutationObserver to watch for class changes
                                            const observer = new MutationObserver(
                                                function(mutations) {
                                                    mutations.forEach(function(
                                                        mutation) {
                                                        if (mutation
                                                            .type ===
                                                            'attributes' &&
                                                            mutation
                                                            .attributeName ===
                                                            'class') {
                                                            // Remove selected class if it gets added
                                                            if (dayElement.classList.contains('selected')) {
                                                                dayElement.classList.remove('selected');
                                                            }
                                                            
                                                            if (!dayElement
                                                                .classList
                                                                .contains(
                                                                    'has-time-off'
                                                                )) {
                                                                // Restore the class immediately
                                                                dayElement
                                                                    .classList
                                                                    .add(
                                                                        'has-time-off'
                                                                    );
                                                            }
                                                        }
                                                    });
                                                });

                                            observer.observe(dayElement, {
                                                attributes: true,
                                                attributeFilter: ['class']
                                            });

                                            console.log(
                                                `Added tooltip for date: ${targetDateStr}`
                                            );
                                        }
                                    }
                                });
                            });
                        }, 100);
                    })
                    .catch(error => {
                        console.error('Error loading time off requests:', error);
                        console.error('Error details:', error.message, error.stack);
                    });
            }

            // Initialize main calendar
            calendarWidgetInstance = flatpickr('#calendarWidget', {
                inline: true,
                defaultDate: defaultDate,
                dateFormat: 'm/d/Y',
                clickOpens: false, // Disable date selection on click
                onChange: function(selectedDates, dateStr) {
                    // Prevent date selection - clear any selected dates
                        if (selectedDates.length > 0) {
                        // Clear selection immediately
                        calendarWidgetInstance.clear();
                        // Remove selected class from all days
                        const allDays = calendarWidgetInstance.calendarContainer.querySelectorAll('.flatpickr-day.selected');
                        allDays.forEach(day => day.classList.remove('selected'));
                    }
                },
                onMonthChange: function(selectedDates, dateStr, instance) {
                    // Make all calendar days non-clickable after month change
                    setTimeout(() => {
                        makeDaysNonClickable(instance);
                    }, 100);
                    
                    const month = String(instance.currentMonth + 1).padStart(2, '0');
                    const year = instance.currentYear;
                    loadTimeOffRequests(month, year);
                },
                onYearChange: function(selectedDates, dateStr, instance) {
                    // Make all calendar days non-clickable after year change
                    setTimeout(() => {
                        makeDaysNonClickable(instance);
                    }, 100);
                    
                    const month = String(instance.currentMonth + 1).padStart(2, '0');
                    const year = instance.currentYear;
                    loadTimeOffRequests(month, year);
                },
                onReady: function(selectedDates, dateStr, instance) {
                    // Make all calendar days non-clickable
                    makeDaysNonClickable(instance);
                    
                    // Fix dayContainer width to show 7 days properly
                    setTimeout(() => {
                        const dayContainer = instance.calendarContainer.querySelector('.dayContainer');
                        if (dayContainer) {
                            // Calculate width for 7 days: (day width + margin) * 7
                            const dayWidth = 44; // 40px width + 2px margin on each side
                            const containerWidth = dayWidth * 7;
                            dayContainer.style.width = containerWidth + 'px';
                            dayContainer.style.minWidth = containerWidth + 'px';
                            dayContainer.style.maxWidth = containerWidth + 'px';
                        }
                    }, 100);

                    // Load requests for current month
                    const month = String(instance.currentMonth + 1).padStart(2, '0');
                    const year = instance.currentYear;
                    loadTimeOffRequests(month, year);
                }
            });

            // Initialize time picker - make it open on click of time display
            const timeDisplayInput = document.getElementById('calendarTimeDisplay');
            timePickerInstance = flatpickr(timeDisplayInput, {
                enableTime: true,
                noCalendar: true,
                dateFormat: 'h:i K',
                defaultDate: defaultDate,
                time_24hr: false,
                clickOpens: true,
                onChange: function(selectedDates, timeStr) {
                    // Time picker updates the time display directly
                    // No need to update combined display since it's removed
                }
            });

            // Set initial values
            const initialDate = now;
            const month = String(initialDate.getMonth() + 1).padStart(2, '0');
            const day = String(initialDate.getDate()).padStart(2, '0');
            const year = initialDate.getFullYear();
            const fullDate = month + '/' + day + '/' + year;

            document.getElementById('calendarDateDisplay').value = fullDate;
            document.getElementById('calendarTimeDisplay').value = defaultTime;

            // Set today's date field to today
            const todayInput = document.getElementById('today');
            if (todayInput) {
                const todayDateStr = `${year}-${month}-${day}`;
                todayInput.value = todayDateStr;
                todayInput.setAttribute('min', todayDateStr);
            }

            // Set min date for start and end date fields
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            if (startDateInput) {
                const todayDateStr = `${year}-${month}-${day}`;
                startDateInput.setAttribute('min', todayDateStr);
            }
            if (endDateInput) {
                const todayDateStr = `${year}-${month}-${day}`;
                endDateInput.setAttribute('min', todayDateStr);
            }

            // Reload calendar when location changes
            const locationSelect = document.getElementById('location');
            if (locationSelect) {
                locationSelect.addEventListener('change', function() {
                    if (calendarWidgetInstance) {
                        const currentMonth = String(calendarWidgetInstance.currentMonth + 1).padStart(2,
                            '0');
                        const currentYear = calendarWidgetInstance.currentYear;
                        loadTimeOffRequests(currentMonth, currentYear);
                    }
                });
            }

            // ========================================
            // FORM SUBMISSION HANDLER
            // ========================================
                const form = document.getElementById('timeOffRequestForm');
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.createElement('span');
            spinner.className = 'spinner-border spinner-border-sm me-2';
            spinner.setAttribute('role', 'status');
            spinner.setAttribute('aria-hidden', 'true');

            if (form) {
                form.addEventListener('submit', async function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    event.stopImmediatePropagation();

                    // Check form validity first
                    if (!form.checkValidity()) {
                        console.log('Form validation failed');
                        form.reportValidity();
                        return false;
                    }


                    if (submitBtn.disabled) {
                        console.log('Form already submitting, ignoring duplicate submission');
                        return false;
                    }

                    submitBtn.disabled = true;
                    if (spinner && !spinner.parentNode) {
                        submitBtn.prepend(spinner);
                    }

                    // Date fields are now simple date inputs, no need to format
                    // The form will submit them directly in YYYY-MM-DD format

                    const formData = new FormData(form);

                    // Debug: Log form data
                    console.log('Form submission started');
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        console.error('CSRF token meta tag not found');
                        const messageDiv = document.getElementById('formMessage');
                        if (messageDiv) {
                            messageDiv.className = 'form-message form-message-error';
                            messageDiv.textContent = 'CSRF token not found. Please refresh the page.';
                            messageDiv.style.display = 'block';
                        }
                        submitBtn.disabled = false;
                        spinner.remove();
                        return;
                    }

                    try {
                        console.log('Sending request to:', "{{ route('form.timeOffRequestForm') }}");
                        const response = await fetch("{{ route('form.timeOffRequestForm') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const messageDiv = document.getElementById('formMessage');
                        if (!messageDiv) {
                            console.error('Message div not found');
                            submitBtn.disabled = false;
                            spinner.remove();
                            return;
                        }

                        // Check if response is OK first
                        if (!response.ok) {
                            console.error('Response not OK:', response.status, response.statusText);
                            let errorMessage = 'Form submission failed.';

                            try {
                                const contentType = response.headers.get('content-type');
                                if (contentType && contentType.includes('application/json')) {
                                    const errorResult = await response.json();
                                    if (errorResult.errors) {
                                        errorMessage += '\n' + Object.values(errorResult.errors).flat()
                                            .join('\n');
                                    } else if (errorResult.message) {
                                        errorMessage += '\n' + errorResult.message;
                                    }
                                } else {
                                    const text = await response.text();
                                    console.error('Non-JSON error response:', text.substring(0, 200));
                                }
                            } catch (parseError) {
                                console.error('Error parsing error response:', parseError);
                                errorMessage += '\nStatus: ' + response.status + ' ' + response
                                    .statusText;
                            }

                            messageDiv.className = 'form-message form-message-error';
                            messageDiv.textContent = errorMessage;
                            messageDiv.style.display = 'block';
                            submitBtn.disabled = false;
                            spinner.remove();
                            return;
                        }

                        // Response is OK, parse JSON
                        let result;
                        const contentType = response.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            result = await response.json();
                            console.log('Success result:', result);
                        } else {
                            // If response is not JSON, it might be an HTML error page
                            const text = await response.text();
                            console.error('Non-JSON success response:', text.substring(0, 200));
                            throw new Error(
                                'Server returned non-JSON response. Please check the form and try again.'
                            );
                        }

                        // Only show success if we have a valid result
                        if (result && (result.message || response.ok)) {
                            messageDiv.className = 'form-message form-message-success';
                            messageDiv.textContent = result.message || 'Form submitted successfully!';
                            messageDiv.style.display = 'block';

                            // Reset form
                            form.reset();

                            // Reset today's date to current date
                            const todayInput = document.getElementById('today');
                            if (todayInput) {
                                const now = new Date();
                                const month = String(now.getMonth() + 1).padStart(2, '0');
                                const day = String(now.getDate()).padStart(2, '0');
                                const year = now.getFullYear();
                                const todayDateStr = `${year}-${month}-${day}`;
                                todayInput.value = todayDateStr;
                                todayInput.setAttribute('min', todayDateStr);
                            }

                            // Reset min dates for start and end date fields
                            const startDateInput = document.getElementById('startDate');
                            const endDateInput = document.getElementById('endDate');
                            if (startDateInput) {
                                const now = new Date();
                                const month = String(now.getMonth() + 1).padStart(2, '0');
                                const day = String(now.getDate()).padStart(2, '0');
                                const year = now.getFullYear();
                                const todayDateStr = `${year}-${month}-${day}`;
                                startDateInput.setAttribute('min', todayDateStr);
                                startDateInput.value = '';
                            }
                            if (endDateInput) {
                                const now = new Date();
                                const month = String(now.getMonth() + 1).padStart(2, '0');
                                const day = String(now.getDate()).padStart(2, '0');
                                const year = now.getFullYear();
                                const todayDateStr = `${year}-${month}-${day}`;
                                endDateInput.setAttribute('min', todayDateStr);
                                endDateInput.value = '';
                            }

                            // Reload calendar to show new request (if approved)
                            if (calendarWidgetInstance) {
                                const currentMonth = String(calendarWidgetInstance.currentMonth + 1)
                                    .padStart(2, '0');
                                const currentYear = calendarWidgetInstance.currentYear;
                                loadTimeOffRequests(currentMonth, currentYear);
                            }

                            // Redirect to thank you page after 2 seconds
                            setTimeout(() => {
                                window.location.href = "{{ route('frontend.thankYou') }}";
                            }, 2000);
                        } else {
                            // This should not happen if response.ok is true, but just in case
                            console.error('Unexpected: response.ok is true but result is invalid:',
                                result);
                            messageDiv.className = 'form-message form-message-error';
                            messageDiv.textContent =
                                'Form submission failed. Invalid response from server.';
                            messageDiv.style.display = 'block';
                            submitBtn.disabled = false;
                            spinner.remove();
                        }
                    } catch (error) {
                        console.error('Error in form submission:', error);
                        console.error('Error details:', error.message);
                        if (error.stack) {
                            console.error('Stack trace:', error.stack);
                        }

                        const messageDiv = document.getElementById('formMessage');
                        if (messageDiv) {
                            messageDiv.className = 'form-message form-message-error';
                            messageDiv.textContent = 'An unexpected error occurred: ' + error.message +
                                '. Please check your connection and try again.';
                            messageDiv.style.display = 'block';
                        }

                        // Make sure button is re-enabled on error
                        if (submitBtn) {
                            submitBtn.disabled = false;
                        }
                        if (spinner && spinner.parentNode) {
                            spinner.remove();
                        }
                    }
                });
            }
            });
        </script>
    @endpush
