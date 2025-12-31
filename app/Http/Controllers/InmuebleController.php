<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Controllers;
use App\Models\Inmueble;
use App\Models\Loteamiento;
use Illuminate\Support\Facades\Redirect;
use DB;


class InmuebleController extends Controller
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

        

            return view('inmueble.tab_show2');
            //return $clientes;
        
        
    }
    //Funcion que trae el id del  medidor mediante consulta obtiene el id del cliente de ese medidor
    // public function obtenerCliente(Request $request)
    //     {

    //         $idcliente = DB::select('select idcliente from medidores where id = ?',[$request->nro_medidor])[0]->idcliente;
    //         $datos = DB::select('select * from clientes where id = ?', [$idcliente]);

    //         return response()->json(['var1'=>$datos]);
    //     }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inmueble= new Inmueble();
        $inmueble->descripcion = $request->descripcion;
        $inmueble->loteamiento_id = $request->loteamiento_id;
        $inmueble->estado = $request->estado;
        $inmueble->moneda = $request->moneda;

        if ($request->factura==null)
            $inmueble->factura = 0;
        else
            $inmueble->factura  = $request->factura;

        if ($request->precio==null)
            $inmueble->precio = 0;
        else
            $inmueble->precio = $request->precio;

        if ($request->frente==null)
            $inmueble->frente = 0;
        else
            $inmueble->frente = $request->frente;
        
        if ($request->contrafrente==null)
            $inmueble->contrafrente = 0;
        else
        $inmueble->contrafrente = $request->contrafrente;

        if ($request->ctactectral==null)
            $inmueble->ctactectral = 0;
        else
            $inmueble->ctactectral = $request->ctactectral;

        if ($request->matricula==null)
            $inmueble->matricula = 0;
        else
            $inmueble->matricula = $request->matricula;

        if ($request->lateral1==null)
            $inmueble->lateral1 = 0;
        else
        $inmueble->lateral1 = $request->lateral1;

        if ($request->lateral2==null)
             $inmueble->lateral2 = 0;
        else
        $inmueble->lateral2 = $request->lateral2;

        if ($request->cantidad_mts==null)
             $inmueble->cantidad_mts = 0;
        else
        $inmueble->cantidad_mts = $request->cantidad_mts;
 
        if ($request->lote==null)
             $inmueble->lote = 0;
        else
        $inmueble->lote = $request->lote;

        if ($request->manzana==null)
            $inmueble->manzana = 0;
         else       
        $inmueble->manzana = $request->manzana;
  
        if ($request->piso_nro==null)
            $inmueble->piso_nro = 0;
        else    
        $inmueble->piso_nro = $request->piso_nro;

        if ($request->dpto_nro==null)
            $inmueble->dpto_nro = 0;
        else  
        $inmueble->dpto_nro = $request->dpto_nro;

        if ($request->geolat==null)
            $inmueble->geolat = 0;
        else  
        $inmueble->geolat = $request->geolat;

        if ($request->geolng==null)
            $inmueble->geolng = 0;
        else       
        $inmueble->geolng = $request->geolng;

        if ($request->comentario_inm==null)
            $inmueble->comentario_inm = "";
        else   
        $inmueble->comentario_inm = $request->comentario_inm;

        if ($request->comentario_inm==null)
            $inmueble->descripcion_fac = "";
        else   
            $inmueble->descripcion_fac = $request->descripcion_fac;

        $inmueble->save();
        //$cliente->idempresa = $request->id_empresa; 
        //$edad = \Carbon\Carbon::parse($request->fecha_nacimiento)->age;
        //$cliente->edad = $request->edad;
        //$cliente->user = auth()->user()->email;

        //$fecha_nacimiento  = "1990-10-23";
        $inmueble->save();
        return Redirect::to("inmueble");
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
        //
        $inmueble=Inmueble::findOrFail($request->id_inmueble);
        $inmueble->descripcion = $request->descripcion;
        $inmueble->loteamiento_id = $request->loteamiento_id;
        $inmueble->estado = $request->estado;
        $inmueble->moneda = $request->moneda;

        if ($request->factura==null)
            $inmueble->factura = 0;
        else
            $inmueble->factura  = $request->factura;

        if ($request->precio==null)
            $inmueble->precio = 0;
        else
            $inmueble->precio = $request->precio;

        if ($request->frente==null)
            $inmueble->frente = 0;
        else
            $inmueble->frente = $request->frente;
            
        if ($request->ctactectral==null)
            $inmueble->ctactectral = 0;
        else
        $inmueble->ctactectral = $request->ctactectral;

        if ($request->matricula==null)
            $inmueble->matricula = 0;
        else
            $inmueble->matricula = $request->matricula;

        if ($request->contrafrente==null)
            $inmueble->contrafrente = 0;
        else
        $inmueble->contrafrente = $request->contrafrente;

        if ($request->lateral1==null)
            $inmueble->lateral1 = 0;
        else
        $inmueble->lateral1 = $request->lateral1;

        if ($request->lateral2==null)
             $inmueble->lateral2 = 0;
        else
        $inmueble->lateral2 = $request->lateral2;

        if ($request->cantidad_mts==null)
             $inmueble->cantidad_mts = 0;
        else
        $inmueble->cantidad_mts = $request->cantidad_mts;
 
        if ($request->lote==null)
             $inmueble->lote = 0;
        else
        $inmueble->lote = $request->lote;

        if ($request->manzana==null)
            $inmueble->manzana = 0;
         else       
        $inmueble->manzana = $request->manzana;
  
        if ($request->piso_nro==null)
            $inmueble->piso_nro = 0;
        else    
        $inmueble->piso_nro = $request->piso_nro;

        if ($request->dpto_nro==null)
            $inmueble->dpto_nro = 0;
        else  
        $inmueble->dpto_nro = $request->dpto_nro;

        if ($request->geolat==null)
            $inmueble->geolat = 0;
        else  
        $inmueble->geolat = $request->geolat;

        if ($request->geolng==null)
            $inmueble->geolng = 0;
        else       
        $inmueble->geolng = $request->geolng;

        if ($request->comentario_inm==null)
            $inmueble->comentario_inm = "";
        else   
        $inmueble->comentario_inm = $request->comentario_inm;

        if ($request->descripcion_fac==null)
            $inmueble->descripcion_fac= "";
        else   
        $inmueble->descripcion_fac = $request->descripcion_fac;

        $inmueble->save();
        return Redirect::to("inmueble");
    }
    
    public function destroy($id, $inmueble)
    {
        Inmueble::destroy($id);
        //return Redirect::to( {{URL::action('InmuebleController@show', $inmueble->id)}});
       
    }

    public function show($id)
    {
        $inmueble=Inmueble::join('loteamientos','inmuebles.loteamiento_id','=','loteamientos.id')
        ->select('inmuebles.id as id_inmueble','inmuebles.descripcion as descripcion','inmuebles.loteamiento_id',
        'loteamientos.descripcion as loteamiento','inmuebles.frente','inmuebles.ctactectral','inmuebles.matricula',
        'inmuebles.contrafrente','inmuebles.factura',
        'inmuebles.lateral1','inmuebles.lateral2','inmuebles.cantidad_mts','inmuebles.lote','inmuebles.manzana',
        'inmuebles.piso_nro','inmuebles.dpto_nro','inmuebles.geolat','inmuebles.geolng','inmuebles.comentario_inm',
        'inmuebles.descripcion_fac','inmuebles.precio','inmuebles.moneda','inmuebles.estado','inmuebles.vendedor_id')
        ->where('inmuebles.id','=',$id)
        ->orderBy('inmuebles.descripcion','desc')
        ->first();

        $clientes=DB::table('clientes')
        ->select('clientes.id','clientes.tipo_documento','clientes.num_documento','clientes.nombre')->get();

        $vendedores=DB::table('vendedores')
        ->select('id','name')->get();

        $loteamientos=DB::table('loteamientos')
        ->select('loteamientos.id','loteamientos.descripcion')->get();

        $imagenes=DB::table('inmo_img')
        ->select('id','imagen')
        ->where('inmueble_id','=',$id)->get();

        //dd($inmueble->comentario_inm);

        return view('inmueble.show',["inmueble"=>$inmueble,"clientes"=>$clientes,"imagenes"=>$imagenes,"loteamientos"=>$loteamientos,"vendedores"=>$vendedores]);

    }

    public function detalleCuotasInm($id){
        
        //dd($id);
        //DETALLES DEL O LOS INMUEBLES
        $id_cuota=DB::table('cuotas')
        ->select('id')
        ->where('inmueble_id','=',$id)
        ->first();

        $cantCuotas=DB::table('cuotas_det')
        ->select('cuota_nro')
        ->where('cuota_id','=',$id_cuota->id)
        ->count('cuota_nro');

        $cuotaCero=DB::table('cuotas_det')
        ->select('cuota_nro')
        ->where('cuota_id','=',$id_cuota->id)
        ->get();
        
        if($cuotaCero[0]->cuota_nro == 0)
            $cantCuotas=$cantCuotas-1;
            else
            $cantCuotas=$cantCuotas;

        $cuotas=DB::table('cuotas as c')
        ->join('cuotas_det as cdet','cdet.cuota_id','=','c.id')
        ->join('inmuebles as i','c.inmueble_id','=','i.id')
        ->join('loteamientos as l','i.loteamiento_id','=','l.id')
        ->join('clientes as cli','c.cliente_id','=','cli.id')
        ->select('cdet.cuota_nro as cuota_nro','cdet.capital as capital','cdet.fec_vto as fec_vto',
        'i.descripcion as descripcion','cli.nombre as cliente','l.descripcion as urba','i.moneda as moneda')
        ->where('inmueble_id','=',$id)
        ->orderBy('cdet.cuota_nro')
        ->get();


        $pagos=DB::table('pagos as p')
        ->join('inmuebles as i','i.id','=','p.inmueble_id')
        ->select('p.fec_pag as fechapago','p.cuota as cuota_nro','p.cuota_id as cuota_id',
        'p.total_pag as totalpagado','p.cuota as capitalcuota',
        DB::raw('0 as saldo'))
        ->where('p.inmueble_id','=',$id)
        ->orderBy('p.cuota')
        ->get();

        
        return view('inmueble.detalleCuotas',["cuotas"=>$cuotas, "pagos"=>$pagos,"cantCuotas"=>$cantCuotas]);
    }

    public function proformaPDF(Request $request)
    {
        //dd($request);
        $cuotas_arr=json_decode($request->cuotas_arr);
        $precio_inm=$request->precio_inm;
        $cliente=$request->cliente;
        //dd($cuotas_arr);
        return view('inmueble.impresion',["cuotas_arr"=>$cuotas_arr,
        "cliente"=>$cliente,"precio_inm"=>$precio_inm]);
    }
}


