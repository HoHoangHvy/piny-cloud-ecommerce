<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $global_team = Team::where('name', 'Global')->first();
        User::create([
            'id' => Str::uuid(),
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123123'),
            'email_verified_at' => now(),
            'is_admin' => true,
            'api_token' => Str::random(80),
            'user_type' => 'user',
            'team_id' => $global_team->id
        ])->assignRole('admin');
    }
}
