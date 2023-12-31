<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $includes = [];
        if ($request->query('includeInscriptions')) $includes[] = 'inscriptions';
        $data = Student::with($includes)->get();

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
        $validator = Validator::make($request->all(), [
            "dni" => "required",
            "name" => "required",
            "lastname" => "required",
            "sex" => "required|in:" . implode(",", Student::$_SEXS),
            "instruction" => "required|in:" . implode(",", Student::$_INSTRUCTIONS),
            "address" => "required",
            "email" => "required",
            "cellphone" => "required",
            "phone" => "required",
            "description" => "required",
            "entity_name" => "required",
            "entity_post" => "required",
            "entity_address" => "required",
            "entity_phone" => "required"
        ], [
            "required" => "El campo :attribute es requerido",
            "sex.in" => "El campo sex debe ser uno de los siguientes valores: " . implode(",", Student::$_SEXS),
            "instruction.in" => "El campo instruction debe ser uno de los siguientes valores: " . implode(",", Student::$_INSTRUCTIONS),
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }


        $data = Student::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "data" => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Student $student)
    {
        $includes = [];
        if ($request->query('includeInscriptions')) $includes[] = 'inscriptions';
        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "data" => $student->load($includes)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            "dni" => "required",
            "name" => "required",
            "lastname" => "required",
            "sex" => "required|in:" . implode(",", Student::$_SEXS),
            "instruction" => "required|in:" . implode(",", Student::$_INSTRUCTIONS),
            "address" => "required",
            "email" => "required",
            "cellphone" => "required",
            "phone" => "required",
            "description" => "required",
            "entity_name" => "required",
            "entity_post" => "required",
            "entity_address" => "required",
            "entity_phone" => "required"
        ], [
            "required" => "El campo :attribute es requerido",
            "sex.in" => "El campo sex debe ser uno de los siguientes valores: " . implode(",", Student::$_SEXS),
            "instruction.in" => "El campo instruction debe ser uno de los siguientes valores: " . implode(",", Student::$_INSTRUCTIONS),
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        $student->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "data" => $student
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->load('inscriptions');
        if ($student->inscriptions->count() > 0) {
            return response()->json([
                "success" => false,
                "message" => "No se puede eliminar el estudiante porque tiene inscripciones asociadas",
                "data" => $student
            ]);
        }

        $student->delete();
        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "data" => $student
        ]);
    }
}
