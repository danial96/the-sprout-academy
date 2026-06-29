@extends('backend.partials.master')

@section('title', 'Time Clock Change Requests')

@section('content')
    <h1 class="mt-4">Time Clock Change Requests</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Time Clock Change Requests</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-clock me-1"></i>
            Time Clock Change Requests
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Date To Be Changed</th>
                        <th>Clock In</th>
                        <th>Clock Out For Lunch</th>
                        <th>Clock In From Lunch</th>
                        <th>Clock Out</th>
                        {{-- <th>Supervisor</th> --}} {{-- TEMPORARILY REMOVED --}}
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
                ajax: "{{ route('admin.forms.time-clock-change-requests') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'date_to_be_changed',
                        name: 'date_to_be_changed'
                    },
                    {
                        data: 'clock_in_time',
                        name: 'clock_in_time'
                    },
                    {
                        data: 'clock_out_for_lunch',
                        name: 'clock_out_for_lunch'
                    },
                    {
                        data: 'clock_in_from_lunch',
                        name: 'clock_in_from_lunch'
                    },
                    {
                        data: 'clock_out_time',
                        name: 'clock_out_time'
                    },
                    // { // TEMPORARILY REMOVED
                    //     data: 'supervisor_name',
                    //     name: 'supervisor_name'
                    // },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endpush
