<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\EnviarEmailContratos;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        EnviarEmailContratos::class
    ];

    protected function schedule(Schedule $schedule)
    {
		$schedule->command('enviar:emails')->everyMinute();	
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
