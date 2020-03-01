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
<h1 class="mb-4">Categories @if($parent) / {{ $parent->name }} @endif</h1>
<a class="btn btn-primary btn-sm mb-2" href="{{ route('categories.create') }}">Create Category</a>

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
        @php $i = 1 @endphp
        @forelse($categories as $cat)
        {{-- @if ($loop->index == 2)
                    @continue
                @endif --}}
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $cat->id }}</td>
            <td>@if($loop->first)
                First:
                @elseif($loop->last)
                Last:
                @else
                Mid:
                @endif
                <a href="{{ route('categories.child', [$cat->id]) }}">{{ $cat->name }}</a></td>
            <td>{{ $cat->parent_id }}</td>
            <td>{{ $cat->created_at }}</td>
            <td>
                <a href="{{ route('categories.edit', [$cat->id]) }}">Edit</a>
                <form method="post" action="{{ route('categories.delete', [$cat->id]) }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>

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