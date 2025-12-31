<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Gasto;
use App\Models\Concepto;
use App\Models\Precio_historico;
use App\Models\Pago_gasto;
use App\Models\Factura;
use App\Models\Gasto_det;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\NumerosEnLetras;
use DateTime;
use DB;
use PDF;

class GastoController extends Controller
{
    public function index(Request $request){
      
        if($request){
        
            $sql=trim($request->get('buscarTexto'));
            $gastos=DB::table('gastos as c')
            ->join('gastos_det as cdet','c.id','=','cdet.gasto_id')
            ->join('proveedores as p','p.id','=','c.proveedor_id')
            ->join('users as u','u.id','=','c.user_id')
            ->select('c.id','c.fact_compra','c.iva','c.fecha','c.total','c.estado','p.nombre',
            'c.estado_pago','c.contable')
            ->where('c.fact_compra','LIKE','%'.$sql.'%')
            ->orwhere('p.nombre','LIKE','%'.$sql.'%')
            ->orderBy('c.id','desc')
            ->groupBy('c.id','c.fact_compra','c.iva','c.fecha','c.total','c.estado','p.nombre',
            'c.estado_pago','c.contable')
            ->simplepaginate(10);
             
 
            return view('gasto.index',["gastos"=>$gastos,"buscarTexto"=>$sql]);
            
           //return $gastos;
        }
    }

    public function create(){
 
        /*listar las proveedores en ventana modal*/
        $proveedores=DB::table('proveedores')->get();
       
        /*listar los productos en ventana modal*/
        $productos=DB::table('productos as p')
        ->select(DB::raw('CONCAT(p.ArtCode," ",p.descripcion) AS producto'),'p.id')
        ->get(); 

        return view('gasto.create',["proveedores"=>$proveedores,"productos"=>$productos]);

   }

   public function getProveedores(Request $request)
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

    public function getConceptos(Request $request)
    {
 
    	$search = $request->search;

        if($search == ''){
            $conceptos = Concepto::orderby('descripcion','asc')
                    ->select('id','descripcion')
                    ->limit(20)
                    ->get();
        }else{
            $search = str_replace(" ", "%", $search);
            $conceptos = Concepto::orderby('descripcion','asc')
                    ->select('id','descripcion')
                    //->where('ArtCode','like','%'.$search.'%')
                    //->orWhere('apellido','like','%'.$search.'%')
                    ->where('descripcion','like','%'.$search.'%')
                    ->limit(20)
                    ->get();
        }

        $response = array();

        foreach($conceptos as $prod){
            $response[] = array(
                'id' => $prod->id,
                'text' => $prod->descripcion
            );
        }
        return response()->json($response);
    }
   public function store(Request $request)
   {

        try{

            DB::beginTransaction();

            $fecha_hoy= Carbon::now('America/Asuncion');

            $gasto = new Gasto();
            $gasto->proveedor_id = $request->proveedor_id;
            $gasto->fact_compra = $request->fact_compra;
            $gasto->fecha = $fecha_hoy->toDateString();
            $gasto->iva = $request->total_iva;
            $gasto->total = $request->total_pagar;
            $gasto->estado = 0;
            if($request->contable == "on")
                $gasto->contable = 1;
            else
                $gasto->contable = 0;
            // $gasto->estado_pago = "P";
            $gasto->estado_pago = "P";
            $gasto->user_id = auth()->user()->id;
            $gasto->save();

            $concepto_id=$request->concepto_id;
            $cantidad = str_replace(",", ".", $request->cantidad);

            $precio = str_replace(".", "", $request->precio);

           
            $cont=0;

             while($cont < count($concepto_id)){

                $detalle = new Gasto_det();
                /*enviamos valores a las propiedades del objeto detalle*/
                /*al idcompra del objeto detalle le envio el id del objeto gasto, que es el objeto que se ingresó en la tabla gastos de la bd*/
                $detalle->gasto_id = $gasto->id;
                $detalle->concepto_id = $concepto_id[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio = str_replace(".", "", $precio[$cont]);   
                $detalle->save();

                $cont=$cont+1;                
            }
                
            DB::commit();

        } catch(Exception $e){
            
            DB::rollBack();
        }

        return Redirect::to('gasto');
    }

    public function show($id){

        //dd($id);    
        /*mostrar gasto*/
        //$id = $request->id;
        $gastos=DB::table('gastos as c')
        ->join('gastos_det as cdet','c.id','=','cdet.gasto_id')
        ->join('proveedores as p','p.id','=','c.proveedor_id')
        ->select('c.id','c.fact_compra','c.fecha','c.total','p.nombre','c.iva',
        'p.nombre','p.ruc'
        ,DB::raw('sum(cdet.cantidad*precio) as total'))
        ->where('c.id','=',$id)
        ->orderBy('c.id', 'desc')
        ->groupBy('c.id','c.fact_compra','c.fecha','c.total','p.nombre','c.iva',
        'p.nombre','p.ruc')
        ->first();

        /*mostrar detalles*/
        $detalles=DB::table('gastos_det as cdet')
        ->join('conceptos as p','cdet.concepto_id','=','p.id')
        ->select('cdet.cantidad','cdet.precio','p.descripcion as concepto')
        ->where('cdet.gasto_id','=',$id)
        ->orderBy('cdet.id', 'desc')->get();

        $pagos=DB::table('pagos_gasto as pc')
        //->join('gastos as c','c.id','=','pc.factura_id')
        ->select('pc.factura_id','pc.total_pag','pc.total_pagf','pc.total_pagtr','pc.total_pagch'
        ,'pc.total_pagtd','pc.total_pagtc','pc.fec_pag')
        ->where('pc.factura_id','=',$id)
        ->orderBy('pc.id','asc')
        ->get();

        if($pagos->isEmpty()){
                $pagos="Vacio";
            }
        
        return view('gasto.show',['gastos' => $gastos,'detalles' =>$detalles,'pagos' =>$pagos]);
    }
    
    public function edit(Request $request){


            $gasto = Gasto::findOrFail($request->id_gasto);
            $gasto->estado = 1;
            $gasto->save();
            return Redirect::to('gasto');

    }

     public function pagarGasto($id)
    {
        //dd($id);
        $id = $id;

        $bancos=DB::table('bancos')
            ->select('bancos.id','bancos.descripcion')
            ->get();
        
        $cuentas=DB::table('cuentas_corriente as cc')
        ->join('bancos as b','b.id','=','cc.banco_id')
        ->select('cc.id','cc.nro_cuenta','cc.banco_id','b.descripcion as banco')
        ->get();

        $gastos=DB::table('gastos as c')
            ->join('gastos_det as cdet','c.id','=','cdet.gasto_id')
            ->join('proveedores as p','p.id','=','c.proveedor_id')
            ->join('users as u','u.id','=','c.user_id')
            ->select('c.id','c.fact_compra','c.iva','c.fecha','c.total','c.estado','p.nombre','c.estado_pago')
            ->where('c.id','=',$id)
            ->orderBy('c.id','desc')
            ->groupBy('c.id','c.fact_compra','c.iva','c.fecha','c.total','c.estado','p.nombre','c.estado_pago')
            ->first();

        $pagos=DB::table('pagos_gasto as pc')
        ->join('gastos as c','c.id','=','pc.factura_id')
        ->select('pc.id','c.fact_compra','c.fecha','c.total','c.estado','c.estado_pago',
         DB::raw('sum(total_pag) as capital_pagado'))
        ->where('pc.factura_id','=',$id)
        ->orderBy('pc.id','desc')
        ->groupBy('pc.id','c.fact_compra','c.fecha','c.total','c.estado','c.estado_pago')
        ->get();
        //dd($pagos[0]->capital_pagado);
        if($pagos->isNotEmpty()){
            $saldo_pagar=$gastos->total - $pagos[0]->capital_pagado;
            //dd($saldo_pagar);
            return view('gasto.pagarFactura',['id' => $id,'bancos' => $bancos,'gastos' => $gastos,
        'saldo_pagar'=>$saldo_pagar,'cuentas'=>$cuentas]);
                   }
            
        else{
            $saldo_pagar=$gastos->total;
            return view('gasto.pagarFactura',['id' => $id,'bancos' => $bancos,'gastos' => $gastos,
            'saldo_pagar'=>$saldo_pagar,'cuentas'=>$cuentas]); 
        }

    }

    public function pagarFactGasto(Request $request)
    {
        //dd($request);
        try
            {        
                DB::beginTransaction();
                // Empezamos a cobrar
                $now = Carbon::now();
                $pago_gasto= new Pago_gasto();
                $pago_gasto->factura_id=$request->id_factura;

                //$ingreso=strval($request->total_pagadof+$request->total_pagadoch+$request->total_pagadotc+$request->total_pagadotd+$request->total_pagadotr);

                if($request->total_pagadof == null)
                    $pago_gasto->total_pagf = 0;
                else
                    $pago_gasto->total_pagf = str_replace(".","",$request->total_pagadof);
                //dd($pago_gasto->total_pagf);
                if($request->total_pagadoch == null)
                    $pago_gasto->total_pagch = 0;
                else
                $pago_gasto->total_pagch = str_replace(".","",$request->total_pagadoch);
                
                $pago_gasto->nro_cheque = $request->nro_cheque;
                $pago_gasto->banco_cheque = $request->ban_che_id;
                $pago_gasto->librador = '';

                if($request->total_pagadotc == null)
                    $pago_gasto->total_pagtc = 0;
                else
                $pago_gasto->total_pagtc = str_replace(".","",$request->total_pagadotc);
                
                $pago_gasto->banco_tcredito = 0;
                $pago_gasto->nro_tcredito = $request->nro_tcredito;

                if($request->total_pagadotd == null)
                    $pago_gasto->total_pagtd = 0;
                else
                $pago_gasto->total_pagtd = str_replace(".","",$request->total_pagadotd);

                $pago_gasto->banco_tdebito = 0;
                $pago_gasto->nro_tdebito = $request->nro_tdebito;

                $request->total_pagadotr=$request->total_pagadotr == NULL ? 0 : $request->total_pagadotr;
                $pago_gasto->total_pagtr = str_replace(".","",$request->total_pagadotr);
                $pago_gasto->nro_cuenta = $request->cuenta_id;

                $ingreso=$pago_gasto->total_pagf+$pago_gasto->total_pagch+$pago_gasto->total_pagtc+$pago_gasto->total_pagtd+$pago_gasto->total_pagtr;

                //dd($ingreso);
                $diferencia = ($request->saldo) - $ingreso;
                $pago_gasto->capital = $ingreso;
                $pago_gasto->total_pag = $ingreso;

                if ($diferencia<=0){
                    $pago_gasto->pago_est = "C";
                    $item = Gasto::findOrFail($request->id_factura);
                    $item->estado_pago='C';
                    $item->update();
                }
                else
                {
                    $pago_gasto->pago_est = "P";
                }
                $pago_gasto->fec_pag = $now;
                $pago_gasto->usuario_id = auth()->user()->id;

                $pago_gasto->save();

                DB::commit();
            }
            catch(Exception $e){        
                    DB::rollBack();
        }
        return Redirect::to("gasto");
    }

    public function destroy($id)
    {
        
         try{

            DB::beginTransaction();


            $gastos = Gasto::findOrFail($id);
            //dd($venta);

            if($gastos->estado == 1){
                
                $gastos = DB::table('gastos as g')
                ->select('id')
                ->where('g.id', '=', $id)
                ->first();

                if(isset($gastos)){
                    $gastos_det = DB::table('gastos_det as gdet')
                    ->select('id')
                    ->where('gdet.gasto_id', '=', $id)
                    ->get();
                //dd($ventas_det);

                    for ($i = 0; $i < sizeof($gastos_det); $i++) {
                        Gasto_det::destroy($gastos_det[$i]->id);
                    }
                    Gasto::destroy($id);

                }
                //dd($ventas_det);

            }
            else{
                return Redirect::to('gasto')->with('msj', 'FACTURA COMPRA DEBE SER ANULADA ANTES DE BORRAR');

            }

            DB::commit();

        } catch(Exception $e){
            
            DB::rollBack();
        }

        return Redirect::to('gasto')->with('msj', 'FACTURA ELIMINADA');
    }

    public function gastoContable(Request $request)
    {
        $gastos = Gasto::findOrFail($request->id_gasto);

        if($gastos->contable == 0)
            $gastos->contable = 1;
        else
            $gastos->contable = 0;
        $gastos->update();

        return Redirect::to('gasto')->with('msj2', 'ESTADO CONTABLE DEL GASTO HA CAMBIADO');
    }

}
