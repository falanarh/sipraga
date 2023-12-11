<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'Koordinator'],
            ['name' => 'Teknisi'],
            ['name' => 'Pelapor'],
            ['name' => 'PemakaiBHP'],
        ];

        // Menambahkan data ke tabel roles
        DB::table('roles')->insert($roles);
    }
}