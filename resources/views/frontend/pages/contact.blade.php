@extends('frontend.master')

@section('content')

{{-- HERO SECTION --}}
<div class="hero hero-inner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mx-auto text-center">
                <div class="intro-wrap">
                    <h1 class="mb-0">Contact Us</h1>
                    <p class="text-white">
                        Feel free to reach out to us for any inquiries, tour details,
                        or travel assistance. We are always here to help you.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CONTACT FORM SECTION --}}
<div class="untree_co-section">
    <div class="container">
        <div class="row">

            {{-- FORM --}}
            <div class="col-lg-6 mb-5 mb-lg-0">
                <form 
                    action="{{ route('contact.submit') }}" 
                    method="POST" 
                    class="contact-form" 
                    data-aos="fade-up" 
                    data-aos-delay="200"
                >
                    @csrf

                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- VALIDATION ERRORS --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="text-black">First name</label>
                                <input 
                                    type="text" 
                                    name="first_name" 
                                    class="form-control"
                                    value="{{ old('first_name') }}"
                                    required
                                >
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="text-black">Last name</label>
                                <input 
                                    type="text" 
                                    name="last_name" 
                                    class="form-control"
                                    value="{{ old('last_name') }}"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="text-black">Email address</label>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="text-black">Message</label>
                        <textarea 
                            name="message" 
                            class="form-control" 
                            cols="30" 
                            rows="5" 
                            required
                        >{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Send Message
                    </button>
                </form>
            </div>

            {{-- CONTACT INFO --}}
            <div class="col-lg-5 ml-auto">
                <div class="quick-contact-item d-flex align-items-center mb-4">
                    <span class="flaticon-house"></span>
                    <address class="text">
                        Road 12, Sector 10, Uttara, Dhaka
                    </address>
                </div>

                <div class="quick-contact-item d-flex align-items-center mb-4">
                    <span class="flaticon-phone-call"></span>
                    <address class="text">
                        +880 1787 362195
                    </address>
                </div>

                <div class="quick-contact-item d-flex align-items-center mb-4">
                    <span class="flaticon-mail"></span>
                    <address class="text">
                        aafiajahin@gmail.com
                    </address>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
