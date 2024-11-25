<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, HasUuid;
    protected $fillable = [
        'id',
        'name',
        'description',
        'image',
        'status',
        'price',
        'cost',
        'up_m_price',
        'up_l_price',
        'is_topping',
    ];
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
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('s3')->url($this->image) : null;
    }

}
