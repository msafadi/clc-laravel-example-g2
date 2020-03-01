@extends('layouts.admin')

@section('main')

<h1 class="mb-4">Categories</h1>

@if ($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif


<form method="post" action="{{ route('categories.update', [$category->id]) }}">
    @csrf
    @method('put')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $category->name) }}">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" id="description">{{ old('description', $category->description) }}</textarea>
    </div>
    <div class="form-group">
        <label for="parent_id">Category Parent</label>
        <select name="parent_id" id="parent_id" class="form-control">
            <option value="">No Parent</option>
            @foreach (App\Category::all() as $cat)
                <option value="{{ $cat->id }}" @if($cat->id == old('parent_id', $category->parent_id)) selected @endif>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

@endsection