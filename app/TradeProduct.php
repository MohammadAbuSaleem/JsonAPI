<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeProduct extends Model
{
    protected $fillable = [
        'trade_id',
        'offered_product_id',
        'requested_product_id',
    ];

    public function offeredProduct()
    {
        return $this->belongsTo('App\Product', 'offered_product_id');
    }

    public function requestedProduct()
    {
        return $this->belongsTo('App\Product', 'requested_product_id');
    }
}
