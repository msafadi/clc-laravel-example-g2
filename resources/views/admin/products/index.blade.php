@extends('layouts.admin')

@section('title', 'Products')

@section('main')
<h1 class="mb-4">Products</h1>
<a class="btn btn-primary btn-sm mb-2" href="{{ route('products.create') }}">Create Product</a>

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
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1 @endphp
        @forelse($products as $product)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $product->id }}</td>
            <td><img src="{{ asset('storage/' . $product->image) }}" width="60"></td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->category_id }}</td>
            <td>{{ $product->created_at }}</td>
            <td>
                <a href="{{ route('products.edit', [$product->id]) }}">Edit</a>
                <form method="post" action="{{ route('products.destroy', [$product->id]) }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No products found!</td>
        </tr>
        @endforelse
    </tbody>
</table>

@if (method_exists($products, 'links'))
{{ $products->links() }}
@endif

<form method="get" action="{{ route('products.index') }}">
    Items Per Page: <select name="perpage">
        <option value="1">1<option>
        <option value="5">5<option>
        <option value="10">10<option>
        <option value="all">All<option>  
    </select>
    <button type="submit">Apply</button>
</form>

@endsection