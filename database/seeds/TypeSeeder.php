<?php

namespace Database\Seeders;

use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name'              => 'Question',
                'color'             => 'info',
                'others'            => 0,
                'only_visible_for_admin' =>0,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Incident',
                'color'              => 'dark',
                'others'            => 0,
                'only_visible_for_admin' =>0,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Problem',
                'color'              => 'warning',
                'others'            => 0,
                'only_visible_for_admin' =>0,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Feature Request',
                'color'              => 'danger',
                'others'            => 0,
                'only_visible_for_admin' =>0,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Lead',
                'color'              => 'success',
                'others'            => 0,
                'only_visible_for_admin' =>0,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];
        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
