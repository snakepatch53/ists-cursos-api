<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Template;
use App\Models\User;
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
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "duration" => "required",
            "date_start" => "required",
            "date_end" => "required",
            "quota" => "required",
            "whatsapp" => "required",
            "description" => "required",
            'teacher_id' => 'required|exists:users,id',
            'responsible_id' => 'required|exists:users,id',
            'template_id' => 'required|exists:templates,id',
            "image" => "required|file|mimes:" . $this->IMAGE_TYPE
        ], [
            'name.required' => 'El nombre es requerido',
            'duration.required' => 'La duración es requerida',
            'date_start.required' => 'La fecha de inicio es requerida',
            'date_end.required' => 'La fecha de fin es requerida',
            'quota.required' => 'El numero de cupos es requerido',
            'whatsapp.required' => 'El link de grupo de whatsapp es requerido',
            'description.required' => 'La descripción es requerida',
            'teacher_id.required' => 'El docente es requerido',
            'responsible_id.required' => 'El responsable es requerido',
            'template_id.required' => 'La plantilla es requerida',
            'teacher_id.exists' => 'El docente no existe',
            'responsible_id.exists' => 'El responsable no existe',
            'template_id.exists' => 'La plantilla no existe',
            'image.required' => 'La imagen es requerida',
            'image.file' => 'La imagen debe ser un archivo',
            'image.mimes' => 'La imagen debe ser de tipo ' . $this->IMAGE_TYPE
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                'errors' => $validator->errors(),
                "data" => null
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
            'errors' => null,
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
        $validator = Validator::make(
            $request->all(),
            [
                "name" => "required",
                "duration" => "required",
                "date_start" => "required",
                "date_end" => "required",
                "quota" => "required",
                "whatsapp" => "required",
                "description" => "required",
                'teacher_id' => 'required|exists:users,id',
                'responsible_id' => 'required|exists:users,id',
                'template_id' => 'required|exists:templates,id',
            ],
            [
                'name.required' => 'El nombre es requerido',
                'duration.required' => 'La duración es requerida',
                'date_start.required' => 'La fecha de inicio es requerida',
                'date_end.required' => 'La fecha de fin es requerida',
                'quota.required' => 'El numero de cupos es requerido',
                'whatsapp.required' => 'El link de grupo de whatsapp es requerido',
                'description.required' => 'La descripción es requerida',
                'teacher_id.required' => 'El docente es requerido',
                'responsible_id.required' => 'El responsable es requerido',
                'template_id.required' => 'La plantilla es requerida',
                'teacher_id.exists' => 'El docente no existe',
                'responsible_id.exists' => 'El responsable no existe',
                'template_id.exists' => 'La plantilla no existe',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $course->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $course
        ]);
    }

    public function updateWithImage(Request $request, $id)
    {
        $request->merge(["id" => $id]);

        $rules = [
            'id' => 'exists:courses,id',
            "name" => "required",
            "duration" => "required",
            "date_start" => "required",
            "date_end" => "required",
            "quota" => "required",
            "whatsapp" => "required",
            "description" => "required",
            'teacher_id' => 'required|exists:users,id',
            'responsible_id' => 'required|exists:users,id',
            'template_id' => 'required|exists:templates,id',
        ];

        $exists_image = $request->hasFile("image");
        if ($exists_image) $rules["image"] = "required|file|mimes:" . $this->IMAGE_TYPE;

        $validator = Validator::make($request->all(), $rules, [
            'id.exists' => 'El id del curso no existe',
            'name.required' => 'El nombre es requerido',
            'duration.required' => 'La duración es requerida',
            'date_start.required' => 'La fecha de inicio es requerida',
            'date_end.required' => 'La fecha de fin es requerida',
            'quota.required' => 'El numero de cupos es requerido',
            'whatsapp.required' => 'El link de grupo de whatsapp es requerido',
            'description.required' => 'La descripción es requerida',
            'teacher_id.required' => 'El docente es requerido',
            'responsible_id.required' => 'El responsable es requerido',
            'template_id.required' => 'La plantilla es requerida',
            'teacher_id.exists' => 'El docente no existe',
            'responsible_id.exists' => 'El responsable no existe',
            'template_id.exists' => 'La plantilla no existe',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $image = Course::find($id);

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
            "errors" => null,
            "data" => $image
        ]);
    }

    public function updatePublished(Request $request, $id)
    {
        $request->merge(["id" => $id]);

        $validator = Validator::make($request->all(), [
            'id' => 'exists:courses,id',
            "published" => "required",
        ], [
            'id.exists' => 'El id del curso no existe',
            'name.required' => 'El nombre es requerido',
            'duration.required' => 'La duración es requerida',
            'date_start.required' => 'La fecha de inicio es requerida',
            'date_end.required' => 'La fecha de fin es requerida',
            'quota.required' => 'El numero de cupos es requerido',
            'whatsapp.required' => 'El link de grupo de whatsapp es requerido',
            'description.required' => 'La descripción es requerida',
            'teacher_id.required' => 'El docente es requerido',
            'responsible_id.required' => 'El responsable es requerido',
            'template_id.required' => 'La plantilla es requerida',
            'teacher_id.exists' => 'El docente no existe',
            'responsible_id.exists' => 'El responsable no existe',
            'template_id.exists' => 'La plantilla no existe',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $course = Course::find($id);

        $course->update([
            "published" => $request->published
        ]);

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $course
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
        if ($course->inscriptions->count() > 0) {
            return response()->json([
                "success" => false,
                "message" => "No se puede eliminar el curso porque tiene inscripciones asociadas",
                "errors" => ["course_id" => ["No se puede eliminar el curso porque tiene inscripciones asociadas"]],
                "data" => null
            ]);
        }

        Storage::delete($this->IMAGE_PATH . "/" . $course->image);
        $course->delete();
        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "errors" => null,
            "data" => $course
        ]);
    }
}
