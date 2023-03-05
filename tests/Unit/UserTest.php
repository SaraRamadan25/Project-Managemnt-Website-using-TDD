<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test  */
    public function a_user_has_projects()
    {
        $user = User::factory()->create();
        $this->assertInstanceOf(Collection::class, $user->projects);

    }

    /** @test  */

public function a_user_has_accessible_projects(){

    $sara = $this->signIn();

     ProjectFactory::ownedBy($sara)->create();
    $this->assertCount(1,$sara->accessibleProjects());

    $hager = User::factory()->create();
    $ahmed = User::factory()->create();

    $project = tap(ProjectFactory::ownedBy($hager)->create())->invite($ahmed);

    $this->assertCount(1,$sara->accessibleProjects());

    $project->invite($sara);

    $this->assertCount(2,$sara->accessibleProjects());


}
}
