<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentPost;
use Illuminate\Support\Facades\Auth;

class ContentPostController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $query = ContentPost::with(['client', 'assignedTo', 'createdBy']);

        if ($user && !$user->isOwner()) {
            $clientIds = \App\Models\Client::where('assigned_smm', $user->id)->pluck('id');
            $query->where(fn($q) => $q->whereIn('client_id', $clientIds)
                ->orWhere('assigned_to', $user->id));
        }

        if ($request->client_id) {
            $query->where('client_id', $request->client_id);
        }

        $posts = $query->orderBy('date')->get();

        if ($request->wantsJson()) {
            return response()->json($posts);
        }

        return view('calendar.index', compact('posts'));
    }
}
