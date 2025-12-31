<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Controllers;
use App\Models\Cliente;
use App\Models\Inmueble;
use App\Models\Mueble;
use App\Models\Loteamiento;
use App\Models\Proforma;
use App\Models\Proforma_det;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use DB;


class ProformaController extends Controller
{
    //
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
            //$lotefiltro=trim($request->get('loteTexto'));

            $loteamientos=DB::table('loteamientos')
            ->select('loteamientos.id','loteamientos.descripcion')->get();

            $lotefiltro=trim($request->get('filtroLoteamiento'));
            if ($lotefiltro=="")$lotefiltro="0";

            if ($lotefiltro=="0")
            {
                //$inmuebles=DB::table('inmuebles')
                //->select('inmuebles.id','inmuebles.descripcion','inmuebles.loteamiento_id')
                //->where('inmuebles.descripcion','LIKE','%'.$sql.'%')
                //->orderBy('inmuebles.descripcion','desc')
                //->simplepaginate(10);
                $inmuebles=Inmueble::join('loteamientos','inmuebles.loteamiento_id','=','loteamientos.id')
                ->join('estado_inm','inmuebles.estado','=','estado_inm.id')
                ->select('inmuebles.id','inmuebles.descripcion','inmuebles.moneda','inmuebles.precio','loteamientos.descripcion as loteamiento','estado_inm.estado as est_des')
                ->where('inmuebles.descripcion','LIKE','%'.$sql.'%')
                ->orderBy('inmuebles.descripcion','desc')
                ->simplepaginate(10);
            }
            else
            {
                $inmuebles=Inmueble::join('loteamientos','inmuebles.loteamiento_id','=','loteamientos.id')
                ->join('estado_inm','inmuebles.estado','=','estado_inm.id')
                ->select('inmuebles.id','inmuebles.descripcion','inmuebles.moneda','inmuebles.precio','loteamientos.descripcion as loteamiento','estado_inm.estado as est_des')
                ->where('inmuebles.loteamiento_id','=',$lotefiltro)
                ->orderBy('inmuebles.descripcion','desc')
                ->simplepaginate(10);
            }


            /*listar los roles en ventana modal*/
    

            return view('inmueble.index',["inmuebles"=>$inmuebles,"loteamientos"=>$loteamientos,"buscarTexto"=>$sql]);
            //return $clientes;
        }
        
    }


    public function calcularCuota(Request $request)
    {
      
      
        $request->validate([
            'idcliente' => 'required',
            'tiempo' => 'required',
            'precio_inm' => 'required',
            'precio_mue' => 'required'
        ]);

        /// Si hay entrega el monto a calcular es el monto menos lo que se entrega
        $producto=strtoupper($request->producto);
        
        $precio_inm=$request->precio_inm ?: 0;
        $precio_inm=str_replace(".", "", $precio_inm);
        
        $precio_mue=$request->precio_mue ?: 0;
        $precio_mue=str_replace(".", "", $precio_mue);

        $entrega=$request->entrega ?: 0;
        $entrega=str_replace(".", "", $entrega);

        
        
        $desde=$request->desde;
        
        
        if ($desde=='tab_show'){
            $monto=$request->precio_inm ?: 0;
            $monto=str_replace(".", "", $monto);
            //dd($monto);
            //$inmueble_ven=$request->id_inmuebleven;
            //s$inmueble=Inmueble::findOrFail($request->id_inmuebleven);
            $idcliente=$request->idcliente;
            $cliente=Cliente::findOrFail($request->idcliente);
            //$moneda=$inmueble->moneda;
        }
        
        else{
            if ($desde=='tab_show_mue'){
                $monto=$request->precio_mue ?: 0;
                $monto=str_replace(".", "", $monto);
                
                $mueble_ven=$request->id_muebleven;
                $mueble=Mueble::findOrFail($request->id_muebleven);
                $idcliente=$request->idcliente;
                $cliente=Cliente::findOrFail($request->idcliente);
                $moneda=$mueble->moneda;
            }
            else
            {
                $monto=$request->precio_inm ?: 0;
                $monto=str_replace(".", "", $monto);
                $idcliente=0;
                $moneda=$request->mon;
                $cliente_nom=$request->cliente_nom ?: '';

            }
        }
        $monto=$monto-$entrega;
        //dd($monto);
        $tiempo=$request->tiempo ?: 1;
        $interes=$request->interes ?: 0;
        $tasa=$request->interes ?: 0;
        $can_ref=$request->can_ref ?: 0;
        $per_ref=$request->per_ref ?: 0;
        $refuerzo=$request->refuerzo ?: 0;
        $refuerzo=str_replace(".", "", $refuerzo);
        
        $fec_vto_1= new Carbon($request->primer_vto) ? :  Carbon::now('America/Asuncion');
        $primer_vto=$fec_vto_1->toDateString();

        $ent_vto= new Carbon($request->ent_vto) ? :  Carbon::now('America/Asuncion');
        $entrega_vto=$ent_vto->toDateString();
        //dd($primer_vto, $entrega_vto);
        $ref_vto= new Carbon($request->refuerzo_vto) ? :  Carbon::now('America/Asuncion');
        $refuerzo_vto=$ref_vto->toDateString();
        
        $con_iva=$request->con_iva ?: "off";
     
        // interes es igual a interes mensual se verifica que no sea 0 
        if ($interes>0){
            $interes=$interes/12;
        }

        // Aca calcularemos el iva del total de los intereses
        if ($con_iva=="on")
        {
            
            if ($interes>0){
                $montoi=$monto;
                $montoia=$monto;            
                $pagoInteresi=0;  $pagoIvai=0; $pagoCapitali = 0;  $cuotai;  $contador = 0;
                $totalInteresi=0; $totalIvai=0;  $totalPagoi=0; $entregadoi=0; $entro1=0;
                /// Vamos a calcular cuotas hasta que el monto del prestamo sea mayor al 
                /// desembolso
                while ($monto>=$entregadoi)
                {
                    $totalInteresi=0;  $totalIvai=0;  $totalPagoi=0;
                    $entregadoi=0;
                    $number=1+$interes/100;
                    $cuotai = round(($montoi * (pow($number, $tiempo)*$interes/100)/(pow($number, $tiempo)-1)),0 );
    
                    for($i = 1; $i <= $tiempo; $i++) 
                    {
                        $pagoInteresi = $montoi*($interes/100);
                        $pagoCapitali = $cuotai - $pagoInteresi;
                        $pagoIvai = $pagoInteresi*0.1;
                        $montoi = $montoi-$pagoCapitali;
                        if ($i==$tiempo){
                            if ($montoi!=0){
                                $pagoCapitali=$pagoCapitali+$montoi;
                                $cuotai=$cuotai+$montoi;
                            }
                        }
                        $totalInteresi= $totalInteresi+($pagoInteresi);
                        $totalPagoi=$totalPagoi+$pagoCapitali;
                        $totalIvai=$totalIvai+$pagoIvai;
                    }
    
    
                    $entregadoi=$totalPagoi-$totalIvai;
                    
                    $contador++;
                    if ($entro1==0)
                    {
                        $montoia=$montoia+$totalIvai;
                        $entro1=1;
                    }
                        else
                    {
                        if($moneda=="GS")
                            $montoia=$montoia+1000;
                        else
                            $montoia=$montoia+1;

                    }
                    $montoi=$montoia;
                }
                $monto=$montoi;
    
            }

        }
        // /////////////////////   SIN IVA ////////////////////////////////////////////////

        $pagoInteres=0; $pagoCapital = 0; $cuota = 0;$totalIva=0; $totalInteres=0; 
        $totalCapital=0; $entregado=0;$cuo_imp=0;
        $cuotas_arr = [];

        if ($interes>0){
            $number=1+$interes/100;
            $cuota = round(($monto * (pow($number, $tiempo)*$interes/100)/(pow($number, $tiempo)-1)),0 );
            $cuo_imp=$cuota;
        }else{
             $cuota=round(($monto/$tiempo),0);
            $cuo_imp=$cuota;
        }

        for($i = 1; $i <= $tiempo; $i++) 
        {
            if ($interes>0){
                $pagoInteres = $monto*($interes/100);
            }
            else
            {
                $pagoInteres = 0;
            }
            $pagoCapital = $cuota - $pagoInteres;
            if ($con_iva=="on"){
                $pagoIva = $pagoInteres*0.1;
            }else{
                $pagoIva = 0;
            }
            
            $monto = $monto-$pagoCapital;
 
            if ($i==$tiempo){
                if ($monto!=0){
                    $pagoCapital=$pagoCapital+$monto;
                    $cuota=$cuota+$monto;
                }
            }
            $totalInteres= $totalInteres+$pagoInteres;
            $totalIva= $totalIva+$pagoIva;
            $totalCapital= $totalCapital+$pagoCapital;
        
    
            if ($con_iva=="on"){
                $entregado=$totalCapital-$totalIva;
            }else
            {
                $entregado=$totalCapital;
            }
            
    
            $cap=$pagoCapital;
            $int=$pagoInteres;
            $iva=$pagoIva;
            $cuo=$cuota;
            $mon=$monto;
  
            $cuotas_arr[$i]=[
                'fec_vto'=>$fec_vto_1->toDateString(),
                'cap'=>$cap,
                'int'=>$int,
                'iva'=>$iva]
            ;

            $fec_vto_1=$fec_vto_1->addMonth();
          
        }
       // $cuotas_arr=collect($cuotas_arr);
 
        if ($desde=='tab_show'){
        
            return view('inmueble.impresion',["cuotas_arr"=>$cuotas_arr,"producto"=>$producto,
           "primer_vto"=>$primer_vto,"interes"=>$tasa,"desde"=>$desde,
            "entrega"=>$entrega,"entrega_vto"=>$entrega_vto,"tiempo"=>$tiempo,"refuerzo"=>$refuerzo,
            "can_ref"=>$can_ref,"per_ref"=>$per_ref,"refuerzo_vto"=>$refuerzo_vto,"cuo_imp"=>$cuo_imp,
            "idcliente"=>$idcliente,"cliente"=>$cliente,"precio_inm"=>$precio_inm,"precio_mue"=>$precio_mue]);
        }
         else

            if ($desde=='tab_show_mue')
            {
                return view('mueble.impresion',["cuotas_arr"=>$cuotas_arr,
                "primer_vto"=>$primer_vto,"interes"=>$tasa,"desde"=>$desde,"mueble_ven"=>$mueble_ven,
                "entrega"=>$entrega,"entrega_vto"=>$entrega_vto,"tiempo"=>$tiempo,"refuerzo"=>$refuerzo,
                "can_ref"=>$can_ref,"per_ref"=>$per_ref,"refuerzo_vto"=>$refuerzo_vto,"cuo_imp"=>$cuo_imp,
                "idcliente"=>$idcliente,"cliente"=>$cliente,"precio_mue"=>$precio_mue,"precio_inm"=>$precio_inm]);
            }else
            {
                return view('inmueble.impresion',["cuotas_arr"=>$cuotas_arr,
                "primer_vto"=>$primer_vto,"interes"=>$tasa,"desde"=>$desde,"inmueble_ven"=>0,
                "entrega"=>$entrega,"entrega_vto"=>$entrega_vto,"tiempo"=>$tiempo,"refuerzo"=>$refuerzo,
                "can_ref"=>$can_ref,"per_ref"=>$per_ref,"refuerzo_vto"=>$refuerzo_vto,"cuo_imp"=>$cuo_imp,
                "idcliente"=>$idcliente,"cliente_nom"=>$cliente_nom,"precio_inm"=>$precio_inm]);

            }

    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
  
        $request->validate([
            'idcliente' => 'required',
            'tiempo' => 'required',
            'precio_inm' => 'required',
            'precio_mue' => 'required'
        ]);
    
        

            try{
    
                DB::beginTransaction();
                $desde=$request->desde;
                $proforma= new Proforma();
                if ($desde=='tab_show'){
                    $proforma->inmueble_id = 0;
                    $proforma->producto = strtoupper($request->producto);
                    $proforma->mueble_id = 0;
                    $proforma->electro_id = 0;
                }
                if ($desde=='tab_show_mue'){
                    $proforma->inmueble_id = 0;
                    $proforma->electro_id = 0;
                    $proforma->mueble_id = $request->id_muebleven;
                }


                if ($request->idcliente==null)
                    $proforma->cliente_id = 0;
                else
                    $proforma->cliente_id = $request->idcliente;

                if ($desde=='tab_show'){
                    $proforma->precio_inm = $request->precio_inm;
                }
                if ($desde=='tab_show_mue'){
                    $proforma->precio_inm = $request->precio_mue;
                }

                if ($request->tiempo==null)
                    $proforma->tiempo = 0;
                else
                    $proforma->tiempo = $request->tiempo;

                $cuotas=$request->tiempo;

                $proforma->primer_vto = $request->primer_vto;

                if ($request->entrega==null)
                    $proforma->entrega = 0;
                else
                    $proforma->entrega = $request->entrega;
                
                if ($request->entrega_vto==null)    
                    $proforma->entrega_vto=Carbon::now();
                else
                    $proforma->entrega_vto=$request->entrega_vto;
    
                $proforma->refuerzo = $request->refuerzo;

                if ($request->refuerzo==null)
                    $proforma->refuerzo = 0;
                else
                    $proforma->refuerzo = $request->refuerzo;

                if ($request->can_ref==null)
                    $proforma->refuerzo_can = 0;
                else
                    $proforma->refuerzo_can = $request->can_ref;

                if ($request->per_ref==null)
                    $proforma->refuerzo_per = 0;
                else
                    $proforma->refuerzo_per = $request->per_ref;

                if ($request->refuerzo_vto==null)
                    $proforma->refuerzo_vto=Carbon::now();
                else
                    $proforma->refuerzo_vto=$request->refuerzo_vto;

                $proforma->usuario = auth()->user()->id;
                
                $proforma->save();
                /// Variables para el calculo  de cuotas
                $entrego=$proforma->entrega;
                $total=$request->tot_imp;
                $cuotas=$proforma->tiempo;
                //$totaladividir=$total-($entrego+($proforma->refuerzo*$proforma->refuerzo_can));
                
                $cont=0;

                /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// ///
                /// Si tiene entrega entonces la primera cuota es la fecha de vencimiento de entrega
                if ($entrego > 0)
                    {
                        $vto=$proforma->entrega_vto;
                        $importeCuota=$proforma->entrega;
                    }
                    else
                    {
                        $cont=$cont+1;
                    }
                    
                /* Cargamos las cuotas*/
                while($cont <= $cuotas){

                if ($cont>0)
                {
                        $vto= $request->cfec_vto[$cont-1];
                        $importeCuota=$request->ccap[$cont-1]+$request->cint[$cont-1]+$request->civa[$cont-1];
                }
                    
                $detalle = new Proforma_det();
                $detalle->proforma_id = $proforma->id;
                $detalle->cuota_nro = $cont;
                $detalle->fec_vto= $vto;
                $detalle->capital = $importeCuota;
                $detalle->interes = 0;
                $detalle->iva = 0;
                $detalle->total_cuota = $importeCuota;
                $detalle->save();

                $cont=$cont+1;
              
                }
                //dd($request);     
                // if ($desde=='tab_show'){
                //     $inmueble=Inmueble::findOrFail($request->id_inmuebleven);
                //     $inmueble->proforma_id=$proforma->id;
                //     $inmueble->save();
                // }
                // if ($desde=='tab_show_mue'){
                //     $mueble=Mueble::findOrFail($request->id_muebleven);
                //     $mueble->proforma_id=$proforma->id;
                //     $mueble->save();
                // }
                
                DB::commit();
                if ($desde=='tab_show'){
                    return Redirect::to("venta")->with('msj2', 'Grabado exitosamente !');
                }
                if ($desde=='tab_show_mue'){
                    return Redirect::to("/mueble/0")->with('msj2', 'Grabado exitosamente !');
                }
    
            } catch(Exception $e){
                    
                    DB::rollBack();
                    if ($desde=='tab_show'){
                        return Redirect::to("venta")->with('msj3', 'Error al intentar grabar. Verifique Datos');
                    }
                    if ($desde=='tab_show_mue'){
                        return Redirect::to("/mueble/0")->with('msj3', 'Error al intentar grabar. Verifique Datos');
                    }
            }

    
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

    }
      
    
    public function destroy($id, $inmueble)
    {
        Inmueble::destroy($id);
        //return Redirect::to( {{URL::action('InmuebleController@show', $inmueble->id)}});
       
    }

    public function show($id)
    {
        $proforma=Proforma::join('proforma_det','proforma.id','=','proforma_det.proforma_id')
        ->join('inmuebles','proforma.inmueble_id','=','inmuebles.id')
        ->select('inmuebles.descripcion as descripcion','proforma.inmueble_id','proforma_det.fec_vto','proforma_det.cuota_nro','proforma_det.capital','proforma_det.interes','proforma_det.total_cuota')
        ->where('proforma.id','=',$id)
        ->orderBy('proforma_det.fec_vto','asc')
        ->get();

        $proforma_det=0;

        return view('proforma.index',["proforma"=>$proforma,"proforma_det"=>$proforma_det]);

    }

}
