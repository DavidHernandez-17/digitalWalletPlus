<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_wallet')->constrained('digital_wallets');
            $table->foreignId('id_client')->constrained('users');
            $table->string('payment_concept');
            $table->string('pay_to')->default('0');
            $table->integer('value');
            $table->string('id_session');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_wallets');
    }
};
