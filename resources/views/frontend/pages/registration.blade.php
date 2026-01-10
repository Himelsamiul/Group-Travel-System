@extends('frontend.master')
@section('content')

<div class="hero hero-inner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mx-auto text-center">
                <div class="intro-wrap">
                    <h1 class="mb-0">Registration</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="custom-block" data-aos="fade-up" data-aos-delay="100">

                    <form class="contact-form bg-white p-4"
                          action="{{ route('web.do.registration') }}"
                          method="POST">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label class="text-black">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="text-black">Email address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label class="text-black">Phone</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>

                        <!-- Gender -->
                        <div class="form-group">
                            <label class="text-black">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Date of Birth -->
                        <div class="form-group">
                            <label class="text-black">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control">
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label class="text-black">Address</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>

                        <!-- Nationality -->
                        <div class="form-group">
                            <label class="text-black">Nationality</label>
                            <input type="text" name="nationality" class="form-control">
                        </div>

                        <!-- NID / Passport -->
                        <div class="form-group">
                            <label class="text-black">NID / Passport</label>
                            <input type="text" name="nid_passport" class="form-control">
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label class="text-black">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label class="text-black">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Register
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
