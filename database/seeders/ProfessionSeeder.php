<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('professions')->delete();
        $now = Carbon::now();
        DB::table('professions')->insert([
            [
                'id' => 1,
                'name' => 'Artist',
                'slug' => 'artist',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'name' => 'Physician',
                'slug' => 'physician',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'name' => 'Teacher',
                'slug' => 'teacher',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'name' => 'Scientist',
                'slug' => 'scientist',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 5,
                'name' => 'Engineer',
                'slug' => 'engineer',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 6,
                'name' => 'Architect',
                'slug' => 'architect',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 7,
                'name' => 'Designer',
                'slug' => 'designer',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 8,
                'name' => 'Lawyer',
                'slug' => 'lawyer',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 9,
                'name' => 'Electrician',
                'slug' => 'electrician',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 10,
                'name' => 'Technician',
                'slug' => 'technician',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 11,
                'name' => 'Pharmacist',
                'slug' => 'pharmacist',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 12,
                'name' => 'Accountant',
                'slug' => 'accountant',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 13,
                'name' => 'Dentist',
                'slug' => 'dentist',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 14,
                'name' => 'Labourer',
                'slug' => 'labourer',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 15,
                'name' => 'Software Developer',
                'slug' => 'software-developer',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 16,
                'name' => 'Librarian',
                'slug' => 'librarian',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 17,
                'name' => 'Veterinarian',
                'slug' => 'veterinarian',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 18,
                'name' => 'Chef',
                'slug' => 'chef',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 19,
                'name' => 'Butcher',
                'slug' => 'butcher',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 20,
                'name' => 'Firefighter',
                'slug' => 'firefighter',
                'deleted_at' => null,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
