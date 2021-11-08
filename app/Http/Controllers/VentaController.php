<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ventas;

class VentaController extends Controller
{
    /** REPORTE 1 POCIONES POR BRUJA/S 
     * indicar cuantas pociones ha comprado una o varias brujas
     * en un periodo de tiempo, costo de las mismas en unidad y compra total.
     * 
     * Campos necesarios:
     * Filtro por bruja (id = {id_cliente})
     * Flitro entre fechas (fecha1, fecha2)
    */

    public function reporte1(Request $request){
        $ventas = Ventas::query();
        //Revisa si vienen los campos que filtar query (id brujas y fechas)
        if($request->get('id')){
            $ventas->whereIn('cliente', $request->id)->get();
        }
        if($request->get('fecha1') && $request->get('fecha2')){
            $ventas->whereBetween('ventas.fecha', [$request->fecha1, $request->fecha2]);
        }
        $ventas->leftjoin('pociones', 'ventas.id_posion', '=', 'pociones.id');
        $ventas->leftjoin('recetas', 'recetas.id_posion', '=', 'ventas.id_posion');
        $ventas->leftjoin('ingredientes', 'ingredientes.id', '=', 'recetas.id_ingredientes');
        $ventas->leftjoin('brujas', 'ventas.cliente', '=', 'brujas.id');
        $ventas->groupBy('ventas.id');;
        $result = $ventas->select('brujas.nombre_bruja','pociones.nombre as nombre_pocion','ventas.cantidad', Ventas::raw('sum(recetas.cantidad*ingredientes.precio) as costo_UN_pocion'), Ventas::raw('sum(recetas.cantidad*ingredientes.precio)*ventas.cantidad as total_compra'))->get();
        return $result;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = Ventas::all();
        return $ventas;
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
        $ventas = new Ventas();
        $ventas->cliente = $request->cliente;
        $ventas->id_posion = $request->id_posion;
        $ventas->cantidad = $request->cantidad;

        $ventas->save();
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
        $ventas = Ventas::findOrFail($request->id);
        $ventas->cliente = $request->cliente;
        $ventas->id_posion = $request->id_posion;
        $ventas->cantidad = $request->cantidad;

        $ventas->save();
        return $ventas;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ventas = Ventas::destroy($request->id);
        return $ventas;
    }
}
