<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['nombre', 'apellido', 'edad', 'fecha_nacimiento'];
    public $timestamps = false;

    public static function calcularPromedioEdad()
    {
        return DB::table('clientes')->avg('edad');
    }

    public static function calcularDesviacionEstandarEdad()
    {
        return DB::table('clientes')->select(DB::raw('STDDEV(edad) as desviacion_estandar_edad'))->first()->desviacion_estandar_edad;
    }


    public static function obtenerListaClientes()
    {
        $clientes = DB::table('clientes')->get();

        // Calcular la fecha probable de muerte de cada cliente
        foreach ($clientes as $cliente) {
            $fechaNacimiento = new \DateTime($cliente->fecha_nacimiento);
            $edad = $fechaNacimiento->diff(new DateTime())->y;
            $esperanzaVida = 80; 
            $fechaMuerte = $fechaNacimiento->add(new \DateInterval('P' . ($esperanzaVida - $edad) . 'Y'));
            $cliente->fecha_muerte = $fechaMuerte->format('Y-m-d');
        }

        return $clientes;
    }
}