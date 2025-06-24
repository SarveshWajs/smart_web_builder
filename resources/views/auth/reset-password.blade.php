@extends('layouts.app')

@section('content')

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4>Reset Password</h4>
        </div>
        <div class="card-body">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                {{-- Password Reset Token --}}
                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email', request()->email) }}" required autofocus>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
