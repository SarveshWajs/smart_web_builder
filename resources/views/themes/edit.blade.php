@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Theme</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('themes.update', $theme->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Theme Name</label>
                <input type="text" name="name" value="{{ old('name', $theme->name) }}" class="form-control" id="name" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('themes.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
