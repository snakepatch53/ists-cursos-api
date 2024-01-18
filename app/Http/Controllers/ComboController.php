<?php

namespace App\Http\Controllers;

use App\Exports\InscriptionCetecApprovedsExport;
use App\Exports\InscriptionCetecRegisterExport;
use App\Models\Course;
use App\Models\Inscription;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use League\Csv\Writer;
use Maatwebsite\Excel\Facades\Excel;

class ComboController extends Controller
{

    public function enroll_registerStudentOrNot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "course_id" => "required|exists:courses,id",
            'student.dni' => 'required',
            "student.name" => "required",
            "student.lastname" => "required",
            "student.sex" => "required|in:Masculino,Femenino,Otro",
            "student.instruction" => "required|in:Primaria,Secundaria,Técnico,Superior",
            "student.address" => "required",
            "student.email" => "required|email",
            "student.cellphone" => "required",
            "student.phone" => "nullable",
            "student.description" => "required",
            "student.entity_name" => "required",
            "student.entity_post" => "required",
            "student.entity_address" => "required",
            "student.entity_phone" => "required"
        ], [
            'course_id.required' => 'El curso es requerido',
            'course_id.exists' => 'El curso no existe',
            'student.dni.required' => 'El DNI del estudiante es requerido',
            'student.name.required' => 'El nombre del estudiante es requerido',
            'student.lastname.required' => 'El apellido del estudiante es requerido',
            'student.sex.required' => 'El sexo del estudiante es requerido',
            'student.sex.in' => 'El sexo debe ser Masculino, Femenino u Otro',
            'student.instruction.required' => 'La instrucción del estudiante es requerida',
            'student.instruction.in' => 'La instrucción debe ser Primaria, Secundaria, Técnico o Superior',
            'student.address.required' => 'La dirección del estudiante es requerida',
            'student.email.required' => 'El correo del estudiante es requerido',
            'student.email.email' => 'El correo del estudiante no es válido',
            'student.cellphone.required' => 'El celular del estudiante es requerido',
            'student.description.required' => 'La descripción del estudiante es requerida',
            'student.entity_name.required' => 'El nombre de la entidad del estudiante es requerido',
            'student.entity_post.required' => 'El cargo de la entidad del estudiante es requerido',
            'student.entity_address.required' => 'La dirección de la entidad del estudiante es requerida',
            'student.entity_phone.required' => 'El teléfono de la entidad del estudiante es requerido'
        ]);

        if ($validator->fails()) return response()->json([
            "success" => false,
            "message" => $validator->errors()->first(),
            "errors" => $validator->errors(),
            "data" => null
        ]);

        // validamos si el estudiante existe
        $student = Student::where("dni", $request->student["dni"])->first();
        if (!$student) $student = Student::create($request->student);
        else $student->update($request->student);

        // validamos que el estudiante no este inscrito en el curso a traves del dni
        $inscription = Inscription::where("course_id", $request->course_id)
            ->whereHas("student", function ($query) use ($request) {
                $query->where("dni", $request->student["dni"]);
            })->first();
        if ($inscription) return response()->json([
            "success" => false,
            "message" => "El estudiante ya se encuentra inscrito en el curso",
            "errors" => ["dni" => ["El estudiante ya se encuentra inscrito en el curso"]],
            "data" => null
        ]);

        // validamos si hay cupos disponibles en el curso
        $course = Course::find($request->course_id);
        if ($course->quota <= $course->inscriptions()->count()) return response()->json([
            "success" => false,
            "message" => "El curso no tiene cupos disponibles",
            "errors" => ["course_id" => ["El curso no tiene cupos disponibles"]],
            "data" => null
        ]);

        // validamos que el curso no haya iniciado
        if ($course->course_started) return response()->json([
            "success" => false,
            "message" => "El curso ya ha iniciado",
            "errors" => ["course_id" => ["El curso ya ha iniciado"]],
            "data" => null
        ]);

        // validamos que el curso este publicado
        if (!$course->published) return response()->json([
            "success" => false,
            "message" => "El curso no esta publicado",
            "errors" => ["course_id" => ["El curso no esta publicado"]],
            "data" => null
        ]);

        // una vez validado el estudiante y que no este inscrito en el curso, lo inscribimos
        $inscription = Inscription::create([
            "certificate_code" => "",
            "student_id" => $student->id,
            "course_id" => $request->course_id,
            "state" => "Inscrito"
        ]);

        return response()->json([
            "success" => true,
            "message" => "Estudiante inscrito correctamente",
            "errors" => null,
            "data" => $inscription
        ]);
    }

    public function showCertificates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username" => "required"
        ], [
            "username.required" => "El nombre de usuario es requerido"
        ]);

        if ($validator->fails()) return response()->json([
            "success" => false,
            "message" => $validator->errors()->first(),
            "errors" => $validator->errors(),
            "data" => null
        ]);

        // get for dni or email
        $student = Student::where("dni", $request->username)->orWhere("email", $request->username)->first();
        if (!$student) return response()->json([
            "success" => false,
            "message" => "El estudiante no existe",
            "errors" => ["username" => ["El estudiante no existe"]],
            "data" => null
        ]);

        // get inscriptions
        $includes = [];
        if ($request->query('includeStudent')) $includes[] = 'student';
        if ($request->query('includeCourse')) $includes[] = 'course';
        $inscriptions = Inscription::with($includes)->where("student_id", $student->id)->get();

        return response()->json([
            "success" => true,
            "message" => "Inscripciones del estudiante",
            "errors" => null,
            "data" => $inscriptions ? $inscriptions : []
        ]);
    }

    public function showStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "dni" => "required"
        ], [
            "dni.required" => "El DNI es requerido"
        ]);

        if ($validator->fails()) return response()->json([
            "success" => false,
            "message" => $validator->errors()->first(),
            "errors" => $validator->errors(),
            "data" => null
        ]);

        // get for dni or email
        $student = Student::where("dni", $request->dni)->first();
        if (!$student) return response()->json([
            "success" => false,
            "message" => "El estudiante no existe",
            "errors" => ["username" => ["El estudiante no existe"]],
            "data" => null
        ]);

        return response()->json([
            "success" => true,
            "message" => "Inscripciones del estudiante",
            "errors" => null,
            "data" => $student ? $student : []
        ]);
    }

    public function updateStateAndCertificateCode(Request $request, $id)
    {
        $inscription = Inscription::find($id);
        if (!$inscription) return response()->json([
            "success" => false,
            "message" => "Recurso no encontrado",
            "errors" => ["id" => ["El recurso no existe"]],
            "data" => null
        ]);

        $validator = Validator::make($request->all(), [
            "state" => "required|in:" . implode(",", Inscription::$_STATES)
        ], [
            "state.required" => "El estado es requerido",
            "state.in" => "El estado debe ser uno de los siguientes: " . implode(",", Inscription::$_STATES),
            "certificate_code.required" => "El código del certificado es requerido"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $inscription->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $inscription
        ]);
    }

    public function getInsciptionsCetecRegisterExcel(Request $request, $id)
    {
        return Excel::download(new InscriptionCetecRegisterExport($id), 'inscriptions_for_register_cetec.xlsx');
    }

    public function getInscriptionCetecApprovedsExport(Request $request, $id)
    {
        return Excel::download(new InscriptionCetecApprovedsExport($id), 'inscriptions_for_codes_cetec.xlsx');
    }

    public function getInscriptionMoodleCsvExport(Request $request, $course_id)
    {
        $course = Course::find($course_id);
        if (!$course) abort(404);
        $inscriptions = Inscription::where('course_id', $course_id)->where('state', 'Inscrito')->get(); // load if state is inscrito
        $inscriptions->load('student');
        // Datos que deseas incluir en el CSV
        // Crear un objeto Writer
        $csvWriter = Writer::createFromFileObject(new \SplTempFileObject());
        $csvWriter->insertOne(['username', 'password', 'firstname', 'lastname', 'email', 'course1', 'type1']);
        foreach ($inscriptions as $inscription) {
            $csvWriter->insertOne([
                $inscription->student->dni,
                "Ists-" . date('Y'),
                $inscription->student->name,
                $inscription->student->lastname,
                $inscription->student->email,
                str_replace(' ', '_', $course->name),
                1
            ]);
        }


        // use League\Csv\Writer;
        // use Illuminate\Support\Facades\Response;



        // Agregar datos al archivo CSV

        // Configurar la respuesta HTTP
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="inscriptions_for_moodle.csv"',
        );

        // Crear la respuesta con el contenido del archivo CSV y los encabezados
        $response = Response::make($csvWriter->output(null, "\n", ''), 200, $headers);

        return $response;
    }
}
