<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => "Checklist Admin",
            'email' => "robhowdle94@gmail.com",
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $user->assign('superadmin');
    }
}
