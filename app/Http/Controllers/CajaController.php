<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Cajero;
use App\Models\Inmueble;
use App\Models\Mueble;
use App\Models\Tipo_mueble;
use App\Models\Acuerdo;
use App\Models\Tipo_acuerdo;
use App\Models\Cuota;
use App\Models\Cuota_det;
use App\Models\Pago;
use App\Models\Venta;
use App\Models\Pago_Trn;
use App\Models\Recibo_Param;
use App\Models\Factura;
use App\Models\Factura_Det;
use App\Models\Parametro;
use App\Models\Loteamiento;
use App\Models\Recibo;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\NumerosEnLetras;
use DateTime;
use DB;
use PDF;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
            $caja_nro = DB::select('select caja_nro from cajeros where user_id = ? ',[auth()->user()->id]);
            if($caja_nro == NULL)
                $caja_nro = "No es cajero";
            else
            $caja_nro = $caja_nro[0]->caja_nro;
            //dd($caja_nro);

            // /*listar los tipos de movimientosl*/
            $tipo_mov=DB::table('tipo_movimientos')
            ->select('id','descripcion','ing_egr')
            ->where('id','!=','0')->get(); 
            //Listar los clientes
            $clientes=DB::table('clientes')
            ->select('clientes.fecha_nacimiento','clientes.edad','clientes.id',
            'clientes.nombre','clientes.tipo_documento','clientes.num_documento',
            'clientes.direccion','clientes.telefono','clientes.email',
            'clientes.estado_civil',
            'clientes.sexo','clientes.user')
            ->orderBy('clientes.id','desc')
            ->get();

            $bancos=DB::table('bancos')
            ->select('bancos.id','bancos.descripcion')
            ->get();

            $tipos_iva=DB::table('ivas as i')
            ->select('i.id','i.descripcion','i.iva')
            ->get();

            $cuentas=DB::table('cuentas_corriente as cc')
            ->join('bancos as b','b.id','=','cc.banco_id')
            ->select('cc.id','cc.nro_cuenta','cc.banco_id','b.descripcion as banco')
            ->get();

            $cuotaCaja = null;
            $inmueble= ['id'=>'0','descripcion'=>""];
            return view('caja.index',["caja_nro"=>$caja_nro,"tipo_mov"=>$tipo_mov,
            "clientes"=>$clientes,"cuotaCaja"=>$cuotaCaja,"inmueble"=>$inmueble,
            "bancos"=>$bancos,"cuentas"=>$cuentas,"tipos_iva"=>$tipos_iva]);
            
        
            //return $usuarios;
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    //BUSCADOR DE CLIENTE
    public function getClientes(Request $request)
    {
        //console.log("llego aca");
    	$search = $request->search;

        if($search == ''){
            $clientes = Cliente::orderby('nombre','asc')
                    ->select('id','nombre','num_documento','digito')
                    ->limit(5)
                    ->get();
        }else{
            $search = str_replace(" ", "%", $search);
            $clientes = Cliente::orderby('nombre','asc')
                    ->select('id','nombre','apellido','num_documento','digito')
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
                'text' => $cliente->nombre." - ".$cliente->num_documento." - ".$cliente->digito
            );
        }
        return response()->json($response);
    }
    
    public function obtenerInmuebles(Request $request)
    {

        $cuotas=Cuota::join('cuotas_det','cuotas_det.cuota_id','=','cuotas.id')
        ->join('clientes','clientes.id','=','cuotas.cliente_id')
        ->select('cuotas.id','cuotas.factura_id','cuotas.precio_inm','clientes.nombre','cuotas.factura',DB::raw('MIN(cuotas_det.fec_vto) as fec_vto'))
        ->where('cuotas.cliente_id','=',$request->id)
        ->where('cuotas_det.estado_cuota','=','P')
        ->groupBy('cuotas.id','cuotas.factura_id','cuotas.precio_inm','clientes.nombre','cuotas.factura')
        ->get();

        return $cuotas;
    }

    public function obtenerCuotas(Request $request)
    {
        //dd($request);
        $cajaCont= new CajaController();

        //$inm= Inmueble::findOrFail($request->id);
        $param_mora= Loteamiento::findOrFail(1);

        $cuotas=$cajaCont->cuotas_mora_inm($request->id);
        
        return $cuotas;
    }
    

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
    public function recibo(Request $request)
    {
        return view('caja.recibo');
    }
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function pagar(Request $request)
    {
        //dd($request);
        $cajaContPagar= new CajaController();

        try
        {
    
            DB::beginTransaction();

            $trn = Pago_Trn::findOrFail(1);
            $trn->id_transaccion=$trn->id_transaccion+1;
            $tran=$trn->id_transaccion;
            $trn->update();

            $request->total_pagadof = isset($request->total_pagadof) ? ($request->total_pagadof) : 0;
            $request->total_pagadoch = isset($request->total_pagadoch) ? ($request->total_pagadoch) : 0;
            $request->total_pagadotc = isset($request->total_pagadotc) ? ($request->total_pagadotc) : 0;
            $request->total_pagadotd = isset($request->total_pagadotd) ? ($request->total_pagadotd) : 0;
            $request->total_pagadotr =  isset($request->total_pagadotr) ? ($request->total_pagadotr) : 0;

            // Sumamos todas las fuentes de Ingreso a la variable ingreso
            //$ingreso=($request->total_pagadof+$request->total_pagadoch+$request->total_pagadotc+$request->total_pagadotd+$request->total_pagadotr)- $request->total_vuelto;
            $ingreso=(str_replace(".","",$request->total_pagadof)+str_replace(".","",$request->total_pagadoch)+str_replace(".","",$request->total_pagadotc)+str_replace(".","",$request->total_pagadotd)+str_replace(".","",$request->total_pagadotr))- $request->total_vuelto;
            //dd($ingreso);
            $venta_id = DB::select('select factura_id from cuotas where id = ? ',[$request->id_cuota]);
            //dd($ingreso);
            //CAMBIAMOS EL ESTADO DE LA VENTA

            $venta_id = $venta_id[0]->factura_id;           
            $ventaMonto=Venta::findOrfail($venta_id);
            
            if($ingreso >= $ventaMonto->total)
            {
                $ventaMonto->estado_pago = "C";
            }
            else
            {
                $ventaMonto->estado_pago = "P";
            }
            //dd($ventaMonto->estado_pago);
            $ventaMonto->update();

            $pcc=0; //Primera cuota cobrada
            $ucc=0; //Ultima cuota cobrada
            $regpag=0; //Para Registrar Pagos en la primera linea solamente
            $tipo_pago=0;

            
                //$inm= Inmueble::findOrFail($request->id_inmueble);
                $cuotas=$cajaContPagar->cuotas_mora_inm($request->id_cuota);
                $tipo_pago=1;
                //dd($cuotas);
            
 
            // Empezamos a cobrar
            
            for($i = 0 ; $i < sizeof($cuotas); $i++)
            {
                if ($ingreso>0)
                {
                    $now = Carbon::now();
                    $pago= new Pago();
                    $pagomora=0;
                    $pagoTodo=0;
                    $pagoTodoMora=0;
                    $pagosCont=0;
                    if ($tipo_pago==1){
                        $pago->factura_id = $request->producto;
                    }
                    
                    $pago->transaccion=$tran;
                    if ($regpag==0)
                    {
                        
                        $regpag=1;
                        if($request->total_pagadof == null)
                            $pago->total_pagf = 0;
                        else
                            $pago->total_pagf = str_replace(".","",$request->total_pagadof);
                        
                        if($request->total_pagadoch == null)
                            $pago->total_pagch = 0;
                        else
                        $pago->total_pagch = str_replace(".","",$request->total_pagadoch);
                        
                        $pago->nro_cheque = $request->nro_cheque;
                        $pago->banco_cheque = $request->ban_che_id;
                        $pago->librador = '';
                        
                        if($request->total_pagadotc == null)
                            $pago->total_pagtc = 0;
                        else
                           $pago->total_pagtc = str_replace(".","",$request->total_pagadotc);
    
                        // $pago->total_pagtc = str_replace(".","",$request->total_pagadotc);
                        $pago->banco_tcredito = 0;
                        $pago->nro_tcredito = $request->nro_tcredito;
                        
                        if($request->total_pagadotd == null)
                            $pago->total_pagtd = 0;
                        else
                           $pago->total_pagtd = str_replace(".","",$request->total_pagadotd);
    
                        // $pago->total_pagtd = str_replace(".","",$request->total_pagadotd);
                        $pago->banco_tdebito = 0;
                        $pago->nro_tdebito = $request->nro_tdebito;
                        
                        if($request->total_pagadotr == null)
                            $pago->total_pagtr = 0;
                        else
                            $pago->total_pagtr = str_replace(".","",$request->total_pagadotr);
                        $pago->nro_cuenta = $request->cuenta_id;
                        // $request->total_pagadotr=$request->total_pagadotr == NULL ? 0 : $request->total_pagadotr;
                        // $pago->total_pagtr = str_replace(".","",$request->total_pagadotr);
                    }
                    else
                    {
                        $regpag=1;
                        $pago->total_pagf = 0;

                        $pago->total_pagch = 0;
                        $pago->nro_cheque = 0;
                        $pago->banco_cheque = 0;
                        $pago->librador = '';
    
                        $pago->total_pagtc = 0;
                        $pago->banco_tcredito = 0;
                        $pago->nro_tcredito = '';
    
                        $pago->total_pagtd = 0;
                        $pago->banco_tdebito = 0;
                        $pago->nro_tdebito = '';

                        $pago->total_pagtr = 0;
                    }
    
                    $pago->moneda="GS";
                    $pago->cuota_id = $cuotas[$i]->id;
                    if ($pcc==0)
                    {
                        $pcc=$cuotas[$i]->cuota_nro;
                    }
                    $ucc=$cuotas[$i]->cuota_nro;   
                    
                    //$pago->iddetcuo = $cuotas[$i]->iddetcuo;
                    if ($ingreso>=$cuotas[$i]->mora){
                        $pago->moratorio = $cuotas[$i]->mora;
                        $ingreso=$ingreso-$cuotas[$i]->mora;
                    }
                        
                    else
                    {
                        $pago->moratorio = $ingreso;
                        $ingreso=0;
                    }
    
                    if ($ingreso>=$cuotas[$i]->punitorio){
                        $pago->punitorio = $cuotas[$i]->punitorio;
                        $ingreso=$ingreso-$cuotas[$i]->punitorio;
                        $pagoTodoMora=1;
                    }
                    else
                    {
                        $pago->punitorio = $ingreso;
                        $ingreso=0;
                    }
    
                    $pagomora=$pago->punitorio+$pago->moratorio;
    
                    // if ($pagomora>0)
                    // {
                    //     $pago->iva=round(($pagomora-($pagomora/1.1)),0);
                    // }else
                    // {
                    $pago->iva = 0;
                    //}
    
                    if ($ingreso>=$cuotas[$i]->interes){
                        $pago->interes = $cuotas[$i]->interes;
                        $pagointeres=$cuotas[$i]->interes;
                        $ingreso=$ingreso-$cuotas[$i]->interes;
    
                    }
                    else{
                        $pago->interes = $ingreso;
                        $pagointeres=$ingreso;
                        $ingreso=0;
                    }
    
                    if ($ingreso>=$cuotas[$i]->capital){
                        $pago->capital = $cuotas[$i]->capital;
                        $pagocapital=$cuotas[$i]->capital;
                        $ingreso=$ingreso-$cuotas[$i]->capital;
                        
                        $pagoTodo=1;
                    }
                    else
                    {
                        $pago->capital = $ingreso;
                        $pagocapital=$ingreso;
                        $ingreso=0;
                    }
    
                    $pago->cuota = $cuotas[$i]->cuota_nro;
                    $pago->plazo = $cuotas[$i]->plazo;
                    $pago->total_pag =$pagomora+$pagocapital+$pagointeres;
                    $pago->saldo = $cuotas[$i]->capital - $pago->total_pag;
                    //dd($pago);
                    $pago->fec_pag = $now;
                    $pago->fec_vto = $cuotas[$i]->fec_vto;
                    $pago->usuario_id = auth()->user()->id;
    
                    if ($pagoTodo==1){
                        $pago->pago_est = "C";
                    }
                    else
                    {
                        $pago->pago_est = "P";
                    }
                    $pago->nro_pago = $pagosCont + 1;
                    $pago->save();
                    
                    if ($pagoTodoMora==1){
                        $item = Cuota_det::findOrFail($cuotas[$i]->iddetcuo);
                        $item->fec_pag=$now;
                        $item->update();
                    }
                    if ($pagoTodo==1){
                        $item = Cuota_det::findOrFail($cuotas[$i]->iddetcuo);
                        $item->estado_cuota='C';
                        $item->update();
                    }
    
                }

            }
     
            if ($tipo_pago==1){
                $recibo=DB::table('pagos as p')
                ->join('cuotas as c','c.id','=','p.cuota_id')
                ->join('ventas as v','v.id','=','c.factura_id')
                ->join('clientes as cli','cli.id','=','c.cliente_id')
                ->select('cli.id as cliente_id','cli.nombre as nombre_cliente','p.factura_id as inm_nro',
                'p.plazo','p.fec_pag as fec_pag','c.factura','v.fact_nro',
                DB::raw('sum(capital) as capital_pagado'),
                DB::raw('sum(interes) as interes_pagado'),
                DB::raw('sum(iva) as iva_pagado'),
                DB::raw('sum(moratorio) as moratorio_pagado'),
                DB::raw('sum(punitorio) as punitorio_pagado'),
                DB::raw('sum(total_pag) as tot_pag'))
                ->where('p.transaccion','=',$tran)
                ->groupby('cli.id','cli.nombre','p.factura_id','p.cuota_id','p.plazo','p.fec_pag','c.factura'
                ,'v.fact_nro')
                ->get();
            }    

            $ids = DB::select('select id from recibos_param where suc_recibo= ?',[auth()->user()->idsucursal]);
            $tran_rec= Recibo_Param::findOrFail($ids[0]->id);
            $tran_rec->nro_recibo=$tran_rec->nro_recibo+1;
            $nrorec=$tran_rec->nro_recibo;
            $tran_rec->update();

            $rec= new Recibo();
            $rec->fec_recibo= $recibo[0]->fec_pag;
            $rec->nro_recibo = $nrorec;
            $rec->doc_cliente = $recibo[0]->cliente_id;
            $rec->monto_pag= $recibo[0]->capital_pagado+$recibo[0]->interes_pagado;
            $rec->tran_inmo= $tran;
            $rec->pcc= $pcc;
            $rec->ucc= $ucc;
            $rec->plazo= $recibo[0]->plazo;
            $rec->factura= $recibo[0]->fact_nro;
            //dd($rec);
            $rec->usuario_id = auth()->user()->id;
            $rec->save();

            $mor_pun=$recibo[0]->moratorio_pagado+$recibo[0]->punitorio_pagado;
            if ($mor_pun>0){
                $fac= new Factura();
                $fac->fec_factura= $recibo[0]->fec_pag;
                $fac->nrof_suc= 0;
                $fac->nrof_expendio = 0;
                $fac->nrof_factura = 0;
                $fac->timbrado = 0;
                $fac->doc_cliente = $recibo[0]->cliente_id;
                $fac->tipo_factura = "CO";
                $fac->total_exe= 0;
                $fac->total_iv5= 0;
                $fac->iv5= 0;
                $fac->total_iv10= $mor_pun;
                $fac->iv10= $recibo[0]->iva_pagado;
                $fac->total_iva= 0;
                $fac->total_gral= $mor_pun;
                $fac->tran_inmo= $tran;
                if ($tipo_pago==1){
                   
                    $fac->cuota_id=$cuotas[0]->id;
                    //$fac->inmueble_id=$inm->id;
                }
                if ($tipo_pago==2){
                    $fac->mueble_id=0;
                    //$fac->mueble_id=$inm->id;
                }
                
                $fac->moneda=$cuotas[0]->moneda;
                $fac->usuario_id = auth()->user()->id;
                $fac->save();
                    
                    if ($recibo[0]->moratorio_pagado>0)
                    {
                        $fac_det1= new Factura_Det();
                        $fac_det1->factura_id=$fac->id;
                        $fac_det1->cod_mercaderia="10";
                        $fac_det1->descripcion_fac="Moratorio Cuota Nro ".$pcc."-".$ucc." de ".$recibo[0]->plazo;
                        $fac_det1->cantidad=1;
                        $fac_det1->precio_uni=$recibo[0]->moratorio_pagado;
                        $fac_det1->precio_exe=0;
                        $fac_det1->precio_iv5=0;
                        $fac_det1->precio_iv10=$recibo[0]->moratorio_pagado;
                        $fac_det1->save();

                    }
                    if ($recibo[0]->punitorio_pagado>0)
                    {
                        $fac_det2= new Factura_Det();
                        $fac_det2->factura_id=$fac->id;
                        $fac_det2->cod_mercaderia="20";
                        $fac_det2->descripcion_fac="Punitorio Cuota Nro ".$pcc."-".$ucc." de ".$recibo[0]->plazo;
                        $fac_det2->cantidad=1;
                        $fac_det2->precio_uni=$recibo[0]->punitorio_pagado;
                        $fac_det2->precio_exe=0;
                        $fac_det2->precio_iv5=0;
                        $fac_det2->precio_iv10=$recibo[0]->punitorio_pagado;
                        $fac_det2->save();
                    }
            }
        
       
        
        DB::commit();
            ///////////////////////////////////////////////////
            //Datos descripción del recibo
            

            $tot_pag = $recibo[0]->tot_pag;
            $tot_pag_let=NumerosEnLetras::convertir($tot_pag,'Guaranies',false,'Centavos');

        } 
        catch(Exception $e){        
                DB::rollBack();
        }
        return Redirect::to("pago");
        

    }

    public function cuotas_mora_inm($id_cuota)
    {

        $cuo= Cuota::findOrFail($id_cuota);
        $param_mora= Loteamiento::findOrFail(1);

        // Generamos todas las cuotas pendientes de Pago para ese Inmueble
        $cuotas=DB::table('cuotas_det as cd')
        ->join('cuotas as c','c.id','=','cd.cuota_id')
        //->join('inmuebles as i','c.inmueble_id','=','i.id')
        ->select('c.id',
        'cd.id as iddetcuo','c.tiempo as plazo','cd.cuota_nro','cd.capital','cd.interes','cd.iva',
        'cd.total_cuota','cd.fec_vto','cd.estado_cuota','cd.fec_pag','c.moneda',
        DB::raw('0 as mora'),
        DB::raw('0 as punitorio'),
        DB::raw('0 as iva'),
        DB::raw('0 as total_c'),
        DB::raw('0 as capital_pagado'),
        DB::raw('0 as interes_pagado'),
        DB::raw('0 as moratorio_pagado'),
        DB::raw('0 as punitorio_pagado'),
        DB::raw('0 as iva_pagado') )
        ->where('c.id','=',$id_cuota)
        ->where('cd.estado_cuota','=','P')
        ->orderBy('cd.cuota_nro')
        ->get();

        //dd($cuotas);
       
        // Si existen cuotas pendientes verificamos si existen pagos para esas cuotas
            if (sizeof($cuotas)>0)
            {
            $pagos=DB::table('pagos as p')
            ->select('p.factura_id','p.cuota_id','p.cuota','p.fec_pag',
            DB::raw('sum(capital) as capital_pagado'),
            DB::raw('sum(interes) as interes_pagado'),
            DB::raw('sum(moratorio) as moratorio_pagado'),
            DB::raw('sum(punitorio) as punitorio_pagado'))
            //->where('p.inmueble_id','=',$id_inmueble)
            ->where('p.cuota_id','=',$cuotas[0]->id)
            ->groupby('p.factura_id','p.cuota_id','p.cuota','p.fec_pag')
            ->get();
            }
       
    // Recorremos las cuotas pendientes y vamos descontando
    // de la plata con la que se cuenta para pagar

        for($i = 0 ; $i < sizeof($cuotas); $i++)
        {
            $fecha_hoy= Carbon::now('America/Asuncion');
            $fecha_vto= new Carbon($cuotas[$i]->fec_vto);    
            $fecha_pag= new Carbon($cuotas[$i]->fec_pag); 
            // Cambiamos esto a la inversa 
            //if  ($fecha_vto<$fecha_pag) {
            //    $fecha_vto=$fecha_pag;
            //}

            if  ($fecha_pag>$fecha_vto) {
                $fecha_vto=$fecha_pag;
            }
            
            $ivamora=0;               
            $ivapunitorio=0;
            $pagocapital=0;
            $pagointeres=0;
            

            $diasMora = date_diff($fecha_vto, $fecha_hoy)->format('%R%a');

            //******** Aca se resta la porcion pagada de la cuota ******/
            for($j = 0 ; $j < sizeof($pagos); $j++)
            {
                if($pagos[$j]->cuota==$cuotas[$i]->cuota_nro)
                {
                        $cuotas[$i]->capital=round(($cuotas[$i]->capital-$pagos[$j]->capital_pagado),0);
                        $cuotas[$i]->interes=round(($cuotas[$i]->interes-$pagos[$j]->interes_pagado),0);

                    if ($pagos[$j]->fec_pag>$cuotas[$i]->fec_pag){
                        $cuotas[$i]->moratorio_pagado=$cuotas[$i]->moratorio_pagado+$pagos[$j]->moratorio_pagado;
                        $cuotas[$i]->punitorio_pagado=$cuotas[$i]->punitorio_pagado+$pagos[$j]->punitorio_pagado;
                    }

                }

            }
            // Calculamos la mora
            if ($diasMora>0)
            {
                
                    $cuotas[$i]->mora = round((($cuotas[$i]->capital*$param_mora->mora_gs*$diasMora)/36500),0);
                    $ivamora=round((($cuotas[$i]->mora*10)/100),0);
                    $cuotas[$i]->punitorio = round((($cuotas[$i]->mora *$param_mora->pun_gs)/100),0);

                $cuotas[$i]->mora =$cuotas[$i]->mora +$ivamora;

                    $ivapunitorio=round((($cuotas[$i]->punitorio *10)/100),0);

                $cuotas[$i]->punitorio =$cuotas[$i]->punitorio +$ivapunitorio;

                $cuotas[$i]->mora = $cuotas[$i]->mora -$cuotas[$i]->moratorio_pagado;
                $cuotas[$i]->punitorio = $cuotas[$i]->punitorio -$cuotas[$i]->punitorio_pagado;
                
                    $ivamora=round((($cuotas[$i]->mora*10)/100),0);
                    $ivapunitorio=round((($cuotas[$i]->punitorio *10)/100),0);
                
                //$ivamora=round((($cuotas[$i]->mora*10)/100),0);
                //$ivapunitorio=round((($cuotas[$i]->punitorio *10)/100),0);
                $cuotas[$i]->iva =  $ivamora+$ivapunitorio;
            }
            
            $cuotas[$i]->total_c = $cuotas[$i]->capital+$cuotas[$i]->interes+$cuotas[$i]->mora + $cuotas[$i]->punitorio;

        }
    //dd($cuotas);
    return $cuotas;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$tc)
    {
        //dd($id);

        if($tc=="RECIBO"){
            $rec_tip=DB::table('recibos as rec')
            ->join('pagos as p','p.transaccion','=','rec.tran_inmo')
            ->where('rec.id','=', $id)
            ->get();

           //dd($rec_tip);
            $rec_num=DB::table('recibos as rec')
            ->join('pagos as p','p.transaccion','=','rec.tran_inmo')
            ->join('cuotas as c','p.cuota_id','=','c.id')
            ->select(DB::raw('count(*)'))
            ->where('c.factura','=',  $rec_tip[0]->factura)
            ->first();
            //dd($rec_num);

            //dd($rec_tip);
            if ($rec_tip[0]->factura_id!=null){
                $rec=DB::table('recibos as rec')
                ->join('clientes as cli','cli.id','=','rec.doc_cliente')
                ->join('pagos as p','p.transaccion','=','rec.tran_inmo')
                ->join('ventas_det as vdet','vdet.venta_id','=','p.factura_id')
                ->join('ventas as v','v.id','=','vdet.venta_id')
                ->join('productos as pro','pro.id','=','vdet.producto_id')
                ->select('rec.tran_inmo','rec.id','rec.fec_recibo as fecha','rec.nro_recibo as nro_com',
                'cli.nombre as nombre_cli','rec.monto_pag as total','rec.pcc','rec.ucc','rec.plazo',
                'p.inmueble_id','p.moneda','p.cuota','p.capital','p.interes','p.moratorio','p.punitorio',
                'p.iva','p.factura_id','rec.factura','p.nro_pago',
                'p.total_pag','p.total_pagf','p.total_pagch','p.total_pagtd','p.total_pagtc',
                'p.total_pagtr','p.fec_vto','v.total as total_original',
                'rec.nro_recibo as nro_recibo','cli.num_documento as ruc','vdet.producto_id','pro.descripcion as 
                producto','vdet.cantidad','vdet.precio','v.total as total_venta','pro.precio_venta','p.saldo as saldo',
                DB::raw('"RECIBO" as tipo_com'),
                DB::raw('sum(total_pag) as capital_pagado'))
                ->where('rec.id','=', $id)
                ->groupby('rec.tran_inmo','rec.id','rec.fec_recibo','rec.nro_recibo',
                'cli.nombre','rec.monto_pag','rec.pcc','rec.ucc','rec.plazo',
                'p.inmueble_id','p.moneda','p.cuota','p.capital','p.interes','p.moratorio','p.punitorio',
                'p.iva','p.factura_id','rec.factura','p.nro_pago',
                'p.total_pag','p.total_pagf','p.total_pagch','p.total_pagtd','p.total_pagtc',
                'p.total_pagtr','p.fec_vto','v.total',
                'rec.nro_recibo','cli.num_documento','vdet.producto_id','pro.descripcion','vdet.cantidad','vdet.precio','v.total','pro.precio_venta','p.saldo')
                ->get();
            }
            //dd($rec);
            $tp = $rec[0]->total;
            //dd($tp);
            if($rec[0]->moneda == "GS"){
                $tot_pag_let=NumerosEnLetras::convertir($tp,'Guaranies',false,'Centavos');
            }
            else{
                $tot_pag_let=NumerosEnLetras::convertir($tp,'Dolares',false,'Centavos');
            }
            
     
            //return view('caja.recibo',["rec"=>$rec,"tot_pag_let"=>$tot_pag_let]);

            return $pdf= \PDF::loadView('caja.reciboPrueba',["rec"=>$rec,"tot_pag_let"=>$tot_pag_let])
            ->setPaper([0, 0, 702.2835, 1150.087], 'portrait')
            ->stream('Recibo'.$id.'pdf');

        }
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function comprobante(Request $request)
    {
        //dd($request);
        $date1 = isset($request->fecha1)?$request->fecha1 : null;
        $date2 = isset($request->fecha2)?$request->fecha2 : null;
        $cliente = isset($request->idcliente)?$request->idcliente : 0;
        //dd($date1,$date2,$cliente);
        $cajero=auth()->user()->id;
        $cajeroNom = User::findOrFail($cajero);

        //VERIFICA SI ES ADMINISTRAADOR PARA VER TODOS LOS COMPROBANTES
     
            if($date1 == null)
            {
                if($cliente == null) {
                    $fecha_hoy= Carbon::now('America/Asuncion');
                    $rec=DB::table('recibos as rec')
                    ->join('clientes as cli','cli.id','=','rec.doc_cliente')
                    ->select('rec.id','rec.fec_recibo as fecha','rec.nro_recibo as nro_com','cli.nombre as doc_cli','rec.monto_pag as total',
                    'rec.usuario_id as usuario_id', DB::raw('"RECIBO" as tipo_com'))
                    ->where('rec.fec_recibo','=', Carbon::today())
                    //->where('rec.usuario_id','=',$cajero)
                    //->whereBetween('rec.fec_recibo',[($date1),($date2)])
                    ->orderBy('rec.id','desc')
                    ->get();
            
                    $compro=$rec;
                }
                else{
                    $fecha_hoy= Carbon::now('America/Asuncion');
                    $rec=DB::table('recibos as rec')
                    ->join('clientes as cli','cli.id','=','rec.doc_cliente')
                    ->select('rec.id','rec.fec_recibo as fecha','rec.nro_recibo as nro_com','cli.nombre as doc_cli','rec.monto_pag as total',
                    'rec.usuario_id as usuario_id', DB::raw('"RECIBO" as tipo_com'))
                    //->where('rec.fec_recibo','=', Carbon::today())
                    ->where('cli.id','=',$cliente)
                    //->whereBetween('rec.fec_recibo',[($date1),($date2)])
                    ->orderBy('rec.id','desc')
                    ->get();
            
                    $compro=$rec;
                }
                
            }
            else{
                
                if($cliente == null){
                    $fecha_hoy= Carbon::now('America/Asuncion');
                    $rec=DB::table('recibos as rec')
                    ->join('clientes as cli','cli.id','=','rec.doc_cliente')
                    ->select('rec.id','rec.fec_recibo as fecha','rec.nro_recibo as nro_com','cli.nombre as doc_cli','rec.monto_pag as total',
                    'rec.usuario_id as usuario_id',DB::raw('"RECIBO" as tipo_com'))
                    //->where('rec.fec_recibo','=', Carbon::today())
                    //->where('rec.usuario_id','=',$cajero)
                    ->whereBetween('rec.fec_recibo',[($date1),($date2)])
                    ->orderBy('rec.id','desc')
                    ->get();

                    $compro=$rec;
                }
                else{
                    $fecha_hoy= Carbon::now('America/Asuncion');
                    $rec=DB::table('recibos as rec')
                    ->join('clientes as cli','cli.id','=','rec.doc_cliente')
                    ->select('rec.id','rec.fec_recibo as fecha','rec.nro_recibo as nro_com','cli.nombre as doc_cli','rec.monto_pag as total',
                    'rec.usuario_id as usuario_id',DB::raw('"RECIBO" as tipo_com'))
                    //->where('rec.fec_recibo','=', Carbon::today())
                    ->where('cli.id','=',$cliente)
                    ->whereBetween('rec.fec_recibo',[($date1),($date2)])
                    ->orderBy('rec.id','desc')
                    ->get();

                    $compro=$rec;
                }
                
            }
            //dd($compro);
            return view('caja.comprobantes',["compro"=>$compro]);
        }
       
    
    public function facturapdf($id)
    {
        $fac=DB::table('facturas as fac')
        ->join('facturas_det as fdet','fdet.factura_id','=','fac.id')
        ->join('clientes as cli','cli.id','=','fac.doc_cliente')
        ->select('fac.id','fac.fec_factura as fecha','fac.nrof_factura as nro_com',
        'fac.nrof_suc as nrof_suc','fac.nrof_expendio as nrof_expendio', 'fac.timbrado as timbrado',
        'fac.total_exe as total_exe','fac.total_iv5 as total_iv5','fac.total_iv10 as total_iv10',
        'fac.total_iva as total_iva','fac.iv5 as iv5','fac.iv10 as iv10',
        'cli.nombre as doc_cli','cli.num_documento as num_documento','cli.direccion as direccion',
        'cli.telefono as telefono','fac.total_gral','fdet.cantidad as cantidad','fdet.descripcion_fac as descripcion',
        'fdet.precio_uni as precio_uni','fdet.precio_exe as precio_exe','fdet.precio_iv5 as precio_iv5',
        'fdet.precio_iv10 as precio_iv10','fdet.cod_mercaderia as merca','fac.tipo_factura as tipo_factura',
        'fac.moneda as moneda',
        DB::raw('"FACTURA" as tipo_com'))
        ->where('fac.id','=', $id)
        ->get();

        //dd($fac);

        $fechaahora= Carbon::now('America/Asuncion');
        $mesLetra = ($fechaahora->monthName); //y con esta obtengo el mes al fin en español!

        $tp = $fac[0]->total_gral;
        //$tot_pag_let=NumerosEnLetras::convertir($tp,'Guaranies',false,'Centavos');
        if($fac[0]->moneda == "GS"){
            $tot_pag_let=NumerosEnLetras::convertir($tp,'Guaranies',false,'Centavos');
        }
        else{
            $tot_pag_let=NumerosEnLetras::convertir($tp,'Dolares',false,'Centavos');
        }

        //return view('caja.facturapdf',["fac"=>$fac,"tot_pag_let"=>$tot_pag_let]);
        return $pdf= \PDF::loadView('caja.facturaPruebaPDF',["fac"=>$fac,"tot_pag_let"=>$tot_pag_let,
        "mesLetra"=>$mesLetra])
         ->setPaper([0, 0, 612.2835, 907.087], 'portrait')
         ->stream('Factura'.$id.'pdf');

        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function arqueo()
    {
        //DB::select("CALL sp_update_pagos()");
        
        $fechaahora= Carbon::today();
        $cajero=auth()->user()->id;
        $mediodia = new DateTime("12:00:00");
        //dd($mediodia);
        $cajeroNom = User::findOrFail($cajero);
        $cajeroNombre = $cajeroNom->name;

        // VERIFICAR PARA QUE EL ADMIN PUEDA VER TODO POR LA MAÑANA
        if((auth()->user()->idrol)==1)
        {
            $arqueo=DB::table('pagos as p')
            ->join('cuotas as c','c.id','=','p.cuota_id')
            ->join('ventas as v','c.factura_id','=','v.id')
            ->join('clientes as cli','cli.id','=','c.cliente_id')
            ->join('users as u','u.id','=','p.usuario_id')
            ->select('cli.nombre as cliente','v.fact_nro as producto','p.cuota as cuota',
            'p.total_pag as importe','p.total_pagf','p.total_pagch','p.created_at',
            'p.total_pagtd','p.total_pagtc','p.total_pagtr','p.fec_pag as fechapago')
            ->where('p.fec_pag','=',$fechaahora)
            ->where('p.created_at','<',$mediodia)
            ->get();
            //dd($arqueo[0]->created_at);
            if($arqueo->isEmpty()){
                $arqueo="Vacio";
            }

            $arqueoTarde=DB::table('pagos as p')
            ->join('cuotas as c','c.id','=','p.cuota_id')
            ->join('ventas as v','c.factura_id','=','v.id')
            ->join('clientes as cli','cli.id','=','c.cliente_id')
            ->join('users as u','u.id','=','p.usuario_id')
            ->select('cli.nombre as cliente','v.fact_nro as producto','p.cuota as cuota',
            'p.total_pag as importe','p.total_pagf','p.total_pagch','p.created_at',
            'p.total_pagtd','p.total_pagtc','p.total_pagtr','p.fec_pag as fechapago')
            ->where('p.fec_pag','=',$fechaahora)
            ->where('p.created_at','>',$mediodia)
            ->get();
            //dd($arqueo[0]->created_at);
            if($arqueoTarde->isEmpty()){
                $arqueoTarde="Vacio";
            }
            // return view('caja.arqueo',["arqueo"=>$arqueo,"arqueoTarde"=>$arqueoTarde,"fechaahora"=>$fechaahora,
            // "cajeroNombre"=>$cajeroNombre]);
        }

        else
        {
            $arqueo=DB::table('pagos as p')
            ->join('cuotas as c','c.id','=','p.cuota_id')
            ->join('ventas as v','c.factura_id','=','v.id')
            ->join('clientes as cli','cli.id','=','c.cliente_id')
            ->join('users as u','u.id','=','p.usuario_id')
            ->select('cli.nombre as cliente','v.fact_nro as producto','p.cuota as cuota',
            'p.total_pag as importe','p.total_pagf','p.total_pagch','p.created_at',
            'p.total_pagtd','p.total_pagtc','p.total_pagtr','p.fec_pag as fechapago')
            ->where('p.fec_pag','=',$fechaahora)
            ->where('p.created_at','<',$mediodia)
            ->get();
            //dd($arqueo);
            if($arqueo->isEmpty()){
                $arqueo="Vacio";
            }
           $arqueoTarde=DB::table('pagos as p')
            ->join('cuotas as c','c.id','=','p.cuota_id')
            ->join('ventas as v','c.factura_id','=','v.id')
            ->join('clientes as cli','cli.id','=','c.cliente_id')
            ->join('users as u','u.id','=','p.usuario_id')
            ->select('cli.nombre as cliente','v.fact_nro as producto','p.cuota as cuota',
            'p.total_pag as importe','p.total_pagf','p.total_pagch','p.created_at',
            'p.total_pagtd','p.total_pagtc','p.total_pagtr','p.fec_pag as fechapago')
            ->where('p.fec_pag','=',$fechaahora)
            ->where('p.created_at','>',$mediodia)
            ->get();
            //dd($arqueo[0]->created_at);
            if($arqueoTarde->isEmpty()){
                $arqueoTarde="Vacio";
            }
            // return view('caja.arqueo',["arqueo"=>$arqueo,"arqueoTarde"=>$arqueoTarde,"fechaahora"=>$fechaahora,
            // "cajeroNombre"=>$cajeroNombre]);
        }

            //FACTURAS PENDIENTES DE COBRO POR CAJA
            $cuotas_pagar = DB::table('cuotas as c')
            ->join('cuotas_det as cdet','cdet.cuota_id','=','c.id')
            ->join('clientes as cli','cli.id','=','c.cliente_id')
            //->join('ventas as v','v.id','=','c.factura_id')
            ->select('c.id','c.cliente_id','c.precio_inm as total','c.pagos_cuo as pagado','c.saldo_cuo as saldo',
            'cli.nombre as nombre','cdet.fec_vto as fecha','c.factura')
            ->where('cdet.estado_cuota','=',"P")
            ->where('cdet.fec_vto','=',$fechaahora)
            ->orderby('c.factura','desc')
            ->get();

            $cajeros=DB::table('cajeros as c')
            ->join('users','users.id','=','c.user_id')
            ->join('roles','roles.id','=','users.idrol')
            ->select('users.id as id','users.name')
            ->orderBy('users.name','asc')
            ->get();
        //dd( $cuotas_pagar);
        return view('caja.arqueo',["arqueo"=>$arqueo,"arqueoTarde"=>$arqueoTarde,"fechaahora"=>$fechaahora,
            "cajeroNombre"=>$cajeroNombre,"cuotas_pagar"=>$cuotas_pagar,"cajeros"=>$cajeros]);
        
    }

    public function arqueo_dias(Request $request)
    {
        //dd($request);
        if($request->fecha1 == null)
        {
            $fecha_arqueo= Carbon::now();
        }
        else
        {
            $fecha_arqueo= $request->fecha1;
        }
        if($request->cajero_id == 0)
        {
            $cajeroNombre = "TODOS";
        }
        else
        {
            $cajero=$request->cajero_id;
            $cajeroNom = User::findOrFail($cajero);
            $cajeroNombre = $cajeroNom->name;
        }        
        //dd($cajeroNombre);
        // VERIFICAR PARA QUE EL ADMIN PUEDA VER TODO
        if((auth()->user()->idrol)==1)
        {
            $arqueo=DB::table('pagos as p')
            ->join('cuotas as c','c.id','=','p.cuota_id')
            ->join('ventas as v','c.factura_id','=','v.id')
            ->join('clientes as cli','cli.id','=','c.cliente_id')
            ->join('users as u','u.id','=','p.usuario_id')
            ->select('cli.nombre as cliente','v.fact_nro as producto','p.cuota as cuota',
            'p.total_pag as importe','p.total_pagf','p.total_pagch',
            'p.total_pagtd','p.total_pagtc','p.total_pagtr','p.fec_pag as fechapago');
            if($request->cajero_id > 0)
            {
                $arqueo=$arqueo->where('p.usuario_id','=',$cajero);
            }
            $arqueo=$arqueo->where('p.fec_pag','=',$fecha_arqueo)
            //
            ->get();
            //dd($arqueo);
            if($arqueo->isEmpty()){
                $arqueo="Vacio";
            }
            return view('caja.arqueo_dias',["arqueo"=>$arqueo,"fecha_arqueo"=>$fecha_arqueo,
            "cajeroNombre"=>$cajeroNombre]);
        }

        else
        {
            $arqueo=DB::table('pagos as p')
            ->join('cuotas as c','c.id','=','p.cuota_id')
            ->join('ventas as v','c.factura_id','=','v.id')
            ->join('clientes as cli','cli.id','=','c.cliente_id')
            ->join('users as u','u.id','=','p.usuario_id')
            ->select('cli.nombre as cliente','v.fact_nro as producto','p.cuota as cuota',
            'p.total_pag as importe','p.total_pagf','p.total_pagch',
            'p.total_pagtd','p.total_pagtc','p.total_pagtr','p.fec_pag as fechapago');
            if($request->cajero_id > 0)
            {
                $arqueo=$arqueo->where('p.usuario_id','=',$cajero);
            }
            $arqueo=$arqueo->where('p.fec_pag','=',$fecha_arqueo)
            //
            ->get();
            //dd($arqueo);
            if($arqueo->isEmpty()){
                $arqueo="Vacio";
            }
            return view('caja.arqueo_dias',["arqueo"=>$arqueo,"fecha_arqueo"=>$fecha_arqueo,"cajeroNombre"=>$cajeroNombre]);
        }
        
    }

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
        //
    }
}