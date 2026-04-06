<?php

namespace App\Services;

use App\Models\LogAktivitas;

class LogService
{
    /**
     * Log user activity
     */
    public static function log($activity, $description = null, $userId = null)
    {
        try {
            $userId = $userId ?? auth()->id();
            
            LogAktivitas::create([
                'user_id' => $userId,
                'activity' => $activity,
                'description' => $description,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            // Silent fail - logging shouldn't break the application
            \Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }

    /**
     * Log login activity
     */
    public static function logLogin($userId)
    {
        self::log('login', 'User login ke sistem', $userId);
    }

    /**
     * Log logout activity
     */
    public static function logLogout($userId)
    {
        self::log('logout', 'User logout dari sistem', $userId);
    }
}
