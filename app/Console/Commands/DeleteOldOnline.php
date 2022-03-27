<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\OnlineStatistics;
use App\Models\Company;
use Schema;
class DeleteOldOnline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'online:statistics';

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
    {          $date=Carbon::now()->subDays(2);
        $companies=Company::withoutGlobalScope('company_id')->where('id','!=',1)->get();

      $data=  OnlineStatistics::whereDate('created_at',"<=",$date)->delete();
        foreach($companies as $company) {
            $table_name=$company->name;
            if(isset($company->table_name))
                $table_name=$company->table_name;

            $table_name = preg_replace('/\s+/', '', $table_name);
            if(Schema::hasTable($table_name)){
                $onlinestatistics = new OnlineStatistics();
                $onlinestatistics->setTable($table_name);
                $onlinestatistics->whereDate('created_at',"<=",$date)->delete();
            }

        }


    }
}
