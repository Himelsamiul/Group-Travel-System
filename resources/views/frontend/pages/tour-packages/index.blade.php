@extends('frontend.master')

@section('content')

<div class="hero hero-inner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="mb-0">Tour Packages</h1>
                <p class="text-muted">Explore our available tour packages</p>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container">
        <div class="row">

            @forelse($packages as $p)
                @php
                    $days = \Carbon\Carbon::parse($p->start_date)
                                ->diffInDays(\Carbon\Carbon::parse($p->end_date)) + 1;
                    $nights = $days - 1;

                    $discount = $p->discount ?? 0;
                    $discountAmount = ($p->price_per_person * $discount) / 100;
                    $finalPrice = $p->price_per_person - $discountAmount;
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">

                        {{-- Image --}}
                        <img src="{{ asset('uploads/tour-packages/'.$p->thumbnail_image) }}"
                             class="card-img-top"
                             style="height:220px;object-fit:cover;">

                        <div class="card-body d-flex flex-column">

                            <h5 class="mb-1">{{ $p->package_title }}</h5>

                            <small class="text-muted mb-2">
                                📍 {{ $p->place->name ?? '-' }}
                            </small>

                            <p class="text-muted small">
                                {{ $p->short_description }}
                            </p>

                            <ul class="list-unstyled small mb-3">
                                <li>🗓 {{ $days }} Days / {{ $nights }} Nights</li>
                                <li>📅 {{ \Carbon\Carbon::parse($p->start_date)->format('d M') }}
                                    →
                                    {{ \Carbon\Carbon::parse($p->end_date)->format('d M Y') }}
                                </li>
                                <li>👥 Seats: {{ $p->available_seats }}</li>
                            </ul>

                            <div class="mb-3">
                                @if($discount > 0)
                                    <del class="text-muted">৳{{ number_format($p->price_per_person) }}</del>
                                    <br>
                                    <strong class="text-success">
                                        ৳{{ number_format($finalPrice) }}
                                    </strong>
                                @else
                                    <strong class="text-success">
                                        ৳{{ number_format($p->price_per_person) }}
                                    </strong>
                                @endif
                            </div>

                            <a href="{{ route('tour.packages.show',$p->id) }}"
                               class="btn btn-primary mt-auto">
                                View Full Details
                            </a>

                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12 text-center text-muted">
                    No tour packages available right now.
                </div>
            @endforelse

        </div>

        <div class="mt-4">
            {{ $packages->links() }}
        </div>
    </div>
</div>

@endsection
