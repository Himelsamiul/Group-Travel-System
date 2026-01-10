@extends('backend.master')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h4>Tour Package Details</h4>
        <a href="{{ route('tour-packages.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    @php
        $price = $package->price_per_person;
        $discountPercent = $package->discount ?? 0;
        $discountAmount = ($price * $discountPercent) / 100;
        $finalPrice = $price - $discountAmount;

        $days = \Carbon\Carbon::parse($package->start_date)
                    ->diffInDays(\Carbon\Carbon::parse($package->end_date)) + 1;
        $nights = $days - 1;
    @endphp

    {{-- ================= PACKAGE INFO ================= --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <strong>Package Information</strong>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('uploads/tour-packages/'.$package->thumbnail_image) }}"
                         class="img-fluid img-thumbnail">
                </div>

                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Package Title</th>
                            <td>{{ $package->package_title }}</td>
                        </tr>

                        <tr>
                            <th>Short Description</th>
                            <td>{{ $package->short_description }}</td>
                        </tr>

                        <tr>
                            <th>Full Description</th>
                            <td>{{ $package->full_description }}</td>
                        </tr>

                        <tr>
                            <th>Schedule</th>
                            <td>
                                {{ $package->start_date }} → {{ $package->end_date }}
                                <br>
                                <small class="text-muted">
                                    {{ $days }} Days / {{ $nights }} Nights
                                </small>
                            </td>
                        </tr>

                        <tr>
                            <th>Price (Per Person)</th>
                            <td>৳{{ number_format($price) }}</td>
                        </tr>

                        <tr>
                            <th>Discount (%)</th>
                            <td>
                                {{ $discountPercent }}%
                            </td>
                        </tr>

                        <tr>
                            <th>Discount Amount</th>
                            <td class="text-danger">
                                -৳{{ number_format($discountAmount) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Final Price</th>
                            <td>
                                <strong class="text-success">
                                    ৳{{ number_format($finalPrice) }}
                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <th>Seats</th>
                            <td>
                                {{ $package->available_seats }} /
                                {{ $package->max_persons }}
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge {{ $package->status=='active'?'badge-success':'badge-secondary' }}">
                                    {{ ucfirst($package->status) }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{ $package->created_at->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= PLACE DETAILS ================= --}}
    <div class="card shadow-sm mb-3">
        <div class="card-header"><strong>Place Details</strong></div>
        <div class="card-body">
            <p><strong>Country:</strong> {{ $package->place->country }}</p>
            <p><strong>Place:</strong> {{ $package->place->name }}</p>
            <p><strong>Note:</strong> {{ $package->place->note ?? '-' }}</p>
        </div>
    </div>

    {{-- ================= HOTEL DETAILS ================= --}}
    <div class="card shadow-sm mb-3">
        <div class="card-header"><strong>Hotel Details</strong></div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $package->hotel->name }}</p>
            <p><strong>Stars:</strong> {{ $package->hotel->stars }} ★</p>
            <p><strong>Note:</strong> {{ $package->hotel->note ?? '-' }}</p>
        </div>
    </div>

    {{-- ================= TRANSPORT DETAILS ================= --}}
    <div class="card shadow-sm mb-3">
        <div class="card-header"><strong>Transportation Details</strong></div>
        <div class="card-body">
            <p><strong>Type:</strong> {{ ucfirst($package->transportation->type) }}</p>
            <p><strong>Name:</strong> {{ $package->transportation->transport_name }}</p>
            <p><strong>Note:</strong> {{ $package->transportation->note ?? '-' }}</p>
        </div>
    </div>

</div>
@endsection
