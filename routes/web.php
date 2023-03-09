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


use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInvitationController;
use App\Http\Controllers\ProjectTaskController;
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

    Route::resource('projects',ProjectController::class);

    Route::post('/projects/{project}/tasks',[ProjectTaskController::class,'store'])->name('projects.tasks.store');

    Route::patch('/projects/{project}/tasks/{task}', [ProjectTaskController::class,'update']);

    Route::post('/projects/{project}/invitations',[ProjectInvitationController::class,'store']);

    Route::get('/home', [HomeController::class, 'index'])->name('home');


});



Auth::routes();




