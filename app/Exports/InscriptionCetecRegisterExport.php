<?php

namespace App\Exports;

use App\Models\Course;
use App\Models\Inscription;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class InscriptionCetecRegisterExport implements FromView, WithDrawings
{
    use Exportable;

    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $course = Course::find($this->id);
        if (!$course) abort(404);
        $inscriptions = Inscription::where('course_id', $this->id)->get();
        // load students
        $inscriptions->load('student');
        return view('inscriptionCetecRegisterExport', [
            'course' => $course,
            'inscriptions' => $inscriptions
        ]);
    }

    public function drawings()
    {
        // Crear un objeto Drawing para la imagen
        $logo_senecyt = new Drawing();
        $logo_senecyt->setName('logo_senecyt');
        $logo_senecyt->setDescription('logo_senecyt');
        $logo_senecyt->setPath(public_path('img/senecyt.png')); // Ruta de la imagen
        $logo_senecyt->setHeight(130); // Altura de la imagen
        $logo_senecyt->setCoordinates('A1'); // Coordenadas en las que se insertará

        $logo_ists = new Drawing();
        $logo_ists->setDescription('logo_ists');
        $logo_ists->setName('logo_ists');
        $logo_ists->setPath(public_path('img/logo.png')); // Ruta de la imagen
        $logo_ists->setHeight(130); // Altura de la imagen
        $logo_ists->setCoordinates('M1'); // Coordenadas en las que se insertará


        return [$logo_senecyt, $logo_ists];
    }
}
