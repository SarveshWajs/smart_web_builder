@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Add New Component</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Please fix the following errors:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('component.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Component Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="html" class="form-label">HTML Code</label>
                <textarea name="html" class="form-control" id="html" rows="5" required>{{ old('html') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="css" class="form-label">CSS Code (Optional)</label>
                <textarea name="css" class="form-control" id="css" rows="3">{{ old('css') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('component.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
