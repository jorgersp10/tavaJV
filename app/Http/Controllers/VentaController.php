<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inmueble;
use App\Models\Mueble;
use App\Models\Factura;
use App\Models\Factura_Det;
use App\Models\Timbrado;
use App\Models\Proforma;
use App\Models\Cuota;
use App\Models\Cuota_det;
use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $idCliente=$request->idCliente;
        $idCliente="0";
        $proforma=Proforma::join('clientes','clientes.id','=','proforma.cliente_id')
        ->select('proforma.id','proforma.producto','proforma.precio_inm','clientes.nombre')
        ->where('proforma.estado','=',0)
        ->orderBy('proforma.primer_vto','asc')
        ->simplepaginate(10);
 
        $clientes=DB::table('clientes')
        ->select('clientes.id','clientes.tipo_documento','clientes.num_documento','clientes.nombre')->get();

        return view('venta.index',["proforma"=>$proforma,
        "clientes"=>$clientes,"idCliente"=>$idCliente]);
    }

    public function getClientesVen(Request $request)
    {
 
    	$search = $request->search;

        if($search == ''){
            $clientes = Cliente::orderby('nombre','asc')
                    ->select('id','nombre')
                    ->limit(5)
                    ->get();
        }else{
            $search = str_replace(" ", "%", $search);
            $clientes = Cliente::orderby('nombre','asc')
                    ->select('id','nombre','apellido','num_documento')
                    ->where('nombre','like','%'.$search.'%')
                    //->orWhere('apellido','like','%'.$search.'%')
                    ->orWhere('num_documento','like','%'.$search.'%')
                    ->limit(5)
                    ->get();
        }

        $response = array();

        foreach($clientes as $cliente){
            $response[] = array(
                'id' => $cliente->id,
                'text' => $cliente->nombre." - ".$cliente->num_documento
            );
        }
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        // $nro_prof=DB::table('inmuebles')
        // ->select('proforma_id')
        // ->where('id','=',$request->id_inmuebleven)
        // ->first();

        $nro_prof= DB::table('proforma')
        ->select('id')
        ->where('id','=',$request->proforma_id)
        ->first();
        $nro_prof=$nro_prof->id;

        $fecha_fac= Carbon::now('America/Asuncion');
        
        $proformac=DB::table('proforma')
        ->select('id','producto','cliente_id','precio_inm','tiempo','primer_vto','entrega','entrega_vto','refuerzo','refuerzo_can','refuerzo_per','refuerzo_vto')
        ->where('id','=',$nro_prof)
        ->first();

        $proformad= DB::table('proforma_det')
        ->select('proforma_id','cuota_nro','fec_vto','capital','interes','iva','total_cuota')
        ->where('proforma_id','=',$nro_prof)
        ->get();


        try{
    
            DB::beginTransaction();

            if ($request->descripcion_fac==null)
                    $request->descripcion_fac="";
            
            // $inm_act= Inmueble::findOrFail($proformac->inmueble_id);
            // $inm_act->estado=2;
            // $inm_act->vendedor_id=$request->vendedor_id;
            // $inm_act->descripcion_fac=$request->descripcion_fac;
            // $inm_act->update();

            $cuota= new Cuota();
            //$cuota->inmueble_id=$proformac->inmueble_id;
            $cuota->producto=$proformac->producto;
            $cuota->cliente_id=$proformac->cliente_id;
            $cuota->tiempo=$proformac->tiempo;
            $cuota->entrega=$proformac->entrega;
            $cuota->entrega_vto=$proformac->entrega_vto;
            $cuota->refuerzo=$proformac->refuerzo;
            $cuota->refuerzo_can=$proformac->refuerzo_can;
            $cuota->refuerzo_per=$proformac->refuerzo_per;
            $cuota->refuerzo_vto=$proformac->refuerzo_vto;
            $cuota->precio_inm=$proformac->precio_inm;
            if(($request->factura!=null) || ($request->factura!=0))
                $cuota->factura=$request->factura;
            else    
                $cuota->factura=0;
            $cuota->usuario=auth()->user()->id;
            //dd($cuota);
            $cuota->save();

                foreach($proformad as $cuotas){
                
                    $detalle = new Cuota_det();
                    $detalle->cuota_id=$cuota->id;
                    $detalle->cuota_nro=$cuotas->cuota_nro;
                    $detalle->fec_vto=$cuotas->fec_vto;
                    $detalle->fec_pag=$cuotas->fec_vto;
                    // if($inm_act->moneda=='US')
                    // {
                    //     $detalle->capital=round($cuotas->capital,2);
                    //     $detalle->interes=round($cuotas->interes,2);
                    //     $detalle->iva=round($cuotas->iva,2);
                    // }
                    // else
                    // {
                        $detalle->capital=round($cuotas->capital,0);
                        $detalle->interes=round($cuotas->interes,0);
                        $detalle->iva=round($cuotas->iva,0);
                    //}

                    $detalle->estado_cuota='P';
                    $detalle->total_cuota=$cuotas->total_cuota;
                    
                    $detalle->save();
                }                 

                // $factura= new Factura();
                // ///
                // $factura->fec_factura=$fecha_fac;
                // $factura->nrof_suc=$request->nrof_sucursal;
                // $factura->nrof_expendio=$request->nrof_expendio;
                // $factura->nrof_factura=$request->nrof_factura;
                // $factura->timbrado=0;
                // $factura->doc_cliente=$proformac->cliente_id;
                // $factura->tipo_factura='CR';
                // ///
                // //$texe=($request->tc_a_pagar*70)/100;
                // $texe=((($request->tc_a_pagar*100)/101.5)*70)/100;
                //     if ($inm_act->moneda=='GS')
                //     {
                //         $texe=round($texe,0);
                //     }
                //     if ($inm_act->moneda=='GS')
                //     {
                //         $request->tc_a_pagar=round($request->tc_a_pagar,0);
                //     }
                // $tcin=$request->tc_a_pagar-$texe;
                // $tivcin=$tcin-($tcin/1.05);
                //     if ($inm_act->moneda=='GS')
                //     {
                //         $tivcin=round($tivcin,0);
                //     }
                // $factura->total_exe=$texe;
                // $factura->total_iv5=$tcin;
                // $factura->iv5=$tivcin;
                
                // $factura->total_iv10=0;
                // $factura->total_iva=0;
                // $factura->iv10=0;
                // $factura->total_gral=$request->tc_a_pagar;
                // $factura->tran_inmo=0;
                // $factura->usuario_id=auth()->user()->id;
                // $factura->inmueble_id=$inm_act->id;
                // $factura->moneda=$inm_act->moneda;
                // $factura->save();

                // //dd($factura);
                // $factura_det= new Factura_det();
                // $factura_det->factura_id=$factura->id;
                // $factura_det->cod_mercaderia=30;
                // $factura_det->cantidad=1;
                
                // $factura_det->descripcion_fac=$request->descripcion_fac;
                // $factura_det->precio_uni=$request->tc_a_pagar;
                // $factura_det->precio_exe=$texe;
                // $factura_det->precio_iv5=$tcin;
                // $factura_det->precio_iv10=0;

                // $factura_det->save();
            $proforma= Proforma::findOrFail($request->proforma_id);
            $proforma->estado=1;
            $proforma->save();
            
            DB::commit();

            return Redirect::to("venta");

            } 
        catch(Exception $e){        
                DB::rollBack();
        }
        

        return Redirect::to("venta");
      
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $proforma=Proforma::join('clientes','clientes.id','=','proforma.cliente_id')
        ->select('proforma.id','proforma.producto','proforma.precio_inm','clientes.nombre')
        ->where('proforma.id','=',$id)
        //->orderBy('proforma.primer_vto','asc')
        ->get();

        // $inmuebles=Inmueble::join('proforma','inmuebles.proforma_id','=','proforma.id')
        // ->join('clientes','clientes.id','=','proforma.cliente_id')
        // ->join('estado_inm','inmuebles.estado','=','estado_inm.id')
        // ->select('inmuebles.id','inmuebles.descripcion','inmuebles.moneda','inmuebles.descripcion_fac',
        // 'inmuebles.precio','inmuebles.proforma_id','estado_inm.estado as est_des','clientes.nombre')
        // ->where('inmuebles.id','=',$id)
        // ->where('inmuebles.estado','=',1)
        // ->orderBy('inmuebles.descripcion','desc')
        // ->get();

        $fecha_fac=Carbon::now();
        $fecha_fac=$fecha_fac->format('Y-m-d');

        // $timbrado=DB::table('timbrados')
        // ->select('id','nro_timbrado','nrof_suc','nrof_expendio','nrof_factura','ini_timbrado','fin_timbrado')
        // ->where('ini_timbrado','<=',$fecha_fac)
        // ->where('fin_timbrado','>=',$fecha_fac)
        // ->first();

        //dd($timbrado);

        // if ($timbrado==null)
        // {
        //     $nro_tim=0;
        //     $nrof_fac=0;        
        // }
        //     else
        // {
        //     $nro_tim=$timbrado->nro_timbrado;
        //     $nrof_suc=$timbrado->nrof_suc;
        //     $nrof_exp=$timbrado->nrof_expendio;
        //     $nrof_fac=$timbrado->nrof_factura;
        // }


        $nro_prof= DB::table('proforma')
        ->select('id')
        ->where('id','=',$id)
        ->first();
        $nro_prof=$nro_prof->id;
        
        $cuotas= DB::table('proforma_det')
        ->select('id','cuota_nro','fec_vto','capital','interes','total_cuota')
        ->where('proforma_id','=',$nro_prof)
        ->get();
        
        $vendedores= DB::table('vendedores')
        ->select('id','name')
        ->get();

        $totales= DB::table('proforma_det')
        ->select('proforma_id',
        DB::raw('sum(capital) as capital_a_pagar'),
        DB::raw('sum(interes) as interes_a_pagar'),
        DB::raw('sum(total_cuota) as tc_a_pagar'))
        ->where('proforma_id','=',$nro_prof)
        ->groupby('proforma_id')
        ->get();


        return view('venta.show',["proforma"=>$proforma,"nro_prof"=>$nro_prof,
        "cuotas"=>$cuotas,"totales"=>$totales,
        "vendedores"=>$vendedores]);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Imagen::findOrFail($id);
        $item->delete();
        return response()->json('Deleted', 200);
    }

    public function calculos()
    {

        return view('venta.calculos');
    }

    public function proformaPDF(Request $request)
    {
        //dd($request);
        $cuotas_arr=json_decode($request->cuotas_arr);
        $precio_inm=$request->precio_inm;
        $cliente=$request->cliente;
        //dd($cuotas_arr);
        return view('venta.impresion',["cuotas_arr"=>$cuotas_arr,
        "cliente"=>$cliente,"precio_inm"=>$precio_inm]);
    }
}
