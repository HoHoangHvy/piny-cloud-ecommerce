<?php

namespace App\Models;

use App\Models\Concerns\HasCreatedBy;
use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuid, HasCreatedBy;

    protected $fillable = [
        'id',
        'order_number',
        'receiver_name',
        'receiver_address',
        'payment_method',
        'payment_status',
        'order_status',
        'order_total',
        'rate',
        'customer_feedback',
        'host_id',
        'source',
        'team_id',
        'created_by',
        'custom_name',
        'type',
        'province',
        'district',
        'ward',
        'street',
    ];

    // Relationship with the host customer
    public function host()
    {
        return $this->belongsTo(Customer::class, 'host_id');
    }

    // Many-to-Many relationship with customers

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customers_orders')
            ->using(CustomerOrder::class) // Use the CustomerOrder pivot model
            ->withPivot('id') // Include the pivot table's ID
            ->withTimestamps();
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
