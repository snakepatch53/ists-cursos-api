<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Inscription::with('student', 'course')->get();
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
    public function show(Inscription $inscription)
    {
        $inscription->load('student', 'course');
        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "data" => $inscription
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
