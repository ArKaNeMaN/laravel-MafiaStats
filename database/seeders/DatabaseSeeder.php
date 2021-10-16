<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Tournament::factory(5)->create();
        \App\Models\Player::factory(30)->create();
        \App\Models\Game::factory(10)->create();

        \App\Models\User::factory(1)->create([
            'login' => 'Admin',
            'email' => 'admin@adm.in',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
    }
}
