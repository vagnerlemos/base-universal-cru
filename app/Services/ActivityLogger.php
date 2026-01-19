<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(string $action, ?string $resource = null, ?int $resourceId = null, ?array $data = null): void
    {
        $request = request();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'app' => $request->route()?->defaults['app'] ?? null,
            'action' => $action,
            'resource' => $resource,
            'resource_id' => $resourceId,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'data' => $data,
        ]);
    }
}
