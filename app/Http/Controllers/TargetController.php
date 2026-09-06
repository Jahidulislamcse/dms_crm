<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Target;
use Illuminate\Support\Facades\Auth;

class TargetController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $query = Target::with(['user', 'items', 'deals']);
        if ($user && !$user->isOwner()) {
            $query->where('user_id', $user->id);
        }

        $targets = $query->orderByDesc('month')->get();

        if ($request->wantsJson()) {
            return response()->json($targets);
        }

        return view('targets.index', compact('targets'));
    }
}
