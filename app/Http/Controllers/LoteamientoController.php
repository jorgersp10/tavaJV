<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loteamiento;
use Illuminate\Support\Facades\Redirect;
use DB;

class LoteamientoController extends Controller
{
    public function index(Request $request)
    {
        if($request){
            //Buscador de texto en el view y tambien la consula para mostrar datos en el index
            $sql=trim($request->get('buscarTexto'));
            $sql = str_replace(" ", "%", $sql);
            $loteamientos=DB::table('loteamientos as l')
            //->join('empresas','clientes.idempresa','=','empresas.id')
            ->select('l.id as id','l.descripcion as descripcion','mora_gs','mora_us')
            ->where('l.descripcion','LIKE','%'.$sql.'%')
            ->orderBy('l.id','asc')
            ->simplePaginate(10);

            //dd($clientes);
            return view('loteamiento.index',["loteamientos"=>$loteamientos,"buscarTexto"=>$sql]);
            //return $clientes;
        }
    }

    public function store(Request $request)
    {
        $loteamiento= new Loteamiento();        
        $loteamiento->descripcion = $request->descripcion;
        $loteamiento->mora_gs = $request->mora_gs;
        $loteamiento->mora_us = $request->mora_us;

        $loteamiento->save();
        return Redirect::to("loteamiento");
    }

    public function update(Request $request)
    {
        $loteamiento= Loteamiento::findOrFail($request->id_loteamiento);
        $loteamiento->descripcion = $request->descripcion;
        $loteamiento->mora_gs = $request->mora_gs;
        $loteamiento->mora_us = $request->mora_us;

        $loteamiento->save();
        return Redirect::to("loteamiento");
    }

    public function destroy($id)
    {
        //dd($id);
        Loteamiento::destroy($id);
        return Redirect::to("loteamiento");
    }
}
