<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i <= 1_000_000; $i++) {
            DB::table('users')->insertOrIgnore([
                'login' => Str::random(20),
                'password' => Hash::make('password'),
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'birthday' => $faker->dateTimeBetween('-60 years', '-20 years'),
                'sex' => rand(0, 1),
                'city' => $faker->city,
            ]);
        }
    }
}
