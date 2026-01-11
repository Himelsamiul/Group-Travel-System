@extends('frontend.master')

@section('content')

@php
    $days = \Carbon\Carbon::parse($package->start_date)
                ->diffInDays(\Carbon\Carbon::parse($package->end_date)) + 1;
    $nights = $days - 1;

    $discount = $package->discount ?? 0;
    $discountAmount = ($package->price_per_person * $discount) / 100;
    $finalPrice = $package->price_per_person - $discountAmount;
@endphp

<div class="hero hero-inner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="mb-0">{{ $package->package_title }}</h1>
                <p class="text-muted">{{ $package->place->name ?? '' }}</p>
                <p class="text-muted">{{ $package->place->country ?? '' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container">

        <div class="row">

            {{-- Image --}}
            <div class="col-md-6 mb-4">
                <img src="{{ asset('uploads/tour-packages/'.$package->thumbnail_image) }}"
                     class="img-fluid rounded shadow-sm">
            </div>

            {{-- Details --}}
            <div class="col-md-6">

                <h4>Package Overview</h4>
                <p>{{ $package->full_description }}</p>

                <ul class="list-unstyled mb-3">
                    <li><strong>Duration:</strong> {{ $days }} Days / {{ $nights }} Nights</li>
                    <li><strong>Schedule:</strong>
                        {{ \Carbon\Carbon::parse($package->start_date)->format('d M Y') }}
                        →
                        {{ \Carbon\Carbon::parse($package->end_date)->format('d M Y') }}
                    </li>
                    <li><strong>Available Seats:</strong> {{ $package->available_seats }}</li>
                </ul>

                <h5>Pricing</h5>
                <ul class="list-unstyled">
                    <li>Price: ৳{{ number_format($package->price_per_person) }}</li>
                    @if($discount > 0)
                        <li>Discount: {{ $discount }}%</li>
                        <li class="text-danger">
                            Discount Amount: -৳{{ number_format($discountAmount) }}
                        </li>
                    @endif
                    <li>
                        <strong class="text-success">
                            Final Price: ৳{{ number_format($finalPrice) }}
                        </strong>
                    </li>
                </ul>

                <hr>

                <h5>Included Services</h5>
                <ul>
                    <li><strong>Hotel:</strong> {{ $package->hotel->name ?? '-' }}
                        ({{ $package->hotel->stars ?? '-' }} ★)
                    </li>
                    <li><strong>Transportation:</strong>
                        {{ ucfirst($package->transportation->type ?? '-') }}
                        - {{ $package->transportation->transport_name ?? '' }}
                    </li>
                </ul>

                <hr>

                {{-- Future Apply Button --}}
                <button class="btn btn-success btn-lg" disabled>
                    Apply / Book Now (Coming Soon)
                </button>

            </div>

        </div>

    </div>
</div>

@endsection
