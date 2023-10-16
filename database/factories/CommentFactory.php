<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'post_id' => mt_rand(1, 10),
            'user_id' => mt_rand(4, 10),
            'content' => collect($this->faker->paragraphs(mt_rand(1, 2)))
                            ->map(function($paragraph) {
                                return "<p>$paragraph</p>";
                            })
                            ->implode('')
        ];
    }
}
