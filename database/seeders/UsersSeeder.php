<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mutaman Elhadi',
            'fullName' => 'John Doe',
            'username' => 'johndoe',
            'password' => Hash::make('rootadmin'),
            'avatar' => '/images/avatars/avatar-1.png',
            'email' => 'mutamanelhadi97@gmail.com',
            'role' => 'admin',
            'abilityRules' => [
                [
                    'action' => 'manage',
                    'subject' => 'all',
                ],
            ],
        ]);
    }
}
