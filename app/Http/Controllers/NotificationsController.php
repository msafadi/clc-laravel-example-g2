<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        return view('notifications', [
            'notifications' => $user->notifications,
            'unread' => $user->unreadNotifications,
        ]);
    }

    public function show($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);

        $notification->markAsRead();

        return redirect()->to($notification->data['action']);
    }
}
