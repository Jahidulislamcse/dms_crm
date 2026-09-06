<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([]);
        }

        $notifs = Notification::where(function($q) use($user) {
            $q->where('user_id', $user->id)->orWhereNull('user_id');
        })->when(!$user->isOwner(), fn($q) => $q->where('is_admin_only', false))
          ->orderByDesc('created_at')->take(20)->get();

        return response()->json($notifs);
    }
}
