@extends('frontend.master')

@section('content')

{{-- Font Awesome CDN (icon guaranteed) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<div class="hero hero-inner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mx-auto text-center">
                <div class="intro-wrap">
                    <h1 class="mb-0">My Profile</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container">

        <!-- PROFILE SECTION -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">

                <div class="card profile-card border-0">
                    <div class="card-body p-4">

                        <!-- Profile Top -->
                        <div class="text-center mb-4">
                            <div class="profile-avatar mx-auto mb-3">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <h4 class="text-white mb-1">{{ $tourist->name }}</h4>
                            <p class="text-white-50 mb-0">{{ $tourist->email }}</p>
                        </div>

                        <!-- Profile Details -->
                        <div class="profile-details bg-white rounded p-4">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $tourist->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ ucfirst($tourist->gender) }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ $tourist->date_of_birth }}</td>
                                </tr>
                                <tr>
                                    <th>Nationality</th>
                                    <td>{{ $tourist->nationality }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $tourist->address }}</td>
                                </tr>
                                <tr>
                                    <th>NID / Passport</th>
                                    <td>{{ $tourist->nid_passport }}</td>
                                </tr>
                                <tr>
                                    <th>Member Since</th>
                                    <td>{{ $tourist->created_at->format('d M Y') }}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- HISTORY SECTION -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient text-white">
                <h5 class="mb-0">History (Demo)</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>SL</th>
                            <th>History Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Tour Booking (Demo)</td>
                            <td>12 Jan 2026</td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Payment Record (Demo)</td>
                            <td>15 Jan 2026</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Support Request (Demo)</td>
                            <td>20 Jan 2026</td>
                            <td><span class="badge bg-info">Processing</span></td>
                        </tr>
                    </tbody>
                </table>

                <p class="text-muted mt-2">
                    * This section is for future use (booking, payment, tour history).
                </p>
            </div>
        </div>

    </div>
</div>

{{-- PAGE STYLES --}}
<style>
    /* Profile Card */
    .profile-card {
        background: linear-gradient(135deg, #b4beebff, #764ba2);
        border-radius: 18px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        transition: transform .3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
    }

    /* Avatar */
    .profile-avatar {
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        color: #fff;
        box-shadow: 0 0 0 6px rgba(255,255,255,0.15);
    }

    /* Details Box */
    .profile-details {
        margin-top: 30px;
    }

    .profile-details th {
        width: 180px;
        font-weight: 600;
        color: #555;
    }

    .profile-details td {
        color: #333;
    }

    /* History Header */
    .bg-gradient {
        background: linear-gradient(135deg, #43cea2, #abd0f6ff);
    }
</style>

@endsection
