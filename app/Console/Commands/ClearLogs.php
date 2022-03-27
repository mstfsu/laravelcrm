<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LoginLogs;
use \Carbon\Carbon;
class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $logs=LoginLogs::withoutGlobalScope('company_id')->where('result','User has been rejected | Account Not Found')->whereDate('created_at','<',Carbon::today())->delete();

    }
}
