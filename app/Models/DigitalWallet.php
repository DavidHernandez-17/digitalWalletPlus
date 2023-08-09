<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'saldo',
        'id_client'
    ];

    public function client(){
        return $this->belongsTo(User::class);
    }

    public function logWallet()
    {
        return $this->belongsTo(LogWallet::class);
    }
}
