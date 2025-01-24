<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        try {
            Artisan::call("backup:run --only-db --disable-notifications");

            Log::info("DB backup successful");
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }

        try {
            // Drop all table
            Schema::disableForeignKeyConstraints();
            foreach (DB::select('SHOW TABLES') as $table) {
                $table_array = get_object_vars($table);
                $table = $table_array[key($table_array)];
                $table = str_replace('ic_', '', $table);
                Schema::drop($table);
            }

            // Upload db
            $sql_path = base_path('icdemo.sql');
            DB::unprepared(file_get_contents($sql_path));

            Log::info("DB uploaded");
        } catch (\Exception $ex) {

        }


        //         $schedule->command('upload_db')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
