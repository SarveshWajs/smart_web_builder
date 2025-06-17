@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Explore Templates</h2>

    {{-- Status Message --}}
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if(auth()->check() && auth()->user()->is_admin)
        {{-- Admin View: Show all Themes and Components in tables --}}
       <div class="row mb-5">
    <div class="col-md-6">
        <h4>Themes</h4>
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>

                        <th>Status</th>
                        <th>Action</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($themes as $index => $theme)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $theme->name }}</td>

                            <td>
                                @if($theme->status)
                                    <span class="badge bg-success">Enabled</span>
                                @else
                                    <span class="badge bg-secondary">Disabled</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('themes.toggle', $theme->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $theme->status ? 'btn-warning' : 'btn-success' }}">
                                        {{ $theme->status ? 'Disable' : 'Enable' }}
                                    </button>
                                </form>
                            </td>
                            <td>{{ $theme->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No themes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <h4>Components</h4>
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($components as $index => $component)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $component->name }}</td>
                            <td>
                                @if($component->status)
                                    <span class="badge bg-success">Enabled</span>
                                @else
                                    <span class="badge bg-secondary">Disabled</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('components.toggle', $component->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $component->status ? 'btn-warning' : 'btn-success' }}">
                                        {{ $component->enabled ? 'Disable' : 'Enable' }}
                                    </button>
                                </form>
                            </td>
                            <td>{{ $component->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No components found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    @else
        {{-- User View: Card Grid --}}
        @if($projects->isEmpty())
            <div class="alert alert-info">No templates available yet.</div>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($projects as $project)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            {{-- Preview placeholder (use preview image if available) --}}
                            <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $project->name }}</h5>
                                <p class="card-text">
                                    <strong>Theme:</strong> {{ $project->theme->name ?? 'N/A' }} <br>
                                    <small class="text-muted">Created on {{ $project->created_at->format('Y-m-d') }}</small>
                                </p>
                            </div>
                            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                                <div class="btn-group" role="group" aria-label="Project Actions">
                                    <a href="{{ route('projects.preview', $project->id) }}" class="btn btn-success btn-sm" target="_blank">
                                        Preview
                                    </a>
                                    <a href="{{ route('projects.download', $project->id) }}" class="btn btn-primary btn-sm">
                                        Download
                                    </a>
                                </div>
                                <form
                                    action="{{ auth()->check() && auth()->user()->favorites->contains($project->id) ? route('projects.unfavorite', $project->id) : route('projects.favorite', $project->id) }}"
                                    method="POST"
                                    style="display:inline;"
                                >
                                    @csrf
                                    @if(auth()->check())
                                        @if(auth()->user()->favorites->contains($project->id))
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 m-0 align-middle" title="Remove from favorites">
                                                <i class="bi bi-heart-fill text-danger fs-5"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-link p-0 m-0 align-middle" title="Add to favorites">
                                                <i class="bi bi-heart fs-5"></i>
                                            </button>
                                        @endif
                                    @else
                                        <button
                                            type="button"
                                            class="btn btn-link p-0 m-0 align-middle"
                                            title="Login to add to favorites"
                                            onclick="window.location='{{ route('login') }}'"
                                        >
                                            <i class="bi bi-heart fs-5"></i>
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
@endsection
