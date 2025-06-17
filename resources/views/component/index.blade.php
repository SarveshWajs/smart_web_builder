@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Components</h2>

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('component.create') }}" class="btn btn-primary">Add New Component</a>
        </div>

        @if($components->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Preview (HTML)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($components as $component)
                        <tr>
                            <td>{{ $component->name }}</td>
                            <td><code>{{ Str::limit(strip_tags($component->html), 100) }}</code></td>
                            <td>
                                <a href="{{ route('component.edit', $component->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('component.destroy', $component->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this component?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $components->links() }}
        @else
            <p>No components found.</p>
        @endif
    </div>
@endsection
