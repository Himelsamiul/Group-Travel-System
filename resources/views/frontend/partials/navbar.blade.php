	<nav class="site-nav">
		<div class="container">
			<div class="site-navigation">
				<a href="index.html" class="logo m-0">BlueWave Tours <span class="text-primary">.</span></a>

				<ul class="js-clone-nav d-none d-lg-inline-block text-left site-menu float-right">
					<li class="active"><a href="{{route('home')}}">Home</a></li>
					<!-- <li class="has-children">
	                    <a href="#">Dropdown</a>
	                    <ul class="dropdown">
	                        <li><a href="elements.html">Elements</a></li>
	                        <li><a href="#">Menu One</a></li>
	                        <li class="has-children">
	                            <a href="#">Menu Two</a>
	                            <ul class="dropdown">
	                                <li><a href="#">Sub Menu One</a></li>
	                                <li><a href="#">Sub Menu Two</a></li>
	                                <li><a href="#">Sub Menu Three</a></li>
	                            </ul>
	                        </li>
	                        <li><a href="#">Menu Three</a></li>
	                    </ul>
	                </li> -->
					<li><a href="{{route('services')}}">Services</a></li>
					<li><a href="{{route('about')}}">About</a></li>
					<li><a href="{{route('contact')}}">Contact Us</a></li>
					@guest('touristGuard')
					<li><a href="{{route('web.registration')}}">Registration</a></li>
					<li><a href="{{route('web.login')}}">Login</a></li>
					@endguest
					@auth('touristGuard')
					<li><a style="color: red;">{{ auth('touristGuard')->user()->name }}</a></li>
					<li><a href="{{route('web.logout')}}">Logout</a></li>
					@endauth
				</ul>

				<a href="#" class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none light" data-toggle="collapse" data-target="#main-navbar">
					<span></span>
				</a>

			</div>
		</div>
	</nav>