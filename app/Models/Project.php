<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    use RecordActivity;

    protected $guarded=[];
    public function path(): string
    {
        return "/projects/{$this->id}";
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function addTasks($tasks)
    {
        return $this->tasks()->createMany($tasks);
    }

    public function addTask($body): Model
    {
        return $this->tasks()->create(compact('body'));
    }

    public function invite(User $user){

         $this->members()->attach($user);
    }
public function members() :BelongsToMany
{
    // we said members as it much clearer but the base class is user
    // as each user has many projects and the project can have many users
        return $this->belongsToMany(User::class,'project_members')->withTimestamps();
}

}
