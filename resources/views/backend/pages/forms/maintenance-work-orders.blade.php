@extends('backend.partials.master')

@section('title', 'Maintenance Work Orders')

@section('content')
    <h1 class="mt-4">Maintenance Work Orders</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Maintenance Work Orders</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-wrench me-1"></i>
            Maintenance Work Orders
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Today's Date</th>
                        <th>Completion Date</th>
                        <th>Area Repair</th>
                        <th>Created At</th>
                        <th>Action</th>
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
            $('#datatablesSimple').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.forms.maintenance-work-orders') }}",
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
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'todays_date',
                        name: 'todays_date'
                    },
                    {
                        data: 'completion_date',
                        name: 'completion_date'
                    },
                    {
                        data: 'area_repair',
                        name: 'area_repair'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ]
            });

            $(document).on('click', '.delete-btn', function() {
                if (!confirm('Are you sure you want to delete this record?')) return;
                const id = $(this).data('id');
                const btn = $(this).prop('disabled', true);
                $.ajax({
                    url: '/admin/forms/maintenance-work-orders/' + id,
                    method: 'POST',
                    data: { _method: 'DELETE' },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function() { $('#datatablesSimple').DataTable().ajax.reload(); },
                    error: function() { alert('Error deleting record.'); btn.prop('disabled', false); }
                });
            });
        });
    </script>
@endpush
