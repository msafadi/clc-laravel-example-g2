@extends('layouts.home')

@section('content')
    <h1>Notifications <span class="badge badge-success">{{ $unread->count() }}</span></h1>
    <table class="table">
        @foreach($notifications as $notification)
        <tr>
            <td><a href="{{ route('notification.show', [$notification->id]) }}"> {{ $notification->data['message'] }} </a></td>
            <td>{{ $notification->created_at }}</td>
            <td>{{ $notification->read_at }}</td>
        </tr>
        @endforeach
    </table>

@endsection
