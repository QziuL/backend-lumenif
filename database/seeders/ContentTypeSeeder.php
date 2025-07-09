<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('content_types')->insert([
            [
               'name' => 'Video',
               'created_at' => now(),
            ],
            [
               'name' => 'Text',
               'created_at' => now(),
            ],
            [
                'name' => 'Image',
                'created_at' => now(),
            ],
            [
                'name' => 'Audio',
                'created_at' => now(),
            ],
            [
                'name' => 'File',
                'created_at' => now(),
            ],
            [
                'name' => 'Quiz',
                'created_at' => now(),
            ]
        ]);
    }
}
