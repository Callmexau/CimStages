<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class NotificationRecipients
{
    public static function agents(): Collection
    {
        return User::whereHas('role', function ($q) {
                $q->where('name', 'agent');
            })
            ->where('is_active', true)
            ->get();
    }

    public static function darhs(): Collection
    {
        return User::whereHas('role', function ($q) {
                $q->where('name', 'darh');
            })
            ->where('is_active', true)
            ->get();
    }
}