<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mesas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MesasController extends Controller
{
    public function index()
    {
        $mesas = mesas::all();
        
        $data = [
            'mesas' => $mesas,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'material' => 'required|max:255',
            'dimensiones'=> 'string|max:20',
            'estilo'=> 'required|max:255',
            'color'=> 'required|max:255'   
        ]);

        if($validator->fails()){
              $data = [
                  'message' => 'Error en la validacion de los datos',
                  'errors' => $validator->errors(),
                  'status' => 200
              ];
              return response()->json($data, 400);
          }

          $mesas = Mesas::create([
            'material' => $request->material,
            'dimensiones'=>  $request->dimensiones,
            'estilo'=>  $request->estilo,
            'color'=>  $request->color
          ]);

          if(!$mesas){
              $data = [
                  'message' => 'Error al crear la mesa',
                  'status' => 500
              ];
              return response()->json($data, 500);
            }

            $data = [
                'mesas' => $mesas,
                'status' => 201
            ];
            return response()->json($data, 201);
    }

    public function show($id)
    {
        $mesas = Mesas::find($id);

        if (!$mesas){
            $data = [
                'message' => 'Mesa no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'mesas' => $mesas,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $mesas = Mesas::find($id);

        if(!$mesas){
            $data = [
                'message' => 'Mesa no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $mesas->delete();

        $data = [
            'message' => 'Mesa eliminada',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $mesas = Mesas::find($id);

        if(!$mesas){
            $data = [
                'message' => 'Mesa no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
     }

     $validator = Validator::make($request->all(), [
        'material' => 'required|max:255',
        'dimensiones'=> 'string|max:20',
        'estilo'=> 'required|max:255',
        'color'=> 'required|max:255'   
    ]);

    if($validator->fails()){
        $data = [
            'message' => 'Error en la validacion de los datos',
            'errors' => $validator->errors(),
            'status' => 200
        ];
        return response()->json($data, 400);
    }

    $mesas->material = $request->material;
    $mesas->dimensiones = $request->dimensiones;
    $mesas->estilo = $request->estilo;
    $mesas->color = $request->color;
    
    $mesas->save();

    $data = [
        'message' => 'mesa actualizada',
        'errors' => $mesas,
        'status' => 200  
    ];

    return response()->json($data, 200);
  }

  public function updatePartial(Request $request, $id)
{
    // Buscar la mesa por ID
    $mesas = Mesas::find($id);

    if (!$mesas) {
        return response()->json([
            'message' => 'Mesa no encontrada',
            'status' => 404
        ], 404);
    }

    // Validación condicional solo para los campos presentes en la solicitud
    $rules = [];

    if ($request->has('material')) {
        $rules['material'] = 'required|max:255';
    }

    if ($request->has('dimensiones')) {
        $rules['dimensiones'] = 'nullable|string|max:20';
    }

    if ($request->has('estilo')) {
        $rules['estilo'] = 'required|max:255';
    }

    if ($request->has('color')) {
        $rules['color'] = 'required|max:255';
    }

    // Validar solo los campos que están presentes en la solicitud
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Error en la validación de los datos',
            'errors' => $validator->errors(),
            'status' => 400
        ], 400);
    }

    // Actualización de los campos solo si están presentes
    if ($request->has('material')) {
        $mesas->material = $request->material;
    }
    if ($request->has('dimensiones')) {
        $mesas->dimensiones = $request->dimensiones;
    }
    if ($request->has('estilo')) {
        $mesas->estilo = $request->estilo;
    }
    if ($request->has('color')) {
        $mesas->color = $request->color;
    }

    $mesas->save();

    return response()->json([
        'message' => 'Mesa actualizada correctamente',
        'status' => 200,
        'data' => $mesas
    ], 200);
}
}
