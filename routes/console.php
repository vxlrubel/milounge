<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('logs:clear', function() {

    // Clear storage logs
    $files = glob(storage_path('logs/*.log'));
    foreach ($files as $file) {
        if (file_exists($file)) {
            unlink($file);
        }
    }

    $this->comment('Logs have been cleared!');

})->describe('Clear log files');
