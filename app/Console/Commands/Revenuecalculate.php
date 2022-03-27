<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Revenue;
use App\Models\Totalrevenue;
use App\Models\Company;
class Revenuecalculate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revenue:calculate';

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
        $companies=Company::withoutGlobalScope('company_id')->get();
        foreach($companies as $company){
            echo $company->id;
            $company_id=$company->id;
            $sum=0;
            $revenues=Revenue::withoutGlobalScope('company_id')->where('added_tototal',0)->where('company_id',$company_id)->get();
            foreach ($revenues as $revenue){
                $sum+=$revenue->revenue;
                $revenue->added_tototal=1;
                $revenue->save();
                $totalrev=Totalrevenue::firstorcreate(['company_id'=>$company_id]);
                $newrev =$sum+$totalrev->total;
                $totalrev->total=$newrev;
                $totalrev->save();
            }
        }

    }
}
