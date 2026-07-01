@extends('backend.partials.master')

@section('title', 'Employee Users')

@section('content')
    <h1 class="mt-4">Employee Users</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Employee Users</li>
    </ol>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i> Create Employee User
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-users me-1"></i>
            Employee Users
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                        <tr id="user-row-{{ $employee->id }}">
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                @if($employee->is_restricted)
                                    <span class="badge bg-danger">Restricted</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td>{{ $employee->created_at?->format('M d, Y h:i A') }}</td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('admin.users.edit', $employee->id) }}"
                                   class="btn btn-sm btn-primary"
                                   title="Update Password"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-key"></i>
                                </a>
                                <button onclick="toggleRestrict({{ $employee->id }}, this)"
                                        class="btn btn-sm {{ $employee->is_restricted ? 'btn-success' : 'btn-warning' }}"
                                        title="{{ $employee->is_restricted ? 'Unrestrict User' : 'Restrict Login' }}"
                                        data-bs-toggle="tooltip"
                                        data-restricted="{{ $employee->is_restricted ? '1' : '0' }}">
                                    <i class="fas {{ $employee->is_restricted ? 'fa-lock-open' : 'fa-ban' }}"></i>
                                </button>
                                <button onclick="deleteUser({{ $employee->id }})"
                                        class="btn btn-sm btn-danger"
                                        title="Delete User"
                                        data-bs-toggle="tooltip">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No employee users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Init Bootstrap tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el, { trigger: 'hover' });
    });

    function toggleRestrict(id, btn) {
        const isRestricted = btn.dataset.restricted === '1';
        const action = isRestricted ? 'unrestrict' : 'restrict';
        if (!confirm(`Are you sure you want to ${action} this user?`)) return;

        fetch(`/admin/users/${id}/toggle-restrict`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            const nowRestricted = data.is_restricted;
            btn.dataset.restricted = nowRestricted ? '1' : '0';
            btn.className = `btn btn-sm ${nowRestricted ? 'btn-success' : 'btn-warning'}`;
            btn.querySelector('i').className = `fas ${nowRestricted ? 'fa-lock-open' : 'fa-ban'}`;

            const tooltip = bootstrap.Tooltip.getInstance(btn);
            if (tooltip) { tooltip.dispose(); }
            btn.setAttribute('title', nowRestricted ? 'Unrestrict User' : 'Restrict Login');
            new bootstrap.Tooltip(btn, { trigger: 'hover' });

            const row = document.getElementById(`user-row-${id}`);
            const badge = row.querySelector('.badge');
            badge.className = `badge ${nowRestricted ? 'bg-danger' : 'bg-success'}`;
            badge.textContent = nowRestricted ? 'Restricted' : 'Active';
        });
    }

    function deleteUser(id) {
        if (!confirm('Are you sure you want to delete this user? This cannot be undone.')) return;

        fetch(`/admin/users/${id}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: new URLSearchParams({ _method: 'DELETE' })
        })
        .then(r => r.json())
        .then(() => {
            document.getElementById(`user-row-${id}`).remove();
        });
    }
</script>
@endpush
