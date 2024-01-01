<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $PHOTO_PATH = "public/img_users";
    private $SIGNATURE_PATH = "public/img_signature";
    private $IMAGE_TYPE = "jpg,jpeg,png";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $includes = [];
        if ($request->query('includeTeacher')) $includes[] = 'courseTeacher';
        if ($request->query('includeResponsible')) $includes[] = 'courseResponsible';

        $data = User::with($includes)->get();
        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "name" => "required",
            "lastname" => "required",
            "dni" => "required",
            "email" => "required",
            "password" => "required",
            "photo" => "required|file|mimes:" . $this->IMAGE_TYPE,
            "signature" => "required|file|mimes:" . $this->IMAGE_TYPE
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        // exist user with email or dni
        if (User::where("email", $request->email)->orWhere("dni", $request->dni)->first()) {
            return response()->json([
                "success" => false,
                "message" => "El email o dni ya existe",
                "data" => null
            ]);
        }


        $fileName_photo = basename($request->file("photo")->store($this->PHOTO_PATH));
        $fileName_signature = basename($request->file("signature")->store($this->SIGNATURE_PATH));

        $data = User::create($request->except(["photo", "signature"]) + ["photo" => $fileName_photo, "signature" => $fileName_signature]);

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "data" => $data
        ]);
    }

    public function updateWithImages(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "Recurso no encontrado",
                "data" => null
            ]);
        }

        $rules = [
            "name" => "required",
            "lastname" => "required",
            "dni" => "required",
            "email" => "required",
            "password" => "required"
        ];

        $exists_photo = $request->hasFile("photo");
        if ($exists_photo) $rules["photo"] = "required|file|mimes:" . $this->IMAGE_TYPE;

        $exists_signature = $request->hasFile("signature");
        if ($exists_signature) $rules["signature"] = "required|file|mimes:" . $this->IMAGE_TYPE;

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        $except = [];
        $field_file = [];

        // eliminamos el archivo anterior
        if ($exists_photo) {
            if (Storage::exists($this->PHOTO_PATH . "/" . $user->photo)) Storage::delete($this->PHOTO_PATH . "/" . $user->photo);
            $fileName = basename($request->file("photo")->store($this->PHOTO_PATH));
            $except[] = "photo";
            $field_file["photo"] = $fileName;
        }

        if ($exists_signature) {
            if (Storage::exists($this->SIGNATURE_PATH . "/" . $user->signature)) Storage::delete($this->SIGNATURE_PATH . "/" . $user->signature);
            $fileName = basename($request->file("signature")->store($this->SIGNATURE_PATH));
            $except[] = "signature";
            $field_file["signature"] = $fileName;
        }

        $user->update($request->except($except) + $field_file);

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "data" => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "data" => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            "name" => "required",
            "lastname" => "required",
            "dni" => "required",
            "email" => "required",
            "password" => "required"
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        $user->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "data" => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->load(['courseTeacher', 'courseResponsible']);
        if ($user->courseTeacher->count() > 0 || $user->courseResponsible->count() > 0) {
            return response()->json([
                "success" => false,
                "message" => "No se puede eliminar el recurso, tiene cursos asociados",
                "data" => null
            ]);
        }

        // eliminamos tambien el archivo
        Storage::delete($this->PHOTO_PATH . "/" . $user->photo);
        Storage::delete($this->SIGNATURE_PATH . "/" . $user->signature);

        $user->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "data" => $user
        ]);
    }
}
