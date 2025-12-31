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

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
            $pagos = DB::table('pagos as p')
            ->join('cuotas as c', 'c.id', '=', 'p.cuota_id')
            ->join('ventas as v', 'v.id', '=', 'c.factura_id')
            ->join('clientes as cli', 'cli.id', '=', 'c.cliente_id')
            ->select('p.id','cli.nombre','v.fact_nro','p.fec_pag','v.total','p.total_pag','p.total_pagf',
            'p.total_pagch','p.total_pagtd','p.total_pagtc','p.total_pagtr','p.saldo')
            ->orderBy('p.id','desc')
            ->get();


            return view('pago.index',["pagos"=>$pagos]);
            
        
            //return $usuarios;
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         try{

            DB::beginTransaction();

            $pago = Pago::findOrFail($id);

            $cuotas_det = DB::table('cuotas_det as cdet')
            ->join('cuotas as c','c.id','=','cdet.cuota_id')
            ->select('*')
            ->where('c.id', '=', $pago->cuota_id)
            ->first();
            
            $cambio_estado = Cuota_det::findOrFail($cuotas_det->id);
            $cambio_estado->estado_cuota = "P";
            $cambio_estado->update();
            
            $maxtran = DB::table('pagos as p')
            ->join('cuotas as c','c.id','=','p.cuota_id')
            ->where('c.id', '=', $pago->cuota_id)
            ->max('transaccion');
            
            $id_recibo = DB::table('recibos as r')
            ->join('ventas as v','v.fact_nro','=','r.factura')
            ->select('r.id','r.tran_inmo')
            ->where('r.tran_inmo', '=', $maxtran)
            ->groupby('r.id','r.tran_inmo')
            ->get();
           
            //dd($id_recibo[0]->tran_inmo,$pago->transaccion);
            if($id_recibo[0]->tran_inmo == $pago->transaccion){
                Pago::destroy($id);
                Recibo::destroy($id_recibo[0]->id);
            }
            else{
                //dd("acad");
                DB::rollBack();
                return Redirect::to('pago')->with('msj', 'HAY PAGOS ANTERIORES QUE DEBEN SER ELIMINADOS PRIMERO');
            }

           

            DB::commit();

        } catch(Exception $e){
            
            DB::rollBack();
        }

        return Redirect::to('pago')->with('msj2', 'PAGO ELIMINADO');
    }
}
