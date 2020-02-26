<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies=Movie::all();
         return response()->json($movies, 200);
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
        $status=Movie::create($request->all());
        if ($status) {
            return response()->json(["status" => $status, "msg" => "Proceso finalizado satisfactoriamente"]);
        } else {
            return response()->json(["status" => $status, "msg" => "Error"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        return response()->json($movie, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        $movie->update($movie->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $status=Movie::findOrFail($movie->id)->update($request->all());
        if ($status) {
            return response()->json(["status" => $status, "msg" => "Proceso finalizado satisfactoriamente"]);
        } else {
            return response()->json(["status" => $status, "msg" => "Error"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $status=Movie::findOrfail($movie->id)->delete();
        if ($status) {
            return response()->json(["status" => $status, "msg" => "La pelicula fue excluida de la lista"]);
        } else {
            return response()->json(["status" => $status, "msg" => "Error"]);
        }
    }
}
