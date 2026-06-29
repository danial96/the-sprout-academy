<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Enrollments</div>
                <a class="nav-link {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}"
                    href="{{ route('admin.enrollments.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
                    Enrollments
                </a>

                <div class="sb-sidenav-menu-heading">User Management</div>
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                    href="{{ route('admin.users.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Employee Users
                </a>

                <div class="sb-sidenav-menu-heading">Content Management</div>
                <a class="nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}"
                    href="{{ route('admin.locations.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-map-marker-alt"></i></div>
                    Locations
                </a>

                <div class="sb-sidenav-menu-heading">Forms</div>
                <a class="nav-link {{ request()->routeIs('admin.forms.*') ? '' : 'collapsed' }}" href="#"
                    data-bs-toggle="collapse" data-bs-target="#collapseForms"
                    aria-expanded="{{ request()->routeIs('admin.forms.*') ? 'true' : 'false' }}"
                    aria-controls="collapseForms">
                    <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                    Forms
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('admin.forms.*') ? 'show' : '' }}" id="collapseForms"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('admin.forms.maintenance-work-orders') ? 'active' : '' }}"
                            href="{{ route('admin.forms.maintenance-work-orders') }}">
                            <i class="fas fa-wrench me-2"></i>Maintenance Work Orders
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.forms.suggestions') ? 'active' : '' }}"
                            href="{{ route('admin.forms.suggestions') }}">
                            <i class="fas fa-lightbulb me-2"></i>Suggestions
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.forms.time-clock-change-requests') ? 'active' : '' }}"
                            href="{{ route('admin.forms.time-clock-change-requests') }}">
                            <i class="fas fa-clock me-2"></i>Time Clock Change Requests
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.forms.time-off-requests') ? 'active' : '' }}"
                            href="{{ route('admin.forms.time-off-requests') }}">
                            <i class="fas fa-calendar-times me-2"></i>Time Off Requests
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.forms.standard-t-shirt-orders') ? 'active' : '' }}"
                            href="{{ route('admin.forms.standard-t-shirt-orders') }}">
                            <i class="fas fa-tshirt me-2"></i>Standard T-Shirt Orders
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.forms.specialty-t-shirt-orders') ? 'active' : '' }}"
                            href="{{ route('admin.forms.specialty-t-shirt-orders') }}">
                            <i class="fas fa-tshirt me-2"></i>Specialty T-Shirt Orders
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.forms.supply-orders') ? 'active' : '' }}"
                            href="{{ route('admin.forms.supply-orders') }}">
                            <i class="fas fa-box me-2"></i>Supply Orders
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.forms.snack-orders') ? 'active' : '' }}"
                            href="{{ route('admin.forms.snack-orders') }}">
                            <i class="fas fa-cookie me-2"></i>Snack Orders
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.forms.newsletter-subscriptions') ? 'active' : '' }}"
                            href="{{ route('admin.forms.newsletter-subscriptions') }}">
                            <i class="fas fa-envelope me-2"></i>Newsletter Subscriptions
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.forms.child-absent-forms') ? 'active' : '' }}"
                            href="{{ route('admin.forms.child-absent-forms') }}">
                            <i class="fas fa-child me-2"></i>Child Absent Forms
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.forms.employment-applications') ? 'active' : '' }}"
                            href="{{ route('admin.forms.employment-applications') }}">
                            <i class="fas fa-briefcase me-2"></i>Employment Applications
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth::user()->name ?? 'Admin' }}
        </div>
    </nav>
</div>
