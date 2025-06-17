@extends('layouts.app')

@section('content')
    <h2>Create New Project</h2>

    <form method="POST" action="{{ route('projects.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Project Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="theme_id" class="form-label">Theme</label>
            <select name="theme_id" class="form-select" required>
                @foreach ($themes as $theme)
                    <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
    <label class="form-label">Select Components (Drag to Reorder)</label>
    <ul id="components" class="list-group">
        @foreach ($components as $component)
            <li class="list-group-item d-flex align-items-center" data-id="{{ $component->id }}">
                <input type="checkbox" name="component_ids[]" value="{{ $component->id }}" class="form-check-input me-2">
                {{ $component->name }}
            </li>
        @endforeach
    </ul>
</div>

        <button type="submit" class="btn btn-primary">Generate UI</button>
    </form>
@endsection
@section('scripts')
<script>
    new Sortable(document.getElementById('components'), {
        animation: 150
    });
</script>
@endsection
