<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta_corriente;
use App\Models\Transferencia;
use Illuminate\Support\Facades\Redirect;
use DB;
class TransferenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         /*listar los productos en ventana modal*/
        $bancos=DB::table('bancos as c')
        ->select('id','descripcion')
        ->get(); 

        $tipo_cuenta=DB::table('tipo_cuenta as tp')
        ->select('tp.id','tp.tipo_cuenta')
        ->get(); 
        
        $cuentas=DB::table('cuentas_corriente as cc')
            ->join('bancos as b','b.id','=','cc.banco_id')
            ->join('tipo_cuenta as tp','tp.id','=','cc.tipo_cuenta')
            ->select('cc.id','cc.nro_cuenta','cc.banco_id','b.descripcion as banco',
            'cc.tipo_cuenta','tp.tipo_cuenta as tipo')
            ->get();
        
        $transfers=DB::table('transferencias as t')
            ->join('cuentas_corriente as cc','cc.id','=','t.cuenta_id1')
            ->join('cuentas_corriente as cc2','cc2.id','=','t.cuenta_id2')
            ->join('bancos as b','b.id','=','cc.banco_id')
            ->join('bancos as b2','b2.id','=','cc2.banco_id')
            ->select('t.id','t.cuenta_id1','cc.nro_cuenta as cuenta1','t.cuenta_id2',
            'cc2.nro_cuenta as cuenta2','t.monto','t.comentario','t.fecha','b.descripcion as banco1',
            'b2.descripcion as banco2')
            ->get();
        //dd($transfers);
        return view('transferencia.create',["bancos"=>$bancos,"tipo_cuenta"=>$tipo_cuenta,
        "cuentas"=>$cuentas,"transfers"=>$transfers]);
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
        $transfer = new Transferencia();        
        $transfer->cuenta_id1 = $request->cuenta_id1;
        $transfer->cuenta_id2 = $request->cuenta_id2;
        $transfer->fecha = $request->fecha;
        $transfer->monto = str_replace(".", "", $request->monto);
        //dd($transfer);
        if($request->comentario == null)
            $transfer->comentario = "NINGUNO";
        else
            $transfer->comentario = $request->comentario;

        $transfer->save();
        
         /*listar los productos en ventana modal*/
        $bancos=DB::table('bancos as c')
        ->select('id','descripcion')
        ->get(); 

        $tipo_cuenta=DB::table('tipo_cuenta as tp')
        ->select('tp.id','tp.tipo_cuenta')
        ->get(); 
        
        $cuentas=DB::table('cuentas_corriente as cc')
            ->join('bancos as b','b.id','=','cc.banco_id')
            ->join('tipo_cuenta as tp','tp.id','=','cc.tipo_cuenta')
            ->select('cc.id','cc.nro_cuenta','cc.banco_id','b.descripcion as banco',
            'cc.tipo_cuenta','tp.tipo_cuenta as tipo')
            ->get();
        
        $transfers=DB::table('transferencias as t')
            ->join('cuentas_corriente as cc','cc.id','=','t.cuenta_id1')
            ->join('cuentas_corriente as cc2','cc2.id','=','t.cuenta_id2')
            ->join('bancos as b','b.id','=','cc.banco_id')
            ->join('bancos as b2','b2.id','=','cc2.banco_id')
            ->select('t.id','t.cuenta_id1','cc.nro_cuenta as cuenta1','t.cuenta_id2',
            'cc2.nro_cuenta as cuenta2','t.monto','t.comentario','t.fecha','b.descripcion as banco1',
            'b2.descripcion as banco2')
            ->get();
        //dd($transfers);
        return view('transferencia.create',["bancos"=>$bancos,"tipo_cuenta"=>$tipo_cuenta,
        "cuentas"=>$cuentas,"transfers"=>$transfers]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuentas_corriente=DB::table('cuentas_corriente as cc')
        ->join('bancos as b','b.id','=','cc.banco_id')
        ->join('tipo_cuenta as tp','tp.id','=','cc.tipo_cuenta')
        ->select('cc.id as id','cc.nro_cuenta','cc.banco_id','b.descripcion as banco',
        'cc.saldo','cc.tipo_cuenta','tp.tipo_cuenta as tipo')
        ->where('cc.id','=',$id)
        //->orderBy('cc.id','asc')
        ->first();

        $bancos=DB::table('bancos as c')
        ->select('id','descripcion')
        ->get(); 

        $tipo_cuenta=DB::table('tipo_cuenta as tp')
        ->select('tp.id','tp.tipo_cuenta as tipo')
        ->get();

        //dd($clientes);
        return view('cuenta_corriente.show',["cuentas_corriente"=>$cuentas_corriente,
        "bancos"=>$bancos,"tipo_cuenta"=>$tipo_cuenta]);
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
        $cuenta_corriente= Cuenta_corriente::findOrFail($request->id_cuenta);
        $cuenta_corriente->nro_cuenta = $request->nro_cuenta;
        $cuenta_corriente->banco_id = $request->banco_id;
        $cuenta_corriente->tipo_cuenta = $request->tipo_cuenta;
        $cuenta_corriente->saldo = 0;

        $cuenta_corriente->save();
        return Redirect::to("cuenta_corriente");
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
        Transferencia::destroy($id);
          /*listar los productos en ventana modal*/
        $bancos=DB::table('bancos as c')
        ->select('id','descripcion')
        ->get(); 

        $tipo_cuenta=DB::table('tipo_cuenta as tp')
        ->select('tp.id','tp.tipo_cuenta')
        ->get(); 
        
        $cuentas=DB::table('cuentas_corriente as cc')
            ->join('bancos as b','b.id','=','cc.banco_id')
            ->join('tipo_cuenta as tp','tp.id','=','cc.tipo_cuenta')
            ->select('cc.id','cc.nro_cuenta','cc.banco_id','b.descripcion as banco',
            'cc.tipo_cuenta','tp.tipo_cuenta as tipo')
            ->get();
        
        $transfers=DB::table('transferencias as t')
            ->join('cuentas_corriente as cc','cc.id','=','t.cuenta_id1')
            ->join('cuentas_corriente as cc2','cc2.id','=','t.cuenta_id2')
            ->join('bancos as b','b.id','=','cc.banco_id')
            ->join('bancos as b2','b2.id','=','cc2.banco_id')
            ->select('t.id','t.cuenta_id1','cc.nro_cuenta as cuenta1','t.cuenta_id2',
            'cc2.nro_cuenta as cuenta2','t.monto','t.comentario','t.fecha','b.descripcion as banco1',
            'b2.descripcion as banco2')
            ->get();
        //dd($transfers);
        return view('transferencia.create',["bancos"=>$bancos,"tipo_cuenta"=>$tipo_cuenta,
        "cuentas"=>$cuentas,"transfers"=>$transfers]);
    }
}
