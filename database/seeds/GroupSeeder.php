<?php

namespace Database\Seeders;

use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [
                'name'              => 'It',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Sales',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];
        foreach ($groups as $group) {
            Group::create($group);
        }
    }
}
