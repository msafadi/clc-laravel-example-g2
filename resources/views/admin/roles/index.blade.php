@extends('layouts.admin')

@section('title', 'Roles')

@section('main')
<header class="d-flex flex-wrap mt-3 mb-5">
    <h1 class="mr-auto">Roles</h1>
    <div>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('roles.create') }}">Create Role</a>
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
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($roles as $role)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $role->id }}</td>
            <td><a href="{{ route('roles.edit', [$role->id]) }}">{{ $role->name }}</a></td>
            <td>
                <a href="{{ route('roles.edit', [$role->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                <form method="post" action="{{ route('roles.destroy', [$role->id]) }}" class="form-inline d-inline">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                </form>

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No Roles found!</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection