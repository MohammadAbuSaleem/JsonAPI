<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'image_url',
        'brief',
        'description',
        'price',
    ];

    public function images()
    {
        return $this->hasMany('App\ProductPicture');
    }


}
