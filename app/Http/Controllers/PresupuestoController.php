<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Presupuesto;
use App\Models\Producto;
use App\Models\Precio_historico;
use App\Models\Factura;
use App\Models\Presupuesto_det;
use App\Models\Venta;
use App\Models\Venta_det;
use App\Models\Cuota;
use App\Models\Cuota_det;
use App\Models\Recibo_Paramorden;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\NumerosEnLetras;
use DateTime;
use Exception;
use DB;
use PDF;

class PresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
      
        if($request){
        
            $sql=trim($request->get('buscarTexto'));
            $ventas=DB::table('presupuestos as v')
            ->join('presupuestos_det as vdet','v.id','=','vdet.venta_id')
            ->join('clientes as c','c.id','=','v.cliente_id')
            ->join('users as u','u.id','=','v.user_id')
             ->select('v.id','v.fact_nro','v.iva5','v.iva10','v.ivaTotal','v.exenta','v.fecha',
             'v.total','v.estado','c.nombre')
            ->where('v.fact_nro','LIKE','%'.$sql.'%')
            ->orderBy('v.id','desc')
            ->groupBy('v.id','v.fact_nro','v.iva5','v.iva10','v.ivaTotal','v.exenta','v.fecha',
            'v.total','v.estado','c.nombre')
            ->paginate(10);
             
 
            return view('presupuesto.index',["ventas"=>$ventas,"buscarTexto"=>$sql]);
            
           //return $compras;
        }
    }

    public function create(){
 
        /*listar las clientes en ventana modal*/
        $clientes=DB::table('clientes')->get();
       
        /*listar los productos en ventana modal*/
        $productos=DB::table('productos as p')
        ->select(DB::raw('CONCAT(p.ArtCode," ",p.descripcion) AS producto'),'p.id')
        ->get(); 

        $empresas=DB::table('empresas as e')
        ->select('e.id as id','e.nombre','e.ruc','e.direccion')
        ->orderBy('e.id','asc')
        ->get();

        $vendedores=DB::table('vendedores as v')
        ->select('v.id','v.name')
        ->where('v.condicion','=',1)
        ->orderBy('v.name','asc')
        ->get();

        $nro_presupuesto = $this->siguienteNroPresupuesto();

        return view('presupuesto.create',["clientes"=>$clientes,"productos"=>$productos,
        "empresas"=>$empresas,"vendedores"=>$vendedores,"nro_presupuesto"=>$nro_presupuesto]);

   }

   public function getClientesVentas(Request $request)
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

   public function store(Request $request)
   {   
        try
        {

            DB::beginTransaction();

            $fecha_hoy= Carbon::now('America/Asuncion');

            $venta = new Presupuesto();
            $venta->cliente_id = $request->cliente_id;
            $venta->fact_nro = $this->siguienteNroPresupuesto();
            $venta->fecha = isset($request->fecha) ? $request->fecha : $fecha_hoy->toDateString();
            $venta->iva5 = $request->total_iva_5 ?? 0;
            $venta->iva10 = $request->total_iva_10 ?? $request->total_iva ?? 0;
            $venta->ivaTotal = $request->total_iva;
            $venta->exenta = $request->total_exenta ?? 0;
            $venta->total = $request->total_pagar;
            $venta->tipo_factura = $request->tipo_factura ?? 0;
            $venta->estado = 0;
            $venta->user_id = auth()->user()->id;
            $venta->contable = 1;
            $venta->empresa_id = $request->empresa_id ?? 1;
            $venta->vendedor_id = $request->vendedor_id == 0 ? null : $request->vendedor_id;
            $venta->save();

            $producto_id=$request->producto_id;
            $servicio = $request->servicio;
            $cantidad = str_replace(",", ".", $request->cantidad);
            $precio = str_replace(".", "", $request->precio);
            $tipo_iva = $request->tipo_iva;

           
            $cont=0;

             while($cont < count($producto_id)){

                $detalle = new presupuesto_det();
                /*enviamos valores a las propiedades del objeto detalle*/
                /*al idcompra del objeto detalle le envio el id del objeto compra, que es el objeto que se ingresó en la tabla compras de la bd*/
                $detalle->venta_id = $venta->id;
                $detalle->producto_id = $producto_id[$cont];
                $detalle->servicio = $servicio[$cont] ?? '';
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio = str_replace(".", "", $precio[$cont]);
                $detalle->tipo_iva = $tipo_iva[$cont] ?? 11;
  
                $detalle->save();
                $cont=$cont+1;                
            }
                
            DB::commit();

        } catch(Exception $e){
            
            DB::rollBack();
        }

        return Redirect::to('presupuesto');
    }

    public function show($id)
    {

        $ventas=DB::table('presupuestos as v')
        ->join('presupuestos_det as vdet','v.id','=','vdet.venta_id')
        ->join('clientes as c','c.id','=','v.cliente_id')
        ->select('v.id','v.fact_nro','v.fecha','v.total','c.nombre','v.iva5',
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento'
        ,DB::raw('sum(vdet.cantidad*precio) as total'))
        ->where('v.id','=',$id)
        ->orderBy('v.id', 'desc')
        ->groupBy('v.id','v.fact_nro','v.fecha','v.total','c.nombre','v.iva5',
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento')
        ->first();

        /*mostrar detalles*/
        $detalles=DB::table('presupuestos_det as vdet')
        ->join('productos as p','vdet.producto_id','=','p.id')
        ->select('vdet.cantidad','vdet.precio',DB::raw('COALESCE(vdet.servicio, p.descripcion) as producto'))
        ->where('vdet.venta_id','=',$id)
        ->orderBy('vdet.id', 'desc')->get();
        
        return view('presupuesto.show',['ventas' => $ventas,'detalles' =>$detalles]);
    }

    public function editar($id)
    {
        //dd($id);
         $ventas=DB::table('presupuestos as v')
        ->join('presupuestos_det as vdet','v.id','=','vdet.venta_id')
        ->join('clientes as c','c.id','=','v.cliente_id')
        ->select('v.id','v.fact_nro','v.fecha','v.total','c.nombre as cliente','v.iva5',
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento','c.id as cliente_id',
        'v.contable','v.empresa_id','v.vendedor_id'
        ,DB::raw('sum(vdet.cantidad*precio) as total'))
        ->where('v.id','=',$id)
        ->orderBy('v.id', 'desc')
        ->groupBy('v.id','v.fact_nro','v.fecha','v.total','c.nombre','v.iva5',
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento','c.id',
        'v.contable','v.empresa_id','v.vendedor_id')
        ->first();

        /*mostrar detalles*/
        $detalles=DB::table('presupuestos_det as vdet')
        ->join('productos as p','vdet.producto_id','=','p.id')
        ->select('vdet.cantidad','vdet.precio',DB::raw('COALESCE(vdet.servicio, p.descripcion) as producto'))
        ->where('vdet.venta_id','=',$id)
        ->orderBy('vdet.id', 'desc')->get();

        //dd($detalles);
        
        $empresas=DB::table('empresas as e')
        ->select('e.id as id','e.nombre','e.ruc','e.direccion')
        ->orderBy('e.id','asc')
        ->get();

        $vendedores=DB::table('vendedores as v')
        ->select('v.id','v.name')
        ->where('v.condicion','=',1)
        ->orWhere('v.id','=',$ventas->vendedor_id)
        ->orderBy('v.name','asc')
        ->get();

        return view('presupuesto.editar',['ventas' => $ventas,'detalles' =>$detalles,
        'empresas'=>$empresas,'vendedores'=>$vendedores]);
    }

    public function obtenerPresupuesto($id)
    {

        $cuotas=DB::table('presupuestos_det as vdet')
        ->join('productos as p','vdet.producto_id','=','p.id')
        ->select('vdet.cantidad','vdet.precio',DB::raw('COALESCE(vdet.servicio, p.descripcion) as producto'),'vdet.producto_id',
        'p.ArtCode','vdet.tipo_iva')
        ->where('vdet.venta_id','=',$id)
        ->orderBy('vdet.id', 'desc')->get();
        
        return $cuotas;
    }

    public function update(Request $request)
    {  //dd($request);  
        
        try
        {
            DB::beginTransaction();
            $presu_id=$request->presuhidden_id;

            $fecha_hoy= Carbon::now('America/Asuncion');

            $venta = Presupuesto::findOrFail($presu_id);
            $venta->cliente_id = $request->cliente_id;
            $venta->fact_nro = $venta->fact_nro;
            $venta->fecha = isset($request->fecha) ? $request->fecha : $fecha_hoy->toDateString();
            $venta->iva5 = $request->total_iva_5 ?? 0;
            $venta->iva10 = $request->total_iva_10 ?? $request->total_iva ?? 0;
            $venta->ivaTotal = $request->total_iva;
            $venta->exenta = $request->total_exenta ?? 0;
            $venta->total = $request->total_pagar;
            $venta->tipo_factura = $request->tipo_factura ?? 0;
            $venta->estado = 0;
            $venta->user_id = auth()->user()->id;
            $venta->contable = 1;
            $venta->empresa_id = $request->empresa_id ?? 1;
            $venta->vendedor_id = $request->vendedor_id == 0 ? null : $request->vendedor_id;
            $venta->save();

            $producto_id=$request->producto_id;
            $servicio = $request->servicio;
            $cantidad = str_replace(",", ".", $request->cantidad);
            $precio = str_replace(".", "", $request->precio);
            $tipo_iva = $request->tipo_iva;

           
            $cont=0;

            //TRAEMOS LOS DETALLES ANTERIORES
            $detallePresu=DB::table('presupuestos_det as odet')
            ->select('id')
            ->where('odet.venta_id','=',$presu_id)
            ->get();
            //BORRARMOS LOS DETALLES ANTERIORES
            //dd($request);
            for ($i = 0; $i < sizeof($detallePresu); $i++) 
            {
                presupuesto_det::destroy($detallePresu[$i]->id);
            }

             while($cont < count($producto_id)){

                $detalle = new presupuesto_det();
                /*enviamos valores a las propiedades del objeto detalle*/
                /*al idcompra del objeto detalle le envio el id del objeto compra, que es el objeto que se ingresó en la tabla compras de la bd*/
                $detalle->venta_id = $venta->id;
                $detalle->producto_id = $producto_id[$cont];
                $detalle->servicio = $servicio[$cont] ?? '';
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio = str_replace(".", "", $precio[$cont]);
                $detalle->tipo_iva = $tipo_iva[$cont] ?? 11;
  
                $detalle->save();
                $cont=$cont+1;                
            }
                
            DB::commit();

        } catch(Exception $e){
            
            DB::rollBack();
        }

        return Redirect::to('presupuesto');
    }

    public function facturar($id)
    {
        $fechaEmision = Carbon::now('America/Asuncion');
        $sucursal = auth()->user()->idsucursal;

        $presupuesto = Presupuesto::findOrFail($id);

        if ($presupuesto->estado == 1) {
            return Redirect::to('presupuesto')->with('msj', 'PRESUPUESTO YA FACTURADO');
        }

        $timbrados = DB::table('timbrados as t')
        ->select('id','ini_timbrado','fin_timbrado','suc_timbrado',
        'nrof_suc','nrof_expendio','nro_timbrado')
        ->where('estado','=',0)
        ->where('suc_timbrado','=',$sucursal)
        ->orderBy('id','desc')
        ->get();

        if ($timbrados->isEmpty()) {
            return Redirect::to('presupuesto')->with('msj', 'NO EXISTE TIMBRADO ACTIVO');
        }

        if ($fechaEmision > $timbrados[0]->fin_timbrado) {
            return Redirect::to('presupuesto')->with('msj', 'TIMBRADO VENCIDO');
        }

        $nroFactura = $this->siguienteNroFactura();

        try {
            DB::beginTransaction();

            $venta = new Venta();
            $venta->cliente_id = $presupuesto->cliente_id;
            $venta->empresa_id = $presupuesto->empresa_id ?? 1;
            $venta->vendedor_id = $presupuesto->vendedor_id;
            $venta->fact_nro = $nroFactura;
            $venta->timbrado = $timbrados[0]->nro_timbrado;
            $venta->fecha = $fechaEmision->toDateString();
            $venta->iva5 = $presupuesto->iva5;
            $venta->iva10 = $presupuesto->iva10;
            $venta->ivaTotal = $presupuesto->ivaTotal;
            $venta->exenta = $presupuesto->exenta ?? 0;
            $venta->total = $presupuesto->total;
            $venta->tipo_factura = $presupuesto->tipo_factura;
            $venta->estado = 0;
            $venta->user_id = auth()->user()->id;
            $venta->suc_nro = $timbrados[0]->nrof_suc;
            $venta->expendio_nro = $timbrados[0]->nrof_expendio;
            $venta->contable = 1;

            $venta->save();

            $detalles = Presupuesto_det::where('venta_id', $presupuesto->id)->get();

            foreach ($detalles as $presu_det) {
                $detalle = new Venta_det();
                $detalle->venta_id = $venta->id;
                $detalle->producto_id = $presu_det->producto_id;
                $detalle->servicio = $presu_det->servicio;
                $detalle->cantidad = $presu_det->cantidad;
                $detalle->precio = $presu_det->precio;
                $detalle->tipo_iva = $presu_det->tipo_iva ?? 11;
                $detalle->save();
            }

            $cuota = new Cuota();
            $cuota->factura_id = $venta->id;
            $cuota->cliente_id = $presupuesto->cliente_id;
            $cuota->tiempo = 0;
            $cuota->entrega = 0;
            $cuota->precio_inm = $presupuesto->total;
            $cuota->factura = $nroFactura;
            $cuota->suc_nro = $timbrados[0]->nrof_suc;
            $cuota->expendio_nro = $timbrados[0]->nrof_expendio;
            $cuota->usuario = auth()->user()->id;
            $cuota->save();

            $detalle = new Cuota_det();
            $detalle->cuota_id = $cuota->id;
            $detalle->cuota_nro = 1;
            $detalle->fec_vto = $fechaEmision;
            $detalle->fec_pag = $fechaEmision;
            $detalle->capital = round($presupuesto->total, 0);
            $detalle->interes = 0;
            $detalle->iva = round($presupuesto->ivaTotal, 0);
            $detalle->estado_cuota = 'P';
            $detalle->total_cuota = $presupuesto->total;
            $detalle->save();

            $presupuesto->estado = 1;
            $presupuesto->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::to('presupuesto')->with('msj', 'NO SE PUDO FACTURAR EL PRESUPUESTO');
        }

        return Redirect::to('factura')->with('msj2', 'PRESUPUESTO FACTURADO');
    }

    public function facturarPost(Request $request, $id)
    {
        $fechaEmision = Carbon::now('America/Asuncion');
        $sucursal = auth()->user()->idsucursal;

        $presupuesto = Presupuesto::findOrFail($id);

        if ($presupuesto->estado == 1) {
            return Redirect::to('presupuesto')->with('msj', 'PRESUPUESTO YA FACTURADO');
        }

        $timbrados = DB::table('timbrados as t')
        ->select('id','ini_timbrado','fin_timbrado','suc_timbrado',
        'nrof_suc','nrof_expendio','nro_timbrado')
        ->where('estado','=',0)
        ->where('suc_timbrado','=',$sucursal)
        ->orderBy('id','desc')
        ->get();

        if ($timbrados->isEmpty()) {
            return Redirect::to('presupuesto')->with('msj', 'NO EXISTE TIMBRADO ACTIVO');
        }

        if ($fechaEmision > $timbrados[0]->fin_timbrado) {
            return Redirect::to('presupuesto')->with('msj', 'TIMBRADO VENCIDO');
        }

        $nroFactura = $request->filled('fact_nro') ? $request->fact_nro : $this->siguienteNroFactura();

        if ($request->filled('fact_nro')) {
            $exists = Venta::where('fact_nro', $nroFactura)->exists();
            if ($exists) {
                return Redirect::to('presupuesto')->with('msj', 'EL NUMERO DE FACTURA INGRESADO YA EXISTE');
            }
        }

        try {
            DB::beginTransaction();

            $venta = new Venta();
            $venta->cliente_id = $presupuesto->cliente_id;
            $venta->empresa_id = $presupuesto->empresa_id ?? 1;
            $venta->vendedor_id = $presupuesto->vendedor_id;
            $venta->fact_nro = $nroFactura;
            $venta->timbrado = $timbrados[0]->nro_timbrado;
            $venta->fecha = $fechaEmision->toDateString();
            $venta->iva5 = $presupuesto->iva5;
            $venta->iva10 = $presupuesto->iva10;
            $venta->ivaTotal = $presupuesto->ivaTotal;
            $venta->exenta = $presupuesto->exenta ?? 0;
            $venta->total = $presupuesto->total;
            $venta->tipo_factura = $presupuesto->tipo_factura;
            $venta->estado = 0;
            $venta->user_id = auth()->user()->id;
            $venta->suc_nro = $timbrados[0]->nrof_suc;
            $venta->expendio_nro = $timbrados[0]->nrof_expendio;
            $venta->contable = 1;

            $venta->save();

            $detalles = Presupuesto_det::where('venta_id', $presupuesto->id)->get();

            foreach ($detalles as $presu_det) {
                $detalle = new Venta_det();
                $detalle->venta_id = $venta->id;
                $detalle->producto_id = $presu_det->producto_id;
                $detalle->servicio = $presu_det->servicio;
                $detalle->cantidad = $presu_det->cantidad;
                $detalle->precio = $presu_det->precio;
                $detalle->tipo_iva = $presu_det->tipo_iva ?? 11;
                $detalle->save();
            }

            $cuota = new Cuota();
            $cuota->factura_id = $venta->id;
            $cuota->cliente_id = $presupuesto->cliente_id;
            $cuota->tiempo = 0;
            $cuota->entrega = 0;
            $cuota->precio_inm = $presupuesto->total;
            $cuota->factura = $nroFactura;
            $cuota->suc_nro = $timbrados[0]->nrof_suc;
            $cuota->expendio_nro = $timbrados[0]->nrof_expendio;
            $cuota->usuario = auth()->user()->id;
            $cuota->save();

            $detalle = new Cuota_det();
            $detalle->cuota_id = $cuota->id;
            $detalle->cuota_nro = 1;
            $detalle->fec_vto = $fechaEmision;
            $detalle->fec_pag = $fechaEmision;
            $detalle->capital = round($presupuesto->total, 0);
            $detalle->interes = 0;
            $detalle->iva = round($presupuesto->ivaTotal, 0);
            $detalle->estado_cuota = 'P';
            $detalle->total_cuota = $presupuesto->total;
            $detalle->save();

            $presupuesto->estado = 1;
            $presupuesto->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::to('presupuesto')->with('msj', 'NO SE PUDO FACTURAR EL PRESUPUESTO');
        }

        return Redirect::to('factura')->with('msj2', 'PRESUPUESTO FACTURADO');
    }

    private function siguienteNroPresupuesto()
    {
        $ultimo = DB::table('presupuestos')
        ->where('fact_nro','LIKE','PRES-%')
        ->selectRaw("MAX(CAST(REPLACE(fact_nro, 'PRES-', '') AS UNSIGNED)) as ultimo")
        ->value('ultimo');

        $numero = ((int) $ultimo) + 1;

        return 'PRES-'.str_pad($numero, 6, '0', STR_PAD_LEFT);
    }

    private function siguienteNroFactura()
    {
        $ultimo = DB::table('ventas')
        ->whereRaw("fact_nro REGEXP '^[0-9]+$'")
        ->where('fact_nro','>',0)
        ->where('estado','=',0)
        ->selectRaw('MAX(CAST(fact_nro AS UNSIGNED)) as ultimo')
        ->value('ultimo');

        return ((int) $ultimo) + 1;
    }

    public function obtenerPrecio(Request $request)
        {
            $precio = DB::select('select * from productos where id = ?', [$request->producto_id]);
            return response()->json(['var'=>$precio]);
        }

    public function presuPDF($id){

        $ventas=DB::table('presupuestos as v')
        ->join('presupuestos_det as vdet','v.id','=','vdet.venta_id')
        ->join('clientes as c','c.id','=','v.cliente_id')
        ->select('v.id','v.fact_nro','v.fecha','v.total','c.nombre','c.num_documento as ruc','c.digito',
        'c.direccion','c.telefono','v.iva5','v.iva10','v.ivaTotal','v.exenta','v.tipo_factura',
        'c.num_documento')
        ->where('v.id','=',$id)
        ->orderBy('v.id', 'desc')
        ->groupBy('v.id','v.fact_nro','v.fecha','v.total','c.nombre','c.num_documento','c.digito',
        'c.direccion','c.telefono','v.iva5','v.iva10','v.ivaTotal','v.exenta','v.tipo_factura')
        ->get();

        $fechaahora2 = Carbon::parse($ventas[0]->fecha);
        $diafecha = Carbon::parse($ventas[0]->fecha)->format('d');
        $mesLetra = $fechaahora2->monthName;
        $agefecha = Carbon::parse($fechaahora2)->year;

        $tot_pag_let=NumerosEnLetras::convertir($ventas[0]->total,'Guaranies',false,'Centavos');
        //dd($tot_pag_let);
        /*mostrar detalles*/
        $detalles=DB::table('presupuestos_det as vdet')
        ->join('productos as p','vdet.producto_id','=','p.id')
        ->select('vdet.id','vdet.precio','p.descripcion',DB::raw('COALESCE(vdet.servicio, p.descripcion) as producto'),
        DB::raw('sum(vdet.cantidad*precio) as subtotal'),
        DB::raw('sum(vdet.cantidad) as cantidad'))
        ->where('vdet.venta_id','=',$id)
        ->groupby('vdet.precio','p.descripcion','vdet.id','vdet.servicio')
        ->orderBy('vdet.id', 'desc')->get();
        
        return $pdf= \PDF::loadView('presupuesto.presuPDF',['ventas' => $ventas,'detalles' =>$detalles,
        'diafecha' =>$diafecha,'mesLetra' =>$mesLetra,'agefecha' =>$agefecha,'tot_pag_let'=>$tot_pag_let])
         ->setPaper([0, 0, 702.2835, 1150.087], 'portrait')
         ->stream('Presupuesto-'.$ventas[0]->nombre.'.pdf');
    }

    public function destroy($id)
    {
       
        $det_presu = DB::table('presupuestos_det as vdet')
        ->select('id')
        ->where('vdet.venta_id', '=', $id)
        ->get();
        //dd($det_presu);
            Presupuesto::destroy($id);

         for($i = 0 ; $i < sizeof($det_presu); $i++)
         {
            Presupuesto_det::destroy($det_presu[$i]->id);

         }

        return Redirect::to("presupuesto");
    }

}
