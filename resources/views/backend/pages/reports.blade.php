@extends('backend.master')

@section('content')
<div class="container-fluid" id="print-area">

    {{-- ================= HEADER ================= --}}
    <div class="text-center mb-4">
        <h2>Tour Management System</h2>
        <h4>Booking Report</h4>
    </div>

    {{-- ================= FILTER ================= --}}
    <form method="GET" action="{{ route('admin.reports') }}" class="row g-3 mb-4 no-print">

        <div class="col-md-3">
            <label>Tourist Name</label>
            <input type="text" name="tourist_name" class="form-control"
                   value="{{ request('tourist_name') }}">
        </div>

        <div class="col-md-3">
            <label>Tour Package</label>
            <select name="tour_package_id" class="form-control">
                <option value="">All Packages</option>
                @foreach($packages as $pkg)
                    <option value="{{ $pkg->id }}"
                        {{ request('tour_package_id')==$pkg->id?'selected':'' }}>
                        {{ $pkg->package_title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control"
                   value="{{ request('phone') }}">
        </div>


        <div class="col-md-2">
            <label>From Date</label>
            <input type="date" name="from_date" class="form-control"
                   value="{{ request('from_date') }}">
        </div>

        <div class="col-md-3">
            <label>To Date</label>
            <input type="date" name="to_date" class="form-control"
                   value="{{ request('to_date') }}">
        </div>

        <div class="col-md-12 text-end">
            <button class="btn btn-primary">
                <i class="la la-search"></i> Search
            </button>

            <button type="button" onclick="window.print()" class="btn btn-success">
                <i class="la la-print"></i> Print
            </button>

            <a href="{{ route('admin.reports') }}" class="btn btn-secondary">
                Reset
            </a>
        </div>

    </form>

    {{-- ================= REPORT TABLE ================= --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>SL</th>
                        <th>Tourist</th>
                        <th>Phone</th>
                        <th>Package</th>
                       
                        <th>Final Amount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Applied Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $key => $app)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $app->tourist->name ?? '-' }}</td>
                            <td>{{ $app->phone }}</td>
                            <td>{{ $app->tourPackage->package_title ?? '-' }}</td>
                            


                    
                            <td style="color: orange;">৳{{ number_format($app->final_amount) }}</td>
                            <td style="color: red;">৳{{ number_format($app->final_amount - $app->dues) }}</td>
                            <td style="color: green;">৳{{ number_format($app->dues) }}</td>
                            <td>{{ $app->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                No records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ================= PRINT CSS (SAFE) ================= --}}
<style>
@media print {

    @page {
        size: A4 landscape;
        margin: 10mm;
    }

    body * {
        visibility: hidden;
    }

    #print-area, #print-area * {
        visibility: visible;
    }

    #print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .no-print {
        display: none !important;
    }

    table {
        width: 100% !important;
        table-layout: fixed !important;
        border-collapse: collapse;
    }

    table th, table td {
        border: 1px solid #000 !important;
        padding: 4px !important;
        font-size: 10px !important;
        word-wrap: break-word;
        word-break: break-word;
        white-space: normal !important;
        text-align: left;
    }

    h2, h4 {
        text-align: center;
        margin-bottom: 8px;
    }
}
</style>

@endsection
