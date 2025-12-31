<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Cliente;
use App\Models\Proveedor;
use Illuminate\Http\File;
use App\Models\Cheque_emitido;
use App\Models\Cotizacion;
use App\Models\Documento;
use DB;
use Carbon\Carbon;
use DateTime;

class Cheque_emitidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if($request){
            //Buscador de texto en el view y tambien la consula para mostrar datos en el index
            $sql=trim($request->get('buscarTexto'));
            $sql = str_replace(" ", "%", $sql);
            $cheques=DB::table('cheques_emitido as ch')
            ->join('bancos as b','b.id','=','ch.banco_id')
            ->join('clientes as c','c.id','=','ch.librador_id')
            //->join('clientes as c2','c2.id','=','ch.endosante_id')
            //->join('estados_cheque as e','e.id','=','ch.estado')
            //->join('sucursales as s','s.id','=','ch.sucursal_id')
            ->join('tipo_cheques as tc','tc.id','=','ch.tipo_cheque')
            ->join('users as u','u.id','=','ch.user_id')
            ->select('ch.id','ch.nro_cheque','b.descripcion as banco','c.nombre as librador',
            'ch.importe_cheque','ch.fec_venc','ch.estado as estado',
            'tc.id as tipo_cheque_id','tc.tipo_cheque',
            'u.name as usuario','ch.cuenta_corriente')
            ->where('ch.nro_cheque','LIKE','%'.$sql.'%')
            ->orwhere('c.nombre','LIKE','%'.$sql.'%')
            ->orderBy('ch.id','desc')
            ->simplepaginate(10);
            //dd($cheques);
            $bancos=DB::table('bancos')
            ->select('id','descripcion')
            ->get();

            $tipo_cheques = DB::table('tipo_cheques')
            ->select('id', 'tipo_cheque')
            ->get();

            /*listar los roles en ventana modal*/

            return view('cheque_emitido.index',["bancos"=>$bancos,"cheques"=>$cheques,"tipo_cheques"=>$tipo_cheques,"buscarTexto"=>$sql]);
            //return $clientes;
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bancos = DB::table('bancos')
        ->select('id', 'descripcion')
        ->get();

        $tipo_cheques = DB::table('tipo_cheques')
        ->select('id', 'tipo_cheque')
        ->get();

        $cuentas_corriente=DB::table('cuentas_corriente as cc')
        ->select('cc.id as id','cc.nro_cuenta','cc.saldo')
        ->get();

    
        return view('cheque_emitido.create',["bancos"=>$bancos,"cuentas_corriente"=>$cuentas_corriente,
        "tipo_cheques"=>$tipo_cheques]);
    }

    public function getClienteEm(Request $request)
    {
 
    	$search = $request->search;

        if($search == ''){
            $clientes = Cliente::orderby('nombre','asc')
                    ->select('id','nombre','num_documento')
                    ->limit(5)
                    ->get();
        }else{
            $search = str_replace(" ", "%", $search);
            $clientes = Cliente::orderby('nombre','asc')
                    ->select('id','nombre','num_documento')
                    ->where('nombre','like','%'.$search.'%')
                    //->orWhere('apellido','like','%'.$search.'%')
                    ->orWhere('num_documento','like','%'.$search.'%')
                    ->limit(5)
                    ->get();
        }

        $response = array();

        foreach($clientes as $cli){
            $response[] = array(
                'id' => $cli->id,
                'text' => $cli->nombre." - ".$cli->num_documento
            );
        }
        return response()->json($response);
    }

    public function getProveedorEm(Request $request)
    {
 
    	$search = $request->search;

        if($search == ''){
            $proveedores = Proveedor::orderby('nombre','asc')
                    ->select('id','nombre','ruc')
                    ->limit(5)
                    ->get();
        }else{
            $search = str_replace(" ", "%", $search);
            $proveedores = Proveedor::orderby('nombre','asc')
                    ->select('id','nombre','ruc')
                    ->where('nombre','like','%'.$search.'%')
                    //->orWhere('apellido','like','%'.$search.'%')
                    ->orWhere('ruc','like','%'.$search.'%')
                    ->limit(5)
                    ->get();
        }

        $response = array();

        foreach($proveedores as $prov){
            $response[] = array(
                'id' => $prov->id,
                'text' => $prov->nombre." - ".$prov->ruc
            );
        }
        return response()->json($response);
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
        $request->validate([
            'cuenta_corriente' => 'required',
            'banco_id' => 'required',
            'nro_cheque' => 'required'
        ]);

        $cheque = new Cheque_emitido();
        $cheque->sucursal_id = "1";
        $cheque->nro_cheque = str_replace(".", "", $request->nro_cheque);
        $cheque->tipo_cheque = $request->tipo_cheque_id;
        $cheque->banco_id = $request->banco_id;
        $cheque->cuenta_corriente = $request->cuenta_corriente;

        isset($request->cliente_id) ? $cheque->librador_id = $request->cliente_id : $cheque->librador_id = $request->proveedor_id;


        $cheque->importe_cheque = str_replace(".", "", $request->importe_cheque);
        $cheque->fec_venc = $request->fec_venc;
        //$cheque->moneda = $request->moneda;
        $cheque->endosante_id = 0;

        $cheque->estado = "1";
        $cheque->user_id = auth()->user()->id;

        $cheque->save();
        return Redirect::to("cheque_emitido")->with('msj2', 'CHEQUE REGISTRADO');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd($id);
        $cheques = DB::table('cheques_emitido as ch')
        ->join('bancos as b', 'b.id', '=', 'ch.banco_id')
        ->join('clientes as c', 'c.id', '=', 'ch.librador_id')
        //->join('clientes as c2', 'c2.id', '=', 'ch.endosante_id')
        ->join('cuentas_corriente as cc', 'cc.id', '=', 'ch.cuenta_corriente')
        //->join('sucursales as s','s.id','=','ch.sucursal_id')
        ->join('tipo_cheques as tc','tc.id','=','ch.tipo_cheque')
        ->join('users as u','u.id','=','ch.user_id')
        ->select('ch.id', 'ch.nro_cheque', 'b.descripcion as banco', 'c.nombre as librador',
            'ch.importe_cheque', 'ch.fec_venc','ch.estado as estado','ch.tipo_cheque as tp_id',
            'b.id as banco_id','ch.librador_id',
            'tc.id as tipo_cheque_id','tc.tipo_cheque','cc.nro_cuenta',
            'u.name as usuario','ch.cuenta_corriente')
        ->where('ch.id', '=' ,$id)
        ->first();
        //dd($cheques);
        $bancos = DB::table('bancos')
        ->select('id', 'descripcion')
        ->get();

        $tipo_cheques = DB::table('tipo_cheques')
        ->select('id', 'tipo_cheque')
        ->get();

        $cuentas_corriente=DB::table('cuentas_corriente as cc')
        ->select('cc.id as id','cc.nro_cuenta')
        ->get();

    /*listar los roles en ventana modal*/

    return view('cheque_emitido.show', ["bancos" => $bancos, "cheques" => $cheques,
    "tipo_cheques" => $tipo_cheques,"cuentas_corriente" => $cuentas_corriente]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cheques = DB::table('cheques_emitido as ch')
        ->join('bancos as b', 'b.id', '=', 'ch.banco_id')
        ->join('clientes as c', 'c.id', '=', 'ch.librador_id')
        //->join('clientes as c2', 'c2.id', '=', 'ch.endosante_id')
        ->join('cuentas_corriente as cc', 'cc.id', '=', 'ch.cuenta_corriente')
        // ->join('sucursales as s', 's.id', '=', 'ch.sucursal_id')
        ->join('tipo_cheques as tc', 'tc.id', '=', 'ch.tipo_cheque')
        ->join('users as u','u.id','=','ch.user_id')
        ->select('ch.id', 'ch.nro_cheque', 'b.descripcion as banco', 'c.nombre as librador',
            'ch.importe_cheque', 'ch.fec_venc','ch.estado as estado',
            'b.id as banco_id','ch.librador_id',
            'tc.id as tipo_cheque_id','tc.tipo_cheque','cc.nro_cuenta',
            'u.name as usuario','ch.cuenta_corriente')
        ->where('ch.id', '=', $id)
        ->first();
        //dd($cheques);
        $bancos = DB::table('bancos')
        ->select('id', 'descripcion')
        ->get();

        $tipo_cheques = DB::table('tipo_cheques')
        ->select('id', 'tipo_cheque')
        ->get();

    /*listar los roles en ventana modal*/

        return view('cheque_emitido.ver', ["bancos" => $bancos, "cheques" => $cheques,"tipo_cheques" => $tipo_cheques]);

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
        //dd($request);
        $cheque = Cheque_emitido::findOrFail($request->id);
        $cheque->sucursal_id = "1";
        $cheque->nro_cheque = str_replace(".", "", $request->nro_cheque);
        $cheque->tipo_cheque = $request->tipo_cheque_id;
        $cheque->banco_id = $request->banco_id;
        $cheque->cuenta_corriente = $request->cuenta_corriente;
           isset($request->cliente_id) ? $cheque->librador_id = $request->cliente_id : $cheque->librador_id = $request->proveedor_id;
        $cheque->importe_cheque = str_replace(".", "", $request->importe_cheque);
        $cheque->fec_venc = $request->fec_venc;
        //$cheque->moneda = $request->moneda;
        $cheque->endosante_id = 0;
        //$cheque->fec_apertura = $request->fec_apertura;

        // if ($request->rechazos_if == null) {$cheque->rechazos_if = 0;}
        // $cheque->rechazos_if = $request->rechazos_if;

        // $cheque->informconf = strtoupper($request->informconf);
        // $cheque->infocheck = strtoupper($request->infocheck);
        // $cheque->calificacion = $request->calificacion;
        $cheque->estado = "1";
        $cheque->user_id = auth()->user()->id;

        $cheque->save();
        return Redirect::to("cheque_emitido")->with('msj2', 'CHEQUE ACTUALIZADO');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        Cheque_emitido::destroy($id);
        return Redirect::to("cheque_emitido");
    }

    public function cobrarCheque(Request $request){

            $cheque = Cheque_emitido::findOrFail($request->id_cheque);

            if($cheque->estado == 1){
                $cheque->estado = 0;
                $cheque->save();
            }
                
            else{
                $cheque->estado = 1;
                $cheque->save();
            }

            
            return Redirect::to('cheque_emitido');

    }

    public function obtenerBanco(Request $request)
    {
        $banco = DB::select('select * from cuentas_corriente where id = ?', [$request->cuenta_corriente]);
        return response()->json(['var'=>$banco]);
    }

}
