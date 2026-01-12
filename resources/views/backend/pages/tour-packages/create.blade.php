@extends('backend.master')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Create Tour Package</h4>

    {{-- ================= GLOBAL VALIDATION ERRORS ================= --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST"
                  action="{{ route('tour-packages.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- Package Title --}}
                    <div class="col-md-6 mb-3">
                        <label>Package Title *</label>
                        <input type="text"
                               name="package_title"
                               value="{{ old('package_title') }}"
                               class="form-control @error('package_title') is-invalid @enderror"
                               required>
                        @error('package_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Place --}}
                    <div class="col-md-6 mb-3">
                        <label>Place *</label>
                        <select name="place_id"
                                class="form-control @error('place_id') is-invalid @enderror"
                                required>
                            <option value="">Select Place</option>
                            @foreach($places as $place)
                                <option value="{{ $place->id }}"
                                    {{ old('place_id') == $place->id ? 'selected' : '' }}>
                                    {{ $place->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('place_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Start Date --}}
                    <div class="col-md-6 mb-3">
                        <label>Start Date *</label>
                        <input type="date"
                               name="start_date"
                               value="{{ old('start_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="form-control @error('start_date') is-invalid @enderror"
                               required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- End Date --}}
                    <div class="col-md-6 mb-3">
                        <label>End Date *</label>
                        <input type="date"
                               name="end_date"
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('end_date') }}"
                               class="form-control @error('end_date') is-invalid @enderror"
                               required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Max Persons --}}
                    <div class="col-md-6 mb-3">
                        <label>Max Persons *</label>
                        <input type="number"
                               name="max_persons"
                               value="{{ old('max_persons') }}"
                               class="form-control @error('max_persons') is-invalid @enderror"
                               required>
                        @error('max_persons')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Min Persons --}}
                    <div class="col-md-6 mb-3">
                        <label>Min Persons</label>
                        <input type="number"
                               name="min_persons"
                               value="{{ old('min_persons') }}"
                               class="form-control @error('min_persons') is-invalid @enderror">
                        @error('min_persons')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div class="col-md-6 mb-3">
                        <label>Price Per Person *</label>
                        <input type="number"
                               name="price_per_person"
                               value="{{ old('price_per_person') }}"
                               class="form-control @error('price_per_person') is-invalid @enderror"
                               required>
                        @error('price_per_person')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Discount --}}
                    <div class="col-md-6 mb-3">
                        <label>Discount (%)</label>
                        <input type="number"
                               name="discount"
                               value="{{ old('discount') }}"
                               class="form-control @error('discount') is-invalid @enderror">
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Hotel --}}
                    <div class="col-md-6 mb-3">
                        <label>Hotel *</label>
                        <select name="hotel_id"
                                class="form-control @error('hotel_id') is-invalid @enderror"
                                required>
                            <option value="">Select Hotel</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}"
                                    {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                    {{ $hotel->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('hotel_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Transportation --}}
                    <div class="col-md-6 mb-3">
                        <label>Transportation *</label>
                        <select name="transportation_id"
                                class="form-control @error('transportation_id') is-invalid @enderror"
                                required>
                            <option value="">Select Transport</option>
                            @foreach($transportations as $t)
                                <option value="{{ $t->id }}"
                                    {{ old('transportation_id') == $t->id ? 'selected' : '' }}>
                                    {{ ucfirst($t->type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('transportation_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Included Items --}}
                    <div class="col-md-12 mb-3">
                        <label>Included Items *</label>
                        <textarea name="included_items"
                                  class="form-control @error('included_items') is-invalid @enderror"
                                  rows="3"
                                  required>{{ old('included_items') }}</textarea>
                        @error('included_items')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Excluded Items --}}
                    <div class="col-md-12 mb-3">
                        <label>Excluded Items</label>
                        <textarea name="excluded_items"
                                  class="form-control @error('excluded_items') is-invalid @enderror"
                                  rows="3">{{ old('excluded_items') }}</textarea>
                        @error('excluded_items')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Thumbnail Image --}}
                    <div class="col-md-6 mb-3">
                        <label>Thumbnail Image *</label>
                        <input type="file"
                               name="thumbnail_image"
                               class="form-control @error('thumbnail_image') is-invalid @enderror"
                               required>
                        @error('thumbnail_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label>Status *</label>
                        <select name="status"
                                class="form-control @error('status') is-invalid @enderror"
                                required>
                            <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Short Description --}}
                    <div class="col-md-12 mb-3">
                        <label>Short Description *</label>
                        <textarea name="short_description"
                                  class="form-control @error('short_description') is-invalid @enderror"
                                  rows="2"
                                  required>{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Full Description --}}
                    <div class="col-md-12 mb-3">
                        <label>Full Description *</label>
                        <textarea name="full_description"
                                  class="form-control @error('full_description') is-invalid @enderror"
                                  rows="4"
                                  required>{{ old('full_description') }}</textarea>
                        @error('full_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
