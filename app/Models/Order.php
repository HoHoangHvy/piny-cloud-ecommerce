<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuid;
    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
