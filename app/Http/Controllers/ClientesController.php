<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    public function crearCliente(Request $request)
    {
        // Leer los datos enviados en la solicitud POST
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $edad = $request->input('edad');
        $fecha_nacimiento = $request->input('fecha_nacimiento');

        // Validar los datos recibidos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'edad' => 'required|numeric|min:1',
            'fecha_nacimiento' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
            ], 400);
        }

        // Crear un nuevo objeto Cliente con los datos validados
        $cliente = new Cliente();
        $cliente->nombre = $nombre;
        $cliente->apellido = $apellido;
        $cliente->edad = $edad;
        $cliente->fecha_nacimiento = $fecha_nacimiento;

        // Guardar el cliente en la base de datos
        $cliente->save();

        // Retornar una respuesta con el nuevo cliente creado
        return response()->json([
            'mensaje' => 'Cliente creado con éxito',
            'cliente' => $cliente,
        ], 201);
    }
    public function listarClientes(){
        return Cliente::obtenerListaClientes();
    }
    public function kpiClientes(){
        return response()->json([
            'promedio_edad' => Cliente::calcularPromedioEdad(),
            'desviacion_estandar_edad' => Cliente::calcularDesviacionEstandarEdad(),
        ], 201);
    }
}
