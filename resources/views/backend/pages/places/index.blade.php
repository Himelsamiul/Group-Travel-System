@extends('backend.master')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">Manage Places</h4>

    <div class="row">

        <!-- ================= CREATE / EDIT FORM ================= -->
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

                        <!-- Country -->
                        <div class="form-group mb-3">
                            <label>Country</label>
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

                        <!-- Place Name -->
                        <div class="form-group mb-3">
                            <label>Place Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ $place->name ?? '' }}"
                                   placeholder="Enter place name"
                                   required>
                        </div>

                        <!-- Note -->
                        <div class="form-group mb-3">
                            <label>Note</label>
                            <textarea name="note"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Optional note">{{ $place->note ?? '' }}</textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary w-100">
                                {{ isset($place) ? 'Update Place' : 'Create Place' }}
                            </button>

                            @if(isset($place))
                                <a href="{{ route('places.index') }}"
                                   class="btn btn-secondary w-100">
                                    Cancel
                                </a>
                            @endif
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- ================= PLACE LIST ================= -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Place List</strong>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">SL</th>
                                <th>Country</th>
                                <th>Place</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th width="140">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($places as $key => $p)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $p->country }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->note }}</td>
                                    <td>{{ $p->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <a href="{{ route('places.edit',$p->id) }}"
                                           class="btn btn-sm btn-info">
                                            Edit
                                        </a>

<form action="{{ route('places.destroy',$p->id) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirm('Are you sure you want to delete this place?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">
        Delete
    </button>
</form>


                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No places found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection


{{-- ================= SWEETALERT DELETE CONFIRM ================= --}}




