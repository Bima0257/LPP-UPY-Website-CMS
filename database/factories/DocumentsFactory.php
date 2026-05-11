<?php

namespace Database\Factories;

use App\Models\DocumentCategories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Documents;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Documents>
 */
class DocumentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Documents::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        $fileTypes = [
            'pdf' => 'application/pdf',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        $ext = $this->faker->randomElement(array_keys($fileTypes));

        return [
            'title' => $title,
            'date' => $this->faker->date(),
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'description' => $this->faker->paragraph(),
            'file_path' => 'documents/sample-' . $this->faker->numberBetween(1, 10) . '.' . $ext,
            'file_mime' => $fileTypes[$ext],
            'file_extension' => $ext,
            'file_size' => $this->faker->numberBetween(100000, 5000000),
            'is_published' => $this->faker->boolean(80),
            'is_protected' => $this->faker->boolean(30),
            'access_password' => $this->faker->boolean(30) ? 'secret123' : null,
            'uploaded_by' => User::inRandomOrder()->value('id'),
            'category_id' => DocumentCategories::inRandomOrder()->value('id'),
        ];
    }
}
