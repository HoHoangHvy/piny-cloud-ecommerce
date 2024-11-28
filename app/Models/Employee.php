<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasUuid;
    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'date_of_birth',
        'gender',
        'team_id',
        'level',
        'user_id',
        'date_registered',
    ];
    // Corrected relationship methods
    public function user()
    {
        return $this->belongsTo(User::class); // Singular: "user"
    }

    public function team()
    {
        return $this->belongsTo(Team::class); // Singular: "team"
    }
}
