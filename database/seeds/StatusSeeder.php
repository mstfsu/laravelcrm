<?php

namespace Database\Seeders;

use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'name'              => 'New',
                'color'              => 'info',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Work in progress',
                'color'              => 'success',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Resolved',
                'color'              => 'warning',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Waiting on customer',
                'color'              => 'danger',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Waiting on agent',
                'color'              => 'dark',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];
        foreach ($status as $statu) {
            Status::create($statu);
        }
    }
}
