/**
 * The Sprout Academy - Main JavaScript
 * Handles mobile menu, top bar, and other interactive elements
 */

(function () {
    "use strict";

    // ========================================
    // Mobile Menu Accessibility Enhancement
    // ========================================
    const navbarToggler = document.querySelector(".navbar-toggler");
    const navbarCollapse = document.querySelector(".navbar-collapse");

    if (navbarToggler && navbarCollapse) {
        // Close menu on Escape key
        document.addEventListener("keydown", function (e) {
            if (
                e.key === "Escape" &&
                navbarCollapse.classList.contains("show")
            ) {
                const bsCollapse =
                    bootstrap.Collapse.getInstance(navbarCollapse);
                if (bsCollapse) {
                    bsCollapse.hide();
                }
                navbarToggler.focus();
            }
        });

        // Close menu when clicking outside
        document.addEventListener("click", function (e) {
            if (navbarCollapse.classList.contains("show")) {
                if (
                    !navbarCollapse.contains(e.target) &&
                    !navbarToggler.contains(e.target)
                ) {
                    const bsCollapse =
                        bootstrap.Collapse.getInstance(navbarCollapse);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            }
        });
    }

    // ========================================
    // Sticky Header Scroll Effect
    // ========================================
    const siteHeader = document.querySelector('.site-header');
    const topBar = document.querySelector('.top-bar');
    
    if (siteHeader) {
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Hide top bar and move header up when scrolled down
            if (scrollTop > 50) {
                siteHeader.classList.add('scrolled');
                if (topBar) {
                    topBar.style.transform = 'translateY(-100%)';
                }
            } else {
                siteHeader.classList.remove('scrolled');
                if (topBar) {
                    topBar.style.transform = 'translateY(0)';
                }
            }
            
            lastScrollTop = scrollTop;
        });
    }

    // ========================================
    // Smooth Scroll for Anchor Links
    // ========================================
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            const href = this.getAttribute("href");
            if (href !== "#" && href !== "#!") {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: "smooth",
                        block: "start",
                    });
                    // Update URL without jumping
                    history.pushState(null, null, href);
                    // Focus the target for accessibility
                    target.setAttribute("tabindex", "-1");
                    target.focus();
                }
            }
        });
    });

    // ========================================
    // Floating Chat Button
    // ========================================
    const chatBtn = document.querySelector(".floating-chat-btn");
    if (chatBtn) {
        chatBtn.addEventListener("click", function () {
            // Add your chat integration here
            alert("Chat functionality will be integrated here.");
            // Example: window.open('https://your-chat-service.com', '_blank');
        });
    }

    // ========================================
    // Lazy Loading Images Enhancement
    // ========================================
    if ("loading" in HTMLImageElement.prototype) {
        // Browser supports native lazy loading
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach((img) => {
            img.src = img.dataset.src || img.src;
        });
    } else {
        // Fallback for browsers that don't support lazy loading
        const script = document.createElement("script");
        script.src =
            "https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js";
        document.body.appendChild(script);
    }

    // ========================================
    // Form Validation Enhancement
    // ========================================
    const forms = document.querySelectorAll(".needs-validation");
    Array.from(forms).forEach((form) => {
        form.addEventListener(
            "submit",
            function (e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add("was-validated");
            },
            false
        );
    });

    // ========================================
    // Newsletter Form Handler
    // ========================================
    const newsletterForm = document.getElementById("newsletterForm");
    if (newsletterForm) {
        const submitBtn = newsletterForm.querySelector("#newsletterSubmitBtn");
        const btnText = submitBtn ? submitBtn.querySelector(".btn-text") : null;
        const btnSpinner = submitBtn
            ? submitBtn.querySelector(".btn-spinner")
            : null;
        const formMessage = document.getElementById("newsletterMessage");

        newsletterForm.addEventListener("submit", function (e) {
            e.preventDefault();

            // Hide previous messages
            if (formMessage) {
                formMessage.style.display = "none";
                formMessage.className = "newsletter-message";
            }

            // Show spinner and disable button
            if (btnText && btnSpinner && submitBtn) {
                btnText.style.display = "none";
                btnSpinner.style.display = "inline-block";
                submitBtn.disabled = true;
            }

            // Create FormData
            const formData = new FormData(newsletterForm);

            // AJAX submission
            fetch(newsletterForm.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    // Hide spinner and enable button
                    if (btnText && btnSpinner && submitBtn) {
                        btnText.style.display = "inline-block";
                        btnSpinner.style.display = "none";
                        submitBtn.disabled = false;
                    }

                    if (data.success) {
                        // Show success message
                        if (formMessage) {
                            formMessage.textContent = data.message;
                            formMessage.className =
                                "newsletter-message success";
                            formMessage.style.display = "block";
                        }

                        // Reset form
                        newsletterForm.reset();
                    } else {
                        // Show error message
                        let errorMessage =
                            data.message ||
                            "An error occurred. Please try again.";

                        // Add validation errors if present
                        if (data.errors) {
                            const errorList = Object.values(data.errors)
                                .flat()
                                .join("<br>");
                            errorMessage += "<br>" + errorList;
                        }

                        if (formMessage) {
                            formMessage.innerHTML = errorMessage;
                            formMessage.className = "newsletter-message error";
                            formMessage.style.display = "block";
                        }
                    }
                })
                .catch((error) => {
                    // Hide spinner and enable button
                    if (btnText && btnSpinner && submitBtn) {
                        btnText.style.display = "inline-block";
                        btnSpinner.style.display = "none";
                        submitBtn.disabled = false;
                    }

                    // Show error message
                    if (formMessage) {
                        formMessage.textContent =
                            "An error occurred while subscribing. Please try again later.";
                        formMessage.className = "newsletter-message error";
                        formMessage.style.display = "block";
                    }

                    console.error("Error:", error);
                });
        });
    }

    // ========================================
    // Video Play Button Handler
    // ========================================
    const videoPlayBtns = document.querySelectorAll(".video-play-btn");
    videoPlayBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            const videoContainer = this.closest(".video-showcase");
            // Add your video player logic here
            console.log("Video play clicked");
            // Example: Replace with iframe or video element
        });
    });

    // ========================================
    // Scroll to Top on Page Load (if hash present)
    // ========================================
    window.addEventListener("load", function () {
        if (window.location.hash) {
            const target = document.querySelector(window.location.hash);
            if (target) {
                setTimeout(() => {
                    target.scrollIntoView({
                        behavior: "smooth",
                        block: "start",
                    });
                }, 100);
            }
        }
    });

    // ========================================
    // Add Active State to Current Nav Item
    // ========================================
    // Note: Server-side Blade template handles active states via route names
    // This JS only ensures only ONE nav item is active at a time
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll(".nav-link");

    // First, collect all currently active links
    const activeLinks = Array.from(navLinks).filter((link) =>
        link.classList.contains("active")
    );

    // If multiple links are active, remove active from all except the one matching current path
    if (activeLinks.length > 1) {
        let foundMatch = false;

        navLinks.forEach((link) => {
            // Skip dropdown toggles and invalid links
            if (
                link.classList.contains("dropdown-toggle") ||
                !link.href ||
                link.href === "#" ||
                link.href.includes("javascript:")
            ) {
                return;
            }

            try {
                const linkPath = new URL(link.href).pathname;

                // If this link matches current path and we haven't found a match yet, keep it active
                if (linkPath === currentPath && !foundMatch) {
                    foundMatch = true;
                    link.classList.add("active");
                    link.setAttribute("aria-current", "page");
                } else {
                    // Remove active from all other links
                    link.classList.remove("active");
                    link.removeAttribute("aria-current");
                }
            } catch (e) {
                // Invalid URL, remove active state
                link.classList.remove("active");
                link.removeAttribute("aria-current");
            }
        });
    }

    // ========================================
    // Testimonial Carousel Auto-scroll
    // ========================================
    const testimonialCarousel = document.querySelector(".testimonial-carousel");
    if (testimonialCarousel) {
        let isScrolling;
        let scrollAmount = 0;

        // Auto-scroll functionality (optional)
        // Uncomment if you want auto-scrolling testimonials
        /*
    setInterval(() => {
      if (!isScrolling) {
        scrollAmount += 320; // width of one image + gap
        if (scrollAmount >= testimonialCarousel.scrollWidth - testimonialCarousel.clientWidth) {
          scrollAmount = 0;
        }
        testimonialCarousel.scrollTo({
          left: scrollAmount,
          behavior: 'smooth'
        });
      }
    }, 5000);
    */

        // Pause auto-scroll when user is manually scrolling
        testimonialCarousel.addEventListener("scroll", () => {
            clearTimeout(isScrolling);
            isScrolling = setTimeout(() => {
                isScrolling = null;
            }, 150);
        });
    }

    // ========================================
    // Accordion Toggle - Only One Open at a Time
    // ========================================
    const accordionButtons = document.querySelectorAll(".accordion-button");

    accordionButtons.forEach((button) => {
        const targetId = button.getAttribute("data-bs-target");
        const targetElement = document.querySelector(targetId);
        const accordionItem = button.closest(".accordion-item");

        if (targetElement) {
            // When an accordion is about to open, close all others
            targetElement.addEventListener("show.bs.collapse", function () {
                // Close all other accordions
                const allAccordionCollapses = document.querySelectorAll(".accordion-collapse.show");
                allAccordionCollapses.forEach((collapse) => {
                    if (collapse !== targetElement) {
                        const bsCollapse = bootstrap.Collapse.getInstance(collapse);
                        if (bsCollapse) {
                            bsCollapse.hide();
                        }
                    }
                });

                // Add active class to current accordion
                button.classList.add("active");
                if (accordionItem) {
                    accordionItem.classList.add("active-item");
                }
            });

            targetElement.addEventListener("hide.bs.collapse", function () {
                button.classList.remove("active");
                if (accordionItem) {
                    accordionItem.classList.remove("active-item");
                }
            });

            // Set initial state based on whether collapse is shown
            if (targetElement.classList.contains("show")) {
                button.classList.add("active");
                if (accordionItem) {
                    accordionItem.classList.add("active-item");
                }
            }
        }
    });

    // ========================================
    // Directors Tab Functionality
    // ========================================
    const directorTabs = document.querySelectorAll(".director-tab");
    const directorCards = document.querySelectorAll(".director-card");

    if (directorTabs.length > 0 && directorCards.length > 0) {
        directorTabs.forEach((tab) => {
            tab.addEventListener("click", function () {
                const location = this.getAttribute("data-location");

                // Remove active class from all tabs
                directorTabs.forEach((t) => t.classList.remove("active"));

                // Add active class to clicked tab
                this.classList.add("active");

                // Hide all director cards
                directorCards.forEach((card) => {
                    card.classList.remove("active");
                });

                // Show the selected director card
                const targetCard = document.getElementById(location);
                if (targetCard) {
                    setTimeout(() => {
                        targetCard.classList.add("active");
                    }, 50);
                }
            });
        });
    }

    // ========================================
    // Video Play Button Handler (Main Video)
    // ========================================
    const mainVideoPlayBtn = document.querySelector(".video-play-btn-main");
    const mainVideoPlayer = document.querySelector(".main-video-player");

    if (mainVideoPlayBtn && mainVideoPlayer) {
        mainVideoPlayBtn.addEventListener("click", function () {
            mainVideoPlayer.play();
            const showcase = this.closest(".video-showcase-main");
            if (showcase) {
                showcase.classList.add("playing");
            }
            this.style.display = "none";
        });

        // Show play button when video is paused
        mainVideoPlayer.addEventListener("pause", function () {
            if (mainVideoPlayBtn) {
                mainVideoPlayBtn.style.display = "flex";
            }
            const showcase = mainVideoPlayBtn.closest(".video-showcase-main");
            if (showcase) {
                showcase.classList.remove("playing");
            }
        });

        // Hide play button when video is playing
        mainVideoPlayer.addEventListener("play", function () {
            if (mainVideoPlayBtn) {
                mainVideoPlayBtn.style.display = "none";
            }
            const showcase = mainVideoPlayBtn?.closest(".video-showcase-main");
            if (showcase) {
                showcase.classList.add("playing");
            }
        });
    }

    // ========================================
    // Curriculum Video Play Button Handler
    // ========================================
    const curriculumVideoPlayBtn = document.getElementById(
        "play-curriculum-video-btn"
    );
    const curriculumVideoPlayer = document.querySelector(
        ".curriculum-video-player"
    );

    if (curriculumVideoPlayBtn && curriculumVideoPlayer) {
        curriculumVideoPlayBtn.addEventListener("click", function () {
            curriculumVideoPlayer.play();
            const showcase = this.closest(".curriculum-video-showcase");
            if (showcase) {
                showcase.classList.add("playing");
            }
            this.style.display = "none";
        });

        // Show play button when video is paused
        curriculumVideoPlayer.addEventListener("pause", function () {
            if (curriculumVideoPlayBtn) {
                curriculumVideoPlayBtn.style.display = "flex";
            }
            const showcase = curriculumVideoPlayBtn?.closest(
                ".curriculum-video-showcase"
            );
            if (showcase) {
                showcase.classList.remove("playing");
            }
        });

        // Hide play button when video is playing
        curriculumVideoPlayer.addEventListener("play", function () {
            if (curriculumVideoPlayBtn) {
                curriculumVideoPlayBtn.style.display = "none";
            }
            const showcase = curriculumVideoPlayBtn?.closest(
                ".curriculum-video-showcase"
            );
            if (showcase) {
                showcase.classList.add("playing");
            }
        });
    }

    // ========================================
    // Masonry Gallery Lightbox
    // ========================================
    function initMasonryGallery() {
        const gallerySections = document.querySelectorAll(
            ".masonry-gallery-section"
        );

        gallerySections.forEach((section) => {
            const galleryId = section.id;
            // Find lightbox within the section first, then by ID
            const lightbox = section.querySelector(`#lightbox-${galleryId}`) || 
                           document.getElementById(`lightbox-${galleryId}`);
            const galleryItems = section.querySelectorAll(
                ".masonry-gallery-item"
            );
            
            if (!lightbox || galleryItems.length === 0) return;
            
            const lightboxImage = lightbox.querySelector(
                ".masonry-lightbox-image"
            );
            const lightboxCaption = lightbox.querySelector(
                ".masonry-lightbox-caption"
            );
            const closeBtn = lightbox.querySelector(".masonry-lightbox-close");
            const prevBtn = lightbox.querySelector(".masonry-lightbox-prev");
            const nextBtn = lightbox.querySelector(".masonry-lightbox-next");
            const backdrop = lightbox.querySelector(
                ".masonry-lightbox-backdrop"
            );

            if (!lightboxImage) return;

            let currentIndex = 0;
            const images = Array.from(galleryItems).map((item) => {
                const img = item.querySelector(".masonry-gallery-image");
                if (!img) return null;
                return {
                    src: img.getAttribute("data-lightbox-src") || img.getAttribute("src") || img.src,
                    alt: img.getAttribute("alt") || img.alt || "Gallery image",
                };
            }).filter(img => img !== null);
            
            if (images.length === 0) return;

            // Open lightbox
            function openLightbox(index) {
                if (index < 0 || index >= images.length) return;
                currentIndex = index;
                updateLightboxImage();
                lightbox.classList.add("active");
                lightbox.setAttribute("aria-modal", "true");
                document.body.style.overflow = "hidden"; // Prevent body scroll
            }

            // Close lightbox
            function closeLightbox() {
                lightbox.classList.remove("active");
                lightbox.setAttribute("aria-modal", "false");
                document.body.style.overflow = ""; // Restore body scroll
            }

            // Update lightbox image
            function updateLightboxImage() {
                if (!images[currentIndex] || !lightboxImage) return;
                
                // Set image source - use a placeholder first to prevent flicker
                const newSrc = images[currentIndex].src;
                if (lightboxImage.src !== newSrc) {
                    lightboxImage.style.opacity = "0";
                    lightboxImage.src = newSrc;
                    lightboxImage.alt = images[currentIndex].alt || "Gallery image";
                    
                    // Fade in image when loaded
                    lightboxImage.onload = function() {
                        lightboxImage.style.opacity = "1";
                        lightboxImage.style.transition = "opacity 0.3s ease";
                    };
                    lightboxImage.onerror = function() {
                        console.error("Failed to load image:", newSrc);
                        lightboxImage.style.opacity = "0";
                    };
                }
                
                if (lightboxCaption) {
                    lightboxCaption.textContent = images[currentIndex].alt || "";
                }

                // Update button states
                if (prevBtn) {
                    prevBtn.style.display =
                        currentIndex === 0 ? "none" : "flex";
                    prevBtn.disabled = currentIndex === 0;
                }
                if (nextBtn) {
                    nextBtn.style.display =
                        currentIndex === images.length - 1 ? "none" : "flex";
                    nextBtn.disabled = currentIndex === images.length - 1;
                }
            }

            // Navigate to previous image
            function showPrevious() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateLightboxImage();
                }
            }

            // Navigate to next image
            function showNext() {
                if (currentIndex < images.length - 1) {
                    currentIndex++;
                    updateLightboxImage();
                }
            }

            // Event listeners for gallery items - use once flag to prevent duplicates
            galleryItems.forEach((item, index) => {
                // Check if listener already attached
                if (item._hasListener) return;
                item._hasListener = true;
                
                item.addEventListener("click", (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    openLightbox(index);
                });

                // Keyboard accessibility
                item.addEventListener("keydown", (e) => {
                    if (e.key === "Enter" || e.key === " ") {
                        e.preventDefault();
                        e.stopPropagation();
                        openLightbox(index);
                    }
                });
            });

            // Close button
            if (closeBtn && !closeBtn._hasListener) {
                closeBtn._hasListener = true;
                closeBtn.addEventListener("click", (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    closeLightbox();
                });
            }

            // Backdrop click to close
            if (backdrop && !backdrop._hasListener) {
                backdrop._hasListener = true;
                backdrop.addEventListener("click", (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    closeLightbox();
                });
            }

            // Previous button
            if (prevBtn && !prevBtn._hasListener) {
                prevBtn._hasListener = true;
                prevBtn.addEventListener("click", (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    showPrevious();
                });
            }

            // Next button
            if (nextBtn && !nextBtn._hasListener) {
                nextBtn._hasListener = true;
                nextBtn.addEventListener("click", (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    showNext();
                });
            }

            // Keyboard navigation - use a unique handler per gallery
            const keyboardHandler = function (e) {
                if (!lightbox.classList.contains("active")) return;

                switch (e.key) {
                    case "Escape":
                        e.preventDefault();
                        e.stopPropagation();
                        closeLightbox();
                        break;
                    case "ArrowLeft":
                        e.preventDefault();
                        e.stopPropagation();
                        showPrevious();
                        break;
                    case "ArrowRight":
                        e.preventDefault();
                        e.stopPropagation();
                        showNext();
                        break;
                }
            };
            document.addEventListener("keydown", keyboardHandler);

            // Prevent lightbox content clicks from closing
            const lightboxContainer = lightbox.querySelector(
                ".masonry-lightbox-container"
            );
            if (lightboxContainer) {
                lightboxContainer.addEventListener("click", (e) => {
                    e.stopPropagation();
                });
            }
            
            // Store reference for cleanup if needed
            lightbox._galleryHandler = keyboardHandler;
        });
    }

    // Initialize masonry gallery on DOM ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initMasonryGallery);
    } else {
        initMasonryGallery();
    }

    // Re-initialize if new galleries are added dynamically
    const masonryObserver = new MutationObserver(() => {
        initMasonryGallery();
    });

    masonryObserver.observe(document.body, {
        childList: true,
        subtree: true,
    });
})();
