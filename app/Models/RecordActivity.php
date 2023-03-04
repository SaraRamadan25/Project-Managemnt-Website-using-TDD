<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use JetBrains\PhpStorm\ArrayShape;
use function class_basename;

trait RecordActivity
{
    public array $oldAttributes = [];

    public static function bootRecordActivity()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }


    protected function activityDescription(string $description): string
    {
        return "{$description}_" . strtolower(class_basename($this));
    }


    protected static function recordableEvents(): array
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }

        return ['created', 'updated'];
    }


    public function recordActivity($description)
    {
        $this->activity()->create([
            'user_id' => ($this->project ?? $this)->owner->id,
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }


    public function activity(): MorphMany|HasMany
    {
        if (get_class($this) === Project::class) {
            return $this->hasMany(Activity::class)->latest();
        }

        return $this->morphMany(Activity::class, 'subject')->latest();
    }


    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_diff_assoc(
                    $this->oldAttributes, $this->getAttributes()
                ),
                'after' => array_diff_assoc(
                    $this->getChanges(), ['updated_at' => $this->updated_at]
                )
            ];
        }
    }
}
