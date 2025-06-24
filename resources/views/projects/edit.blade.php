@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Project: {{ $project->name }}</h2>
    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Project Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $project->name }}" required>
        </div>
        <div class="mb-3">
            <label for="theme_id" class="form-label">Theme</label>
            <select name="theme_id" id="theme_id" class="form-control" required>
                @foreach($themes as $theme)
                    <option value="{{ $theme->id }}" @if($project->theme_id == $theme->id) selected @endif>
                        {{ $theme->name }}
                    </option>
                @endforeach
            </select>
        </div>
       <div class="mb-3">
    <label for="component_ids" class="form-label">Components</label>
    <ul id="components" class="list-group">
    @foreach ($components as $component)
        <li class="list-group-item d-flex align-items-center justify-content-between" data-id="{{ $component->id }}">
            <div>
                <input
                    type="checkbox"
                    name="component_ids[]"
                    value="{{ $component->id }}"
                    class="form-check-input me-2 component-checkbox"
                    @if($project->components->contains($component->id)) checked @endif
                >
                {{ $component->name }}
            </div>
            <span class="handle ms-2" style="cursor:move;">
                <i class="bi bi-list"></i>
            </span>
        </li>
    @endforeach
</ul>
<small class="text-muted">Drag to reorder. Uncheck to remove from project.</small>
</div>

        <button type="submit" class="btn btn-primary">Update Project</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Make the list sortable
    new Sortable(document.getElementById('components'), {
        handle: '.handle',
        animation: 150
    });
    // No need to hide <li> on uncheck!
});
</script>
@endpush
