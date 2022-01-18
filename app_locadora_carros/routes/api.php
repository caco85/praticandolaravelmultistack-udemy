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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('jwt.auth')->group(function() {
    Route::post('logout','App\Http\Controllers\AuthController@logout');
    Route::post('refresh','App\Http\Controllers\AuthController@refresh');
    Route::post('me','App\Http\Controllers\AuthController@me');
    Route::apiResource('cliente','App\Http\Controllers\ClienteController');
    Route::apiResource('carro','App\Http\Controllers\CarroController');
    Route::apiResource('locacao','App\Http\Controllers\LocacaoController');
    Route::apiResource('marca','App\Http\Controllers\MarcaController');
    Route::apiResource('modelo','App\Http\Controllers\ModeloController');
});

Route::post('login','App\Http\Controllers\AuthController@login');


// Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTY0MjUxNTAxOSwiZXhwIjoxNjQyNTE4NjE5LCJuYmYiOjE2NDI1MTUwMTksImp0aSI6IlNBY1pIMzRwa3Y3c2RPY1AiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.fKZZVCURBLHKkJ1rLxpn-aPa1pvvz9XKlBYEIHgfC5s
