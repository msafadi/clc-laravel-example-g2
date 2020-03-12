@extends('layouts.admin')

@section('main')
<h1 class="mb-4">Create Product</h1>

@if ($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}">
        @if($errors->has('name'))
        <p class="text-danger">{{ implode(', ', $errors->get('name')) }}</p>
        @endif
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description">{{ old('description') }}</textarea>
        @error('description')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
            <option value="">No Parent</option>
            @foreach (App\Category::all() as $cat)
                <option value="{{ $cat->id }}" @if(old('category_id') == $cat->id) selected @endif>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('category_id')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}">
        @if($errors->has('price'))
        <p class="text-danger">{{ implode(', ', $errors->get('price')) }}</p>
        @endif
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image[]" multiple class="form-control @error('image') is-invalid @enderror" id="image">
        @if($errors->has('image'))
        <p class="text-danger">{{ implode(', ', $errors->get('image')) }}</p>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>

@endsection