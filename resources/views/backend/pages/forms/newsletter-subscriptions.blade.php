@extends('backend.partials.master')

@section('title', 'Newsletter Subscriptions')

@section('content')
    <h1 class="mt-4">Newsletter Subscriptions</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Newsletter Subscriptions</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-envelope me-1"></i> Newsletter Subscriptions</div>
            <a href="{{ route('admin.forms.newsletter-subscriptions.export') }}" class="btn btn-sm btn-success">
                <i class="fas fa-file-csv me-1"></i> Export CSV
            </a>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
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
                ajax: "{{ route('admin.forms.newsletter-subscriptions') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
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
                    url: '/admin/forms/newsletter-subscriptions/' + id,
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
