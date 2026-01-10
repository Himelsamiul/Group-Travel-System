@extends('backend.master')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Create Tour Package</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST"
                  action="{{ route('tour-packages.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Package Title *</label>
                        <input type="text" name="package_title"
                               class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Place *</label>
                        <select name="place_id" class="form-control" required>
                            <option value="">Select Place</option>
                            @foreach($places as $place)
                                <option value="{{ $place->id }}">{{ $place->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Start Date *</label>
                        <input type="date" name="start_date"
                               class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>End Date *</label>
                        <input type="date" name="end_date"
                               class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Max Persons *</label>
                        <input type="number" name="max_persons"
                               class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Min Persons</label>
                        <input type="number" name="min_persons"
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Price Per Person *</label>
                        <input type="number" name="price_per_person"
                               class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Discount (%)</label>
                        <input type="number" name="discount"
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Hotel *</label>
                        <select name="hotel_id" class="form-control" required>
                            <option value="">Select Hotel</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Transportation *</label>
                        <select name="transportation_id" class="form-control" required>
                            <option value="">Select Transport</option>
                            @foreach($transportations as $t)
                                <option value="{{ $t->id }}">{{ ucfirst($t->type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Included Items *</label>
                        <textarea name="included_items"
                                  class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Excluded Items</label>
                        <textarea name="excluded_items"
                                  class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Thumbnail Image *</label>
                        <input type="file" name="thumbnail_image"
                               class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Short Description *</label>
                        <textarea name="short_description"
                                  class="form-control" rows="2" required></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Full Description *</label>
                        <textarea name="full_description"
                                  class="form-control" rows="4" required></textarea>
                    </div>
                </div>

                <button class="btn btn-primary">
                    Create Package
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
