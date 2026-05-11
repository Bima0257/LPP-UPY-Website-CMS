<?php

namespace Database\Factories;

use App\Models\PostCategories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Posts::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'post_category_id' => PostCategories::inRandomOrder()->value('id'),
            'title' => $title,
            'date' => $this->faker->date(),
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'content' => $this->faker->paragraphs(5, true),
            'thumbnail' => 'thumbnails/default/default1.jpg',
            'image' => 'images/default/default2.jpg',
            'author_id' => User::inRandomOrder()->value('id'),
            'is_published' => $this->faker->boolean(70),
        ];
    }
}
