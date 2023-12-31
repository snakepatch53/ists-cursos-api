<?php

namespace App\Http\Controllers;

use App\Models\SocialNetwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialNetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socialNetworks = SocialNetwork::all();
        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => $socialNetworks
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
            "value" => "required",
            "url" => "required",
            "icon" => "required",
            "color" => "required",
            "color2" => "required"
        ], [
            "required" => "El campo :attribute es requerido"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        $socialNetwork = SocialNetwork::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "data" => $socialNetwork
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SocialNetwork  $socialNetwork
     * @return \Illuminate\Http\Response
     */
    public function show(SocialNetwork $socialNetwork)
    {
        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "data" => $socialNetwork
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SocialNetwork  $socialNetwork
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SocialNetwork $socialNetwork)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "value" => "required",
            "url" => "required",
            "icon" => "required",
            "color" => "required",
            "color2" => "required"
        ], [
            "required" => "El campo :attribute es requerido"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => implode(" - ", $validator->errors()->all()),
                "data" => $validator->errors()
            ]);
        }

        $socialNetwork->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "data" => $socialNetwork
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SocialNetwork  $socialNetwork
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialNetwork $socialNetwork)
    {
        $socialNetwork->delete();
        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "data" => $socialNetwork
        ]);
    }
}
