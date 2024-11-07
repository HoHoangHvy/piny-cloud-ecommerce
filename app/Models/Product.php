<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuid;
    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class);
    }
    public function toppings()
    {
        return $this->belongsToMany(Product::class, 'products_toppings', 'product_id', 'topping_id')
                    ->withTimestamps();
    }

    public function productsToppingThis()
    {
        return $this->belongsToMany(Product::class, 'products_toppings', 'topping_id', 'product_id')
                    ->withTimestamps();
    }
}
