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

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
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

                        {{-- Pricing --}}
                        <th>Amount</th>
                        <th>Discount</th>
                        <th>Final Amount</th>

                        {{-- Status --}}
                        <th>Status</th>
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

                            {{-- Pricing --}}
                            <td>৳{{ number_format($price) }}</td>

                            <td>
                                @if($discount > 0)
                                    {{ $discount }}% <br>
                                    <small class="text-danger">
                                        (-৳{{ number_format($discountAmount) }})
                                    </small>
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                <strong class="text-success">
                                    ৳{{ number_format($finalAmount) }}
                                </strong>
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($app->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($app->status === 'accepted')
                                    <span class="badge bg-success">Accepted</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>

                            <td>{{ $app->created_at->format('d M Y') }}</td>

                            {{-- Action --}}
                            <td>
                                @if($app->status === 'pending')
                                    <form action="{{ route('admin.tour.approvals.approve', $app->id) }}"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-sm btn-success"
                                            onclick="return confirm('Approve this application?')">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.tour.approvals.reject', $app->id) }}"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Reject this application?')">
                                            Reject
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">No Action</span>
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
