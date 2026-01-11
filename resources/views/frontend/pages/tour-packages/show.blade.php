@extends('frontend.master')

@section('content')

@php
    use Carbon\Carbon;

    $days = Carbon::parse($package->start_date)
                ->diffInDays(Carbon::parse($package->end_date)) + 1;
    $nights = $days - 1;

    $discount = $package->discount ?? 0;
    $discountAmount = ($package->price_per_person * $discount) / 100;
    $finalPrice = $package->price_per_person - $discountAmount;
@endphp

{{-- ================= HERO ================= --}}
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

{{-- ================= PACKAGE DETAILS ================= --}}
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
                    <li>
                        <strong>Duration:</strong>
                        {{ $days }} Days / {{ $nights }} Nights
                    </li>
                    <li>
                        <strong>Schedule:</strong>
                        {{ Carbon::parse($package->start_date)->format('d M Y') }}
                        →
                        {{ Carbon::parse($package->end_date)->format('d M Y') }}
                    </li>
<li>
    <strong>Seats:</strong>
    {{ $package->available_seats }}
    out of
    {{ $package->max_persons }}
    remaining
</li>


                {{-- Pricing --}}
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

                {{-- Included Services --}}
                <h5>Included Services</h5>
                <ul>
                    <li>
                        <strong>Hotel:</strong>
                        {{ $package->hotel->name ?? '-' }}
                        ({{ $package->hotel->stars ?? '-' }} ★)
                    </li>
                    <li>
                        <strong>Transportation:</strong>
                        {{ ucfirst($package->transportation->type ?? '-') }}
                        - {{ $package->transportation->transport_name ?? '' }}
                    </li>
                </ul>

                <hr>

                {{-- ================= APPLY BUTTON ================= --}}
{{-- ================= APPLY BUTTON ================= --}}

@if(!$canApply)

    <button class="btn btn-secondary btn-lg" disabled>
        Application Already Submitted
    </button>

@else

    <a href="{{ route('tour.apply.form', $package->id) }}"
       class="btn btn-success btn-lg">
        Apply for this Tour
    </a>

@endif


            </div>
        </div>
    </div>
</div>

<hr class="my-5">

{{-- ================= REVIEW SECTION ================= --}}
<div class="untree_co-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h4 class="mb-4">Write a Review</h4>

                        <div class="mb-3">
                            <label class="d-block mb-2">
                                <strong>Your Rating</strong>
                            </label>

                            <div class="rating-stars" style="font-size:26px;color:#ffc107;">
                                ★ ★ ★ ★ ★
                            </div>

                            <small class="text-muted">
                                (Star selection will be enabled later)
                            </small>
                        </div>

                        <div class="form-group mb-4">
                            <label><strong>Your Review</strong></label>
                            <textarea class="form-control"
                                      rows="5"
                                      placeholder="Share your experience about this tour..."
                                      disabled></textarea>
                        </div>

                        <button class="btn btn-primary" disabled>
                            Submit Review (Coming Soon)
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
