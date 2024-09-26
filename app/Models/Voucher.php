<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
