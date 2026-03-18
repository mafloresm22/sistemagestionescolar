<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Configuraciones;
use App\Models\Turnos;
use App\Models\Niveles;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        User::create([
            'name' => 'mafloresm01',
            'email' => 'mathiasfabricio22f@gmail.com',
            'password' => Hash::make('mathias123'),
        ])->assignRole('ADMINISTRADOR');

        Configuraciones::create([
            'nombreConfiguraciones' => 'I.E. ANTENOR ORREGO ESPINOZA',
            'descripcionConfiguraciones' => 'Escuela publica Institución educativa Antenor Orrego Espinoza',
            'correoInstitucionalConfiguraciones' => 'AntenorOrrego@gmail.com',
            'telefonoConfiguraciones' => '580844',
            'divisaConfiguraciones' => 'S/.',
            'direccionConfiguraciones' => 'AV.ANTENOR ORREGO',
            'logoConfiguraciones' => 'uploads/logos/1770742357_unnamed.jpg',
            'webConfiguraciones' => 'www.AntenorOrrego.com',
        ]);

        Turnos::create(['nombreTurno' => 'MAÑANA']);
        Turnos::create(['nombreTurno' => 'TARDE']);
        Turnos::create(['nombreTurno' => 'NOCHE']);

        Niveles::create(['nombreNivel' => 'INICIAL']);
        Niveles::create(['nombreNivel' => 'PRIMARIA']);
        Niveles::create(['nombreNivel' => 'SECUNDARIA']);
    }
}
