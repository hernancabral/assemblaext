<?php

use Illuminate\Database\Seeder;

class PrioritizedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Prioritized::class, 10)->create();
    }
}
