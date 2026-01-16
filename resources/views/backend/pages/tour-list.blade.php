@extends('backend.master')

@section('content')

<div class="container-fluid">
    <h4 class="mb-4">Tour Applications (All Details)</h4>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
<form method="GET" class="card mb-3">
    <div class="card-body">
        <div class="row g-2">

            {{-- Name --}}
            <div class="col-md-3">
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Search by name"
                       value="{{ request('name') }}">
            </div>

            {{-- Phone --}}
            <div class="col-md-3">
                <input type="text"
                       name="phone"
                       class="form-control"
                       placeholder="Search by phone"
                       value="{{ request('phone') }}">
            </div>

            {{-- Package --}}
            <div class="col-md-3">
                <select name="package_id" class="form-control">
                    <option value="">All Packages</option>
                    @foreach($packages as $package)
                        <option value="{{ $package->id }}"
                            {{ request('package_id') == $package->id ? 'selected' : '' }}>
                            {{ $package->package_title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- From Date --}}
            <div class="col-md-3">
                <input type="date"
                       name="from_date"
                       class="form-control"
                       value="{{ request('from_date') }}">
            </div>

            {{-- To Date --}}
            <div class="col-md-3">
                <input type="date"
                       name="to_date"
                       class="form-control"
                       value="{{ request('to_date') }}">
            </div>

            {{-- Buttons --}}
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100">
                    🔍 Search
                </button>
                <a href="{{ route('admin.tour.approvals') }}"
                   class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

        </div>
    </div>
</form>

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-white">
                    <tr>
                        <th>#</th>

                        {{-- Tourist Info --}}
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>NID / Passport</th>

                        {{-- Apply Time Info --}}
                        <th>Present Address</th>
                        <th>City</th>
                        <th>Emergency Contact</th>
                        <th>Note Name</th>
                        <th>Special Note</th>

                        {{-- Tour Info --}}
                        <th>Tour Package</th>
                        <th>Price Per Person</th>
                        <th>Total Person</th>

                        {{-- Pricing --}}
                        <th>Total Amount</th>
                        <th>Dues</th>

                        {{-- Status --}}
                        <th>Status</th>
                        <th>Payment Status</th>
                        <th>Applied At</th>

                        {{-- Action --}}
                        <th width="160">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($applications as $key => $app)

                        @php
                            $price = $app->tourPackage->price_per_person ?? 0;
                            $discount = $app->tourPackage->discount ?? 0;
                            $discountAmount = ($price * $discount) / 100;
                            $finalAmount = $price - $discountAmount;
                        @endphp

                        <tr>
                            <td>{{ $key + 1 }}</td>

                            {{-- Tourist Info --}}
                            <td>{{ $app->tourist->name ?? '-' }}</td>
                            <td>{{ $app->tourist->email ?? '-' }}</td>
                            <td>{{ $app->phone }}</td>
                            <td>{{ $app->tourist->date_of_birth ?? '-' }}</td>
                            <td>{{ ucfirst($app->tourist->gender ?? '-') }}</td>
                            <td>{{ $app->tourist->nationality ?? '-' }}</td>
                            <td>{{ $app->tourist->nid_passport ?? '-' }}</td>

                            {{-- Apply Time Info --}}
                            <td>{{ $app->address }}</td>
                            <td>{{ $app->city }}</td>
                            <td>{{ $app->emergency_contact }}</td>
                            <td>{{ $app->note_name ?? '-' }}</td>
                            <td>{{ $app->special_note ?? '-' }}</td>

                            {{-- Tour --}}
                            <td>{{ $app->tourPackage->package_title ?? '-' }}</td>
                            <td>{{ $app->tourPackage->price_per_person }}</td>
                            <td>{{ $app->total_persons }}</td>

                            <td>
                                <strong class="text-success">
                                    ৳{{ number_format($app->final_amount) }}
                                </strong>
                            </td>
                            <td>
                                <strong class="text-success">
                                    ৳{{ number_format($app->dues) }}
                                </strong>
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($app->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($app->status === 'accepted')
                                    <span class="badge bg-success">Accepted</span>
                                @elseif($app->status === 'booked')
                                    <span class="badge bg-success">Booked</span>
                                @elseif($app->status === 'cancel requested')
                                    <span class="badge bg-success">Cancel Requested</span>
                                @elseif($app->status === 'cancel request accept')
                                    <span class="badge bg-success">Cancel Request Accept</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                {{ $app->payment_status }}
                            </td>

                            <td>{{ $app->created_at->format('d M Y') }}</td>

                            {{-- Action --}}
                            <td>
                                @if($app->payment_status === 'Partial Paid' && $app->status != 'cancel request accept')
                                    <form action="{{ route('admin.tour.payment.complete', $app->id) }}"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-sm btn-success"
                                            onclick="return confirm('Accept this payment complete?')">
                                            Complete Payment
                                        </button>
                                    </form>
                                @endif
                                @if($app->status === 'cancel requested')
                                    <form action="{{ route('admin.tour.accept.cancel.request', $app->id) }}"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-sm btn-success"
                                            onclick="return confirm('Are you sure you want to accept this cancel request?')">
                                            Accept Cancel Request
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="20" class="text-center">
                                No tour applications found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection
