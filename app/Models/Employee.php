<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasUuid;
    public function users()
    {
        return $this->belongsTo(Team::class);
    }
    public function teams()
    {
        return $this->belongsTo(Team::class);
    }
}
