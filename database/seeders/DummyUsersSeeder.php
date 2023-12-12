<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $userData = [
                // [
                //     'name' => 'Diaz Haykal',
                //     'email' => 'teknisi2@gmail.com',
                //     'role' => 'Teknisi',
                //     'password' => bcrypt('123456')
                // ]
                // ,
                // [
                //     'name' => 'Sindu Dinar',
                //     'email' => 'koordinator@gmail.com',
                //     'role' => 'Koordinator',
                //     'password' => bcrypt('123456')
                // ],
                // [
                //     'name' => 'Falana Rofako',
                //     'email' => 'pelapor@gmail.com',
                //     'role' => 'Pelapor',
                //     'password' => bcrypt('123456')
                // ],
                // [
                //     'name' => 'Anggy Distria',
                //     'email' => 'pemakaibhp@gmail.com',
                //     'role' => 'PemakaiBHP',
                //     'password' => bcrypt('123456')
                // ],
                // [
                //     'name' => 'Gita Kirana',
                //     'email' => 'admin@gmail.com',
                //     'role' => 'Admin',
                //     'password' => bcrypt('123456')
                // ],
                // [
                //     'name' => 'Sariyyanti Hikmah',
                //     'email' => 'teknisi@gmail.com',
                //     'role' => 'Teknisi',
                //     'password' => bcrypt('123456')
                // ]
                // ,
                [
                    'name' => 'Falana Rofako',
                    'email' => 'admin2@gmail.com',
                    'role' => 'Admin',
                    'password' => bcrypt('123456')
                ]
            ];

            foreach($userData as $key => $val){
                User::create($val);
            }
    }
}
