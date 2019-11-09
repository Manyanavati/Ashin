<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$bM.p/pF7exVoEptt40jVu.2hug80bKGdRzvu8oPGexkp5BSY6IJTK',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
