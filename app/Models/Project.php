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

    public function recordActivity($type){

        Activity::create([
            'project_id'=>$this->id,
            'description'=>$type
        ]);
    }
}
