@extends('frontend.master')

@section('content')
<div class="hero hero-inner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mx-auto text-center">
                <div class="intro-wrap">
                    <h1 class="mb-0">Booking Form</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('tour.apply', $package->id) }}" method="POST">
                    @csrf

                    {{-- ================= TOURIST INFO (READ ONLY) ================= --}}
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">Your Information</h5>

                            <div class="mb-2">
                                <label>Name</label>
                                <input type="text" class="form-control"
                                       value="{{ $tourist->name }}" readonly>
                            </div>

                            <div class="mb-2">
                                <label>Email</label>
                                <input type="email" class="form-control"
                                       value="{{ $tourist->email }}" readonly>
                            </div>

                            <div class="mb-2">
                                <label>Date of Birth</label>
                                <input type="text" class="form-control"
                                       value="{{ $tourist->date_of_birth }}" readonly>
                            </div>

                            <div class="mb-2">
                                <label>Gender</label>
                                <input type="text" class="form-control"
                                       value="{{ ucfirst($tourist->gender) }}" readonly>
                            </div>

                            <div class="mb-2">
                                <label>Nationality</label>
                                <input type="text" class="form-control"
                                       value="{{ $tourist->nationality }}" readonly>
                            </div>

                            <div class="mb-2">
                                <label>NID / Passport</label>
                                <input type="text" class="form-control"
                                       value="{{ $tourist->nid_passport }}" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- ================= TOUR APPLICATION INFO ================= --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Tour Application Details</h5>

                            {{-- Phone --}}
                            <div class="mb-2">
                                <label>Phone Number</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $tourist->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Present Address --}}
                            <div class="mb-2">
                                <label>Present Address</label>
                                <textarea name="present_address"
                                          class="form-control @error('present_address') is-invalid @enderror">{{ old('present_address', $tourist->address) }}</textarea>
                                @error('present_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div class="mb-2">
                                <label>City / District</label>
                                <input type="text"
                                       name="city"
                                       class="form-control @error('city') is-invalid @enderror"
                                       value="{{ old('city') }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Emergency Contact --}}
                            <div class="mb-2">
                                <label>Emergency Contact</label>
                                <input type="text"
                                       name="emergency_contact"
                                       class="form-control @error('emergency_contact') is-invalid @enderror"
                                       value="{{ old('emergency_contact') }}">
                                @error('emergency_contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Total Persons --}}
                            <div class="mb-2">
                                <label>Total Person</label>
                                <input type="number"
                                       name="total_persons"
                                       class="form-control @error('total_persons') is-invalid @enderror"
                                       value="{{ old('total_persons') }}">
                                @error('total_persons')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Note Name --}}
                            <div class="mb-2">
                                <label>Note Name (optional)</label>
                                <input type="text"
                                       name="note_name"
                                       class="form-control"
                                       value="{{ old('note_name') }}">
                            </div>

                            {{-- Special Note --}}
                            <div class="mb-3">
                                <label>Special Note (optional)</label>
                                <textarea name="special_note"
                                          class="form-control">{{ old('special_note') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-success">
                                Apply for this Tour
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
