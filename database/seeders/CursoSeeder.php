<?php

namespace Database\Seeders;

use App\Enums\CursoStatusEnum;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::with('roles')->whereHas('roles', function ($query) {
           $query->where('name', 'CRIADOR');
        })->first();

        DB::table('courses')->insert([
            [
                'public_id' => uuid_create(),
                'creator_id' => $user->id,
                'title' => 'API RESTful com Laravel 12',
                'description' => 'Aprenda algo para ganhar dinheiro.',
                'status' => CursoStatusEnum::Approved,
                'created_at' => now(),
            ],
            [
                'public_id' => uuid_create(),
                'creator_id' => $user->id,
                'title' => 'Introdução ao Angular com PrimeNG',
                'description' => 'Seja o melhor desenvolvedor frontend do mundo.',
                'status' => CursoStatusEnum::Pending,
                'created_at' => now(),
            ]
        ]);
    }
}
