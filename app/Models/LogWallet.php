<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_wallet',
        'payment_concept',
        'description',
        'value'
    ];

    public function wallet(){
        return $this->hasMany(DigitalWallet::class);
    }
}
