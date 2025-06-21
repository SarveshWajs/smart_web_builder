@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Component</h3>

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

        <form method="POST" action="{{ route('component.update', $component->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Component Name</label>
                <input type="text" name="name" value="{{ old('name', $component->name) }}" class="form-control" id="name" required>
            </div>

            <div class="mb-3">
                <label for="html" class="form-label">HTML Code</label>
                <textarea name="html" class="form-control" id="html" rows="5" required>{{ old('html', $component->html) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="css" class="form-label">CSS Code (optional)</label>
                <textarea name="css" class="form-control" id="css" rows="3">{{ old('css', $component->css) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="js" class="form-label">JavaScript Code (Optional)</label>
                <textarea name="js" class="form-control" id="js" rows="3">{{ old('js', $component->js) }}</textarea>
            </div>

           <div class="mb-3">
    <label class="form-label">Uploaded Images</label>
    <div class="d-flex flex-wrap gap-2">
        @if(is_array($component->images))
            @foreach($component->images as $img)
                <div class="position-relative" style="display:inline-block;">
                    <img src="{{ asset('storage/' . $img) }}" alt="Component Image" style="max-width: 120px; max-height: 120px; border:1px solid #ccc; padding:2px;">
                    <form action="{{ route('component.image.delete', [$component->id, 'image' => urlencode($img)]) }}" method="POST" style="position:absolute; top:2px; right:2px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this image?')">&times;</button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>
</div>
            <div class="mb-3">
                <label for="images" class="form-label">Add/Replace Images (Optional)</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                <small class="form-text text-muted">Uploading new images will add to the existing ones.</small>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('component.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
