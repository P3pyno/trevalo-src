<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $title = $model->title ?? $model->id;
            ActivityLog::log('created', class_basename($model), $model->id, "{$title} created");
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            unset($changes['updated_at']);
            
            if (!empty($changes)) {
                $title = $model->title ?? $model->id;
                ActivityLog::log('updated', class_basename($model), $model->id, "{$title} updated", $changes);
            }
        });

        static::deleted(function ($model) {
            $title = $model->title ?? $model->id;
            ActivityLog::log('deleted', class_basename($model), $model->id, "{$title} deleted");
        });
    }
}
