<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Radacct;
use DB;

class OnlineChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        $data=Radacct::select(DB::raw('Date(acctstarttime) as  date_x'),DB::raw('count("username") as total')  ) ->groupby('date_x') ->get() ;
        $x_array=array();
        $y_array=array();
        foreach ($data as $dash){
            array_push($x_array,$dash->date_x);
            array_push($y_array,$dash->total);
        }
        return $this->chart->areaChart()
            ->setTitle('Sales during 2021.')
            ->setSubtitle('Physical sales vs Digital sales.')
            ->addData('Physical sales', $y_array)

            ->setXAxis($x_array)
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10);;
    }
}
