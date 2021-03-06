<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Todo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1,1000),
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'isCompleted' => rand(0,1),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
