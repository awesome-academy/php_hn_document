<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function mark($id)
    {
        Auth::user()->unreadNotifications->where('data.id', $id)->markAsRead();

        return redirect()->route('users.show', $id);
    }

    public function markAll()
    {
        $user = Auth::user();
        $user->unreadNotifications()->update(['read_at' => now()]);

        return redirect()->back();
    }
}
