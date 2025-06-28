<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buscar os papéis no banco de dados
        $adminRole = Role::where('name', 'ADMIN')->first();
        $creatorRole = Role::where('name', 'CRIADOR')->first();
        $alunoRole = Role::where('name', 'ALUNO')->first();

        // 2. Criar um usuário Administrador
        $adminUser = User::factory()->create([
            'public_id' => uuid_create(),
            'name' => 'Admin LumenIF',
            'email' => 'admin@lumenif.com',
            'password' => Hash::make('admin123'), // Use uma senha simples para teste
        ]);
        $adminUser->roles()->attach($adminRole);

        // 3. Criar um usuário Criador de Conteúdo
        $creatorUser = User::factory()->create([
            'public_id' => uuid_create(),
            'name' => 'Criador Exemplo',
            'email' => 'criador@lumenif.com',
            'password' => Hash::make('criador123'),
        ]);
        $creatorUser->roles()->attach($creatorRole);

        // 4. Criar 10 usuários Alunos com dados fakes
        User::factory(10)->create()->each(function ($user) use ($alunoRole) {
            $user->roles()->attach($alunoRole);
        });
    }
}
