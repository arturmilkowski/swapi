<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Collection;
// use Illuminate\Support\Facades\DB;
use App\Services\Saving;

class DownloadSwapi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swapi:download
                            {what : Choose from: people, planets, starships}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download data from the Star Wars API and save them to the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $what = $this->argument('what');
        $service = new Saving;
        $success = $service->save($what);
        if ($success) {
            $this->info('Download was successful ' . $what . ' ' . $success);
        } else {
            $this->error('Something went wrong');
        }
        
        return 0;
    }
}
