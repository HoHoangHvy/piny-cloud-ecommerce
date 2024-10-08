<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsTo(Team::class);
    }
    public function teams()
    {
        return $this->belongsTo(Team::class);
    }
}
