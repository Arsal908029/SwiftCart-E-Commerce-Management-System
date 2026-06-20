<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['product_id', 'quantity', 'buyer_name'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
