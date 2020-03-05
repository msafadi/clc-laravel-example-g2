@extends('layouts.admin')

@section('main')

<h1 class="mb-4">Edit Tag</h1>

@if ($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif


<form method="post" action="{{ route('tags.update', [$tag->id]) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $tag->name) }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

@endsection