<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'barcode', 'product', 'price'
    ];

    public function category(){
        return $this->belongsTo('App\Category');
    }
}
