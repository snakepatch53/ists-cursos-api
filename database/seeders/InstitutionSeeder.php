<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Institution::factory()->count(5)->create();
        DB::table('institutions')->insert([
            "name" => "Instituto Superior Tecnológico Sucúa",
            "initials" => "ISTS",
            "logo" => "1.png",
            "url" => "https://www.istsucua.edu.ec/"
        ]);
        DB::table('institutions')->insert([
            "name" => "Secretaria de Educación Superior, Ciencia, Tecnología e Innovación",
            "initials" => "SENESCYT",
            "logo" => "2.png",
            "url" => "https://www.educacionsuperior.gob.ec/"
        ]);
        DB::table('institutions')->insert([
            "name" => "Centro de Tecnología de Entretenimiento y Capacitación Profesional",
            "initials" => "CETEC",
            "logo" => "3.png",
            "url" => "https://www.educacionsuperior.gob.ec/"
        ]);
    }
}
