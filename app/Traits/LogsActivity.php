<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected function logActivity($event, $description = null, $subjectId = null, $subjectType = null)
    {
        $user = Auth::user();
        
        // If no custom description is provided, generate a default one
        if (!$description) {
            $description = $this->generateDescription($event, $user);
        }

        return ActivityLog::create([
            'causer_id' => $user->id,
            'causer_type' => $user->role ?? 'user',
            'event' => $event,
            'description' => $description,
            'subject_id' => $subjectId,
            'subject_type' => $subjectType
        ]);
    }

    private function generateDescription($event, $user)
    {
        $name = $user->name;
        $role = ucfirst($user->role);
        
        return match($event) {
            'create' => "{$name} ({$role}) created a new appointment",
            'cancel' => "{$name} ({$role}) cancelled their appointment",
            'generate_report' => "{$name} ({$role}) generated their appointment report",
            'generate_admin_report' => "{$name} ({$role}) generated an administrative report",
            'delete' => "{$name} ({$role}) deleted an appointment",
            'login' => "{$name} ({$role}) logged in",
            'logout' => "{$name} ({$role}) logged out",
            default => "{$name} ({$role}) performed {$event}"
        };
    }
} 