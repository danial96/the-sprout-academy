@extends('backend.partials.master')

@section('title', 'Snack Orders')

@section('content')
    <h1 class="mt-4">Snack Orders</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Snack Orders</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-cookie me-1"></i>
            Snack Orders
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Location</th>
                        <th>Items Count</th>
                        <th>Order Items</th>
                        <th>Other</th>
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
            const dataTable = $('#datatablesSimple').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.forms.snack-orders') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'location', name: 'location' },
                    { data: 'items_count', name: 'items_count' },
                    { data: 'order_items', name: 'order_items' },
                    { data: 'other', name: 'other' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'desc']]
            });

            $(document).on('click', '.delete-btn', function() {
                if (!confirm('Are you sure you want to delete this record?')) return;
                const id = $(this).data('id');
                const btn = $(this).prop('disabled', true);
                $.ajax({
                    url: '/admin/forms/snack-orders/' + id,
                    method: 'POST',
                    data: { _method: 'DELETE' },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function() { dataTable.ajax.reload(); },
                    error: function() { alert('Error deleting record.'); btn.prop('disabled', false); }
                });
            });
        });
    </script>
@endpush
