<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [[
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => bcrypt('secret')
        ]];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
