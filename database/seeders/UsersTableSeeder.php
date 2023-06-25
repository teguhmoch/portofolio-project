<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Master',
                'email'          => 'master@master.com',
                'password'       => bcrypt('password'),
                'status'         => 'active',
                'nik'            => 11450332,
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'status'         => 'active',
                'nik'            => 11450333,
                'remember_token' => null,
            ],
            [
                'id'             => 3,
                'name'           => 'Admin Gudang',
                'email'          => 'gudang@admin.com',
                'password'       => bcrypt('password'),
                'nik'            => 11450335,
                'status'         => 'active',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
