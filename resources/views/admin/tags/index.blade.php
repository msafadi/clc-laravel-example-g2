@extends('layouts.admin')

@section('title', 'Tags')

@section('main')
<header class="d-flex flex-wrap mt-3 mb-5">
    <h1 class="mr-auto">Tags</h1>
    <div>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('tags.create') }}">Create Tag</a>
    </div>
</header>
@if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Name</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($tags as $tag)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $tag->id }}</td>
            <td>{{ $tag->name }}</td>
            <td>{{ $tag->created_at }}</td>
            <td>
                <a href="{{ route('tags.edit', [$tag->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                <form method="post" action="{{ route('tags.destroy', [$tag->id]) }}" class="form-inline d-inline">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No tags found!</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection