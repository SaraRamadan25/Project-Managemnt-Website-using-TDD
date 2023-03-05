<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use WithFaker, RefreshDatabase;


    /** @test */

    public function a_project_can_invite_a_user()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = User::factory()->create());
        $this->signIn($newUser);
        $this->post(route('projects.tasks.store', $project), $task = ['body' => 'fooTask']);
        $this->assertDatabaseHas('tasks',$task);

    }
}
