<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscriber;
use App\Models\OnlineStatistics;
use App\Models\User;
use App\Models\Company;
use Schema;
class Countonlineusers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'online:count';

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

        $companies=Company::withoutGlobalScope('company_id')->where('id','!=',1)->get();
        $data = Subscriber::withoutGlobalScope('company_id')->where('onlinestatus', 'online')->count();
        $onlinestatistics = new OnlineStatistics();
        $onlinestatistics->count = $data;
        $onlinestatistics->company_id = 1;
        $onlinestatistics->user_id = 1;
        $onlinestatistics->save();
        foreach($companies as $company) {
            $table_name=$company->name;
            if(isset($company->table_name))
                $table_name=$company->table_name;

            $table_name = preg_replace('/\s+/', '', $table_name);
            $table_name = str_replace('-', '', $table_name);
            $table_name = str_replace('.', '', $table_name);
             if(!Schema::hasTable($table_name)){
                 Schema::connection('mysql')->create($table_name, function($table)
                 {
                     $table->increments('id');
                     $table->unsignedInteger('count');
                     $table->unsignedInteger('company_id');
                     $table->unsignedInteger('user_id');
                     $table->timestamp('created_at')->nullable();
                     $table->timestamp('updated_at')->nullable();

                 });
             }
            $data = Subscriber::withoutGlobalScope('company_id')->where('onlinestatus', 'online')->where('company_id',$company->id)->count();

            $onlinestatistics = new OnlineStatistics();
            $onlinestatistics->setTable($table_name);
            $onlinestatistics->count = $data;
            $onlinestatistics->company_id = $company->id;
            $onlinestatistics->user_id = $company->id;
            $onlinestatistics->save();
        }

    }
}
