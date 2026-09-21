<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigFactura;
use Illuminate\Support\Facades\Redirect;

class ConfigFacturaController extends Controller
{
    /**
     * Muestra el formulario con los valores actuales de altura de cabecera.
     */
    public function index()
    {
        $config = ConfigFactura::actual();

        return view('config_factura.index', ['config' => $config]);
    }

    /**
     * Actualiza los valores (en px) de las cabeceras de la factura.
     */
    public function update(Request $request)
    {
        $request->validate([
            'cabecera' => 'required|integer|min:0',
            'cabecera2' => 'required|integer|min:0',
            'cabecera3' => 'required|integer|min:0',
        ]);

        $config = ConfigFactura::actual();
        $config->cabecera = $request->cabecera;
        $config->cabecera2 = $request->cabecera2;
        $config->cabecera3 = $request->cabecera3;
        $config->save();

        return Redirect::to('config_factura')->with('msj', 'CONFIGURACION ACTUALIZADA');
    }
}
