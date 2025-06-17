@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Component</h3>

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

        <form method="POST" action="{{ route('component.update', $component->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Component Name</label>
                <input type="text" name="name" value="{{ old('name', $component->name) }}" class="form-control" id="name" required>
            </div>

            <div class="mb-3">
                <label for="html" class="form-label">HTML Code</label>
                <textarea name="html" class="form-control" id="html" rows="5" required>{{ old('html', $component->html) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="css" class="form-label">CSS Code (optional)</label>
                <textarea name="css" class="form-control" id="css" rows="3">{{ old('css', $component->css) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('component.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
