<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredientes;
use App\Models\Ventas;
use App\Models\Recetas;

class IngredienteController extends Controller
{
    /**
     * 
     */
    public function reporte2(Request $request){
        
        /**
         * Query hacia tabla ventas para sumar la cantidad de pociones que se vendieron en un rango de fecha.
         * join hacia pociones para obtener nombre e id de pocion
         */
        $ventas = Ventas::query();
        $ventas->select(Ventas::raw('sum(cantidad) as cant_total'), 'pociones.nombre as nombre_pocion', 'pociones.id as id_pocion');
        $ventas->leftjoin('pociones', 'ventas.id_posion', '=', 'pociones.id');
        if($request->get('id_pocion')){
            $ventas->whereIn('ventas.id_posion', $request->id_pocion);
        }
        if($request->get('fecha1')&&$request->get('fecha2')){
            $ventas->whereBetween('ventas.fecha', [$request->fecha1, $request->fecha2]);
        }
        
        $resp=$ventas->groupBy('ventas.id_posion')->get()->toArray();//Se transforma resultado a Array para manejarlo dentro de foreach

        $i = 0;
        
        $respuesta = []; //variabl de respuesta json
        foreach($resp as $suma_total){
            $i = $suma_total['cant_total'];
            /**
             * Query de consulta hacia tabla recetas, para obener la cantidad de ingredientes por receta y calcular el total segun la cantidad vendida y el precio unitario.
             */
            $ingredientes = Recetas::query()
                            ->leftjoin('ingredientes', 'recetas.id_ingredientes', '=', 'ingredientes.id')
                            ->select('ingredientes.nombre_ingrediente', 'ingredientes.precio', Ingredientes::raw('recetas.cantidad*'.$i.' as total_ing'), Ingredientes::raw('(recetas.cantidad*'.$i.')*ingredientes.precio as total_costo_ing'))
                            ->where('recetas.id_posion', '=', $suma_total['id_pocion']);
            $respuesta[] = $suma_total;
            $respuesta[] = $ingredientes->get();
        }
        
        return $respuesta;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingredientes = Ingredientes::all();
        return $ingredientes;
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
        $ingredientes = new Ingredientes();
        $ingredientes->nombre_ingrediente = $request->nombre;
        $ingredientes->precio = $request->precio;
        $ingredientes->save();
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
        $ingredientes = Ingredientes::findOrFail($request->id);
        $ingredientes->nombre_ingrediente = $request->nombre;
        $ingredientes->precio = $request->precio;

        $ingredientes->save();
        return $ingredientes;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ingredientes = Ingredientes::destroy($request->id);
        return $ingredientes;
    }
}
