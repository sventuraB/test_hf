<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/**
 * Rutas para registro, login e informacion de usuario.
 * Register:
 *  name->nombre del usuario
 *  email->email del usuario
 *  password->contraseña con largo minimo 8 caracteres
 * Login:
 *  email->email del usuario
 *  password->contraseña con largo minimo 8 caracteres
 * userInfo
 *  Devuelve autmaticamente informacion del usuario logeado
 *    "id"
 *    "name"
 *    "email"
 *    "email_verified_at"
 *    "created_at"
 *    "updated_at"
 */
Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/userinfo', 'App\Http\Controllers\AuthController@infouser')->middleware('auth:sanctum');


/**
 * Reportes
 * Reporte1: Reporte de venta por Bruja. 
 * Campos requeridos:
 * id[] -> id de Bruja o Brujas. Si va vacio, devolvera todas las brujas.
 * fecha1 ->fecha inicio para filtro por fechas.
 * fecha2 ->fecha fin para filtro por fechas
 *  Si fechas van vacias, devolvera todas las ventas.
 * 
 * Reporte2: Reporte de uiso de insumos.
 * id_pocion[] -> id de la pocion o pociones. Si va vacio, devovlera todaas las pociones
 * fecha1 ->fecha inicio para filtro por fechas.
 * fecha2 ->fecha fin para filtro por fechas
 *  Si fechas van vacias, devolvera todas las ventas.
 */
######
Route::get('/reporte1', 'App\Http\Controllers\VentaController@reporte1')->middleware('auth:sanctum');
Route::get('/reporte2', 'App\Http\Controllers\IngredienteController@reporte2')->middleware('auth:sanctum');
#########

/**
 * CRUD Ventas. 
 */
Route::get('/ventas', 'App\Http\Controllers\VentaController@index')->middleware('auth:sanctum');
Route::post('/ventas', 'App\Http\Controllers\VentaController@store')->middleware('auth:sanctum');
Route::put('/ventas/{id}', 'App\Http\Controllers\VentaController@update')->middleware('auth:sanctum');
Route::delete('/ventas/{id}', 'App\Http\Controllers\VentaController@destroy')->middleware('auth:sanctum');

/**
 * CRUD Pociones
 */
Route::get('/pociones', 'App\Http\Controllers\PocionController@index')->middleware('auth:sanctum');
Route::post('/pociones', 'App\Http\Controllers\PocionController@store')->middleware('auth:sanctum');
Route::put('/pociones/{id}', 'App\Http\Controllers\PocionController@update')->middleware('auth:sanctum');
Route::delete('/pociones/{id}', 'App\Http\Controllers\PocionController@destroy')->middleware('auth:sanctum');

/**
 * CRUD Ingredientes
 */
Route::get('/ingredientes', 'App\Http\Controllers\IngredienteController@index')->middleware('auth:sanctum');
Route::post('/ingredientes', 'App\Http\Controllers\IngredienteController@store')->middleware('auth:sanctum');
Route::put('/ingredientes/{id}', 'App\Http\Controllers\IngredienteController@update')->middleware('auth:sanctum');
Route::delete('/ingredientes/{id}', 'App\Http\Controllers\IngredienteController@destroy')->middleware('auth:sanctum');

/**
 * CRUD Brujas
 */
Route::get('/brujas', 'App\Http\Controllers\BrujaController@index')->middleware('auth:sanctum');
Route::post('/brujas', 'App\Http\Controllers\BrujaController@store')->middleware('auth:sanctum');
Route::put('/brujas/{id}', 'App\Http\Controllers\BrujaController@update')->middleware('auth:sanctum');
Route::delete('/brujas/{id}', 'App\Http\Controllers\BrujaController@destroy')->middleware('auth:sanctum');
