<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create(
            ['name' => 'admin'],
            ['name' => 'student'],
            ['name' => 'teacher']
        );

        User::create(
            ['name' => 'Aleksandar', 'email' => 'amarkovic@projectland.rs', 'role_id' => 1, 'password' => Hash::make('00000000'), 'lang' => 'sr'],
            ['name' => 'Nikola', 'email' => '', 'nstamenkovski@projectland.rs' => 1, 'password' => Hash::make('00000000'), 'lang' => 'sr'],
        );
    }
}
