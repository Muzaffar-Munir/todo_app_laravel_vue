<?php

namespace Database\Factories;

use App\Models\Clients;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Clients::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => (User::factory()->state([
                'role' => 'client',
            ])),
            'business_name' => $this->faker->name,
            'subscription_type' => '0',
            'abn' => '1212121',
            'business_address' => $this->faker->name,
        ];
    }
}
