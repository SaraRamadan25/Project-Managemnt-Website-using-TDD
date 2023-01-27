<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function path(): string
    {
        return "/projects/{$this->id}";
    }
    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class);
    }


    public function addTask($body): Model
    {
       return $this->tasks()->create(compact('body'));
    }
    public function activity(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Activity::class);
    }




    public function recordActivity($description){
        // because we have the activity relation in this class,
        // we shouldn't use Activity Model directly, instead we do this
        //and the project_id is assigned automatically, we don't have to type it
        // we only have to provide a description
        //compact description = 'description'=>$description
        $this->activity()->create(compact('description'));
    /*    Activity::create([
            'project_id'=>$this->id,
            'description'=>$type
        ]);*/
    }
}
