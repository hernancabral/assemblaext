<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class MilestonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Milestone::class, 10)->create();
    }
}
