@extends('backend.partials.master')

@section('title', 'Update Employee Password')

@section('content')
    <h1 class="mt-4">Update Employee Password</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Employee Users</a></li>
        <li class="breadcrumb-item active">Update Password</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-key me-1"></i>
            Update Password for {{ $employee->name }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $employee->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" value="{{ $employee->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $employee->email }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" required minlength="8">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password <span
                            class="text-danger">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                        required minlength="8">
                </div>

                <button type="submit" class="btn btn-primary">Update Password</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
