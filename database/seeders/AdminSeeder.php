<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('admins')->count();
        if ($count == 0) {
            DB::table('admins')->insert(
                [
                    [
                        'role_id'           => 1,
                        'name'              => 'Oshit Sutra Dhar',
                        'username'          => 'oshitsd',
                        'mobile'            => '01883847733',
                        'email'             => 'oshitsd@gmail.com',
                        'password'          => Hash::make('oshitsd'),
                        'status'            => 'active',
                        'remember_token'    => Str::random(10),
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ],
                ]
            );
        }
    }
}
