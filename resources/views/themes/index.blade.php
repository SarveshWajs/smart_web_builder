@extends('layouts.app')

@section('content')
    <h3>Themes</h3>
    <a href="{{ route('themes.create') }}" class="btn btn-primary mb-2">Add Theme</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($themes as $theme)
            <tr>
                <td>{{ $theme->name }}</td>
                <td>
                    <a href="{{ route('themes.edit', $theme) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('themes.destroy', $theme) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this theme?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
