<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Controllers;
use App\Models\Mueble;
use App\Models\Tipo_muebles;
use Illuminate\Support\Facades\Redirect;
use DB;

class MuebleController extends Controller
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
            //$tipofiltro=trim($request->get('loteTexto'));

            $tipo_muebles=DB::table('tipo_muebles')
            ->select('tipo_muebles.id','tipo_muebles.descripcion')->get();

            $tipofiltro=trim($request->get('filtroTipo'));
            if ($tipofiltro=="")$tipofiltro="0";

            if ($tipofiltro=="0")
            {
                $muebles=Mueble::join('tipo_muebles','muebles.tipo_mueble','=','tipo_muebles.id')
                ->join('estado_inm','muebles.estado','=','estado_inm.id')
                ->select('muebles.id','muebles.descripcion','muebles.moneda','muebles.precio_mue',
                'tipo_muebles.descripcion as tipo_mueble','estado_inm.estado as est_des')
                ->where('muebles.descripcion','LIKE','%'.$sql.'%')
                ->orderBy('muebles.descripcion','desc')
                ->simplepaginate(20);
            }
            else
            {
                $muebles=Mueble::join('tipo_muebles','muebles.tipo_mueble','=','tipo_muebles.id')
                ->join('estado_inm','muebles.estado','=','estado_inm.id')
                ->select('muebles.id','muebles.descripcion','muebles.moneda','muebles.precio_mue',
                'tipo_muebles.descripcion as tipo_mueble','estado_inm.estado as est_des')
                ->where('muebles.tipo_muebles','=',$tipofiltro)
                ->orderBy('muebles.descripcion','desc')
                ->simplepaginate(20);
            }

            $estados=DB::table('estado_inm')
            ->select('estado_inm.id','estado_inm.estado as estado')->get();

    

            return view('mueble.index',["muebles"=>$muebles,"tipo_muebles"=>$tipo_muebles,"buscarTexto"=>$sql,"estados"=>$estados]);
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
        $muebles= new Mueble();
        $muebles->descripcion = $request->descripcion;
        $muebles->tipo_mueble = $request->tipo_mueble;
        $muebles->estado = $request->estado;
        $muebles->moneda = $request->moneda;

        if ($request->color==null)
            $muebles->color = "";
        else   
            $muebles->color = $request->color;

        // if ($request->factura==null)
        //     $muebles->factura = 0;
        // else
        //     $muebles->factura  = $request->factura;

        if ($request->precio_mue==null)
            $muebles->precio_mue = 0;
        else
            $muebles->precio_mue = (int) str_replace(".","",$request->precio_mue);

        if ($request->ano_fabricacion==null)
            $muebles->ano_fabricacion = 0;
        else
            $muebles->ano_fabricacion = $request->ano_fabricacion;
        
        if ($request->marca==null)
            $muebles->marca = 0;
        else
        $muebles->marca = $request->marca;

        if ($request->modelo==null)
            $muebles->modelo = 0;
        else
            $muebles->modelo = $request->modelo;

        if ($request->chapa_nro==null)
            $muebles->chapa_nro = 0;
        else
            $muebles->chapa_nro = $request->chapa_nro;

        if ($request->chasis_nro==null)
            $muebles->chasis_nro = 0;
        else
        $muebles->chasis_nro = $request->chasis_nro;

        if ($request->descripcion_fac==null)
            $muebles->descripcion_fac = "";
        else   
            $muebles->descripcion_fac = $request->descripcion_fac;

        $muebles->save();
       
        $muebles->save();
        return Redirect::to("mueble");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mueble=Mueble::join('tipo_muebles','muebles.tipo_mueble','=','tipo_muebles.id')
        ->select('muebles.id as id_mueble','muebles.descripcion as descripcion','muebles.tipo_mueble',
        'tipo_muebles.descripcion as tipo_mueble','muebles.precio_mue','muebles.moneda',
        'muebles.estado','muebles.descripcion_fac','muebles.ano_fabricacion','muebles.marca',
        'muebles.modelo','muebles.chapa_nro','muebles.chasis_nro','muebles.estado','muebles.color',
        'muebles.vendedor_id','muebles.factura',)
        ->where('muebles.id','=',$id)
        ->orderBy('muebles.descripcion','desc')
        ->first();

        $clientes=DB::table('clientes')
        ->select('clientes.id','clientes.tipo_documento','clientes.num_documento','clientes.nombre')->get();

        $vendedores=DB::table('vendedores')
        ->select('id','name')->get();

        $tipo_muebles=DB::table('tipo_muebles')
            ->select('tipo_muebles.id','tipo_muebles.descripcion')->get();

        // $imagenes=DB::table('inmo_img')
        // ->select('id','imagen')
        // ->where('inmueble_id','=',$id)->get();

        //dd($inmueble->comentario_inm);

        return view('mueble.show',["mueble"=>$mueble,"clientes"=>$clientes,"tipo_muebles"=>$tipo_muebles,"vendedores"=>$vendedores]);

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
        //dd($request);
        $muebles=Mueble::findOrFail($request->id_mueble);
        $muebles->descripcion = $request->descripcion;
        $muebles->tipo_mueble = $request->tipo_mueble;
        $muebles->estado = $request->estado;
        $muebles->moneda = $request->moneda;
        if ($request->color==null)
            $muebles->color = "";
        else   
            $muebles->color = $request->color;


        // if ($request->factura==null)
        //     $muebles->factura = 0;
        // else
        //     $muebles->factura  = $request->factura;

        if ($request->factura==null)
            $muebles->factura = 0;
        else
            $muebles->factura = $request->factura;

        if ($request->precio_mue==null)
            $muebles->precio_mue = 0;
        else
            $muebles->precio_mue = (int) str_replace(".","",$request->precio_mue);

        if ($request->ano_fabricacion==null)
            $muebles->ano_fabricacion = 0;
        else
            $muebles->ano_fabricacion = $request->ano_fabricacion;
        
        if ($request->marca==null)
            $muebles->marca = 0;
        else
        $muebles->marca = $request->marca;

        if ($request->modelo==null)
            $muebles->modelo = 0;
        else
            $muebles->modelo = $request->modelo;

        if ($request->chapa_nro==null)
            $muebles->chapa_nro = 0;
        else
            $muebles->chapa_nro = $request->chapa_nro;

        if ($request->chasis_nro==null)
            $muebles->chasis_nro = 0;
        else
        $muebles->chasis_nro = $request->chasis_nro;

        if ($request->descripcion_fac==null)
            $muebles->descripcion_fac = "";
        else   
            $muebles->descripcion_fac = $request->descripcion_fac;

        $muebles->save();
       
        $muebles->save();
        return Redirect::to("mueble");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $mueble)
    {
        Mueble::destroy($id);
       
    }

    public function proformaPDF(Request $request)
    {
        //dd($request);
        $cuotas_arr=json_decode($request->cuotas_arr);
        $precio_mue=$request->precio_mue;
        $cliente=$request->cliente;
        //dd($cuotas_arr);
        return view('mueble.impresion',["cuotas_arr"=>$cuotas_arr,
        "cliente"=>$cliente,"precio_mue"=>$precio_mue]);
    }

    public function detalleCuotasMue($id){
        
        //dd($id);
        //DETALLES DEL O LOS INMUEBLES
        $id_cuota=DB::table('cuotas')
        ->select('id')
        ->where('mueble_id','=',$id)
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
        ->join('muebles as m','c.mueble_id','=','m.id')
        ->join('tipo_muebles as tm','m.tipo_mueble','=','tm.id')
        ->join('clientes as cli','c.cliente_id','=','cli.id')
        ->select('cdet.cuota_nro as cuota_nro','cdet.capital as capital','cdet.fec_vto as fec_vto',
        'm.descripcion as descripcion','cli.nombre as cliente','tm.descripcion as urba','m.moneda as moneda')
        ->where('mueble_id','=',$id)
        ->orderBy('cdet.cuota_nro')
        ->get();


        $pagos=DB::table('pagos as p')
        ->join('muebles as i','i.id','=','p.mueble_id')
        ->select('p.fec_pag as fechapago','p.cuota as cuota_nro','p.cuota_id as cuota_id',
        'p.total_pag as totalpagado','p.cuota as capitalcuota',
        DB::raw('0 as saldo'))
        ->where('p.mueble_id','=',$id)
        ->orderBy('p.cuota')
        ->get();

        
        return view('mueble.detalleCuotas',["cuotas"=>$cuotas, "pagos"=>$pagos,"cantCuotas"=>$cantCuotas]);
    }
}
