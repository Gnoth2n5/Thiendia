<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Support\Carbon;

class CustomServeCommand extends ServeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve
                            {--host=127.0.0.1 : The host address to serve the application on}
                            {--port=8000 : The port to serve the application on}
                            {--tries= : The max number of ports to attempt to serve from}
                            {--no-reload : Do not reload the development server on .env file changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve the application on the PHP development server (Fixed version)';

    /**
     * Get the date from the given PHP server output.
     * Fixed version that handles cases where preg_match doesn't find a match.
     *
     * @param  string  $line
     * @return \Illuminate\Support\Carbon
     */
    protected function getDateFromLine($line)
    {
        $regex = env('PHP_CLI_SERVER_WORKERS', 1) > 1
            ? '/^\[\d+]\s\[([a-zA-Z0-9: ]+)\]/'
            : '/^\[([^\]]+)\]/';

        $line = str_replace('  ', ' ', $line);

        preg_match($regex, $line, $matches);

        // Fix: Check if matches[1] exists before using it
        if (! isset($matches[1])) {
            // Return current time if no match found
            return Carbon::now();
        }

        return Carbon::createFromFormat('D M d H:i:s Y', $matches[1]);
    }
}
