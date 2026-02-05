<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Administrador',
            'description' => 'Acceso total al sistema',
        ]);

        Role::create([
            'name' => 'Evaluador',
            'description' => 'Realiza evaluaciones ergonómicas',
        ]);

        Role::create([
            'name' => 'Experto',
            'description' => 'Analiza y valida evaluaciones',
        ]);

        Role::create([
            'name' => 'Cliente',
            'description' => 'Solo puede ver sus evaluaciones',
        ]);
    }
}
