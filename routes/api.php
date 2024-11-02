<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/picsum-proxy', function () {
    // Hacemos la solicitud a la API de Picsum
    $response = Http::get('https://picsum.photos/v2/list');

    // Devolvemos la respuesta como JSON
    return $response->json();
});
