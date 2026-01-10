@extends('backend.master')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">Manage Transportation</h4>

    <div class="row">

        {{-- ================= CREATE / EDIT FORM ================= --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>
                        {{ isset($transport) ? 'Edit Transportation' : 'Create Transportation' }}
                    </strong>
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($transport)
                                    ? route('transportations.update',$transport->id)
                                    : route('transportations.store') }}">
                        @csrf
                        @if(isset($transport))
                            @method('PUT')
                        @endif

                        {{-- Type --}}
                        <div class="form-group mb-3">
                            <label>Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-control" required>
                                <option value="">Select Type</option>
                                @foreach(['bus','car','air','launch','micro'] as $type)
                                    <option value="{{ $type }}"
                                        {{ (isset($transport) && $transport->type == $type) ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Transport Name --}}
                        <div class="form-group mb-3">
                            <label>Transport Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="transport_name"
                                   class="form-control"
                                   value="{{ $transport->transport_name ?? '' }}"
                                   required>
                        </div>

                        {{-- Status --}}
                        <div class="form-group mb-3">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="active"
                                    {{ (isset($transport) && $transport->status=='active') ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive"
                                    {{ (isset($transport) && $transport->status=='inactive') ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        {{-- Note --}}
                        <div class="form-group mb-3">
                            <label>Note</label>
                            <textarea name="note"
                                      class="form-control"
                                      rows="3">{{ $transport->note ?? '' }}</textarea>
                        </div>

                        <button class="btn btn-primary w-100">
                            {{ isset($transport) ? 'Update Transportation' : 'Create Transportation' }}
                        </button>

                        @if(isset($transport))
                            <a href="{{ route('transportations.index') }}"
                               class="btn btn-secondary w-100 mt-2">
                                Cancel
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- ================= LIST ================= --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Transportation List</strong>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="40">SL</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th width="130">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transportations as $key => $t)
                                    <tr>
                                        <td>{{ $transportations->firstItem() + $key }}</td>
                                        <td>{{ ucfirst($t->type) }}</td>
                                        <td>{{ $t->transport_name }}</td>
                                        <td>{{ $t->note ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $t->status=='active'?'badge-success':'badge-secondary' }}">
                                                {{ ucfirst($t->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $t->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('transportations.edit',$t->id) }}"
                                               class="btn btn-sm btn-info">
                                                Edit
                                            </a>

                                            <form action="{{ route('transportations.destroy',$t->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Delete this transportation?');">
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
                                        <td colspan="7" class="text-center text-muted">
                                            No transportation found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- ================= CUSTOM PAGINATION ================= --}}
                    @if ($transportations->lastPage() > 1)
                        <nav class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted small">
                                Showing {{ $transportations->firstItem() }} to {{ $transportations->lastItem() }}
                                of {{ $transportations->total() }} results
                            </div>

                            <ul class="pagination mb-0">
                                <li class="page-item {{ $transportations->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $transportations->previousPageUrl() ?? '#' }}">
                                        Previous
                                    </a>
                                </li>

                                @for ($i = 1; $i <= $transportations->lastPage(); $i++)
                                    <li class="page-item {{ $transportations->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $transportations->url($i) }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                <li class="page-item {{ $transportations->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $transportations->nextPageUrl() ?? '#' }}">
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
