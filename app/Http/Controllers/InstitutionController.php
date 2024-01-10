<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InstitutionController extends Controller
{
    private $LOGO_PATH = "public/img_institutions";
    private $LOGO_TYPE = "jpg,jpeg,png";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Institution::all();
        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "errors" => null,
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
            "name" => "required",
            "initials" => "required",
            "logo" => "required|file|mimes:" . $this->LOGO_TYPE,
            "url" => "required"
        ], [
            "required" => "El campo :attribute es requerido",
            "mimes" => "El campo :attribute debe ser un archivo de tipo: " . $this->LOGO_TYPE,
            "file" => "El campo :attribute debe ser un archivo"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $fileName = basename($request->file("logo")->store($this->LOGO_PATH));

        $data = Institution::create($request->except("logo") + ["logo" => $fileName]);

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function show(Institution $institution)
    {
        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "errors" => null,
            "data" => $institution
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Institution $institution)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "initials" => "required",
            "url" => "required"
        ], [
            "required" => "El campo :attribute es requerido"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $institution->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "data" => $institution
        ]);
    }

    public function updateWithLogo(Request $request, $id)
    {
        $institution = Institution::find($id);
        if (!$institution) {
            return response()->json([
                "success" => false,
                "message" => "Recurso no encontrado",
                "errors" => ["id" => ["El id no existe"]],
                "data" => null
            ]);
        }


        $rules = [
            "name" => "required",
            "initials" => "required",
            "url" => "required"
        ];

        // valida si existe el archivo
        $exists_logo = $request->hasFile("logo");
        if ($exists_logo) $rules["logo"] = "required|file|mimes:" . $this->LOGO_TYPE;

        //siempre queda igual
        $validator = Validator::make($request->all(), $rules, [
            "required" => "El campo :attribute es requerido",
            "mimes" => "El campo :attribute debe ser un archivo de tipo: " . $this->LOGO_TYPE,
            "file" => "El campo :attribute debe ser un archivo"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        // eliminamos el archivo anterior
        if ($exists_logo) {
            if (Storage::exists($this->LOGO_PATH . "/" . $institution->logo)) Storage::delete($this->LOGO_PATH . "/" . $institution->logo);
            $fileName = basename($request->file("logo")->store($this->LOGO_PATH));
            $institution->update($request->except("logo") + ["logo" => $fileName]);
        } else {
            $institution->update($request->all());
        }


        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $institution
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institution $institution)
    {
        // eliminamos tambien el archivo
        Storage::delete($this->LOGO_PATH . "/" . $institution->logo);

        $institution->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "data" => $institution
        ]);
    }
}
