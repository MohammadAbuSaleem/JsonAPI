<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        'offeror_user_id',
        'receiver_user_id',
        'status',
        'longtitude',
        'latitude'
    ];

    public function tradeProducts()
    {
        return $this->hasMany('App\TradeProduct');
    }
}
