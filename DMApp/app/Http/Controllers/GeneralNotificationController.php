<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralNotificationController extends Controller
{
    public function markAsRead($id)
    {
        // 特定の通知を既読にする
        $notification = auth()->user()->notifications()->find($id);
        if($notification) {
            $notification->markAsRead();
        }

        return back();
    }
}
