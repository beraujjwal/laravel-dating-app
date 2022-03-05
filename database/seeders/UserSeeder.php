<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $now = Carbon::now();
        DB::table('users')->insert([
            [
                'provider_id' => null,
                'provider' => null,
                'name' => 'John Doe',
                'phone' => '9883266203',
                'email' => 'bera.ujjwal@hotmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('9883266203'),
                'deleted_at' => null,
                'status' => true,
                'online' => false,
                'remember_token' => 'OMIFmypRPasdasbgayNX1pANnjsb2oI74ZGObt',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'provider_id' => '123456789',
                'provider' => 'facebook',
                'name' => 'Anna John',
                'phone' => null,
                'email' => '123456789@hotmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456789'),
                'deleted_at' => null,
                'status' => true,
                'online' => false,
                'remember_token' => 'OMIFmypRP603nk1RbgayNX1pANnjsb2oIsafdt',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'provider_id' => '456789123',
                'provider' => 'facebook',
                'name' => 'William Doe',
                'phone' => null,
                'email' => '456789123@hotmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('456789123'),
                'deleted_at' => null,
                'status' => true,
                'online' => false,
                'remember_token' => 'OMIFmypRP603nk1RbgaasdaasdaoI74ZGObt',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'provider_id' => '789123456',
                'provider' => 'google',
                'name' => 'Kamal Doe',
                'phone' => null,
                'email' => '456789123@hotmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('456789123'),
                'deleted_at' => null,
                'status' => true,
                'online' => false,
                'remember_token' => 'OMIFmypRP603nk1RbgayNX1pANnjsb2oI74ZGObt',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'provider_id' => '5951236874',
                'provider' => 'firebase',
                'name' => null,
                'phone' => '5951236874',
                'email' => null,
                'email_verified_at' => null,
                'password' => Hash::make('5951236874'),
                'deleted_at' => null,
                'status' => true,
                'online' => false,
                'remember_token' => 'OMIFmypRP605951236874X1pANnjsb2oI74ZGObt',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
