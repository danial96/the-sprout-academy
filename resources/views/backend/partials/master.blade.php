<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - The Sprout Academy Admin</title>

    <!-- SB Admin CSS -->
    <link href="{{ asset('backend/admin-panel-theme/css/styles.css') }}" rel="stylesheet" />

    <!-- Font Awesome (using CDN as fallback, but prefer local if available) -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!-- Fix for stuck backdrop/overlay CSS -->
    <style>
        /* FIX: Remove sidebar overlay on desktop - this is the main issue! */
        @media (min-width: 992px) {
            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_content:before,
            #layoutSidenav #layoutSidenav_content:before {
                display: none !important;
                content: none !important;
            }
        }
        
        /* Ensure no stuck backdrops */
        body:not(.modal-open):not(.offcanvas-open) .modal-backdrop,
        body:not(.modal-open):not(.offcanvas-open) .offcanvas-backdrop {
            display: none !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
        
        /* Ensure body is always clickable when no modal is open */
        body:not(.modal-open):not(.offcanvas-open) {
            overflow: auto !important;
            padding-right: 0 !important;
        }
        
        /* Ensure main content is always visible and clickable */
        #layoutSidenav_content {
            opacity: 1 !important;
            pointer-events: auto !important;
        }
        
        /* Remove any stuck overlays with high z-index */
        body > div[style*="z-index: 1037"],
        body > div[style*="z-index: 1040"],
        body > div[style*="z-index: 1050"] {
            display: none !important;
        }
    </style>

    @stack('styles')
</head>

<body class="sb-nav-fixed">
    <!-- Top Navigation -->
    @include('backend.partials.header')

    <div id="layoutSidenav">
        <!-- Sidebar Navigation -->
        @include('backend.partials.sidebar')

        <!-- Main Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            @include('backend.partials.footer')
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- SB Admin Scripts -->
    <script src="{{ asset('backend/admin-panel-theme/js/scripts.js') }}"></script>

    <!-- Chart.js (for dashboard charts if needed) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>

    <!-- Fix for stuck modal backdrop and overlay issues -->
    <script>
        $(document).ready(function() {
            // Function to clean up all overlays and backdrops
            function cleanupOverlays() {
                // CRITICAL FIX: Remove sb-sidenav-toggled class from body (this is the main issue!)
                $('body').removeClass('sb-sidenav-toggled');
                
                // Remove modal backdrops
                $('.modal-backdrop').remove();
                $('.offcanvas-backdrop').remove();
                
                // Remove any custom overlays
                $('[style*="z-index: 1037"]').remove();
                $('[style*="background: #000"]').filter(function() {
                    return $(this).css('opacity') == '0.5';
                }).remove();
                
                // Reset body styles
                $('body').removeClass('modal-open offcanvas-open');
                $('body').css({
                    'overflow': '',
                    'padding-right': '',
                    'opacity': '',
                    'pointer-events': ''
                });
                
                // Reset main content opacity and remove pseudo-element overlay
                $('#layoutSidenav_content').css({
                    'opacity': '1',
                    'pointer-events': 'auto'
                });
                $('main').css('opacity', '');
                $('.container-fluid').css('opacity', '');
                
                // Clear localStorage to prevent sidebar toggle from persisting
                localStorage.removeItem('sb|sidebar-toggle');
            }
            
            // IMMEDIATE cleanup on page load - run multiple times to ensure it works
            cleanupOverlays();
            setTimeout(cleanupOverlays, 100);
            setTimeout(cleanupOverlays, 500);
            
            // Clean up on modal hide
            $(document).on('hidden.bs.modal', '.modal', function () {
                setTimeout(cleanupOverlays, 100);
            });
            
            // Clean up on offcanvas hide
            $(document).on('hidden.bs.offcanvas', '.offcanvas', function () {
                setTimeout(cleanupOverlays, 100);
            });
            
            // Emergency cleanup - press ESC key anywhere to remove backdrop
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' || e.keyCode === 27) {
                    cleanupOverlays();
                }
            });
            
            // Click on overlay to remove it
            $(document).on('click', '#layoutSidenav_content', function(e) {
                // If clicking on the overlay (not on actual content)
                if (e.target === this || $(e.target).closest('#layoutSidenav_content').length) {
                    cleanupOverlays();
                }
            });
            
            // Monitor for sb-sidenav-toggled class being added and remove it immediately on desktop
            if (window.innerWidth >= 992) {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === 'class') {
                            if ($('body').hasClass('sb-sidenav-toggled')) {
                                console.log('Removing stuck sb-sidenav-toggled class');
                                $('body').removeClass('sb-sidenav-toggled');
                            }
                        }
                    });
                });
                
                observer.observe(document.body, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
