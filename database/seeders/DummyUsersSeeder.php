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
                [
                    'name' => 'Diaz Haykal',
                    'email' => 'teknisi2@gmail.com',
                    'role' => 'Teknisi',
                    'password' => bcrypt('123456')
                ]
                // ,
                // [
                //     'name' => 'Mas Koordinator',
                //     'email' => 'koordinator@gmail.com',
                //     'role' => 'Koordinator',
                //     'password' => bcrypt('123456')
                // ],
                // [
                //     'name' => 'Mas Pelapor',
                //     'email' => 'pelapor@gmail.com',
                //     'role' => 'Pelapor',
                //     'password' => bcrypt('123456')
                // ],
                // [
                //     'name' => 'Mas PemakaiBHP',
                //     'email' => 'pemakaibhp@gmail.com',
                //     'role' => 'PemakaiBHP',
                //     'password' => bcrypt('123456')
                // ],
                // [
                //     'name' => 'Mas Teknisi',
                //     'email' => 'teknisi@gmail.com',
                //     'role' => 'Teknisi',
                //     'password' => bcrypt('123456')
                // ]
            ];

            foreach($userData as $key => $val){
                User::create($val);
            }
    }
}
