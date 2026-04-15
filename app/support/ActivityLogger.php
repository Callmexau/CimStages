<?php

namespace App\Support;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log(
        string $action,
        string $description,
        ?string $targetType = null,
        ?int $targetId = null,
        array $properties = []
    ): void {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'description' => $description,
            'properties' => !empty($properties) ? $properties : null,
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
        ]);
    }
}