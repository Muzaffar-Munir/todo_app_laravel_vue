<?php

namespace Database\Factories;

use App\Models\Freelancers;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FreelancersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Freelancers::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'industry' => 'ef0084e6-90cb-4dd0-8c49-5a622d4c5e31',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing , sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniamdidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.'
            // 'business_address' => $this->faker->paragraph,
        ];
    }
}
