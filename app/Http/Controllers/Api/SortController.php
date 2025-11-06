<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cover;
use Illuminate\Http\Request;

class SortController extends Controller
{
    public function covers(Request $request)
    {
        $sorts = $request->get('sorts'); // Array de IDs en el nuevo orden

        $order = 1; // Iniciar el orden en 1

        // Actualizar el campo 'order' de cada portada según el nuevo orden
        foreach ($sorts as $sort) {

            $cover = Cover::find($sort); // Buscar la portada por su ID

            $cover->order = $order; // Asignar el nuevo orden
            $cover->save(); // Guardar los cambios

            $order++; // Incrementar el orden para la siguiente portada

        }
    }
}
