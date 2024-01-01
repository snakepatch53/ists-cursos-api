<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComboController extends Controller
{

    public function enroll_registerStudentOrNot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "course_id" => "required|exists:courses,id",
            'student.dni' => 'required',
            "student.name" => "required",
            "student.lastname" => "required",
            "student.sex" => "required|in:Masculino,Femenino,Otro",
            "student.instruction" => "required|in:Primaria,Secundaria,Técnico,Superior",
            "student.address" => "required",
            "student.email" => "required|email",
            "student.cellphone" => "required",
            "student.phone" => "nullable",
            "student.description" => "required",
            "student.entity_name" => "required",
            "student.entity_post" => "required",
            "student.entity_address" => "required",
            "student.entity_phone" => "required"

        ], [
            'course_id.required' => 'El curso es requerido',
            'course_id.exists' => 'El curso no existe',
            'student.dni.required' => 'El DNI del estudiante es requerido',
            'student.name.required' => 'El nombre del estudiante es requerido',
            'student.lastname.required' => 'El apellido del estudiante es requerido',
            'student.sex.required' => 'El sexo del estudiante es requerido',
            'student.sex.in' => 'El sexo debe ser Masculino, Femenino u Otro',
            'student.instruction.required' => 'La instrucción del estudiante es requerida',
            'student.instruction.in' => 'La instrucción debe ser Primaria, Secundaria, Técnico o Superior',
            'student.address.required' => 'La dirección del estudiante es requerida',
            'student.email.required' => 'El correo del estudiante es requerido',
            'student.email.email' => 'El correo del estudiante no es válido',
            'student.cellphone.required' => 'El celular del estudiante es requerido',
            'student.description.required' => 'La descripción del estudiante es requerida',
            'student.entity_name.required' => 'El nombre de la entidad del estudiante es requerido',
            'student.entity_post.required' => 'El cargo de la entidad del estudiante es requerido',
            'student.entity_address.required' => 'La dirección de la entidad del estudiante es requerida',
            'student.entity_phone.required' => 'El teléfono de la entidad del estudiante es requerido'
        ]);

        if ($validator->fails()) return response()->json([
            "success" => false,
            "message" => $validator->errors()->first(),
            "errors" => $validator->errors(),
            "data" => null
        ]);

        // validamos si el estudiante existe
        $student = Student::where("dni", $request->student["dni"])->first();
        if (!$student) $student = Student::create($request->student);
        else $student->update($request->student);

        // validamos que el estudiante no este inscrito en el curso a traves del dni
        $inscription = Inscription::where("course_id", $request->course_id)
            ->whereHas("student", function ($query) use ($request) {
                $query->where("dni", $request->student["dni"]);
            })->first();

        if ($inscription) return response()->json([
            "success" => false,
            "message" => "El estudiante ya se encuentra inscrito en el curso",
            "errors" => ["dni" => ["El estudiante ya se encuentra inscrito en el curso"]],
            "data" => null
        ]);

        // una vez validado el estudiante y que no este inscrito en el curso, lo inscribimos

        $inscription = Inscription::create([
            "certificate_code" => "",
            "student_id" => $student->id,
            "course_id" => $request->course_id,
            "approval" => false
        ]);

        return response()->json([
            "success" => true,
            "message" => "Estudiante inscrito correctamente",
            "errors" => null,
            "data" => $inscription
        ]);
    }
}