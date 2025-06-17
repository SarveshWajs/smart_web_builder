@extends('layouts.app')

@section('content')
    <h2>Admin Dashboard</h2>

    <div class="mb-3">
        <a href="{{ route('themes.index') }}" class="btn btn-outline-primary">Manage Themes</a>
        <a href="{{ route('component.index') }}" class="btn btn-outline-success">Manage Components</a>
    </div>
@endsection

