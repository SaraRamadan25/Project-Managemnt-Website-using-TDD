<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;


class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
     public function definition(): array
    {
        return [
            'title'=>$this->faker->sentence(4),
            'description'=>$this->faker->sentence(4),
            'notes' => 'Foobar notes',
            'owner_id' =>User::factory()

        ];

    }

}
