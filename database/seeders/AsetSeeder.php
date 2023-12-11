<?php

namespace Database\Seeders;

use App\Models\Aset;
use Illuminate\Database\Seeder;

class AsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AsetSeeder::class
        ]);
    }
}
