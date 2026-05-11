<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'divisi' => $this->faker->randomElement([
                'Frontend Developer',
                'Backend Developer',
                'UI/UX Designer',
                'Project Manager',
                'Digital Marketing',
                null
            ]),
            'foto' => 'members/member1.jpg',
            'instagram_link' => $this->faker->optional()->url(),
            'linkedin_link' => $this->faker->optional()->url(),
            'facebook_link' => $this->faker->optional()->url(),
            'sort_order' => $this->faker->numberBetween(1, 20),
        ];
    }
}
