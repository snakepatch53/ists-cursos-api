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
            "course_id" => "required",
            "student_id" => "required|unique:inscriptions,student_id,NULL,id,course_id," . $request->input('course_id'),
            "student.dni" => "required",
            "student.name" => "required",
            "student.lastname" => "required",
            "student.sex" => "required",
            "student.instruction" => "required",
            "student.address" => "required",
            "student.email" => "required|email",
            "student.cellphone" => "required",
            "student.phone" => "required",
            "student.description" => "required",
            "student.entity_name" => "required",
            "student.entity_post" => "required",
            "student.entity_address" => "required",
            "student.entity_phone" => "required"

        ], [
            'certificate_code.unique' => 'El código de certificado ya existe',
            'course_id.required' => 'El curso es requerido',
            'student_id.required' => 'El id del estudiante es requerido',
            'student_id.unique' => 'El estudiante ya está inscrito en este curso',
            'student.name.required' => 'El nombre del estudiante es requerido',
            'student.lastname.required' => 'El apellido del estudiante es requerido',
            'student.instruction.required' => 'La instrucción del estudiante es requerida',
            'student.address.required' => 'La dirección del estudiante es requerida',
            'student.email.required' => 'El correo del estudiante es requerido',
            'student.email.email' => 'El correo del estudiante no es válido',
            'student.cellphone.required' => 'El celular del estudiante es requerido',
            'student.phone.required' => 'El teléfono del estudiante es requerido',
            'student.description.required' => 'La descripción del estudiante es requerida',
            'student.entity_name.required' => 'El nombre de la entidad del estudiante es requerido',
            'student.entity_post.required' => 'El cargo de la entidad del estudiante es requerido',
            'student.entity_address.required' => 'La dirección de la entidad del estudiante es requerida',
            'student.entity_phone.required' => 'El teléfono de la entidad del estudiante es requerido'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        //si existe el estudiante se actualiza sino se crea
        $action = "created";
        $student_id = $request->student_id;
        $student = Student::find($student_id);
        $request->merge(["certificate_code" => ""]);
        if (!$student) {
            // validar que el dni no exista
            $student = Student::where("dni", $request->student["dni"])->first();
            if ($student) {
                return response()->json([
                    "success" => false,
                    "message" => "El DNI ya existe",
                    "errors" => ["dni" => ["El DNI ya existe"]],
                    "data" => null
                ]);
            }
            $student_id = Student::create($request->student)->id;
        } else {
            $student->update($request->student);
            $action = "updated";
        }

        //se crea la inscripcion
        $request->merge(["student_id" => $student_id]);
        $request->merge(["approval" => false]);
        $data = Inscription::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "data" => $data,
            "action_student" => $action
        ]);
    }
}
