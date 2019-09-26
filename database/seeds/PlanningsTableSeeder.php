<?php

use Illuminate\Database\Seeder;

class PlanningsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Planning::class, 10)->create();
    }
}
