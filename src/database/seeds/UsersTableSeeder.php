<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [[
            'email' => 'admin@vertor.com',
            'password' => Hash::make('password')
        ]];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
