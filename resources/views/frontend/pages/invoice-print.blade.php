@extends('frontend.master')

@section('content')

{{-- ================= INVOICE HEADER ================= --}}
<div class="invoice-header no-print-hide">
    <h2>BlueWave Tour</h2>
    <p class="tagline">A Smart Tour Booking Platform</p>
</div>

<div class="invoice-wrapper">

    {{-- Print Button --}}
    <div class="text-center mb-3 no-print">
        <button onclick="window.print()" class="btn btn-dark">
            🖨️ Print Invoice
        </button>
    </div>

    {{-- ================= INVOICE CARD ================= --}}
    <div class="invoice-card">

        {{-- Title --}}
        <div class="invoice-title">
            <h3>Tour Booking Invoice</h3>
            <p>
                <strong>Invoice ID:</strong> #{{ $application->id }} <br>
                <strong>Date:</strong> {{ $application->created_at->format('d M Y') }}
            </p>
        </div>

        {{-- ================= CUSTOMER INFO ================= --}}
        <h5 class="section-title">Customer Information</h5>
        <table class="info-table">
            <tr><th>Name</th><td>{{ $tourist->name }}</td></tr>
            <tr><th>Email</th><td>{{ $tourist->email }}</td></tr>
            <tr><th>Phone</th><td>{{ $tourist->phone }}</td></tr>
        </table>

        {{-- ================= TOUR INFO ================= --}}
        <h5 class="section-title">Tour Information</h5>
        <table class="info-table">
            <tr><th>Place</th><td>{{ $application->tourPackage->place->name ?? '-' }}</td></tr>
            <tr><th>Package</th><td>{{ $application->tourPackage->package_title ?? '-' }}</td></tr>
            <tr><th>Tour Date</th><td>{{ $application->tourPackage->start_date ?? '-' }}</td></tr>
            <tr><th>Total Persons</th><td>{{ $application->total_persons }}</td></tr>
        </table>

        {{-- ================= PAYMENT SUMMARY ================= --}}
        <h5 class="section-title">Payment Summary</h5>
        <table class="payment-table">
            <tr>
                <th>Price Per Person</th>
                <td>৳{{ number_format($application->tourPackage->price_per_person ?? 0) }}</td>
            </tr>
            <tr>
                <th>Discount</th>
                <td>{{ $application->tourPackage->discount ?? 0 }}%</td>
            </tr>
            <tr class="highlight">
                <th>Final Amount</th>
                <td>৳{{ number_format($application->final_amount) }}</td>
            </tr>
            <tr>
                <th>Total Due</th>
                <td class="danger">৳{{ number_format($application->dues) }}</td>
            </tr>
        </table>

        {{-- ================= STATUS ================= --}}
        <h5 class="section-title" style="color: green;">Booking & Payment Status</h5>
        <table class="info-table">
            <tr>
                <th>Booking Status</th>
                <td class="status" style="color: blue;">
                    {{ strtoupper($application->status) }}
                </td>
            </tr>
            <tr>
                <th>Payment Status</th>
                <td style="color: green;">{{ $application->payment_status }}</td>
            </tr>
        </table>

        {{-- ================= SIGNATURE ================= --}}
        <div class="signature-section">
            <div class="signature-box">
                <span class="signature-text">Afia</span>
                <hr>
                <p>
                    <strong></strong><br>
                    Managing Director
                </p>
            </div>
        </div>

    </div>

    {{-- ================= INVOICE FOOTER ================= --}}
    <div class="invoice-footer">
        <p><strong>BlueWave Tour</strong></p>
        <p>Afia Jahin</p>
        <p>📞 01787362195</p>
        <p>📍 Road 12, Sector 10, Uttara, Dhaka</p>
        <p class="note">
            This invoice is system generated and valid without physical signature.
        </p>
    </div>

</div>

{{-- ================= STYLES ================= --}}
<style>
/* ================= SCREEN STYLE ================= */
.invoice-header{text-align:center;margin-bottom:20px}
.invoice-header h2{color:#0d6efd;margin-bottom:0}
.tagline{font-size:13px;color:#666}

.invoice-wrapper{max-width:900px;margin:auto}
.invoice-card{background:#fff;padding:30px;border:1px solid #ddd}
.invoice-title{text-align:center;margin-bottom:25px}

.info-table,.payment-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px
}
.info-table th,.info-table td,
.payment-table th,.payment-table td{
    border:1px solid #ddd;
    padding:8px;
    font-size:14px
}
.info-table th{width:30%;background:#f8f9fa}
.payment-table .highlight td{font-weight:bold;background:#e9f5ff}
.payment-table .danger{color:#dc3545}

.section-title{margin:25px 0 10px;font-weight:600}
.status{font-weight:bold}

.signature-section{
    display:flex;
    justify-content:flex-end;
    margin-top:40px
}
.signature-box{width:220px;text-align:center}
.signature-text{
    font-family:'Brush Script MT',cursive;
    font-size:36px
}

.invoice-footer{
    text-align:center;
    margin-top:30px;
    font-size:13px;
    color:#444
}
.invoice-footer .note{
    font-style:italic;
    margin-top:8px
}

/* ================= PRINT CONTROL ================= */
@media print {

    /* hide invoice print button */
    .no-print{
        display:none !important;
    }

    /* 🔥 hide MAIN SITE NAVBAR */
    .logo-header,
    .navbar-header,
    .navbar{
        display:none !important;
    }

    /* 🔥 hide MAIN SITE FOOTER (this fixes 2nd page issue) */
    .site-footer{
        display:none !important;
    }

    /* page behavior */
    body{
        background:#fff !important;
    }

    .invoice-wrapper{
        page-break-inside: avoid;
    }
}
</style>

@endsection
