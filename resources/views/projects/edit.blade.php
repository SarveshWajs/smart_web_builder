@extends('layouts.app')

@section('content')
    <h2>Edit Template: {{ $project->name }}</h2>

    <form method="POST" action="{{ route('projects.update', $project->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="theme_id" class="form-label">Theme</label>
            <select class="form-select" name="theme_id" required>
                @foreach($themes as $theme)
                    <option value="{{ $theme->id }}" {{ $project->theme_id == $theme->id ? 'selected' : '' }}>
                        {{ $theme->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="component_ids" class="form-label">Components</label>
            <select class="form-select" name="component_ids[]" multiple required>
                @foreach($components as $component)
                    <option value="{{ $component->id }}" {{ $project->components->contains($component->id) ? 'selected' : '' }}>
                        {{ $component->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl or Cmd to select multiple.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update Template</button>
    </form>
@endsection
