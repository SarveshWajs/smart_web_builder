@extends('layouts.app')

@section('content')
   <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="mb-0">My Favorite Templates</h2>
        <span class="badge bg-primary fs-6">
            {{ $projects->count() }} Favorite Template{{ $projects->count() !== 1 ? 's' : '' }}
        </span>
    </div>
    @if($projects->isEmpty())
        <div class="alert alert-info">No templates available yet.</div>
    @else
        <div class="mb-4">
            <input type="text" id="favoriteSearch" class="form-control" placeholder="Search favorites...">
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4" id="favoriteCards">
           @foreach($projects as $project)
    <div class="col favorite-card" data-name="{{ strtolower($project->name) }}" data-description="{{ strtolower($project->description) }}">
        <div class="card h-100 shadow-sm">

            {{-- Preview placeholder (use preview image if available) --}}
            <div class="card-img-top text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 180px; padding: 0;">
                    <iframe src="{{ asset('storage/projects/project_' . $project->id . '/index.html') }}"
                            style="width: 100%; height: 180px; border: none;"></iframe>
                </div>
            </div>
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0">{{ $project->name }}</h5>
                    <span>
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
                    </span>
                </div>
                <p class="card-text">
                    <strong>Theme:</strong> {{ $project->theme->name ?? 'N/A' }} <br>
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Created on : {{ $project->created_at->format('Y-m-d') }}</small>
                        <small class="text-muted">Created By : {{ $project->user->name ?? 'Unknown' }}</small>
                    </div>
                </p>
                <p class="card-text text-muted flex-grow-1">{{ Str::limit($project->description, 80) }}</p>
                @if(!empty($project->tags))
                    <div class="mb-2">
                        @foreach($project->tags as $tag)
                            <span class="badge bg-secondary me-1">{{ $tag }}</span>
                        @endforeach
                    </div>
                @elseif(!empty($project->category))
                    <span class="badge bg-info mb-2">{{ $project->category }}</span>
                @endif
            </div>
            {{-- Share button in footer, full width, grey --}}
            <div class="card-footer bg-light border-0 p-0">
                <button class="btn w-100 text-secondary share-btn" style="background:#f1f1f1;" title="Share" data-link="{{ route('projects.show', $project->id) }}">
                    <i class="bi bi-share me-2"></i>Share
                </button>
            </div>
        </div>
    </div>
@endforeach
        </div>
    @endif


@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Search functionality
        const searchInput = document.getElementById('favoriteSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = this.value.trim().toLowerCase();
                document.querySelectorAll('.favorite-card').forEach(card => {
                    const name = card.getAttribute('data-name');
                    const desc = card.getAttribute('data-description');
                    if (name.includes(query) || desc.includes(query)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }

        // Share button functionality
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const link = this.getAttribute('data-link');
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(link).then(() => {
                        alert('Link copied!');
                    });
                } else {
                    prompt('Copy this link:', link);
                }
            });
        });
    });
</script>
@endpush
