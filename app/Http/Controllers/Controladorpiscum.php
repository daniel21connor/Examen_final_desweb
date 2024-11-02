<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Controladorpiscum extends Controller
{
    public function getPicsumData(): \Illuminate\Http\JsonResponse
    {
        try {
            // Realizamos la solicitud a la API de Picsum
            $response = Http::get('https://picsum.photos/v2/list');

            // Verificamos si la solicitud fue exitosa
            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['message' => 'Error al obtener datos de la API de Picsum'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar la solicitud', 'error' => $e->getMessage()], 500);
        }
    }
}
