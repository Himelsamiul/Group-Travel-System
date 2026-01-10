@extends('backend.master')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">Manage Hotels</h4>

    <div class="row">

        {{-- ================= CREATE / EDIT FORM ================= --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>
                        {{ isset($hotel) ? 'Edit Hotel' : 'Create Hotel' }}
                    </strong>
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($hotel) ? route('hotels.update',$hotel->id) : route('hotels.store') }}">
                        @csrf
                        @if(isset($hotel))
                            @method('PUT')
                        @endif

                        {{-- Hotel Name --}}
                        <div class="form-group mb-3">
                            <label>Hotel Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ $hotel->name ?? '' }}"
                                   required>
                        </div>

                        {{-- Hotel Stars --}}
                        <div class="form-group mb-3">
                            <label>Hotel Stars <span class="text-danger">*</span></label>
                            <select name="stars" class="form-control" required>
                                <option value="">Select Stars</option>
                                @for($i=1;$i<=5;$i++)
                                    <option value="{{ $i }}"
                                        {{ (isset($hotel) && $hotel->stars == $i) ? 'selected' : '' }}>
                                        {{ $i }} Star
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="form-group mb-3">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="active"
                                    {{ (isset($hotel) && $hotel->status == 'active') ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive"
                                    {{ (isset($hotel) && $hotel->status == 'inactive') ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        {{-- Note --}}
                        <div class="form-group mb-3">
                            <label>Note</label>
                            <textarea name="note"
                                      class="form-control"
                                      rows="3">{{ $hotel->note ?? '' }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary w-100">
                                {{ isset($hotel) ? 'Update Hotel' : 'Create Hotel' }}
                            </button>

                            @if(isset($hotel))
                                <a href="{{ route('hotels.index') }}"
                                   class="btn btn-secondary w-100">
                                    Cancel
                                </a>
                            @endif
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- ================= LIST ================= --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Hotel List</strong>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Stars</th>
                                <th>Status</th>
                                <th>Note</th>
                                <th width="130">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hotels as $key => $h)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $h->name }}</td>
                                    <td>{{ $h->stars }} ★</td>
                                    <td>
                                        <span class="badge {{ $h->status=='active'?'badge-success':'badge-secondary' }}">
                                            {{ ucfirst($h->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $h->note }}</td>
                                    <td>
                                        <a href="{{ route('hotels.edit',$h->id) }}"
                                           class="btn btn-sm btn-info">
                                            Edit
                                        </a>

                                        <form action="{{ route('hotels.destroy',$h->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this hotel?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No hotels found
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
