<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'id',
        'name',
        'guard_name',
        'description',
        'is_admin',
        'apply_team_visibility',
    ];
}
