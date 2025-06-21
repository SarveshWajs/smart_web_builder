@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="mb-0">My Favorite Templates</h2>
        <span class="badge bg-primary fs-6">{{ $projects->count() }} Favorite{{ $projects->count() !== 1 ? 's' : '' }}</span>
    </div>
    @if($projects->isEmpty())
        <div class="text-center py-5">
            <img src="https://cdn.jsdelivr.net/gh/edent/SuperTinyIcons/images/svg/heart.svg" alt="No favorites" style="width:80px;opacity:0.3;">
            <p class="mt-3 text-muted">You have not favorited any templates yet.</p>
        </div>
    @else
        <div class="mb-4">
            <input type="text" id="favoriteSearch" class="form-control" placeholder="Search favorites...">
        </div>
        <div class="row g-4" id="favoriteCards">
            @foreach($projects as $project)
                <div class="col-md-4 favorite-card" data-name="{{ strtolower($project->name) }}" data-description="{{ strtolower($project->description) }}">
                    <div class="card shadow-sm h-100 border-0">
                        @if(!empty($project->thumbnail))
                            <img src="{{ $project->thumbnail }}" class="card-img-top" alt="{{ $project->name }}" style="object-fit:cover;max-height:160px;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:160px;">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $project->name }}</h5>
                                <span class="text-danger" title="Favorite">
                                   <form
                                method="POST"
                                action="{{ auth()->check() && auth()->user()->favorites->contains($project->id) ? route('projects.unfavorite', $project->id) : route('projects.favorite', $project->id) }}"
                                class="d-inline"
                            >
                                @csrf
                                @if(auth()->check() && auth()->user()->favorites->contains($project->id))
                                    @method('DELETE')
                                @endif
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-danger" title="{{ auth()->check() && auth()->user()->favorites->contains($project->id) ? 'Unfavorite' : 'Favorite' }}">
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </form>
                                </span>
                            </div>
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
                            <div class="mt-auto d-flex justify-content-between align-items-center gap-2">
  <button
    class="btn btn-primary btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#projectModal"
    data-name="{{ $project->name }}"
    data-description="{{ $project->description }}"
    data-components="{{ is_array($project->components) ? implode(', ', collect($project->components)->pluck('name')->toArray()) : ($project->components ?? '') }}"
    data-theme="{{ $project->theme->name ?? $project->theme ?? '' }}"
>
        View Details
    </button>
    <button class="btn btn-secondary btn-sm share-btn" title="Share" data-link="{{ route('projects.show', $project->id) }}">
        <i class="bi bi-share"></i>
    </button>
</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal -->
        <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalLabel">Project Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="modalProjectName"></h5>
                <p id="modalProjectDescription"></p>
                <hr>
                <div class="mb-2">
                    <strong>Component:</strong>
                    <span id="modalProjectComponent" class="badge bg-secondary"></span>
                </div>
                <div>
                    <strong>Theme:</strong>
                    <span id="modalProjectTheme" class="badge bg-info"></span>
                </div>
            </div>
        </div>
    </div>
</div>
    @endif
@endsection

@push('scripts')
<script>
    // Modal population
     document.addEventListener('DOMContentLoaded', function () {
        const projectModal = document.getElementById('projectModal');
        if (projectModal) {
            projectModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (button) {
                    const name = button.getAttribute('data-name');
                    const description = button.getAttribute('data-description');
                    const components = button.getAttribute('data-components');
                    const theme = button.getAttribute('data-theme');

                    document.getElementById('modalProjectName').textContent = name || '';
                    document.getElementById('modalProjectDescription').textContent = description || '';

                    // Show only the first component name (or all as comma separated)
                    document.getElementById('modalProjectComponent').textContent = components ? components.split(',')[0].trim() : 'N/A';

                    // Theme
                    document.getElementById('modalProjectTheme').textContent = theme || 'N/A';
                }
            });
        }

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
                        this.innerHTML = '<i class="bi bi-check-lg"></i>';
                        setTimeout(() => {
                            this.innerHTML = '<i class="bi bi-share"></i>';
                        }, 1500);
                    });
                } else {
                    prompt('Copy this link:', link);
                }
            });
        });
    });
</script>
@endpush
