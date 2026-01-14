@extends('backend.master')

@section('content')

<div class="container-fluid">
    <h4 class="mb-4">Contact Messages</h4>

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($messages as $key => $message)
                            <tr>
                                <td>{{ $messages->firstItem() + $key }}</td>

                                <td style="color: orange;">
                                    {{ $message->first_name }}
                                    {{ $message->last_name }}
                                </td>

                                <td style="background-color: #dadcfd;">{{ $message->email }}</td>

                                <td style="max-width:300px;">
                                    {{ Str::limit($message->message, 80) }}
                                </td>

                                <td>
                                    {{ $message->created_at->format('d M Y, h:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    No contact messages found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $messages->links() }}
            </div>

        </div>
    </div>
</div>
@endsection

