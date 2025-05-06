<?php
namespace Database\Seeders;

use App\Models\Candidato;
use Illuminate\Database\Seeder;

class CandidatosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default roles
        $candidatos = [
            [
                'DNI' => '12345678A',
                'nombre' => 'Juan',
                'apellidos' => 'Pérez',
                'fecha_nacimiento' => '1990-01-01',
                'javascript' => true,
                'php' => false,
                'html' => true,
                'css' => false,
                'curriculum' => 'ejemplo.pdf',
            ],
            [
                'DNI' => '87654321B',
                'nombre' => 'María',
                'apellidos' => 'Gómez',
                'fecha_nacimiento' => '1992-02-02',
                'javascript' => false,
                'php' => true,
                'html' => true,
                'css' => true,
                'curriculum' => 'ejemplo.pdf',
            ],
            [
                'DNI' => '11223344C',
                'nombre' => 'Pedro',
                'apellidos' => 'López',
                'fecha_nacimiento' => '1988-03-03',
                'javascript' => true,
                'php' => true,
                'html' => false,
                'css' => true,
                'curriculum' => 'ejemplo.pdf',
            ],
            [
                'DNI' => '55667788D',
                'nombre' => 'Ana',
                'apellidos' => 'Martínez',
                'fecha_nacimiento' => '1995-04-04',
                'javascript' => false,
                'php' => false,
                'html' => true,
                'css' => true,
                'curriculum' => 'ejemplo.pdf',
            ],
        ];
        
        foreach ($candidatos as $candidato) {
            Candidato::create($candidato);
        }
    }
}
