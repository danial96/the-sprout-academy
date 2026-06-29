@extends('backend.partials.master')

@section('title', 'Child Absent Forms')

@section('content')
    <h1 class="mt-4">Child Absent Forms</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Child Absent Forms</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-child me-1"></i>
            Child Absent Forms
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Parent Name</th>
                        <th>Child Name</th>
                        <th>Phone Number</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Expected Return</th>
                        <th>Reason</th>
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
            $('#datatablesSimple').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.forms.child-absent-forms') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'child_full_name', name: 'child_full_name' },
                    { data: 'phone_number', name: 'phone_number' },
                    { data: 'location', name: 'location' },
                    { data: 'date_submission', name: 'date_submission' },
                    { data: 'date_of_expected_return', name: 'date_of_expected_return' },
                    { data: 'reason', name: 'reason' },
                    { data: 'created_at', name: 'created_at' }
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endpush

