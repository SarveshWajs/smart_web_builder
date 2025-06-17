@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Explore Templates</h2>

    {{-- Status Message --}}
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    {{-- Create Template Button --}}
    @auth
        <div class="mb-4">
            <a href="{{ route('projects.create') }}" class="btn btn-primary">Create Template</a>
        </div>
    @endauth

    {{-- Card Grid --}}
    @if($projects->isEmpty())
        <div class="alert alert-info">No templates available yet.</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($projects as $project)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        {{-- Preview placeholder (use preview image if available) --}}
                        <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                            <span class="fw-bold">{{ $project->name }}</span>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">{{ $project->name }}</h5>
                            <p class="card-text">
                                <strong>Theme:</strong> {{ $project->theme->name ?? 'N/A' }} <br>
                                <small class="text-muted">Created on {{ $project->created_at->format('Y-m-d') }}</small>
                            </p>
                        </div>

                        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                            <a href="{{ route('projects.preview', $project->id) }}" class="btn btn-success btn-sm" target="_blank">Preview</a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
