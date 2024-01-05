<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => null,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->paragraph,
            'created_at' => fake()->dateTimeBetween('-3 years'),
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at']);
            },
        ];
    }

    public function goodReview(): self
    {
        return $this->state([
            'rating' => fake()->numberBetween(4, 5),
        ]);
    }

    public function averageReview(): self
    {
        return $this->state([
            'rating' => 3,
        ]);
    }

    public function badReview(): self
    {
        return $this->state([
            'rating' => fake()->numberBetween(1, 2),
        ]);
    }
}
