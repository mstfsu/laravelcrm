<?php

namespace Database\Seeders;

use App\Models\Priority;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorities = [
            [
                'name' => 'New',
                'color' => 'success',
                'respond_within_time_value' => 1,
                'respond_within_time_type' => "hrs",
                'resolve_within_time_type' => "hrs",
                'resolve_within_time_value' => 1,
                'sms' => 1,
                "email" => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Medium',
                'color' => 'info',
                'respond_within_time_type' => "hrs",
                'resolve_within_time_type' => "hrs",

                'respond_within_time_value' => 1,
                'resolve_within_time_value' => 1,
                'sms' => 1,
                "email" => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'High',
                'color' => 'warning',
                'respond_within_time_value' => 1,
                'respond_within_time_type' => "hrs",
                'resolve_within_time_value' => 1,
                'resolve_within_time_type' => "hrs",
                'sms' => 1,
                "email" => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Urgent',
                'color' => 'danger',
                'respond_within_time_value' => 1,
                'respond_within_time_type' => "hrs",
                'resolve_within_time_value' => 1,
                'resolve_within_time_type' => "hrs",
                'sms' => 1,
                "email" => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        $this->call([GroupSeeder::class, StatusSeeder::class, TypeSeeder::class]);
        foreach ($priorities as $priority) {
            Priority::create($priority);
        }
    }
}
