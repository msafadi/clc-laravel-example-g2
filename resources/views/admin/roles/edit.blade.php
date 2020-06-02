@extends('layouts.admin')


@section('main')
<header class="d-flex flex-wrap mt-3 mb-5">
    <h1 class="mr-auto">Edit Role</h1>
</header>

<div>
    <form method="post" action="{{ route('roles.update', [$role->id]) }}">
        @csrf
        @method('put')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $role->name) }}">
        </div>

        <div class="form-group">
            <label for="name">Permissions</label>
            <div>
                @foreach (config('permissions') as $code => $label)
                <div class="form-check">
                    <input class="form-check-input" @if(in_array($code, $role_permissions)) checked @endif type="checkbox" name="permissions[]" value="{{ $code }}" id="{{ $code }}">
                    <label class="form-check-label" for="{{ $code }}">
                        {{ $label }}
                    </label>
                </div>
                @endforeach

            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>

</div>


@endsection