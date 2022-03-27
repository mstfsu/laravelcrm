<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Carbon\Carbon;
use App\Models\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'  => 'Super Admin',
        'email' => 'super@admin.com',
        'password' => 'password',
        'email_verified_at' => Carbon::now(),
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
    ];
});
