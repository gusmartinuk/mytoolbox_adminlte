@extends('adminlte::page')

@section('title', 'Edit Note')

@section('content_header')
    <h1>Edit Note</h1>
@endsection

@section('content')
<style>
.ck-editor__editable_inline {
    min-height: 250px;
    max-height: 500px;
}
</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Note</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('notes.update', $note->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" value="{{ old('title', $note->title) }}" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="editor" class="form-control" name="content" rows="15">{{ old('content', $note->content) }}</textarea>
            </div>

            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" class="form-control" name="tags" value="{{ old('tags', implode(',', $note->tags->pluck('name')->toArray())) }}" placeholder="e.g., laravel,php,notes">
            </div>

            <button type="submit" class="btn btn-primary">Update Note</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/ckeditor5-build-classic-base64-upload-adapter@1.0.1/build/ckeditor.min.js"></script>
<script>

    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            toolbar: [ 'heading', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'imageUpload' ],
            image: {
                toolbar: [ 'imageTextAlternative', 'imageStyle:side' ]
            },
            ckfinder: {
                uploadUrl: ''  // Base64 for image upload
            }
        } )
        .catch( error => {
            console.error( error );
        } );
</script>

@endsection
