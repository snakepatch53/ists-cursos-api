<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private $PHOTO_PATH = "public/img_users";
    private $SIGNATURE_PATH = "public/img_signature";
    private $IMAGE_TYPE = "jpg,jpeg,png";


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            "password" => "required"
        ], [
            "username.required" => "El campo username es requerido y debe ser el email o el dni",
            "password.required" => "El campo password es requerido"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        // en usuario puede ser el email o el dni, por lo tanto en attempt validamos en ambos campos

        if (!Auth::attempt(['email' => $request->username, 'password' => $request->password]) && !Auth::attempt(['dni' => $request->username, 'password' => $request->password])) {
            return response()->json([
                "success" => false,
                "message" => "Credenciales incorrectas",
                "errors" => null,
                "data" => null
            ]);
        }

        $user = User::where('email', $request->username)->orWhere('dni', $request->username)->first();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "Sesión iniciada",
            "errors" => null,
            "data" => $user,
            "token" => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "success" => true,
            "message" => "Sesión cerrada",
            "errors" => null,
            "data" => null
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $includes = [];
        if ($request->query('includeCoursesTeacher')) $includes[] = 'courseTeacher';
        if ($request->query('includeCoursesResponsible')) $includes[] = 'courseResponsible';

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
        $validator = Validator::make($request->all(),  [
            "name" => "required",
            "lastname" => "required",
            "dni" => "required|unique:users,dni",
            "email" => "required|email|unique:users,email",
            "password" => "required",
            "role" => "required|in:" . implode(",", User::$_ROLES),
            "photo" => "required|file|mimes:" . $this->IMAGE_TYPE,
            "signature" => "required|file|mimes:" . $this->IMAGE_TYPE
        ], [
            "name.required" => "El campo nombre es requerido",
            "lastname.required" => "El campo apellido es requerido",
            "dni.required" => "El campo dni es requerido",
            "dni.unique" => "El dni ya existe",
            "email.required" => "El campo email es requerido",
            "email.email" => "El campo email no es valido",
            "email.unique" => "El email ya existe",
            "password.required" => "El campo password es requerido",
            "role.required" => "El campo rol es requerido",
            "role.in" => "El campo rol debe ser uno de los siguientes valores: " . implode(", ", User::$_ROLES),
            "photo.required" => "El campo foto es requerido",
            "photo.file" => "El campo foto debe ser un archivo",
            "signature.required" => "El campo firma es requerido",
            "signature.file" => "El campo firma debe ser un archivo",
            "photo.mimes" => "El campo foto debe ser un archivo de tipo: " . $this->IMAGE_TYPE,
            "signature.mimes" => "El campo firma debe ser un archivo de tipo: " . $this->IMAGE_TYPE
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }


        $fileName_photo = basename($request->file("photo")->store($this->PHOTO_PATH));
        $fileName_signature = basename($request->file("signature")->store($this->SIGNATURE_PATH));

        if ($request->password) $request->merge(["password" => Hash::make($request->password)]);
        $data = User::create($request->except(["photo", "signature"]) + ["photo" => $fileName_photo, "signature" => $fileName_signature]);

        $token = $data->createToken('authToken')->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => $data,
            "token" => $token,
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $includes = [];
        if ($request->query('includeCoursesTeacher')) $includes[] = 'courseTeacher';
        if ($request->query('includeCoursesResponsible')) $includes[] = 'courseResponsible';

        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "errors" => null,
            "data" => $user->load($includes),
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
            "role" => "required|in:" . implode(",", User::$_ROLES),
        ];

        $validator = Validator::make($request->all(), $rules, [
            "name.required" => "El campo nombre es requerido",
            "lastname.required" => "El campo apellido es requerido",
            "dni.required" => "El campo dni es requerido",
            "email.required" => "El campo email es requerido",
            "role.required" => "El campo rol es requerido",
            "role.in" => "El campo rol debe ser uno de los siguientes valores: " . implode(", ", User::$_ROLES),
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        if ($request->password) $request->merge(["password" => Hash::make($request->password)]);

        $user->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "data" => $user,
            "token" => null
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
            'dni' => 'required|unique:users,dni,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            "role" => "required|in:" . implode(",", User::$_ROLES),
        ];

        $exists_photo = $request->hasFile("photo");
        if ($exists_photo) $rules["photo"] = "required|file|mimes:" . $this->IMAGE_TYPE;

        $exists_signature = $request->hasFile("signature");
        if ($exists_signature) $rules["signature"] = "required|file|mimes:" . $this->IMAGE_TYPE;

        $validator = Validator::make($request->all(), $rules, [
            "name.required" => "El campo nombre es requerido",
            "lastname.required" => "El campo apellido es requerido",
            "dni.required" => "El campo dni es requerido",
            "dni.unique" => "El dni ya existe",
            "email.required" => "El campo email es requerido",
            "email.email" => "El campo email no es valido",
            "email.unique" => "El email ya existe",
            "role.required" => "El campo rol es requerido",
            "role.in" => "El campo rol debe ser uno de los siguientes valores: " . implode(", ", User::$_ROLES),
            "photo.required" => "El campo foto es requerido",
            "photo.file" => "El campo foto debe ser un archivo",
            "signature.required" => "El campo firma es requerido",
            "signature.file" => "El campo firma debe ser un archivo",
            "photo.mimes" => "El campo foto debe ser un archivo de tipo: " . $this->IMAGE_TYPE,
            "signature.mimes" => "El campo firma debe ser un archivo de tipo: " . $this->IMAGE_TYPE
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
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

        if ($request->password) $request->merge(["password" => Hash::make($request->password)]);
        $user->update($request->except($except) + $field_file);

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $user,
            "token" => null
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
            "errors" => null,
            "data" => $user
        ]);
    }
}
