@extends('layouts.admin')

@section('main')
<h1 class="mb-4">Add Tag</h1>

@if ($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<form method="post" action="{{ route('tags.store') }}">
    @csrf
    <div class="form-group is-invalid">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}">
        @if($errors->has('name'))
        <p class="text-danger">{{ implode(', ', $errors->get('name')) }}</p>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>

@endsection