<?php
/*// event that is fired automatically by eloquent
//when a project is created let's also generate an activity
//when ever you create a new project as part of that we also will generate a new record of activity that points to this project
App\Models\Project::created(function($project){
    \App\Models\Activity::create([
        'project_id'=>$project->id,
        'description'=>'created'
    ]);
});

App\Models\Project::updated(function($project){
    \App\Models\Activity::create([
        'project_id'=>$project->id,
        'description'=>'updated'
    ]);
});*/


use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware'=>'auth'],function(){
    Route::get('/projects',[\App\Http\Controllers\ProjectController::class,'index']);

    Route::post('/projects',[\App\Http\Controllers\ProjectController::class,'store']);
    Route::get('/projects/create',[\App\Http\Controllers\ProjectController::class,'create']);

    Route::get('/projects/{project}',[\App\Http\Controllers\ProjectController::class,'show']);
    Route::get('/projects/{project}/edit',[\App\Http\Controllers\ProjectController::class,'edit']);
    Route::patch('/projects/{project}',[\App\Http\Controllers\ProjectController::class,'update']);

    Route::post('/projects/{project}/tasks',[\App\Http\Controllers\ProjectTaskController::class,'store']);
    Route::patch('/projects/{project}/tasks/{task}', [\App\Http\Controllers\ProjectTaskController::class,'update']);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});


Auth::routes();



