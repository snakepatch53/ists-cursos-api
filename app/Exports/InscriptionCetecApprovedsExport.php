<?php

namespace App\Exports;

use App\Models\Course;
use App\Models\Inscription;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class InscriptionCetecApprovedsExport implements FromView, WithDrawings
{
    use Exportable;

    private $course_id;

    public function __construct($course_id)
    {
        $this->course_id = $course_id;
    }

    public function view(): View
    {
        $course_id = $this->course_id;
        $course = Course::find($course_id);
        if (!$course) abort(404);
        //load teacher
        $teacher = $course->load('teacher');
        // load if state is inscrito
        $inscriptions = Inscription::where('course_id', $course_id)->where('state', 'Inscrito')->get();
        // load students
        $inscriptions->load('student');
        // total aproveds
        $total_aproveds = $inscriptions->count();
        // total desaproveds
        $total_desaproveds = Inscription::where('course_id', $course_id)->where('state', 'Reprobado')->count();
        return view('inscriptionCetecApprovedsExport', [
            'course' => $course,
            'inscriptions' => $inscriptions,
            'teacher' => $teacher,
            'total_aproveds' => $total_aproveds,
            'total_desaproveds' => $total_desaproveds,
            'total_inscriptions' => $total_aproveds + $total_desaproveds
        ]);
    }

    public function drawings()
    {
        $logo_ists = new Drawing();
        $logo_ists->setDescription('logo_ists');
        $logo_ists->setName('logo_ists');
        $logo_ists->setPath(public_path('img/logo.png')); // Ruta de la imagen
        $logo_ists->setHeight(45); // Altura de la imagen
        $logo_ists->setCoordinates('D6'); // Coordenadas en las que se insertará


        return [$logo_ists];
    }
}
