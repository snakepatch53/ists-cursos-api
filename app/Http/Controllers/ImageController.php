<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{

    private $IMAGE_PATH = "public/img_images";
    private $IMAGE_TYPE = "jpg,jpeg,png";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Image::all();
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
            "image" => "required|file|mimes:" . $this->IMAGE_TYPE,
            "description" => "required"
        ];



        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        $fileName = basename($request->file("image")->store($this->IMAGE_PATH));

        $data = Image::create($request->except("image") + ["image" => $fileName]);

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "data" => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "data" => $image
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $rules = ["description" => "required"];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        $image->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "data" => $image
        ]);
    }

    public function updateWithImage(Request $request, $id)
    {
        $rules = ["description" => "required"];

        $exists_image = $request->hasFile("image");
        if ($exists_image) $rules["image"] = "required|file|mimes:" . $this->IMAGE_TYPE;

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        $image = Image::find($id);
        if (!$image) {
            return response()->json([
                "success" => false,
                "message" => "Recurso no encontrado",
                "data" => null
            ]);
        }

        // eliminamos el archivo anterior
        if ($exists_image) {
            if (Storage::exists($this->IMAGE_PATH . "/" . $image->image)) Storage::delete($this->IMAGE_PATH . "/" . $image->image);
            $fileName = basename($request->file("image")->store($this->IMAGE_PATH));
            $image->update($request->except("image") + ["image" => $fileName]);
        } else {
            $image->update($request->all());
        }


        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "data" => $image
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        // eliminamos tambien el archivo
        Storage::delete($this->IMAGE_PATH . "/" . $image->image);

        $image->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "data" => $image
        ]);
    }
}
