<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->orderByDesc('id')
            ->paginate(30);

        return view('system.activity_logs.index', [
            'logs' => $logs,
        ]);
    }

    public function show(ActivityLog $activityLog)
    {
        return view('system.activity_logs.show', [
            'log' => $activityLog,
        ]);
    }
}
