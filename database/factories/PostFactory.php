<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'user_id' => mt_rand(1, 3),
            'content' => collect($this->faker->paragraphs(mt_rand(1, 5)))
                            ->map(function($paragraph) {
                                return "<p>$paragraph</p>";
                            })
                            ->implode(''),
            'image' => ''
        ];
    }
}
