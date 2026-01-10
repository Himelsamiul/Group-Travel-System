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
                        <th>Note</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($packages as $key => $p)
                        @php
                            $discountPercent = $p->discount ?? 0;
                            $discountAmount = ($p->price_per_person * $discountPercent) / 100;
                            $finalPrice = $p->price_per_person - $discountAmount;
                        @endphp

                        <tr>
                            <td>{{ $packages->firstItem() + $key }}</td>

                            {{-- Image --}}
                            <td>
                                <img src="{{ asset('uploads/tour-packages/'.$p->thumbnail_image) }}"
                                     width="70"
                                     class="img-thumbnail">
                            </td>

                            {{-- Title --}}
                            <td>
                                <strong>{{ $p->package_title }}</strong>
                            </td>

                            {{-- Short Description --}}
                            <td>{{ $p->short_description }}</td>

                            {{-- Place --}}
                            <td>{{ $p->place->name ?? '-' }}</td>

                            {{-- Schedule --}}
                            <td>
                                {{ \Carbon\Carbon::parse($p->start_date)->format('d M') }}
                                →
                                {{ \Carbon\Carbon::parse($p->end_date)->format('d M Y') }}
                            </td>

                            {{-- Days --}}
                            <td>
                                {{ \Carbon\Carbon::parse($p->start_date)
                                    ->diffInDays(\Carbon\Carbon::parse($p->end_date)) + 1 }}
                                Days
                            </td>

                            {{-- Price --}}
                            <td>৳{{ number_format($p->price_per_person) }}</td>

                            {{-- Discount % --}}
                            <td>
                                @if($discountPercent > 0)
                                    <span class="badge badge-info">
                                        {{ $discountPercent }}%
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- Discount Amount --}}
                            <td>
                                @if($discountPercent > 0)
                                    <span class="text-danger">
                                        -৳{{ number_format($discountAmount) }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- Final Price --}}
                            <td>
                                <strong class="text-success">
                                    ৳{{ number_format($finalPrice) }}
                                </strong>
                            </td>

                            {{-- Note --}}
                            <td>
                                {{ $p->note ?? '-' }}
                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="badge {{ $p->status=='active' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>

                            {{-- Created --}}
                            <td>
                                {{ $p->created_at->format('d M Y') }}
                            </td>

                            {{-- Action --}}
                            <td>
                                <a href="{{ route('tour-packages.edit',$p->id) }}"
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>

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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center text-muted">
                                No tour packages found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $packages->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
