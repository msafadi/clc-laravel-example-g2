@extends('layouts.admin')

@section('title', 'Categories')

@push('css')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
@push('css')
<link href="{{ asset('css/dashboard2.css') }}" rel="stylesheet">
<link href="{{ asset('css/dashboard2.css') }}" rel="stylesheet">
@endpush

@push('js')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush

@section('nav')
@parent
<h4>Child Nav</h4>
<p>Demo sidebare</p>


@endsection

@section('main')
<header class="d-flex flex-wrap mt-3 mb-5">
    <h1 class="mr-auto">Categories @if($parent) : <small class="text-primary"> {{ $parent->name }}</small> @endif</h1>
    <div>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('categories.create') }}">Create Category</a>
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
            <th>Parent</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $cat)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $cat->id }}</td>
            <td><a href="{{ route('categories.child', [$cat->id]) }}">{{ $cat->name }}</a></td>
            <td>{{ $cat->parent->name }}</td>
            <td>{{ $cat->created_at }}</td>
            <td>
                @can('update', $cat)
                <a href="{{ route('categories.edit', [$cat->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                @endcan
                @can('delete', $cat)
                <form method="post" action="{{ route('categories.delete', [$cat->id]) }}" class="form-inline d-inline">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                </form>
                @endcan
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No categories found!</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection