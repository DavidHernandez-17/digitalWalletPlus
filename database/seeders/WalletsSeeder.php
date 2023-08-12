<?php

namespace Database\Seeders;

use App\Models\DigitalWallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DigitalWallet::create([
            'name' => 'Viaje san andrés',
            'saldo' => '2000000',
            'id_client' => '1',
        ]);

        DigitalWallet::create([
            'name' => 'Moto',
            'saldo' => '600000',
            'id_client' => '1',
        ]);

        DigitalWallet::create([
            'name' => 'Pasaporte',
            'saldo' => '250000',
            'id_client' => '2',
        ]);

        DigitalWallet::create([
            'name' => 'Casa',
            'saldo' => '25000000',
            'id_client' => '2',
        ]);
    }
}
