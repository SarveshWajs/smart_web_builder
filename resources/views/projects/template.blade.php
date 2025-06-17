@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Templates I Created</h2>
    @if($projects->isEmpty())
        <div class="alert alert-info">You have not created any templates yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->name }}</td>
                            <td>{{ Str::limit($project->description ?? '', 60) }}</td>
                            <td>
                                <button
                                    class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#projectModal"
                                    data-name="{{ $project->name }}"
                                    data-description="{{ $project->description }}"
                                >
                                    View Details
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const projectModal = document.getElementById('projectModal');
        if (projectModal) {
            projectModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (button) {
                    const name = button.getAttribute('data-name');
                    const description = button.getAttribute('data-description');
                    document.getElementById('modalProjectName').textContent = name || '';
                    document.getElementById('modalProjectDescription').textContent = description || '';
                }
            });
        }
    });
</script>
@endpush
