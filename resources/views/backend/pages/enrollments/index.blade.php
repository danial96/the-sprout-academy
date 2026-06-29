@extends('backend.partials.master')

@section('title', 'Enrollments')

@section('content')
    <h1 class="mt-4">Enrollments</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Enrollments</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-user-graduate me-1"></i>
                All Enrollments
            </div>
            <div class="d-flex align-items-center gap-2">
                <label for="locationFilter" class="mb-0 me-2">Filter by Location:</label>
                <select id="locationFilter" class="form-select form-select-sm" style="width: auto; min-width: 200px;">
                    <option value="all">All Locations</option>
                    <!-- Options will be loaded via AJAX -->
                </select>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Primary Contact</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Children</th>
                        <th>Referrer</th>
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
            let dataTable;
            
            // Load locations for filter dropdown
            $.ajax({
                url: "{{ route('admin.enrollments.locations') }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    const locationFilter = $('#locationFilter');
                    response.forEach(function(location) {
                        locationFilter.append(
                            $('<option></option>')
                                .attr('value', location.value)
                                .text(location.label)
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error loading locations:', error);
                }
            });

            // Initialize DataTable
            dataTable = $('#datatablesSimple').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.enrollments.index') }}",
                    data: function(d) {
                        d.location = $('#locationFilter').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'primary_contact',
                        name: 'primary_contact'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'children_count',
                        name: 'children_count',
                        orderable: false
                    },
                    {
                        data: 'referrer',
                        name: 'referrer'
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

            // Handle location filter change
            $('#locationFilter').on('change', function() {
                dataTable.ajax.reload();
            });
        });
    </script>
@endpush

