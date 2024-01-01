<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Student::all();
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
            "dni" => "required",
            "name" => "required",
            "lastname" => "required",
            "sex" => "required",
            "instruction" => "required",
            "address" => "required",
            "email" => "required",
            "cellphone" => "required",
            "phone" => "required",
            "description" => "required",
            "entity_name" => "required",
            "entity_post" => "required",
            "entity_address" => "required",
            "entity_phone" => "required"
        ];

        $validator = FacadesValidator::make($request->all(), $rules);
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
    public function show(Student $student)
    {
        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "data" => $student
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
        $rules = [
            "dni" => "required",
            "name" => "required",
            "lastname" => "required",
            "sex" => "required",
            "instruction" => "required",
            "address" => "required",
            "email" => "required",
            "cellphone" => "required",
            "phone" => "required",
            "description" => "required",
            "entity_name" => "required",
            "entity_post" => "required",
            "entity_address" => "required",
            "entity_phone" => "required"
        ];

        $validator = FacadesValidator::make($request->all(), $rules);
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
        $student->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "data" => $student
        ]);
    }
}
