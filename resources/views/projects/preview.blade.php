@extends('layouts.app')

@section('content')
    <h2>Preview: {{ $project->name }}</h2>

    <p><strong>Theme:</strong> {{ $project->theme->name }}</p>

    <iframe src="{{ asset('storage/projects/project_' . $project->id . '/index.html') }}"
            style="width: 100%; height: 600px; border: 1px solid #ccc;"></iframe>

    <a href="{{ asset('storage/projects/project_' . $project->id . '/index.html') }}"
       class="btn btn-secondary mt-3" target="_blank">Open in New Tab</a>
@endsection

