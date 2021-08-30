<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'first_name' => 'Super Admin',
            'email' => 'admin@apexloads.com',
            'email_verify' => '1',
            'phone_verify' => '1',
            'user_role' => '1',
            'responsibilty_type' => '1',
            'account_type' => '1',
            'device_token' => 'admin',
            'password' => bcrypt('welcome')
        ]);
        $user->assignRole('administrator');

    }
}