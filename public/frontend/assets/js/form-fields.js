/**
 * Form Fields Handler - Date and Time Pickers
 * Automatically initializes all date and time fields on the page
 */

(function () {
    "use strict";

    // ========================================
    // DATE PICKER INITIALIZATION
    // ========================================
    function initializeDatePickers() {
        const dateFields = document.querySelectorAll("[data-date-field]");

        dateFields.forEach((wrapper) => {
            const fieldId = wrapper.getAttribute("data-date-field");
            const monthInput = document.getElementById(`${fieldId}Month`);
            const dayInput = document.getElementById(`${fieldId}Day`);
            const yearInput = document.getElementById(`${fieldId}Year`);
            const datePickerInput = document.getElementById(
                `${fieldId}DatePicker`
            );

            // Use data-date-trigger attribute for more reliable selection
            const calendarIcon =
                wrapper.querySelector(`[data-date-trigger="${fieldId}"]`) ||
                document.getElementById(`${fieldId}CalendarIcon`);

            if (
                !monthInput ||
                !dayInput ||
                !yearInput ||
                !datePickerInput ||
                !calendarIcon
            ) {
                console.warn(
                    `Date picker initialization failed for field: ${fieldId}`
                );
                return;
            }

            // Get default date and min date from data attributes
            const defaultDate = wrapper.dataset.defaultDate || null;
            const minDate = wrapper.dataset.minDate || null;

            // Don't auto-fill date fields - let placeholders show instead
            // Users can select date from calendar or type manually

            // Initialize Flatpickr
            const datePicker = flatpickr(`#${fieldId}DatePicker`, {
                dateFormat: "Y-m-d",
                defaultDate: defaultDate === "today" ? "today" : null,
                minDate: minDate === "today" ? "today" : null,
                appendTo: wrapper,
                static: false,
                allowInput: false,
                clickOpens: true,
                enableTime: false,
                onReady: function (selectedDates, dateStr, instance) {
                    positionCalendar(instance, calendarIcon);
                    // Ensure month/year navigation works
                    const monthNav = instance.calendarContainer.querySelector('.flatpickr-month');
                    const yearNav = instance.calendarContainer.querySelector('.flatpickr-year');
                    if (monthNav) {
                        monthNav.style.pointerEvents = 'auto';
                        monthNav.style.cursor = 'pointer';
                    }
                    if (yearNav) {
                        yearNav.style.pointerEvents = 'auto';
                        yearNav.style.cursor = 'pointer';
                    }
                },
                onChange: function (selectedDates, dateStr, instance) {
                    if (selectedDates && selectedDates.length > 0) {
                        updateSplitDateFields(
                            selectedDates,
                            `${fieldId}Month`,
                            `${fieldId}Day`,
                            `${fieldId}Year`
                        );
                    }
                },
                onMonthChange: function (selectedDates, dateStr, instance) {
                    // Ensure calendar stays open and positioned correctly when month changes
                    setTimeout(() => {
                        positionCalendar(instance, calendarIcon);
                    }, 10);
                },
                onYearChange: function (selectedDates, dateStr, instance) {
                    // Ensure calendar stays open and positioned correctly when year changes
                    setTimeout(() => {
                        positionCalendar(instance, calendarIcon);
                    }, 10);
                },
            });

            // Function to open calendar
            function openCalendar() {
                datePicker.open();
                setTimeout(
                    () => positionCalendar(datePicker, calendarIcon),
                    10
                );
            }

            // Open calendar on icon click
            calendarIcon.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                openCalendar();
            });

            // Open calendar when clicking on any date input field
            [monthInput, dayInput, yearInput].forEach((input) => {
                if (input) {
                    input.addEventListener("click", function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        openCalendar();
                    });
                }
            });

            // Setup date input handlers
            setupDateInputs(
                `${fieldId}Month`,
                `${fieldId}Day`,
                `${fieldId}Year`
            );
        });
    }

    // ========================================
    // TIME PICKER INITIALIZATION
    // ========================================
    function initializeTimePickers() {
        const timeFields = document.querySelectorAll("[data-time-field]");

        timeFields.forEach((wrapper) => {
            const fieldId = wrapper.getAttribute("data-time-field");
            const hourInput = document.getElementById(`${fieldId}Hour`);
            const minuteInput = document.getElementById(`${fieldId}Minute`);
            const periodSelect = document.getElementById(`${fieldId}Period`);
            const picker = wrapper.querySelector(
                `[data-time-picker="${fieldId}"]`
            );
            const trigger = wrapper.querySelector(
                `[data-time-trigger="${fieldId}"]`
            );
            const pickerHour = picker?.querySelector(
                `[data-time-hour="${fieldId}"]`
            );
            const pickerMinute = picker?.querySelector(
                `[data-time-minute="${fieldId}"]`
            );
            const pickerPeriod = picker?.querySelector(
                `[data-time-period="${fieldId}"]`
            );

            if (
                !hourInput ||
                !minuteInput ||
                !periodSelect ||
                !picker ||
                !trigger
            )
                return;

            // Auto-fill current time if data-autofill is true
            const autoFill = wrapper.dataset.autofill === "true";
            if (autoFill) {
                const now = new Date();
                let hours = now.getHours();
                const minutes = now.getMinutes();
                const period = hours >= 12 ? "PM" : "AM";
                hours = hours % 12 || 12;

                hourInput.value = String(hours).padStart(2, "0");
                minuteInput.value = String(minutes).padStart(2, "0");
                periodSelect.value = period;

                if (pickerHour && pickerMinute && pickerPeriod) {
                    pickerHour.value = hourInput.value;
                    pickerMinute.value = minuteInput.value;
                    pickerPeriod.value = periodSelect.value;
                }
            }

            // Update inputs from picker
            function updateFromPicker() {
                if (pickerHour) hourInput.value = pickerHour.value;
                if (pickerMinute) minuteInput.value = pickerMinute.value;
                if (pickerPeriod) periodSelect.value = pickerPeriod.value;
            }

            // Sync picker with inputs
            function syncPicker() {
                if (pickerHour) pickerHour.value = hourInput.value || "01";
                if (pickerMinute)
                    pickerMinute.value = minuteInput.value || "00";
                if (pickerPeriod)
                    pickerPeriod.value = periodSelect.value || "AM";
            }

            // Open/Close picker
            function openPicker() {
                syncPicker();
                picker.style.display = "block";
            }

            function closePicker() {
                picker.style.display = "none";
            }

            // Event listeners
            if (pickerHour)
                pickerHour.addEventListener("change", updateFromPicker);
            if (pickerMinute)
                pickerMinute.addEventListener("change", updateFromPicker);
            if (pickerPeriod)
                pickerPeriod.addEventListener("change", updateFromPicker);

            trigger.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                picker.style.display === "none" ? openPicker() : closePicker();
            });

            [hourInput, minuteInput, periodSelect].forEach((el) => {
                if (el)
                    el.addEventListener("click", (e) => {
                        e.preventDefault();
                        openPicker();
                    });
            });

            // Close on outside click
            document.addEventListener("click", (e) => {
                if (!wrapper.contains(e.target) && !picker.contains(e.target)) {
                    closePicker();
                }
            });
        });
    }

    // ========================================
    // HELPER FUNCTIONS
    // ========================================
    function updateSplitDateFields(selectedDate, monthId, dayId, yearId) {
        if (selectedDate && selectedDate.length > 0) {
            const date = new Date(selectedDate[0]);
            const month = String(date.getMonth() + 1).padStart(2, "0");
            const day = String(date.getDate()).padStart(2, "0");
            const year = String(date.getFullYear()).slice(-2);

            const monthInput = document.getElementById(monthId);
            const dayInput = document.getElementById(dayId);
            const yearInput = document.getElementById(yearId);

            if (monthInput) monthInput.value = month;
            if (dayInput) dayInput.value = day;
            if (yearInput) yearInput.value = year;
        }
    }

    function positionCalendar(picker, iconElement) {
        if (picker.calendarContainer && iconElement) {
            const wrapper =
                iconElement.closest(".date-split-wrapper") ||
                iconElement.closest(".time-split-wrapper");
            if (!wrapper) return;

            const calendar = picker.calendarContainer;
            calendar.style.position = "absolute";
            calendar.style.top = "calc(100% + 8px)";
            calendar.style.left = "0";
            calendar.style.right = "auto";
            calendar.style.marginTop = "0";
            calendar.style.marginLeft = "0";
            calendar.style.zIndex = "9999";

            setTimeout(() => {
                const rect = calendar.getBoundingClientRect();
                const viewportWidth = window.innerWidth;
                if (rect.right > viewportWidth) {
                    calendar.style.left = "auto";
                    calendar.style.right = "0";
                }
            }, 10);
        }
    }

    // Sync date picker from manual input
    function syncDatePickerFromInputs(monthId, dayId, yearId, fieldId) {
        const monthInput = document.getElementById(monthId);
        const dayInput = document.getElementById(dayId);
        const yearInput = document.getElementById(yearId);
        const datePickerInput = document.getElementById(`${fieldId}DatePicker`);

        if (!monthInput || !dayInput || !yearInput || !datePickerInput) return;

        const month = monthInput.value.trim();
        const day = dayInput.value.trim();
        const year = yearInput.value.trim();

        // Only sync if all three fields have valid values
        if (month && day && year && 
            !isNaN(parseInt(month)) && !isNaN(parseInt(day)) && !isNaN(parseInt(year))) {
            const monthNum = parseInt(month);
            const dayNum = parseInt(day);
            const yearNum = parseInt(year);
            
            // Validate ranges
            if (monthNum >= 1 && monthNum <= 12 && 
                dayNum >= 1 && dayNum <= 31 && 
                yearNum >= 0 && yearNum <= 99) {
                // Convert YY to YYYY
                const fullYear = '20' + String(yearNum).padStart(2, '0');
                const dateStr = `${fullYear}-${String(monthNum).padStart(2, '0')}-${String(dayNum).padStart(2, '0')}`;
                
                // Find the flatpickr instance
                const datePicker = datePickerInput._flatpickr;
                if (datePicker) {
                    // Set the date without triggering onChange to avoid infinite loop
                    datePicker.setDate(dateStr, false);
                }
            }
        }
    }

    function setupDateInputs(monthId, dayId, yearId, fieldId) {
        const monthInput = document.getElementById(monthId);
        const dayInput = document.getElementById(dayId);
        const yearInput = document.getElementById(yearId);

        if (!monthInput || !dayInput || !yearInput) return;

        // Only allow numbers
        [monthInput, dayInput, yearInput].forEach((input) => {
            input.addEventListener("input", function (e) {
                e.target.value = e.target.value.replace(/[^0-9]/g, "");
            });

            input.addEventListener("keydown", function (e) {
                if (
                    [8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
                    (e.keyCode === 65 && e.ctrlKey === true) ||
                    (e.keyCode === 67 && e.ctrlKey === true) ||
                    (e.keyCode === 86 && e.ctrlKey === true) ||
                    (e.keyCode === 88 && e.ctrlKey === true) ||
                    (e.keyCode >= 35 && e.keyCode <= 39)
                ) {
                    return;
                }
                if (
                    (e.shiftKey || e.keyCode < 48 || e.keyCode > 57) &&
                    (e.keyCode < 96 || e.keyCode > 105)
                ) {
                    e.preventDefault();
                }
            });
        });

        // Auto-advance
        monthInput.addEventListener("input", function (e) {
            if (e.target.value.length === 2) dayInput.focus();
        });

        dayInput.addEventListener("input", function (e) {
            if (e.target.value.length === 2) yearInput.focus();
        });

        // Validate and sync with date picker
        monthInput.addEventListener("blur", function (e) {
            const val = e.target.value.trim();
            if (!val || val === "") {
                e.target.value = "";
                return;
            }
            const numVal = parseInt(val);
            if (isNaN(numVal) || numVal < 1 || numVal > 12) {
                e.target.value = "";
            } else {
                e.target.value = String(numVal).padStart(2, "0");
                syncDatePickerFromInputs(monthId, dayId, yearId, fieldId);
            }
        });

        dayInput.addEventListener("blur", function (e) {
            const val = e.target.value.trim();
            if (!val || val === "") {
                e.target.value = "";
                return;
            }
            const numVal = parseInt(val);
            if (isNaN(numVal) || numVal < 1 || numVal > 31) {
                e.target.value = "";
            } else {
                e.target.value = String(numVal).padStart(2, "0");
                syncDatePickerFromInputs(monthId, dayId, yearId, fieldId);
            }
        });

        yearInput.addEventListener("blur", function (e) {
            const val = e.target.value.trim();
            if (!val || val === "") {
                e.target.value = "";
                return;
            }
            const numVal = parseInt(val);
            if (isNaN(numVal) || numVal < 0 || numVal > 99) {
                e.target.value = "";
            } else {
                e.target.value = String(numVal).padStart(2, "0");
                syncDatePickerFromInputs(monthId, dayId, yearId, fieldId);
            }
        });
    }

    // ========================================
    // INITIALIZE ON DOM READY
    // ========================================
    function init() {
        // Wait for Flatpickr to load
        if (typeof flatpickr === "undefined") {
            setTimeout(init, 100);
            return;
        }

        initializeDatePickers();
        initializeTimePickers();
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();
