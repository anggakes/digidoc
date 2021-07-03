<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UserAdditional extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('users')->insert([
            'name' => 'Yudha Sopian',
            'email' => 'Yudha@bpjstk.co.id',
            'password' => Hash::make('password'),
            'job_position_id' => 4,
            'nip' => '123000000005',
        ]);
        DB::table('users')->insert([
            'name' => 'Rudi sahara',
            'email' => 'Rudi@bpjstk.co.id',
            'password' => Hash::make('password'),
            'job_position_id' => 5,
            'nip' => '123000000006',
        ]);
        DB::table('users')->insert([
            'name' => 'Anjas Sophian',
            'email' => 'Anjas@bpjstk.co.id',
            'password' => Hash::make('password'),
            'job_position_id' => 6,
            'nip' => '123000000007',
        ]);
    }
}
