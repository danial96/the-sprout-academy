@extends('backend.partials.master')

@section('title', 'Suggestions')

@section('content')
    <h1 class="mt-4">Suggestions</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Suggestions</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-lightbulb me-1"></i>
            Suggestions
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Description</th>
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
                ajax: "{{ route('admin.forms.suggestions') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'subject', name: 'subject' },
                    { data: 'description', name: 'description' },
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
                    url: '/admin/forms/suggestions/' + id,
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
