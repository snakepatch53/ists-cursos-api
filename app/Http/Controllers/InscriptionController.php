<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Inscription;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class InscriptionController extends Controller
{

    // WEB ROUTE
    public function certificate(Request $request, $id)
    {
        $inscription = Inscription::find($id);
        if (!$inscription) return abort(404);
        if ($inscription->state != "Aprobado") return abort(404);
        $inscription->load("student", "course");

        $student = $inscription->student;
        $course = $inscription->course;

        function replaceVariables($content, $data, $parentKey = null)
        {
            foreach ($data as $key => $value) {
                $currentKey = $parentKey ? "{$parentKey}.{$key}" : $key;

                if (is_array($value)) {
                    $content = replaceVariables($content, $value, $currentKey);
                } else {
                    $variable = "{{" . $currentKey . "}}";
                    $content = str_replace($variable, $value, $content);
                }
            }

            return $content;
        }
        // inlude tempalte for template_id
        $code = $course->template->code;
        // var_dump($code);
        $code = replaceVariables($code, $inscription->toArray());
        $data = [
            'student' => $student,
            'course' => $course,
            'inscription' => $inscription,
            'code' => $code
        ];
        return Pdf::loadView('certificate', $data)
            ->setPaper('a4', 'landscape')
            ->stream('archivo.pdf');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $includes = [];
        if ($request->query('includeStudent')) $includes[] = 'student';
        if ($request->query('includeCourse')) $includes[] = 'course';

        $data = Inscription::with($includes)->get();
        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "certificate_code" => "required",
            "student_id" => "required",
            "course_id" => "required",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        $errors = [];

        //validaciones del estudiante
        $student = Student::find($request->student_id);
        if (!$student) $errors[] = "El estudiante no existe";

        //validaciones del curso
        $course = Course::find($request->course_id);
        if (!$course) {
            $errors[] = "El curso no existe";
        } else if ($course->date_end < date("Y-m-d")) {
            $errors[] = "El curso ya finalizo";
        } else if ($course->quota <= count($course->inscriptions)) {
            $errors[] = "El curso ya no tiene cupos";
        }

        //validaciones de la inscripcion
        $inscription = Inscription::where("student_id", $request->student_id)->where("course_id", $request->course_id)->first();
        if ($inscription) $errors[] = "El estudiante ya esta inscrito en el curso";

        // si hay errores
        if (count($errors) > 0) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $errors),
                "data" => $errors
            ]);
        }

        // desaprobado siempre al crear
        $request->merge(["approval" => false]);

        $data = Inscription::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "data" => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inscription  $inscription
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Inscription $inscription)
    {
        $includes = [];
        if ($request->query('includeStudent')) $includes[] = 'student';
        if ($request->query('includeCourse')) $includes[] = 'course';

        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "data" => $inscription->load($includes)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inscription  $inscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscription $inscription)
    {
        $rules = [
            "approval" => "required",
            "certificate_code" => "required",
            "student_id" => "required",
            "course_id" => "required",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        $errors = [];

        //validaciones del estudiante
        $student = Student::find($request->student_id);
        if (!$student) $errors[] = "El estudiante no existe";

        //validaciones del curso
        $course = Course::find($request->course_id);
        if (!$course) {
            $errors[] = "El curso no existe";
        } else if ($course->date_end < date("Y-m-d")) {
            $errors[] = "El curso ya finalizo";
        } else if ($course->quota <= count($course->inscriptions)) {
            $errors[] = "El curso ya no tiene cupos";
        }

        //validaciones de la inscripcion sin contar la misma
        $inscription_ = Inscription::where("student_id", $request->student_id)->where("course_id", $request->course_id)->where("id", "!=", $inscription->id)->first();
        if ($inscription_) $errors[] = "El estudiante ya esta inscrito en el curso";


        $inscription->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "data" => $inscription
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscription  $inscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscription $inscription)
    {
        $inscription->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "data" => $inscription
        ]);
    }
}
