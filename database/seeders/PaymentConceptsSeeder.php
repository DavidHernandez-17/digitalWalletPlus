<?php

namespace Database\Seeders;

use App\Models\PaymentConcept;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentConceptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentConcept::create([
            'name' => 'Hogar',
        ]);

        PaymentConcept::create([
            'name' => 'Transporte',
        ]);

        PaymentConcept::create([
            'name' => 'Alimentación',
        ]);

        PaymentConcept::create([
            'name' => 'Moda',
        ]);

        PaymentConcept::create([
            'name' => 'Salud bienestar',
        ]);
    }
}
