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
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function team()
    {
        return $this->belongsTo(Team::class); // Singular: "team"
    }
}
