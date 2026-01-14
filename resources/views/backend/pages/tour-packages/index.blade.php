@extends('backend.master')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Tour Packages</h4>

        <a href="{{ route('tour-packages.create') }}"
           class="btn btn-primary">
            + Create Tour Package
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="40">SL</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Short Description</th>
                        <th>Place</th>
                        <th>Schedule</th>
                        <th>Days</th>

                        <th>Price</th>
                        <th>Discount %</th>
                        <th>Discount Amount</th>
                        <th>Final Price</th>

                        <th>Total Seats</th>
                        <th>Booked</th>
                        <th>Available</th>

                        <th>Status</th>
                        <th>Created</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($packages as $key => $p)
                        @php
                            $discountPercent = $p->discount ?? 0;
                            $discountAmount = ($p->price_per_person * $discountPercent) / 100;
                            $finalPrice = $p->price_per_person - $discountAmount;

                            $days = \Carbon\Carbon::parse($p->start_date)
                                    ->diffInDays(\Carbon\Carbon::parse($p->end_date)) + 1;
                            $nights = $days - 1;

                            $totalSeats = $p->max_persons;
                            $availableSeats = $p->available_seats;
                            $bookedSeats = $p->booked;

                            // 🔐 booking check
                            $hasBooking = $p->tour_applications_count > 0;
                        @endphp

                        <tr>
                            <td>{{ $packages->firstItem() + $key }}</td>

                            <td>
                                <img src="{{ asset('uploads/tour-packages/'.$p->thumbnail_image) }}"
                                     width="70"
                                     class="img-thumbnail">
                            </td>

                            <td><strong>{{ $p->package_title }}</strong></td>

                            <td>{{ $p->short_description }}</td>

                            <td>{{ $p->place->name ?? '-' }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($p->start_date)->format('d M') }}
                                →
                                {{ \Carbon\Carbon::parse($p->end_date)->format('d M Y') }}
                            </td>

                            <td>
                                <span class="badge badge-primary">{{ $days }} D</span>
                                <span class="badge badge-secondary">{{ $nights }} N</span>
                            </td>

                            <td>৳{{ number_format($p->price_per_person) }}</td>

                            <td>
                                @if($discountPercent > 0)
                                    <span class="badge badge-info">{{ $discountPercent }}%</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>
                                @if($discountPercent > 0)
                                    <span class="text-danger">
                                        -৳{{ number_format($discountAmount) }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>
                                <strong class="text-success">
                                    ৳{{ number_format($finalPrice) }}
                                </strong>
                            </td>

                            <td>
                                <span class="badge badge-dark">{{ $totalSeats }}</span>
                            </td>

                            <td>
                                <span class="badge badge-warning">{{ $bookedSeats }}</span>
                            </td>

                            <td>
                                @if($availableSeats > 0)
                                    <span class="badge badge-success">{{ $availableSeats }}</span>
                                @else
                                    <span class="badge badge-danger">Full</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge {{ $p->status == 'active' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>

                            <td>{{ $p->created_at->format('d M Y') }}</td>

                            {{-- 🔐 ACTION --}}
                            <td>
                                <a href="{{ route('tour-packages.show',$p->id) }}"
                                   class="btn btn-sm btn-secondary">
                                   View
                                </a>

                                <a href="{{ route('tour-packages.edit',$p->id) }}"
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>

                                {{-- DELETE LOCK --}}
                                @if($hasBooking)
                                    <button class="btn btn-sm btn-danger" disabled>
                                        Delete
                                    </button>
                                    <small class="text-danger d-block mt-1">
                                        This package has been used by tourist
                                    </small>
                                @else
                                    <form action="{{ route('tour-packages.destroy',$p->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this tour package?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="18" class="text-center text-muted">
                                No tour packages found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $packages->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
