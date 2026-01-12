<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        <ul class="nav">

            {{-- Dashboard --}}
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="la la-dashboard"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            {{-- Places Management --}}
            <li class="nav-item {{ request()->routeIs('places.*') ? 'active' : '' }}">
                <a href="{{ route('places.index') }}">
                    <i class="la la-map-marker"></i>
                    <p>Places</p>
                </a>
            </li>

            {{-- Tour Packages (future ready) --}}
            <li class="nav-item">
                <a href="{{ route('transportations.index') }}">
                    <i class="la la-automobile"></i>
                    <p>Transportation</p>
                </a>
            </li>
            {{-- Tour Packages (future ready) --}}
            <li class="nav-item">
                <a href="{{ route('hotels.index') }}">
                    <i class="la la-hotel"></i>
                    <p>Hotel</p>
                </a>
            </li>
            {{-- Tour Packages (future ready) --}}
            <li class="nav-item">
                <a href="{{ route('tour-packages.index') }}">
                    <i class="la la-suitcase"></i>
                    <p>Tour Packages</p>
                </a>
            </li>
            {{-- Bookings (future) --}}
            <li class="nav-item">
                <a href="{{ route('admin.tour.approvals') }}">
                    <i class="la la-calendar-check-o"></i>
                    <p>Bookings</p>
                </a>
            </li>

            {{-- Clients / Tourists --}}
            <li class="nav-item {{ request()->routeIs('tourists*') ? 'active' : '' }}">
                <a href="{{ route('tourists') }}">
                    <i class="la la-users"></i>
                    <p>Clients</p>
                </a>
            </li>

            {{-- Payments (future) --}}
            <li class="nav-item">
                <a href="#">
                    <i class="la la-credit-card"></i>
                    <p>Payments</p>
                </a>
            </li>

            {{-- Reports --}}
            <li class="nav-item">
                <a href="#">
                    <i class="la la-bar-chart"></i>
                    <p>Reports</p>
                </a>
            </li>

            {{-- Settings --}}
            <!-- <li class="nav-item">
                <a href="#">
                    <i class="la la-cog"></i>
                    <p>Settings</p>
                </a>
            </li> -->

            {{-- Logout --}}
            <li class="nav-item">
                <a href="{{ route('logout') }}">
                    <i class="la la-sign-out"></i>
                    <p>Logout</p>
                </a>
            </li>

        </ul>
    </div>
</div>