<?php

namespace App\Http\Controllers;

use App\Models\Mailbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MailboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Mailbox::all();
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
            "phone" => "required",
            "email" => "required",
            "message" => "required"
        ], [
            "required" => "El campo :attribute es requerido"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $data = Mailbox::create($request->all());

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
     * @param  \App\Models\Mailbox  $mailbox
     * @return \Illuminate\Http\Response
     */
    public function show(Mailbox $mailbox)
    {
        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "errors" => null,
            "data" => $mailbox
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mailbox  $mailbox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mailbox $mailbox)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "phone" => "required",
            "email" => "required",
            "message" => "required"
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

        $mailbox->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $mailbox
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mailbox  $mailbox
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mailbox $mailbox)
    {
        $mailbox->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "errors" => null,
            "data" => $mailbox
        ]);
    }
}
