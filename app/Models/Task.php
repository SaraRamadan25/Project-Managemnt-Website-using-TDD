<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    use HasFactory;
protected $guarded=[];

//ref any relationships that you want to touch whenever this current instance is updated
protected $touches=['project'];
// if completed = 0 or 1 ->cast it to boolean
protected $casts=[
    'completed' =>'boolean'
];

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


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }


    public function recordActivity($description)
    {
        $this->activity()->create([
            'project_id' => $this->project_id,
            'description' => $description
        ]);
    }


    public function activity(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }


        /*    Activity::create([
                'project_id'=>$task->project->id,
                'description'=>'created_task'
            ]);*/

  /*  static::updated(function ($task){
        if( ! $task->completed) return;
        $task->project->recordActivity('completed_task');

        Activity::create([
            'project_id'=>$task->project->id,
            'description'=>'completed_task'
        ]);
    });*/

/*public function complete()
{
    $this->update(['completed'=>true]);
    $this->recordActivity('completed_task');
}
public function incomplete()
{
    $this->update(['completed'=>false]);
    $this->recordActivity('incompleted_task');

}
    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
    public function activity(): morphMany
    {
        // morphmany can trigger any activity,
        // then the name of the col that we morphing
        return $this->morphMany(Activity::class,'subject')->latest();
    }

    public function recordActivity($description){
        // because we have the activity relation in this class,
        // we shouldn't use Activity Model directly, instead we do this
        //and the project_id is assigned automatically, we don't have to type it
        // we only have to provide a description
        //compact description = 'description'=>$description
        // when we move these to task class instead of project,
        // the description don't triggered automatically
        $this->activity()->create([
            'project_id'=> $this->project_id,
            'description'=> $description
        ]);
        /*    Activity::create([
                'project_id'=>$this->id,
                'description'=>$type
            ]);
    }*/
}

