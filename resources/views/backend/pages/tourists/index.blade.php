@extends('backend.master')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Registered Tourists</h3>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>Address</th>
                        <th>NID/Passport</th>
                        <th>Status</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tourists as $key => $tourist)
                        @php
                            $hasBooking = $tourist->tour_applications_count > 0;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $tourist->name }}</td>
                            <td>{{ $tourist->email }}</td>
                            <td>{{ $tourist->phone }}</td>
                            <td>{{ ucfirst($tourist->gender) }}</td>
                            <td>{{ $tourist->nationality }}</td>
                            <td>{{ $tourist->address }}</td>
                            <td>{{ $tourist->nid_passport }}</td>

                            {{-- STATUS --}}
                            <td>
                                <span class="badge {{ $tourist->status == 'active' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ ucfirst($tourist->status) }}
                                </span>
                            </td>

                            {{-- ACTION --}}
                            <td>
                                {{-- ACTIVATE / DEACTIVATE --}}
                                <form action="{{ route('tourists.toggleStatus', $tourist->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm {{ $tourist->status == 'active' ? 'btn-warning' : 'btn-success' }}">
                                        {{ $tourist->status == 'active' ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                {{-- DELETE --}}
                                @if($hasBooking)
                                    <button class="btn btn-sm btn-danger" disabled>
                                        Delete
                                    </button>
                                    <small class="text-danger d-block mt-1">
                                        This tourist has bookings
                                    </small>
                                @else
                                    <form method="POST"
                                          action="{{ route('tourists.delete', $tourist->id) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                No tourists found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
