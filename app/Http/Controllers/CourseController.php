<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    private $IMAGE_PATH = "public/img_courses";
    private $IMAGE_TYPE = "jpg,jpeg,png";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $includes = [];
        if ($request->query('includeTeacher')) $includes[] = 'teacher';
        if ($request->query('includeResponsible')) $includes[] = 'responsible';
        if ($request->query('includeTemplate')) $includes[] = 'template';
        if ($request->query('includeInscriptions')) $includes[] = 'inscriptions';

        $data = Course::with($includes)->get();
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
            "name" => "required",
            "duration" => "required",
            "date_start" => "required",
            "date_end" => "required",
            "quota" => "required",
            "whatsapp" => "required",
            "teacher_id" => "required",
            "responsible_id" => "required",
            "template_id" => "required",
            "image" => "required|file|mimes:" . $this->IMAGE_TYPE
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

        $data = Course::create($request->except("image") + ["image" => $fileName]);

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "data" => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Course $course)
    {
        $includes = [];
        if ($request->query('includeTeacher')) $includes[] = 'teacher';
        if ($request->query('includeResponsible')) $includes[] = 'responsible';
        if ($request->query('includeTemplate')) $includes[] = 'template';
        if ($request->query('includeInscriptions')) $includes[] = 'inscriptions';

        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "data" => $course->load($includes)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $rules = [
            "name" => "required",
            "duration" => "required",
            "date_start" => "required",
            "date_end" => "required",
            "quota" => "required",
            "whatsapp" => "required",
            "teacher_id" => "required",
            "responsible_id" => "required",
            "template_id" => "required"
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        $course->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "data" => $course
        ]);
    }

    public function updateWithImage(Request $request, $id)
    {
        $rules = [
            "name" => "required",
            "duration" => "required",
            "date_start" => "required",
            "date_end" => "required",
            "quota" => "required",
            "whatsapp" => "required",
            "teacher_id" => "required",
            "responsible_id" => "required",
            "template_id" => "required"
        ];

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

        $image = Course::find($id);
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
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        // eliminamos tambien el archivo
        Storage::delete($this->IMAGE_PATH . "/" . $course->image);

        $course->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "data" => $course
        ]);
    }
}
