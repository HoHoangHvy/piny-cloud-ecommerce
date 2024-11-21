<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory, HasUuid;
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
