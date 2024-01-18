<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Template::factory()->count(5)->create();
        DB::table('templates')->insert([
            'name' => '2024 - 2025',
            'code' => '
                <img src="{{fondo_certificado1}}" class="fixed inset-0 -top-3" style="transform:scale(1.08)"/>
                <div class="relative">
                    <div class="mt-80" />
                    <div class="mt-7" />
                    <h3 class="font-arial font-bold text-center text-4xl uppercase opacity-90">{{student.name}} {{student.lastname}}</h3>
                    <div class="mt-4" />
                        <p class="font-arial text-justify px-12 leading-6 opacity-85" style="font-size:1.45rem"> Por haber aprobado el curso de: <b>{{course.name}}</b>, dictado por el {{teacher.name}} {{teacher.lastname}}, en la ciudad de Sucúa, desde el 12 de junio al 23 de julio del 2023, con una  duración de <b>{{course.duration}} horas académicas</b>. </p>
                    <div class="mt-48" />
                    <b class="pl-24 ml-3 font-arial text-lg capitalize opacity-60">{{course.date_end_str}}</span>
                </div>
            ',
        ]);
    }
}
