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

<form method="post" action="{{ route('categories.store') }}">
    @csrf
    <div class="form-group is-invalid">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}">
        @if($errors->has('name'))
        <p class="text-danger">{{ implode(', ', $errors->get('name')) }}</p>
        @endif
    </div>
    <div class="form-group">
        <label for="description">{{ __('Description') }}</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description">{{ old('description') }}</textarea>
        @error('description')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="parent_id">{{ __('Category Parent') }}</label>
        <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
            <option value="">No Parent</option>
            @foreach (App\Category::all() as $cat)
                <option value="{{ $cat->id }}" @if(old('parent_id') == $cat->id) selected @endif>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('parent_id')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Create</button>
</form>

@endsection