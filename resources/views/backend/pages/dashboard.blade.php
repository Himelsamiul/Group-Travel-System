@extends('backend.master')

@section('content')
<div class="container-fluid">
	<h4 class="page-title">Dashboard</h4>

	<div class="row">

		{{-- Total Tour Packages --}}
		<div class="col-md-3">
			<div class="card card-stats card-primary">
				<div class="card-body">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center">
								<i class="la la-suitcase"></i>
							</div>
						</div>
						<div class="col-7 d-flex align-items-center">
							<div class="numbers">
								<p class="card-category">Tour Packages</p>
								<h4 class="card-title">{{ $totalPackages }}</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		{{-- Total Hotels --}}
		<div class="col-md-3">
			<div class="card card-stats card-success">
				<div class="card-body">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center">
								<i class="la la-hotel"></i>
							</div>
						</div>
						<div class="col-7 d-flex align-items-center">
							<div class="numbers">
								<p class="card-category">Hotels</p>
								<h4 class="card-title">{{ $totalHotels }}</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		{{-- Total Transport --}}
		<div class="col-md-3">
			<div class="card card-stats card-warning">
				<div class="card-body">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center">
								<i class="la la-bus"></i>
							</div>
						</div>
						<div class="col-7 d-flex align-items-center">
							<div class="numbers">
								<p class="card-category">Transport</p>
								<h4 class="card-title">{{ $totalTransport }}</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		{{-- Total Places --}}
		<div class="col-md-3">
			<div class="card card-stats card-danger">
				<div class="card-body">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center">
								<i class="la la-map-marker"></i>
							</div>
						</div>
						<div class="col-7 d-flex align-items-center">
							<div class="numbers">
								<p class="card-category">Places</p>
								<h4 class="card-title">{{ $totalPlaces }}</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection
