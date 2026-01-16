@extends('frontend.master')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

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

        {{-- ================= PROFILE SECTION ================= --}}
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="card profile-card border-0">
                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <div class="profile-avatar mx-auto mb-3">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <h4 class="text-white mb-1">{{ $tourist->name }}</h4>
                            <p class="text-white-50 mb-0">{{ $tourist->email }}</p>
                        </div>

                        <div class="profile-details bg-white rounded p-4">
                            <table class="table table-borderless mb-0">
                                <tr><th>Phone</th><td>{{ $tourist->phone }}</td></tr>
                                <tr><th>Gender</th><td>{{ ucfirst($tourist->gender) }}</td></tr>
                                <tr><th>Date of Birth</th><td>{{ $tourist->date_of_birth }}</td></tr>
                                <tr><th>Nationality</th><td>{{ $tourist->nationality }}</td></tr>
                                <tr><th>Address</th><td>{{ $tourist->address }}</td></tr>
                                <tr><th>NID / Passport</th><td>{{ $tourist->nid_passport }}</td></tr>
                                <tr><th>Member Since</th><td>{{ $tourist->created_at->format('d M Y') }}</td></tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- ================= HISTORY SECTION ================= --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient text-white">
                <h5 class="mb-0">My Tour History</h5>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Place</th>
                            <th>Package</th>
                            <th>Price</th>
                            <th>Total Person</th>
                            <th>Discount</th>
                            <th>Discount Amount</th>
                            <th>Final Payable</th>
                            <th>Payment Status</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Cancel Time Limit</th>
                            <th>Applied At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($applications as $key => $app)

                        @php
                            $tourDate = \Carbon\Carbon::parse($app['tour_date']);
                            $cancelLastDate = $tourDate->copy()->subDays(2);
                            $today = \Carbon\Carbon::today();

                            $showCancelButton =
                                $app['status'] === 'booked'
                                && $app['payment_status'] === 'Partial Paid'
                                && $today->lte($cancelLastDate);
                        @endphp

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $app['name'] }}</td>
                            <td>{{ $app['place_name'] }}</td>
                            <td>{{ $app['package_name'] }}</td>
                            <td>৳{{ number_format($app['price']) }}</td>
                            <td>{{ $app['total_persons'] }}</td>
                            <td>{{ $app['discount_pct'] }}%</td>
                            <td class="text-danger">-৳{{ number_format($app['discount_amt']) }}</td>
                            <td class="text-success fw-bold">৳{{ number_format($app['final_amount']) }}</td>
                            <td>{{ $app['payment_status'] }}</td>
                            <td><strong class="text-warning">৳{{ number_format($app['total_due']) }}</strong></td>

                            {{-- STATUS --}}
                            <td>
                                @if($app['status'] === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($app['status'] === 'accepted')
                                    <span class="badge bg-success">Accepted</span>
                                @elseif($app['status'] === 'booked')
                                    <span class="badge bg-success">Booked</span>
                                @elseif(str_contains($app['status'], 'cancel'))
                                    <span class="badge bg-info">{{ ucfirst($app['status']) }}</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>

                            {{-- ✅ CANCEL TIME LIMIT WITH LIVE COUNTDOWN --}}
                            <td>
                                @if($app['status'] === 'booked')
                                    @if($today->lte($cancelLastDate))
                                        <div class="fw-bold text-info">
                                            {{ $cancelLastDate->format('d M Y') }}
                                        </div>
                                        <small
                                            class="countdown-timer text-danger"
                                            data-expire="{{ $cancelLastDate->format('Y-m-d') }} 23:59:59">
                                            Calculating...
                                        </small>
                                    @else
                                        <span class="badge bg-secondary">Expired</span>
                                    @endif
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>

                            <td>{{ $app['applied_at']->format('d M Y') }}</td>

                            {{-- ACTION --}}
                            <td>
                                <a href="{{ route('invoice.print', $app['application_id']) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-primary mb-1">
                                    Invoice
                                </a>

                                @if($showCancelButton)
                                    <a href="{{ route('tour.booking.cancel', $app['application_id']) }}"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to cancel this booking?')">
                                        Cancel
                                    </a>
                                @endif
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="15" class="text-center text-muted">
                                No tour history found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- ================= STYLES ================= --}}
<style>
.profile-card {
    background: linear-gradient(135deg, #b4beebff, #764ba2);
    border-radius: 18px;
    box-shadow: 0 12px 30px rgba(0,0,0,.15);
}
.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:42px;
    color:#fff;
    background:rgba(255,255,255,.2);
}
.profile-details th {
    width:180px;
    font-weight:600;
    color:#555;
}
.bg-gradient {
    background: linear-gradient(135deg, #43cea2, #abd0f6ff);
}
</style>

{{-- ================= LIVE COUNTDOWN SCRIPT ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.countdown-timer').forEach(timer => {

        const expireTime = new Date(timer.dataset.expire).getTime();

        function updateTimer() {
            const now = new Date().getTime();
            const diff = expireTime - now;

            if (diff <= 0) {
                timer.innerHTML = 'Expired';
                timer.classList.remove('text-danger');
                timer.classList.add('text-secondary');
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            timer.innerHTML = `${hours}h ${minutes}m ${seconds}s left`;
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    });

});
</script>

@endsection
