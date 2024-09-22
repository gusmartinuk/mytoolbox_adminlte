@extends('adminlte::page')

@section('title', 'My Notes')

@section('content_header')
    <h1>My Notes</h1>
@endsection

@section('content')
    <!-- Arama Formu -->
    <form action="{{ route('notes.index') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Search notes..." value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </div>
    </form>

    <!-- Notlar Tablosu -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Tags</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes as $note)
                <tr>
                    <td>{{ $note->title }}</td>
                    <td>{!! Str::limit(strip_tags($note->content), 50) !!}</td> <!-- İçeriği sınırlıyoruz -->
                    <td>{{ implode(', ', $note->tags->pluck('name')->toArray()) }}</td>
                    <td>
                        <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Sayfalama -->
    <div class="d-flex justify-content-center">
        {{ $notes->appends(request()->query())->links() }}
    </div>
@endsection
