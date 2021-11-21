<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image'=>'https://source.unsplash.com/random',
            'title'=>$this->faker->sentence,
            'content'=>$this->faker->paragraph,
            'category_id'=>rand(1,5),
            'user_id'=>rand(1,2)
        ];
    }
}
