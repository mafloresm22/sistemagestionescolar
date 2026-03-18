<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'ADMINISTRADOR']);
        Role::create(['name' => 'DIRECTORA/O GENERAL']);
        Role::create(['name' => 'DIRECTORA/O ACADEMICO']);
        Role::create(['name' => 'DIRECTORA/O ADMINISTRATIVO']);
        Role::create(['name' => 'SECRETARIA/O']);
        Role::create(['name' => 'DOCENTE']);
        Role::create(['name' => 'ESTUDIANTE']);
        Role::create(['name' => 'CAJERA/O']);
    }
}
