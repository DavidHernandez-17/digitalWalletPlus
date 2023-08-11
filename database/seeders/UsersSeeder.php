<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'document' => '1193534443',
            'full_name' => 'David Hernández',
            'email' => 'dh17002@gmail.com',
            'cell_phone' => '3017966824',
        ]);

        User::create([
            'document' => '12033722',
            'full_name' => 'Marta Rodriguez',
            'email' => 'martica_rico23@albertoalvarez.com',
            'cell_phone' => '3017966824',
        ]);
    }
}
