<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comision;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use DateTime;
use App\NumerosEnLetras;

class ComisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){
            //Buscador de texto en el view y tambien la consula para mostrar datos en el index
            $sql=trim($request->get('buscarTexto'));
            $sql = str_replace(" ", "%", $sql);
            $comisiones=DB::table('comisiones')
            ->select('comisiones.id','comisiones.meta','comisiones.total_venta',
            'comisiones.porcentaje_comi','comisiones.fecha','comisiones.comision')
            ->where('comisiones.fecha','LIKE','%'.$sql.'%')
            ->orderBy('comisiones.id','desc')
            ->simplepaginate(12);

            return view('comision.index',["comisiones"=>$comisiones,"buscarTexto"=>$sql]);
            //return $comisiones;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comision.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $comision= new Comision();
        $comision->meta = str_replace(".","",$request->meta);
        $comision->total_venta = str_replace(".","",$request->total_venta);
        $comision->porcentaje_comi = $request->porcentaje_comi;
        $comision->fecha = $request->fecha;
        $comision->comision = str_replace(".","",$request->comision);

        $comision->save();
        return Redirect::to("comision")->with('msj2', 'COMISION REGISTRADO');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comisiones=DB::table('comisiones')
        ->select('comisiones.id as id_comision','comisiones.meta','comisiones.total_venta',
        'comisiones.porcentaje_comi','comisiones.fecha','comisiones.comision')
        ->orderBy('comisiones.id','desc')
        ->first();

        return view('comision.show',["comisiones"=>$comisiones]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $comision= Comision::findOrFail($request->id_comision); 
        $comision->meta = str_replace(".","",$request->meta);
        $comision->total_venta = str_replace(".","",$request->total_venta);
        $comision->porcentaje_comi = $request->porcentaje_comi;
        $comision->fecha = $request->fecha;
        $comision->comision = str_replace(".","",$request->comision);

        $comision->save();
        return Redirect::to("comision")->with('msj2', 'COMISION ACTUALIZADO');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
