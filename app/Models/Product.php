<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Product extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'description',
        'price',
        'quantity',
        'image_path',
        'image_url',
    ];

    public function getImageSrcAttribute(): ?string
    {
        if ($this->image_path) return asset('storage/' . $this->image_path);
        if ($this->image_url)  return $this->image_url;
        return null;
    }



    public function carts() {
        return $this->hasMany(Cart::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

    /**
     * The categories that belong to the product.
     */
    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
