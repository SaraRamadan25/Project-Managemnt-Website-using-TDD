<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory,RecordActivity;


    protected $guarded = [];

//ref any relationships that you want to touch whenever this current instance is updated
    protected $touches = ['project'];
// if completed = 0 or 1 ->cast it to boolean
    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static array $recordableEvents = ['created', 'deleted'];


    public function complete()
    {
        $this->update(['completed' => true]);

        $this->recordActivity('completed_task');
    }


    public function incomplete()
    {
        $this->update(['completed' => false]);

        $this->recordActivity('incompleted_task');
    }


    public function project(): belongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function path(): string
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
}




