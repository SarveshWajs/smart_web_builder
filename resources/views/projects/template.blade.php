@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="mb-0">Templates I Created</h2>
        <span class="badge bg-primary fs-6">{{ $projects->count() }} Template{{ $projects->count() !== 1 ? 's' : '' }}</span>
    </div>
    @if($projects->isEmpty())
        <div class="alert alert-info text-center py-5">
            <p class="mt-3 text-muted">You have not created any templates yet.</p>
        </div>
    @else
        <div class="mb-4">
            <input type="text" id="createdSearch" class="form-control" placeholder="Search your templates...">
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4" id="createdCards">
    @foreach($projects as $project)
        <div class="col created-card"
             data-name="{{ strtolower($project->name) }}"
             data-description="{{ strtolower($project->description) }}">
            <div class="card h-100 shadow-sm border-0">
                {{-- Preview placeholder (use preview image if available) --}}
                @if(!empty($project->thumbnail))
                    <img src="{{ $project->thumbnail }}" class="card-img-top" alt="{{ $project->name }}" style="object-fit:cover;max-height:160px;">
                @else
                    <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 180px; padding: 0;">
                        <iframe src="{{ asset('storage/projects/project_' . $project->id . '/index.html') }}"
                                style="width: 100%; height: 180px; border: none;"></iframe>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $project->name }}</h5>
                        <span class="text-muted small" title="Created By">
                            <i class="bi bi-person-circle"></i> {{ $project->user->name ?? 'Unknown' }}
                        </span>
                    </div>
                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($project->description, 80) }}</p>
                </div>
                {{-- Edit button in footer, full width, grey --}}
                <div class="card-footer bg-light border-0 p-0">
                    <a href="{{ route('projects.edit', $project->id) }}"
                       class="btn w-100 text-secondary"
                       style="background:#ffd600;"
                       title="Edit Template">
                        <i class="bi bi-pencil-square me-2"></i>Edit
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
        <!-- Modal for project details (optional, can be implemented as needed) -->
    @endif
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal population
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
                    document.getElementById('modalProjectComponent').textContent = components ? components.split(',')[0].trim() : 'N/A';
                    document.getElementById('modalProjectTheme').textContent = theme || 'N/A';
                }
            });
        }

        // Search functionality
        const searchInput = document.getElementById('createdSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = this.value.trim().toLowerCase();
                document.querySelectorAll('.created-card').forEach(card => {
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
