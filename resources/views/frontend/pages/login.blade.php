@extends('frontend.master')
@section('content')

<div class="hero hero-inner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mx-auto text-center">
                <div class="intro-wrap">
                    <h1 class="mb-0">Login</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5">

                <div class="card login-card border-0 shadow-lg">
                    <div class="card-body p-4">

                        <h4 class="text-center mb-4">Welcome Back</h4>

                        <form action="{{ route('web.do.login') }}" method="POST">
                            @csrf

                            <!-- Email -->
                            <div class="form-group mb-3">
                                <label class="text-black">Email address</label>
                                <input type="email"
                                       class="form-control"
                                       name="email"
                                       placeholder="Enter your email"
                                       required>
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <label class="text-black">Password</label>
                                <input type="password"
                                       class="form-control"
                                       name="password"
                                       placeholder="Enter your password"
                                       required>
                            </div>

                            <!-- Remember + links row -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="remember"
                                           name="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>

                                <div class="login-links d-flex gap-3">
                                    <span class="text-muted small">Forgot password?</span>
                                    <span class="text-muted small">Registration</span>
                                </div>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-primary w-100">
                                Login
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Page styles --}}
<style>
    .login-card {
        border-radius: 16px;
        transition: transform .3s ease;
    }

    .login-card:hover {
        transform: translateY(-4px);
    }

    .login-card .form-control {
        border-radius: 10px;
        padding: 12px;
    }

    .login-links span {
        cursor: default;
        user-select: none;
    }
</style>

@endsection
