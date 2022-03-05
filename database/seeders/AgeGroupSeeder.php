<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;

class AgeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('age_groups')->delete();
        $now = Carbon::now();
        DB::table('age_groups')->insert([
            'id' => 1,
            'gender_id' => 1,
            'max' => '25',
            'min' => '18',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 2,
            'gender_id' => 1,
            'max' => '35',
            'min' => '26',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 3,
            'gender_id' => 1,
            'max' => '45',
            'min' => '36',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 4,
            'gender_id' => 1,
            'max' => '55',
            'min' => '46',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 5,
            'gender_id' => 1,
            'max' => '100',
            'min' => '56',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('age_groups')->insert([
            'id' => 6,
            'gender_id' => 2,
            'max' => '25',
            'min' => '18',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 7,
            'gender_id' => 2,
            'max' => '35',
            'min' => '26',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 8,
            'gender_id' => 2,
            'max' => '45',
            'min' => '36',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 9,
            'gender_id' => 2,
            'max' => '55',
            'min' => '46',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 10,
            'gender_id' => 2,
            'max' => '100',
            'min' => '56',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('age_groups')->insert([
            'id' => 11,
            'gender_id' => 3,
            'max' => '25',
            'min' => '18',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 12,
            'gender_id' => 3,
            'max' => '35',
            'min' => '26',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 13,
            'gender_id' => 3,
            'max' => '45',
            'min' => '36',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 14,
            'gender_id' => 3,
            'max' => '55',
            'min' => '46',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('age_groups')->insert([
            'id' => 15,
            'gender_id' => 3,
            'max' => '100',
            'min' => '56',
            'deleted_at' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
