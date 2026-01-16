@extends('backend.master')

@section('content')
<div class="container-fluid">
    <h4 class="page-title mb-4">Dashboard</h4>

    {{-- ================= BASIC DASHBOARD CARDS ================= --}}
    <div class="row mt-3">

        <div class="col-md-3">
            <div class="stat-card gradient-purple">
                <i class="la la-suitcase stat-icon"></i>
                <div>
                    <p>Tour Packages</p>
                    <h3>{{ $totalPackages }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card gradient-blue">
                <i class="la la-hotel stat-icon"></i>
                <div>
                    <p>Hotels</p>
                    <h3>{{ $totalHotels }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card gradient-orange">
                <i class="la la-bus stat-icon"></i>
                <div>
                    <p>Transport</p>
                    <h3>{{ $totalTransport }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card gradient-red">
                <i class="la la-map-marker stat-icon"></i>
                <div>
                    <p>Places</p>
                    <h3>{{ $totalPlaces }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card gradient-dark">
                <i class="la la-book stat-icon"></i>
                <div>
                    <p>Total Bookings</p>
                    <h3>{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card gradient-cyan">
                <i class="la la-users stat-icon"></i>
                <div>
                    <p>Total Tourists</p>
                    <h3>{{ $totalTourists }}</h3>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= BOOKING STATUS CARDS ================= --}}
    <div class="row mt-4">

        <div class="col-md-3">
            <div class="stat-card gradient-yellow">
                <i class="la la-clock stat-icon"></i>
                <div>
                    <p>Pending</p>
                    <h3>{{ $pendingBookings }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card gradient-green">
                <i class="la la-check stat-icon"></i>
                <div>
                    <p>Accepted</p>
                    <h3>{{ $acceptedBookings }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card gradient-red">
                <i class="la la-times stat-icon"></i>
                <div>
                    <p>Rejected</p>
                    <h3>{{ $rejectedBookings }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card gradient-blue">
                <i class="la la-bookmark stat-icon"></i>
                <div>
                    <p>Booked</p>
                    <h3>{{ $bookedBookings }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card gradient-orange">
                <i class="la la-ban stat-icon"></i>
                <div>
                    <p>Cancel Requested</p>
                    <h3>{{ $cancelReqBookings }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card gradient-cyan">
                <i class="la la-check-circle stat-icon"></i>
                <div>
                    <p>Cancel Approved</p>
                    <h3>{{ $cancelAccBookings }}</h3>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= PIE CHART ================= --}}
    <div class="row mt-5 justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 chart-card">
                <div class="card-header bg-dark text-white text-center">
                    <h6 class="mb-0">Booking Status Overview</h6>
                </div>
                <div class="card-body">
                    <div style="height:220px">
                        <canvas id="bookingPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ================= STYLES ================= --}}
<style>
.stat-card{
    display:flex;
    align-items:center;
    gap:18px;
    padding:22px;
    border-radius:18px;
    color:#fff;
    min-height:120px;
    margin:12px;
    transition:.35s ease;
    cursor:pointer;
    box-shadow:0 14px 28px rgba(0,0,0,.18);
}
.stat-card:hover{
    transform:translateY(-6px) scale(1.02);
    box-shadow:0 24px 40px rgba(0,0,0,.28);
}
.stat-icon{
    font-size:42px;
    animation:float 3s ease-in-out infinite;
}
.stat-card p{
    margin:0;
    font-size:14px;
    opacity:.9;
}
.stat-card h3{
    margin:0;
    font-size:28px;
    font-weight:700;
}

/* gradients */
.gradient-purple{background:linear-gradient(135deg,#667eea,#764ba2)}
.gradient-blue{background:linear-gradient(135deg,#36d1dc,#5b86e5)}
.gradient-orange{background:linear-gradient(135deg,#f7971e,#ffd200)}
.gradient-red{background:linear-gradient(135deg,#ff416c,#ff4b2b)}
.gradient-dark{background:linear-gradient(135deg,#232526,#414345)}
.gradient-green{background:linear-gradient(135deg,#11998e,#38ef7d)}
.gradient-yellow{background:linear-gradient(135deg,#fceabb,#f8b500)}
.gradient-cyan{background:linear-gradient(135deg,#43cea2,#185a9d)}

.chart-card{
    border-radius:16px;
    overflow:hidden;
}

@keyframes float{
    0%{transform:translateY(0)}
    50%{transform:translateY(-6px)}
    100%{transform:translateY(0)}
}
</style>

{{-- ================= CHART JS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('bookingPieChart'), {
    type: 'pie',
    data: {
        labels: [
            'Pending',
            'Accepted',
            'Rejected',
            'Booked',
            'Cancel Requested',
            'Cancel Approved'
        ],
        datasets: [{
            data: [
                {{ $pendingBookings }},
                {{ $acceptedBookings }},
                {{ $rejectedBookings }},
                {{ $bookedBookings }},
                {{ $cancelReqBookings }},
                {{ $cancelAccBookings }}
            ],
            backgroundColor: [
                '#f8b500',
                '#38ef7d',
                '#ff4b2b',
                '#df29ab',
                '#1b20a8',
                '#11644a'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endsection
