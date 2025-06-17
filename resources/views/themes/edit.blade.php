@extends('layouts.app')

@section('content')
    <style>
        .edit-theme-container {
            max-width: 600px;
            margin: 30px auto;
            background: #f8f9fa;
            padding: 30px 25px 20px 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(60,60,60,0.08);
        }
        .edit-theme-container h3 {
            color: #388E3C;
            margin-bottom: 25px;
        }
        .form-label {
            font-weight: 600;
        }
        #name, #custom_css {
            border: 2px solid #4CAF50;
            font-size: 1.1rem;
            transition: border-color 0.3s;
        }
        #name:focus, #custom_css:focus {
            border-color: #388E3C;
            outline: none;
        }
        #custom_css {
            font-family: monospace;
            min-height: 120px;
        }
    </style>

    <div class="container edit-theme-container">
        <h3>Edit Theme</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('themes.update', $theme->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Theme Name</label>
                <input type="text" name="name" value="{{ old('name', $theme->name) }}" class="form-control" id="name" required>
            </div>

            <div class="mb-3">
                <label for="custom_css" class="form-label">Custom CSS</label>
                <textarea name="custom_css" id="custom_css" class="form-control" placeholder="Enter custom CSS here...">{{ old('custom_css', $theme->css) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('themes.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
