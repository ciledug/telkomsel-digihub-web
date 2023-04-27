<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Dalnet Test',
            'username' => 'dalnettest@gmail.com',
            'email' => 'dalnettest@gmail.com',
            'password' => Hash::make('12345678'),
            'enc_key' => 0, // 0:both, 1:dalnet-key, 2:client-key
        ]);
    }
}
