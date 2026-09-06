<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worklog;
use Illuminate\Support\Facades\Auth;

class WorklogController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $query = Worklog::with(['user', 'client', 'task', 'reviewedBy']);
        if ($user && !$user->isOwner() && !$user->isSMM()) {
            $query->where('user_id', $user->id);
        }

        $worklogs = $query->latest('date')->get();

        if ($request->wantsJson()) {
            return response()->json($worklogs);
        }

        return view('worklogs.index', compact('worklogs'));
    }
}
