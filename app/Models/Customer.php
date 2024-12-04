<?php

namespace App\Models;

use App\Models\Concerns\HasCreatedBy;
use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Customer extends Model
{
    use HasFactory, HasUuid, HasCreatedBy;
    protected $fillable = [
        'date_registered',
        'date_of_birth',
        'full_name',
        'gender',
        'phone_number',
        'email'
    ];

    protected static function booted()
    {
        static::creating(function ($customer) {
            $customer->date_registered = $customer->date_registered ?? Carbon::now();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
