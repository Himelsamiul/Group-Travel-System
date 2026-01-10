@extends('backend.master')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Edit Tour Package</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST"
                  action="{{ route('tour-packages.update',$package->id) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Package Title *</label>
                        <input type="text" name="package_title"
                               class="form-control"
                               value="{{ $package->package_title }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Place *</label>
                        <select name="place_id" class="form-control" required>
                            @foreach($places as $place)
                                <option value="{{ $place->id }}"
                                    {{ $package->place_id == $place->id ? 'selected' : '' }}>
                                    {{ $place->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Start Date *</label>
                        <input type="date" name="start_date"
                               class="form-control"
                               value="{{ $package->start_date }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>End Date *</label>
                        <input type="date" name="end_date"
                               class="form-control"
                               value="{{ $package->end_date }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Max Persons *</label>
                        <input type="number" name="max_persons"
                               class="form-control"
                               value="{{ $package->max_persons }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Min Persons</label>
                        <input type="number" name="min_persons"
                               class="form-control"
                               value="{{ $package->min_persons }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Price Per Person *</label>
                        <input type="number" name="price_per_person"
                               class="form-control"
                               value="{{ $package->price_per_person }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Discount (%)</label>
                        <input type="number" name="discount"
                               class="form-control"
                               value="{{ $package->discount }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Hotel *</label>
                        <select name="hotel_id" class="form-control" required>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}"
                                    {{ $package->hotel_id == $hotel->id ? 'selected' : '' }}>
                                    {{ $hotel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Transportation *</label>
                        <select name="transportation_id" class="form-control" required>
                            @foreach($transportations as $t)
                                <option value="{{ $t->id }}"
                                    {{ $package->transportation_id == $t->id ? 'selected' : '' }}>
                                    {{ ucfirst($t->type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Included Items *</label>
                        <textarea name="included_items"
                                  class="form-control"
                                  rows="3" required>{{ $package->included_items }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Excluded Items</label>
                        <textarea name="excluded_items"
                                  class="form-control"
                                  rows="3">{{ $package->excluded_items }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Thumbnail Image</label>
                        <input type="file" name="thumbnail_image"
                               class="form-control">
                        <small class="text-muted">
                            Leave empty to keep existing image
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ $package->status=='active'?'selected':'' }}>Active</option>
                            <option value="inactive" {{ $package->status=='inactive'?'selected':'' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Short Description *</label>
                        <textarea name="short_description"
                                  class="form-control"
                                  rows="2" required>{{ $package->short_description }}</textarea>
                    </div>

                    <div class="col-md-12 mb-4">
                        <label>Full Description *</label>
                        <textarea name="full_description"
                                  class="form-control"
                                  rows="4" required>{{ $package->full_description }}</textarea>
                    </div>

                </div>

                <button class="btn btn-primary">
                    Update Package
                </button>
                <a href="{{ route('tour-packages.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

            </form>
        </div>
    </div>
</div>
@endsection
