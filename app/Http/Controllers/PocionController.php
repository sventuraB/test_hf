<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pociones;

class PocionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if($request->get('nombre')){
            $pociones = Pociones::where('nombre', '=',$request->nombre)->get();
            return $pociones;
        }else{
            $pociones = Pociones::all();
            return $pociones;   
        }

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
        $pociones = new Pociones();
        $pociones->nombre = $request->nombre;
        $pociones->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
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
    public function update(Request $request)
    {
        $pociones = Pociones::findOrFail($request->id);
        $pociones->nombre = $request->nombre;

        $pociones->save();
        return $pociones;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pociones = Pociones::destroy($request->id);
        return $pociones;
    }
}
