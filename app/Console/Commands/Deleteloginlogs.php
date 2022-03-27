<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LoginLogs;
use Carbon\Carbon;
class Deleteloginlogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:loginlogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Login Logs';

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
        $date=Carbon::today()->subDays(7)->format('Y-m-d');
       $loginlogs=LoginLogs::withoutGlobalScope('company_id')->whereDate('created_at','<',$date)->delete();

    }
}
