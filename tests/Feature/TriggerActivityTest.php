<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
   use RefreshDatabase;

    /** @test */
    function creating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    /** @test */
    function updating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);

    }
    /** @test  */
    function creating_a_new_task(){
        $project = ProjectFactory::create();

        $project->addTask('Some Task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);
    }
    /** @test  */
    function completing_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $this->actingAs($project->owner)->patch($project->tasks[0]->path(),[
                'body'=>'foobar',
                'completed'=> true
        ]);
        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }
    /** @test  */
    function incompleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(),[
            'body'=>'foobar',
            'completed'=> true
        ]);
        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(),[
            'body'=>'foobar',
            'completed'=> false
        ]);
        // we use a fresh as we are loading the activity relationship
        // and here when we call it again, we using the already loaded obj
        //new query to fetch the activity
        $project->refresh();

        $this->assertCount(4, $project->activity);
        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }
    /** @test  */
    function deleting_a_task()
{
    $project = ProjectFactory::withTasks(1)->create();

    $project->tasks[0]->delete();

    // how many pieces of activities  should we have
    // one for creating a project, one for creating a task, one for deleting a task
    $this->assertCount(3, $project->activity);

}
}
