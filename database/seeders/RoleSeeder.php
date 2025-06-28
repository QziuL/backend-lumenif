<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'nome' => 'ADMIN',
                'created_at' => now(),
            ],
            [
                'nome' => 'ALUNO',
                'created_at' => now(),
            ],
            [
                'nome' => 'CRIADOR',
                'created_at' => now(),
            ],
        ]);
    }
}
