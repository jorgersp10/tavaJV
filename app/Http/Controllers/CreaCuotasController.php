<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cuota;
use App\Models\Cuota_det;
use App\Models\Pago;
use DB;
use App\Models\TmpCuotas;



class CreaCuotasController extends Controller
{
    //
    public function index()
    {

    }


    public function creacuotas()
    {
 
       
        $cuotas=DB::table('tmp_cuotas')
        ->select('doc','fac','mon_tot','mon_cuo','can_cuo','pri_vto','cuo_pag','procesado')
        ->where('procesado','=',0)->get();

        $cabecera=DB::table('tmp_cuotas as t')
        ->leftjoin('clientes as cli','cli.num_documento','=','t.doc')
        ->select('t.id','t.descripcion','t.doc','fac','t.mon_tot','t.mon_cuo','t.can_cuo','t.cuo_pag',
        't.pri_vto','cli.id as cliente_id','cli.num_documento','cli.nombre','t.fac','t.cuo_par')
        ->where('t.procesado','=',0)->get();
        DB::beginTransaction();
        try
        {
    
            if (sizeof($cabecera)>0)
            {
                for($i = 0 ; $i < sizeof($cabecera); $i++)
                {
                    $cabcuo= new Cuota();
                    $cabcuo->producto = $cabecera[$i]->descripcion;
                    $cabcuo->inmueble_id = 0;
                    $cabcuo->electro_id = 0;
                    $cabcuo->acuerdo_id = 0;
                    if ($cabecera[$i]->cliente_id==null){
                        $cabecera[$i]->cliente_id=999;
                    }
                    $cabcuo->cliente_id = $cabecera[$i]->cliente_id;
                    $cabcuo->precio_inm = $cabecera[$i]->mon_tot;
                    $cabcuo->tiempo = $cabecera[$i]->can_cuo;
                    $cabcuo->primer_vto = $cabecera[$i]->pri_vto;
                    $cabcuo->entrega = 0;
                    $cabcuo->entrega_vto = $cabecera[$i]->pri_vto;
                    $cabcuo->refuerzo = 0;
                    $cabcuo->refuerzo_can = 0;
                    $cabcuo->refuerzo_per = 0;
                    $cabcuo->refuerzo_vto = $cabecera[$i]->pri_vto;
                    $cabcuo->saldo_cuo = 0;
                    $cabcuo->pagos_cuo = 0;
                    $cabcuo->pagos_ven = 0;
                    $cabcuo->total_cuo = 0;
                    $cabcuo->saldo_ven = 0;
                    $cabcuo->dias_mora = 0;
                    $cabcuo->factura = $cabecera[$i]->fac;
                    $cabcuo->created_at =  date("Y-m-d");
                    $cabcuo->updated_at = date("Y-m-d");
                    $cabcuo->usuario = "PJL";
                    $cabcuo->save();

                    $tmp= TmpCuotas::findOrFail($cabecera[$i]->id);
                    $tmp->procesado=1;
                    $tmp->save();
                    
                    $cuo=$cabecera[$i]->can_cuo;
                    if ($cuo>0)
                    {
                        $primer=date_create($cabecera[$i]->pri_vto);
                        for($j = 0 ; $j < $cuo; $j++)
                        {
                            $cuodet= new Cuota_det();
                            $cuota=$j+1;
                            $cuodet->cuota_id=$cabcuo->id;
                            $cuodet->cuota_nro=$cuota;
                            $cuodet->fec_vto=$primer;
                            $cuodet->fec_pag=$primer;
                            $cuodet->capital=$cabecera[$i]->mon_cuo;
                            $cuodet->interes=0;
                            $cuodet->iva=0;
                            $cuodet->total_cuota=$cabecera[$i]->mon_cuo;
                            if ($cuota<=$cabecera[$i]->cuo_pag){
                                $cuodet->estado_cuota="C";
                                $pagcuo= new Pago();
                                $pagcuo->cuota_id=$cabcuo->id;
                                $pagcuo->transaccion=0;
                                $pagcuo->cuota=$cuota;
                                $pagcuo->plazo=$cabecera[$i]->can_cuo;
                                $pagcuo->capital=$cabecera[$i]->mon_cuo;
                                $pagcuo->interes=0;
                                $pagcuo->moratorio=0;
                                $pagcuo->punitorio=0;
                                $pagcuo->iva=0;
                                $pagcuo->total_pag=$cabecera[$i]->mon_cuo;
                                $pagcuo->pago_est="C";
                                $pagcuo->librador="";
                                $pagcuo->total_pagf=$cabecera[$i]->mon_cuo;
                                $pagcuo->total_pagtd=0;
                                $pagcuo->total_pagtc=0;
                                $pagcuo->fec_pag=$primer;
                                $pagcuo->banco_tcredito=0;
                                $pagcuo->usuario_id=0;
                                $pagcuo->save();
                            }else
                            {
                                $cuodet->estado_cuota="P";
                            }
                            
                            $cuodet->created_at =  date("Y-m-d");
                            $cuodet->updated_at = date("Y-m-d");
                            $cuodet->save();
                            $primer=date_add($primer,date_interval_create_from_date_string("1 months"));

                        }
                        if ($cabecera[$i]->cuo_par>0)
                        {

                            $cuota=$cabecera[$i]->cuo_pag+1;
                                $pagcuo= new Pago();
                                $pagcuo->cuota_id=$cabcuo->id;
                                $pagcuo->transaccion=0;
                                $pagcuo->cuota=$cuota;
                                $pagcuo->plazo=$cabecera[$i]->can_cuo;
                                $pagcuo->capital=$cabecera[$i]->cuo_par;
                                $pagcuo->interes=0;
                                $pagcuo->moratorio=0;
                                $pagcuo->punitorio=0;
                                $pagcuo->iva=0;
                                $pagcuo->total_pag=$cabecera[$i]->cuo_par;
                                $pagcuo->pago_est="P";
                                $pagcuo->librador="";
                                $pagcuo->total_pagf=$cabecera[$i]->cuo_par;
                                $pagcuo->total_pagtd=0;
                                $pagcuo->total_pagtc=0;
                                $pagcuo->fec_pag=$primer;
                                $pagcuo->banco_tcredito=0;
                                $pagcuo->usuario_id=0;
                                $pagcuo->save();

                        }

                    }
                }
                
            }
        DB::commit();
        } 
        catch(Exception $e)
        {        
            DB::rollBack;
        }
        return $cuotas;
    }
}
