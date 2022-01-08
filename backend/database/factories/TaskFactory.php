<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $is_completed = $this->faker->boolean(50);

        return [
            'title' => $this->faker->text(20),
            'description' => $this->faker->paragraph(),
            'completed_at' => $is_completed ? $this->faker->dateTimeBetween('-1 week', 'now') : null,
        ];
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'completed_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            ];
        });
    }

    public function incompleted()
    {
        return $this->state(function (array $attributes) {
            return [
                'completed_at' => null,
            ];
        });
    }
}
