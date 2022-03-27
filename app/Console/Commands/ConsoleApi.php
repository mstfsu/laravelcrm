<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConsoleApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'console:api {--view}  {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'API to fetch Data ';

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
    {  $params = $this->argument('data');
      //  $test = unserialize($params);
       $new=\Opis\Closure\unserialize($params);

       echo "hello";
    }
}
