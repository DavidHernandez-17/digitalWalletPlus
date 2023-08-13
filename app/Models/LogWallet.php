<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_wallet',
        'id_client',
        'payment_concept',
        'pay_to',
        'value',
        'id_session',
        'status'
    ];

    public function wallet(){
        return $this->belongsTo(DigitalWallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
