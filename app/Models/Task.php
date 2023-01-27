<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
protected static function boot()
{
    parent::boot();

    static::created(function ($task){
        $task->project->recordActivity('created_task');

        /*    Activity::create([
                'project_id'=>$task->project->id,
                'description'=>'created_task'
            ]);*/
    });
  /*  static::updated(function ($task){
        if( ! $task->completed) return;
        $task->project->recordActivity('completed_task');

        Activity::create([
            'project_id'=>$task->project->id,
            'description'=>'completed_task'
        ]);
    });*/
}
public function complete()
{
    $this->update(['completed'=>true]);
    $this->project->recordActivity('completed_task');
}

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
}
