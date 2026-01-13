@extends('backend.master')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">Manage Places</h4>

    <div class="row">

        {{-- ================= CREATE / EDIT FORM ================= --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>
                        {{ isset($place) ? 'Edit Place' : 'Create Place' }}
                    </strong>
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($place) ? route('places.update',$place->id) : route('places.store') }}">
                        @csrf
                        @if(isset($place))
                            @method('PUT')
                        @endif

                        <div class="form-group mb-3">
                            <label>Country <span class="text-danger">*</span></label>
                            <select name="country" class="form-control" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country }}"
                                        {{ (isset($place) && $place->country == $country) ? 'selected' : '' }}>
                                        {{ $country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Place Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ $place->name ?? '' }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="active"
                                    {{ (isset($place) && $place->status=='active')?'selected':'' }}>
                                    Active
                                </option>
                                <option value="inactive"
                                    {{ (isset($place) && $place->status=='inactive')?'selected':'' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Note</label>
                            <textarea name="note" class="form-control" rows="3">{{ $place->note ?? '' }}</textarea>
                        </div>

                        <button class="btn btn-primary w-100">
                            {{ isset($place) ? 'Update Place' : 'Create Place' }}
                        </button>

                        @if(isset($place))
                            <a href="{{ route('places.index') }}"
                               class="btn btn-secondary w-100 mt-2">
                                Cancel
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- ================= PLACE LIST ================= --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Place List</strong>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Country</th>
                                <th>Place</th>
                                <th>Status</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th width="160">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($places as $key => $p)
                                <tr>
                                    <td>{{ $places->firstItem() + $key }}</td>
                                    <td>{{ $p->country }}</td>
                                    <td>{{ $p->name }}</td>

                                    <td>
                                        <span class="badge {{ $p->status=='active'?'badge-success':'badge-secondary' }}">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>

                                    <td>{{ $p->note }}</td>
                                    <td>{{ $p->created_at->format('d M, Y') }}</td>

                                    <td>
                                        {{-- EDIT --}}
                                        <a href="{{ route('places.edit',$p->id) }}"
                                           class="btn btn-sm btn-info mb-1">
                                            Edit
                                        </a>

                                        {{-- DELETE (LOCKED IF USED) --}}
                                        @if($p->tour_packages_count > 0)
                                            <button class="btn btn-sm btn-secondary mb-1"
                                                    disabled
                                                    title="This place is used in tour packages">
                                                Delete
                                            </button>
                                            <div class="text-danger small">
                                                Used in tour packages
                                            </div>
                                        @else
                                            <form action="{{ route('places.destroy',$p->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Delete this place?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger mb-1">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No places found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- ================= PAGINATION ================= --}}
                    @if ($places->lastPage() > 1)
                        <nav class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted small">
                                Showing {{ $places->firstItem() }} to {{ $places->lastItem() }}
                                of {{ $places->total() }} results
                            </div>

                            <ul class="pagination mb-0">
                                <li class="page-item {{ $places->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $places->previousPageUrl() ?? '#' }}">
                                        Previous
                                    </a>
                                </li>

                                @for ($i = 1; $i <= $places->lastPage(); $i++)
                                    <li class="page-item {{ $places->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $places->url($i) }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                <li class="page-item {{ $places->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $places->nextPageUrl() ?? '#' }}">
                                        Next
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                    {{-- ================= END PAGINATION ================= --}}

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
