@extends('backend.master')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Registered Tourists</h3>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>Address</th>
                        <th>NID/Passport</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tourists as $key => $tourist)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $tourist->name }}</td>
                            <td>{{ $tourist->email }}</td>
                            <td>{{ $tourist->phone }}</td>
                            <td>{{ ucfirst($tourist->gender) }}</td>
                            <td>{{ $tourist->nationality }}</td>
                            <td>{{ $tourist->address }}</td>
                            <td>{{ $tourist->nid_passport }}</td>
                            <td>
                                <form method="POST"
                                      action="{{ route('tourists.delete', $tourist->id) }}"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No tourists found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
