<?php

namespace Database\Factories;

use App\Models\Carousels;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CarouselsFactory extends Factory
{
    protected $model = Carousels::class;

    public function definition(): array
    {
        return [
            'sort_order' => $this->faker->numberBetween(0, 10),
            'author_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'image' => 'carousels/carousel1.jpg',
            'btn_link' => $this->faker->url(),
            'is_published' => $this->faker->boolean(80), // 80% true
        ];
    }
}
