<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    /**
     * Boot the trait and register model events.
     */
    protected static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            static::logActivity('created', $model, null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $oldValues = $model->getOriginal();
            $newValues = $model->getAttributes();
            
            // Only log if there are actual changes
            if ($oldValues !== $newValues) {
                static::logActivity('updated', $model, $oldValues, $newValues);
            }
        });

        static::deleted(function ($model) {
            static::logActivity('deleted', $model, $model->getAttributes(), null);
        });
    }

    /**
     * Log an activity for this model.
     */
    protected static function logActivity(string $action, $model, ?array $oldValues = null, ?array $newValues = null): void
    {
        // Filter out sensitive fields
        $excludeFields = ['password', 'remember_token'];
        
        if ($oldValues) {
            $oldValues = array_diff_key($oldValues, array_flip($excludeFields));
        }
        
        if ($newValues) {
            $newValues = array_diff_key($newValues, array_flip($excludeFields));
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
