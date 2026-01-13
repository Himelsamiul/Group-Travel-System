{{-- ================= HEADER ================= --}}
<div class="main-header">

    {{-- LOGO HEADER --}}
    <div class="logo-header d-flex align-items-center justify-content-center position-relative">

        {{-- SIDEBAR TOGGLER (LEFT) --}}
        <button class="navbar-toggler sidenav-toggler position-absolute left-0 ml-3"
            type="button" data-toggle="collapse" data-target="collapse"
            aria-controls="sidebar" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- CENTER LOGO --}}
        <a href="{{ route('dashboard') }}" class="logo text-center mx-auto">
            Tour management
        </a>

        {{-- TOPBAR TOGGLER (RIGHT) --}}
        <button class="topbar-toggler more position-absolute right-0 mr-3">
            <i class="la la-ellipsis-v"></i>
        </button>

    </div>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-header navbar-expand-lg">
        <div class="container-fluid">

            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle profile-pic d-flex align-items-center"
                       data-toggle="dropdown" href="#" aria-expanded="false">

                        {{-- PROFILE IMAGE (STATIC) --}}
                        <img src="{{ asset('p.jpg') }}"
                             alt="Profile"
                             style="width:35px;height:35px;border-radius:50%;
                                    object-fit:cover;margin-right:8px;">

                        <span>Afia Jahin</span>
                    </a>

                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <div class="user-box text-center p-3">
                                <p class="text-muted mb-0">aafiajahin@gmail.com</p>

                                
                                
                            </div>
								<div class="user-box text-center p-3">
									<p class="text-muted mb-0">Web Developer</p>
								</div>
								<div class="user-box text-center p-3">
<p class="text-muted mb-0">Kodeeo Limited</p>
								</div>
                        </li>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="fa fa-power-off"></i> Logout
                        </a>
                    </ul>
                </li>

            </ul>

        </div>
    </nav>

</div>

{{-- ================= OPTIONAL STYLE ================= --}}
<style>
.logo{
    font-size:20px;
    font-weight:700;
    letter-spacing:1px;
}
</style>
