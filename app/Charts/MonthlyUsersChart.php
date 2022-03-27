<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use App\Models\Subscriber;
class MonthlyUsersChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {  $today=Carbon::today()->format('Y-m-d');
        $allusers=Subscriber::count();
        $blocked_users=Subscriber::where('status','blocked')->count();
        $new_users=Subscriber::where('status','new')->count();
        $expired_users=Subscriber::whereDate('expiration',"<",$today)->count();
        return $this->chart->donutChart()
            ->setTitle('Top 3 scorers of the team.')
            ->setSubtitle('Season 2021.')
            ->addData([$allusers, $blocked_users, $new_users,$expired_users])
            ->setLabels(['ALL Users', 'Blocked Users', 'New Users','Expired Users'])
            ->setColors(['#17610B','#FF4B05','#04C2F1','#F18104']);
    }
}
