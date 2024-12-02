<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'id' => Str::uuid(),
            'name' => 'Global',
            'address' => '',
            'city' => '',
            'state' => '',
            'ward' => '',
            'description' => 'Default team',
        ]);
    }
}
