<?php

namespace Database\Seeders;

use App\Models\Freelancers;
use Illuminate\Database\Seeder;

class FreelancerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Freelancers::factory(5)->create();
    }
}
