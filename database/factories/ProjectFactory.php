<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Project;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Project::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'creator' => rand(1, 10), // Replace with your logic to assign a creator
            'description' => $this->faker->paragraph,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Project $project) {
            $collaboratorsCount = rand(1, 5);
            $collaborators = User::inRandomOrder()->limit($collaboratorsCount)->pluck('id');

            $roles = ['developer', 'tester', 'project manager'];

            $collaboratorsWithType = [];
            foreach ($collaborators as $collaboratorId) {
                $role = $roles[array_rand($roles)]; // Choose a random role from the roles array
                $collaboratorsWithType[$collaboratorId] = ['type' => $role];
            }

            $project->collaborators()->sync($collaboratorsWithType);
        });
    }
}
