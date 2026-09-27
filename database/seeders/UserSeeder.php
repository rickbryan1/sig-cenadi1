<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Administrateur
        User::create([
            'name' => 'KAMGAIMG TCHOUAMBOU',
            'email' => 'kamgaingadmin@cenadi.cm',
            'password' => Hash::make('adminpass2026!'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 2. Chef de Projet (KIM HYUNG)
        User::create([
            'name' => 'KIM HYUNG',
            'email' => 'kim.hyung@cenadi.cm',
            'password' => Hash::make('securedpass2026!'),
            'role' => 'chef_projet',
            'is_active' => true,
        ]);

        // 3. Membre de l'équipe (BTS)
        User::create([
            'name' => 'BTS',
            'email' => 'bts@cenadi.cm',
            'password' => Hash::make('memberpass2026!'),
            'role' => 'member',
            'is_active' => true,
        ]);

        // 4. Commanditaire / Sponsor (BANGTAN)
        User::create([
            'name' => 'BANGTAN',
            'email' => 'bangtan@minfi.gov.cm',
            'password' => Hash::make('sponsorpass2026!'),
            'role' => 'sponsor',
            'is_active' => true,
        ]);
    }
}