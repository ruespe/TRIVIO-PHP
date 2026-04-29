<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['nom' => 'Historia', 'descripcio' => 'Historia del món', 'created_at' => now()],
            ['nom' => 'Esports', 'descripcio' => 'Esports en general', 'created_at' => now()],
            ['nom' => 'Art', 'descripcio' => 'Art arreu del món', 'created_at' => now()],


        ]);
    }
}
