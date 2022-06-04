<?php

namespace Database\Factories;

use App\Models\Clients;
use App\Models\Services;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Services::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'price' => 1000,
            'audience' => $this->faker->name,
            'url'=>$this->faker->url,
            'client_id' => Clients::factory(),
            'requirements'=>$this->faker->paragraph,
            'description'=>$this->faker->paragraph,
            'sales_method' => 'ef0084e6-90cb-4dd0-8c49-5a622d4c5e31',
            'industry'=>'ef0084e6-90cb-4dd0-8c49-5a622d4c5e31'
            
        ];
    }
}
