<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Jenssegers\Agent\Agent;
use App\Models\Seguimiento;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function obtenerIP()
    {

        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    public function seguimiento($usuario, $rol, $tipo_accion, $accion)
    {
        $agente = new Agent();
        $plataforma = $agente->platform(); // Ubuntu, Windows, OS X, ...
        $navegador = $agente->browser(); // Chrome, IE, Safari, Firefox, ...

        if($agente->isRobot() == false){
            $seguimiento = new Seguimiento;
            $seguimiento->usuario = $usuario;
            $seguimiento->rol = $rol;
            $seguimiento->tipo_accion = $tipo_accion;
            $seguimiento->accion = $accion;
            $seguimiento->dispositivo = $agente->device();
            $seguimiento->plataforma = $plataforma;
            $seguimiento->plataforma_version = $agente->version($plataforma);
            $seguimiento->navegador = $navegador;
            $seguimiento->navegador_version = $agente->version($navegador);
            $seguimiento->ip_address =$this->obtenerIP();
            $seguimiento->save();
        }

        return null;
    }
}
