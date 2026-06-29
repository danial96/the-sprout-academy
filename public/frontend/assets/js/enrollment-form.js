/**
 * Enrollment Form Handler
 * Handles multi-step enrollment form with AJAX submission
 */

(function () {
    "use strict";

    // Initialize on DOM ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }

    function init() {
        // Step 1 Form Handler
        const step1Form = document.getElementById("enrollmentStep1Form");
        if (step1Form) {
            handleStep1Form(step1Form);
        }

        // Step 2 Form Handler
        const step2Form = document.getElementById("enrollmentStep2Form");
        if (step2Form) {
            handleStep2Form(step2Form);
        }

        // Step 3 Form Handler
        const step3Form = document.getElementById("enrollmentStep3Form");
        if (step3Form) {
            handleStep3Form(step3Form);
        }

        // Submit Form Handler
        const submitForm = document.getElementById("enrollmentSubmitForm");
        if (submitForm) {
            handleSubmitForm(submitForm);
        }

        // Profile image preview handlers
        initProfileImagePreviews();
    }

    /**
     * Handle Step 1 Form Submission
     */
    function handleStep1Form(form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const submitButton = e.submitter || form.querySelector('button[type="submit"]');
            const action = submitButton ? submitButton.getAttribute("data-action") : "step2";
            const formMessage = document.getElementById("formMessage");

            // Hide previous messages
            if (formMessage) {
                formMessage.style.display = "none";
                formMessage.className = "enrollment-message";
            }

            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Format date of birth
            formatDateOfBirth("dateOfBirth");

            // Disable submit button
            const buttons = form.querySelectorAll("button[type='submit']");
            buttons.forEach((btn) => {
                btn.disabled = true;
                btn.style.opacity = "0.6";
            });

            // Create FormData
            const formData = new FormData(form);
            
            // Add action to form data for backend
            if (action === "review") {
                formData.append("next_step", 4);
            } else {
                formData.append("next_step", 2);
            }

            // AJAX submission
            fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    // Re-enable buttons
                    buttons.forEach((btn) => {
                        btn.disabled = false;
                        btn.style.opacity = "1";
                    });

                    if (data.success) {
                        // Show success message
                        if (formMessage) {
                            formMessage.textContent = data.message;
                            formMessage.className = "enrollment-message success";
                            formMessage.style.display = "block";
                        }

                        // Redirect based on action
                        setTimeout(() => {
                            if (action === "review") {
                                window.location.href = data.data?.redirect_url || form.action.replace("/step1", "/step4");
                            } else {
                                window.location.href = data.data?.redirect_url || form.action.replace("/step1", "/step2");
                            }
                        }, 1000);
                    } else {
                        // Show error message
                        let errorMessage = data.message || "An error occurred. Please try again.";

                        if (data.errors) {
                            const errorList = Object.values(data.errors)
                                .flat()
                                .join("<br>");
                            errorMessage += "<br>" + errorList;
                        }

                        if (formMessage) {
                            formMessage.innerHTML = errorMessage;
                            formMessage.className = "enrollment-message error";
                            formMessage.style.display = "block";
                        }

                        // Scroll to message
                        if (formMessage) {
                            formMessage.scrollIntoView({ behavior: "smooth", block: "nearest" });
                        }
                    }
                })
                .catch((error) => {
                    // Re-enable buttons
                    buttons.forEach((btn) => {
                        btn.disabled = false;
                        btn.style.opacity = "1";
                    });

                    // Show error message
                    if (formMessage) {
                        formMessage.textContent =
                            "An error occurred while saving. Please try again later.";
                        formMessage.className = "enrollment-message error";
                        formMessage.style.display = "block";
                        formMessage.scrollIntoView({ behavior: "smooth", block: "nearest" });
                    }

                    console.error("Error:", error);
                });
        });
    }

    /**
     * Handle Step 2 Form Submission
     */
    function handleStep2Form(form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const submitButton = e.submitter || form.querySelector('button[type="submit"]');
            const action = submitButton ? submitButton.getAttribute("data-action") : "step3";
            const formMessage = document.getElementById("formMessage");

            // Hide previous messages
            if (formMessage) {
                formMessage.style.display = "none";
                formMessage.className = "enrollment-message";
            }

            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Format all child dates of birth
            const childGroups = document.querySelectorAll(".child-field-group");
            childGroups.forEach((group, index) => {
                formatDateOfBirth(`childDateOfBirth${index}`);
            });

            // Disable submit button
            const buttons = form.querySelectorAll("button[type='submit']");
            buttons.forEach((btn) => {
                btn.disabled = true;
                btn.style.opacity = "0.6";
            });

            // Create FormData
            const formData = new FormData(form);

            // AJAX submission
            fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    // Re-enable buttons
                    buttons.forEach((btn) => {
                        btn.disabled = false;
                        btn.style.opacity = "1";
                    });

                    if (data.success) {
                        // Show success message
                        if (formMessage) {
                            formMessage.textContent = data.message;
                            formMessage.className = "enrollment-message success";
                            formMessage.style.display = "block";
                        }

                        // Redirect based on action
                        setTimeout(() => {
                            if (action === "review") {
                                window.location.href = data.data?.redirect_url || form.action.replace("/step2", "/step4");
                            } else {
                                window.location.href = data.data?.redirect_url || form.action.replace("/step2", "/step3");
                            }
                        }, 1000);
                    } else {
                        // Show error message
                        let errorMessage = data.message || "An error occurred. Please try again.";

                        if (data.errors) {
                            const errorList = Object.values(data.errors)
                                .flat()
                                .join("<br>");
                            errorMessage += "<br>" + errorList;
                        }

                        if (formMessage) {
                            formMessage.innerHTML = errorMessage;
                            formMessage.className = "enrollment-message error";
                            formMessage.style.display = "block";
                        }

                        // Scroll to message
                        if (formMessage) {
                            formMessage.scrollIntoView({ behavior: "smooth", block: "nearest" });
                        }
                    }
                })
                .catch((error) => {
                    // Re-enable buttons
                    buttons.forEach((btn) => {
                        btn.disabled = false;
                        btn.style.opacity = "1";
                    });

                    // Show error message
                    if (formMessage) {
                        formMessage.textContent =
                            "An error occurred while saving. Please try again later.";
                        formMessage.className = "enrollment-message error";
                        formMessage.style.display = "block";
                        formMessage.scrollIntoView({ behavior: "smooth", block: "nearest" });
                    }

                    console.error("Error:", error);
                });
        });
    }

    /**
     * Handle Step 3 Form Submission
     */
    function handleStep3Form(form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const submitButton = e.submitter || form.querySelector('button[type="submit"]');
            const action = submitButton ? submitButton.getAttribute("data-action") : "review";
            const formMessage = document.getElementById("formMessage");

            // Hide previous messages
            if (formMessage) {
                formMessage.style.display = "none";
                formMessage.className = "enrollment-message";
            }

            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Ensure all checkbox arrays have values for proper indexing
            // This ensures unchecked checkboxes still send a value to maintain array index alignment
            const contactGroups = document.querySelectorAll('.contact-field-group');
            contactGroups.forEach((group) => {
                // Get all toggle checkboxes in this group
                const livesWith = group.querySelector('input[name="contact_lives_with[]"]');
                const isEmergency = group.querySelector('input[name="contact_is_emergency[]"]');
                const isPickup = group.querySelector('input[name="contact_is_pickup[]"]');

                // If checkbox is not checked, add hidden input with value 0 to maintain array index
                // Check if hidden input already exists to avoid duplicates
                if (livesWith && !livesWith.checked && !group.querySelector('input[name="contact_lives_with[]"][type="hidden"]')) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'contact_lives_with[]';
                    hidden.value = '0';
                    group.appendChild(hidden);
                }
                if (isEmergency && !isEmergency.checked && !group.querySelector('input[name="contact_is_emergency[]"][type="hidden"]')) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'contact_is_emergency[]';
                    hidden.value = '0';
                    group.appendChild(hidden);
                }
                if (isPickup && !isPickup.checked && !group.querySelector('input[name="contact_is_pickup[]"][type="hidden"]')) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'contact_is_pickup[]';
                    hidden.value = '0';
                    group.appendChild(hidden);
                }
            });

            // Disable submit button
            const buttons = form.querySelectorAll("button[type='submit']");
            buttons.forEach((btn) => {
                btn.disabled = true;
                btn.style.opacity = "0.6";
            });

            // Create FormData
            const formData = new FormData(form);

            // AJAX submission
            fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    // Re-enable buttons
                    buttons.forEach((btn) => {
                        btn.disabled = false;
                        btn.style.opacity = "1";
                    });

                    if (data.success) {
                        // Show success message
                        if (formMessage) {
                            formMessage.textContent = data.message;
                            formMessage.className = "enrollment-message success";
                            formMessage.style.display = "block";
                        }

                        // Redirect to review
                        setTimeout(() => {
                            window.location.href = data.data?.redirect_url || form.action.replace("/step3", "/step4");
                        }, 1000);
                    } else {
                        // Show error message
                        let errorMessage = data.message || "An error occurred. Please try again.";

                        if (data.errors) {
                            const errorList = Object.values(data.errors)
                                .flat()
                                .join("<br>");
                            errorMessage += "<br>" + errorList;
                        }

                        if (formMessage) {
                            formMessage.innerHTML = errorMessage;
                            formMessage.className = "enrollment-message error";
                            formMessage.style.display = "block";
                        }

                        // Scroll to message
                        if (formMessage) {
                            formMessage.scrollIntoView({ behavior: "smooth", block: "nearest" });
                        }
                    }
                })
                .catch((error) => {
                    // Re-enable buttons
                    buttons.forEach((btn) => {
                        btn.disabled = false;
                        btn.style.opacity = "1";
                    });

                    // Show error message
                    if (formMessage) {
                        formMessage.textContent =
                            "An error occurred while saving. Please try again later.";
                        formMessage.className = "enrollment-message error";
                        formMessage.style.display = "block";
                        formMessage.scrollIntoView({ behavior: "smooth", block: "nearest" });
                    }

                    console.error("Error:", error);
                });
        });
    }

    /**
     * Handle Final Submission
     */
    function handleSubmitForm(form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const formMessage = document.getElementById("formMessage");
            const submitButton = form.querySelector('button[type="submit"]');

            // Hide previous messages
            if (formMessage) {
                formMessage.style.display = "none";
                formMessage.className = "enrollment-message";
            }

            // Disable submit button and show spinner
            if (submitButton) {
                submitButton.disabled = true;
                const btnText = submitButton.querySelector('.btn-text');
                const btnSpinner = submitButton.querySelector('.btn-spinner');
                
                if (btnText) btnText.style.display = 'none';
                if (btnSpinner) btnSpinner.style.display = 'inline-block';
            }

            // Create FormData
            const formData = new FormData(form);

            // AJAX submission
            fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Show success message
                        if (formMessage) {
                            formMessage.textContent = data.message;
                            formMessage.className = "enrollment-message success";
                            formMessage.style.display = "block";
                        }

                        // Redirect to thank you page
                        setTimeout(() => {
                            window.location.href = data.data?.redirect_url || form.action.replace("/submit", "/thank-you");
                        }, 1000);
                    } else {
                        // Re-enable button and hide spinner
                        if (submitButton) {
                            submitButton.disabled = false;
                            const btnText = submitButton.querySelector('.btn-text');
                            const btnSpinner = submitButton.querySelector('.btn-spinner');
                            
                            if (btnText) btnText.style.display = 'inline-block';
                            if (btnSpinner) btnSpinner.style.display = 'none';
                        }

                        // Show error message
                        let errorMessage = data.message || "An error occurred. Please try again.";

                        if (data.errors) {
                            const errorList = Object.values(data.errors)
                                .flat()
                                .join("<br>");
                            errorMessage += "<br>" + errorList;
                        }

                        if (formMessage) {
                            formMessage.innerHTML = errorMessage;
                            formMessage.className = "enrollment-message error";
                            formMessage.style.display = "block";
                        }

                        // Scroll to message
                        if (formMessage) {
                            formMessage.scrollIntoView({ behavior: "smooth", block: "nearest" });
                        }
                    }
                })
                .catch((error) => {
                    // Re-enable button and hide spinner
                    if (submitButton) {
                        submitButton.disabled = false;
                        const btnText = submitButton.querySelector('.btn-text');
                        const btnSpinner = submitButton.querySelector('.btn-spinner');
                        
                        if (btnText) btnText.style.display = 'inline-block';
                        if (btnSpinner) btnSpinner.style.display = 'none';
                    }

                    // Show error message
                    if (formMessage) {
                        formMessage.textContent =
                            "An error occurred while submitting. Please try again later.";
                        formMessage.className = "enrollment-message error";
                        formMessage.style.display = "block";
                        formMessage.scrollIntoView({ behavior: "smooth", block: "nearest" });
                    }

                    console.error("Error:", error);
                });
        });
    }

    /**
     * Format Date of Birth from split fields
     */
    function formatDateOfBirth(fieldId) {
        const monthInput = document.getElementById(`${fieldId}Month`);
        const dayInput = document.getElementById(`${fieldId}Day`);
        const yearInput = document.getElementById(`${fieldId}Year`);
        const hiddenInput = document.getElementById(`${fieldId}Formatted`);

        if (monthInput && dayInput && yearInput && hiddenInput) {
            const month = monthInput.value.padStart(2, "0");
            const day = dayInput.value.padStart(2, "0");
            const year = "20" + yearInput.value.padStart(2, "0");

            if (month && day && year) {
                const dateStr = `${year}-${month}-${day}`;
                hiddenInput.value = dateStr;
            }
        }
    }

    /**
     * Initialize Profile Image Previews
     */
    function initProfileImagePreviews() {
        document.querySelectorAll('input[type="file"][accept="image/*"]').forEach((input) => {
            input.addEventListener("change", function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        // Find the nearest profile picture image
                        const container = input.closest(".profile-picture-container");
                        if (container) {
                            const img = container.querySelector(".profile-picture");
                            if (img) {
                                img.src = e.target.result;
                            }
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    }
})();


