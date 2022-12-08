<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
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
        Role::insert([
            ['name' => 'admin'],
            ['name' => 'student'],
            ['name' => 'teacher']
        ]);

        User::insert([
            ['name' => 'Aleksandar', 'email' => 'amarkovic@projectland.rs', 'role_id' => 1, 'password' => Hash::make('00000000'), 'lang' => 'sr_lat'],
            ['name' => 'Nikola', 'email' => 'nstamenkovski@projectland.rs', 'role_id' => 1, 'password' => Hash::make('00000000'), 'lang' => 'sr_lat']
        ]);
    }
}
