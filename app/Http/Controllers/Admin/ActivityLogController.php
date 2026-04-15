<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->when($request->filled('action'), function ($query) use ($request) {
                $query->where('action', $request->action);
            })
            ->when($request->filled('user_id'), function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('description', 'ILIKE', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(20);

        $actions = ActivityLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $users = User::orderBy('nom')->orderBy('prenom')->get();

        return view('admin.logs.index', compact('logs', 'actions', 'users'));
    }
}