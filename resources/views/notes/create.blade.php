@extends('adminlte::page')

@section('title', 'Create Note')

@section('content_header')
    <h1>Create Note</h1>
@endsection

@section('content')

<style>
.ck-editor__editable_inline {
    min-height: 250px;
    max-height: 500px;
}
</style>

<form action="{{ route('notes.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" required>
    </div>

    <div class="form-group">
        <label for="content">Content</label>
        <textarea id="editor" class="form-control" name="content" rows="10"></textarea>
    </div>

    <div class="form-group">
        <label for="tags">Tags (comma separated)</label>
        <input type="text" class="form-control" name="tags">
    </div>

    <button type="submit" class="btn btn-primary">Save Note</button>
</form>

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
