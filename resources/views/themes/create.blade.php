@extends('layouts.app')

@section('content')
    <h3>Add New Theme</h3>

    <form method="POST" action="{{ route('themes.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Theme Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button class="btn btn-success">Save</button>
    </form>
@endsection
