@extends('backend.partials.master')

@section('title', 'Time Off Requests')

@section('content')
    <h1 class="mt-4">Time Off Requests</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Time Off Requests</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-calendar-times me-1"></i>
            Time Off Requests
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Paid/Unpaid</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTables will populate this -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const dataTable = $('#datatablesSimple').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.forms.time-off-requests') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'paid_unpaid',
                        name: 'paid_unpaid'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ],
                order: [
                    [0, 'desc']
                ]
            });

            // Approve button handler
            $(document).on('click', '.approve-btn', function() {
                const id = $(this).data('id');
                const btn = $(this);

                if (confirm('Are you sure you want to approve this time off request?')) {
                    btn.prop('disabled', true);

                    $.ajax({
                        url: "{{ route('admin.forms.time-off-requests.approve', ':id') }}".replace(
                            ':id', id),
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response.message || 'Request approved successfully.');
                            dataTable.ajax.reload();
                        },
                        error: function(xhr) {
                            const message = xhr.responseJSON?.message ||
                                'Error approving request.';
                            alert(message);
                            btn.prop('disabled', false);
                        }
                    });
                }
            });

            // Reject button handler
            $(document).on('click', '.reject-btn', function() {
                const id = $(this).data('id');
                const btn = $(this);

                const reason = prompt('Please provide a reason for rejection (optional):');
                if (reason !== null) { // User didn't cancel
                    btn.prop('disabled', true);

                    $.ajax({
                        url: "{{ route('admin.forms.time-off-requests.reject', ':id') }}".replace(
                            ':id', id),
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            rejection_reason: reason
                        },
                        success: function(response) {
                            alert(response.message || 'Request rejected successfully.');
                            dataTable.ajax.reload();
                        },
                        error: function(xhr) {
                            const message = xhr.responseJSON?.message ||
                                'Error rejecting request.';
                            alert(message);
                            btn.prop('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
@endpush
