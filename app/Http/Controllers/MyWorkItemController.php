<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyWorkItem;
use Illuminate\Support\Facades\Auth;

class MyWorkItemController extends Controller
{
    public function index()
    {
        $items = MyWorkItem::where('user_id', Auth::id())->latest()->get();
        return response()->json($items);
    }
}
