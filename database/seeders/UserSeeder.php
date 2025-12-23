<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Luka Milanovic',
            'email' => 'luka@farbara.rs',
            'password' => bcrypt('password'),
            'uloga_id' => 1, // Vlasnik
        ]);

        User::create([
            'name' => 'Andrija Stojanovic',
            'email' => 'andrija@farbara.rs',
            'password' => bcrypt('password'),
            'uloga_id' => 2, // Prodavac
        ]);
    }
}
