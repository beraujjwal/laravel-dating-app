<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->delete();
        $now = Carbon::now();
        DB::table('genders')->insert([
            'id' => 1,
            'name' => 'Male',
            'slug' => 'male',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('genders')->insert([
            'id' => 2,
            'name' => 'Female',
            'slug' => 'female',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('genders')->insert([
            'id' => 3,
            'name' => 'Transgender ',
            'slug' => 'transgender ',
            'deleted_at' => $now,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
