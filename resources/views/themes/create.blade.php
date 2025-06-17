@extends('layouts.app')

@section('content')
    <style>
        #name {
            border: 2px solid #4CAF50;
            font-weight: bold;
            font-size: 1.2rem;
            transition: border-color 0.3s;
        }
        #name:focus {
            border-color: #388E3C;
            outline: none;
        }
        .theme-preview {
            margin-top: 20px;
            padding: 15px;
            border: 1px dashed #4CAF50;
            background: #f9fff9;
            font-size: 1.3rem;
            color: #388E3C;
        }
    </style>

    <h3>Add New Theme</h3>

    <form method="POST" action="{{ route('themes.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Theme Name</label>
            <input type="text" name="name" id="name" class="form-control" required oninput="updatePreview()">
        </div>
        <div class="mb-3">
            <label for="custom_css" class="form-label">Custom CSS</label>
            <textarea name="custom_css" id="custom_css" class="form-control" rows="5" placeholder="Enter custom CSS here..." oninput="updatePreview()"></textarea>
        </div>
        <button class="btn btn-success">Save</button>
    </form>

    <div class="theme-preview" id="themePreview">
        Theme Preview: <span id="previewText"></span>
        <style id="previewStyle"></style>
    </div>

    <script>
        function updatePreview() {
            const nameInput = document.getElementById('name');
            const previewText = document.getElementById('previewText');
            const customCss = document.getElementById('custom_css');
            const previewStyle = document.getElementById('previewStyle');
            previewText.textContent = nameInput.value || 'Your theme name will appear here';
            previewStyle.textContent = customCss.value || '';
        }
        document.addEventListener('DOMContentLoaded', updatePreview);
    </script>
@endsection
