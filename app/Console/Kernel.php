<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Space;
use Illuminate\Support\Arr;
use GuzzleHttp\Exception\ClientException;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $client = new \GuzzleHttp\Client(['headers' => ['X-Api-Key'=>env('X_API_KEY'), 
            'X-Api-Secret' => env('X_API_SECRET'), 'Content-Type' => 'application/json']]);;
            $url = "https://api.assembla.com/v1/spaces/";
    
            try {
                $data = $client->request('GET', $url)->getBody();
                $spaces = json_decode($data, true);
                
                $space_ids = Arr::pluck($spaces, 'wiki_name');
    
                Space::whereNotIn('space_id', $space_ids)->delete();
                foreach ($spaces as $space){
                    Space::updateOrCreate(['space_id' => $space['wiki_name']], ['name' => $space['name']]);
                }
            } catch (ClientException $e){
                echo ('No se encontraron spaces');
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
