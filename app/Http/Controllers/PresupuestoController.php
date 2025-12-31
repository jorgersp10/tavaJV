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
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\NumerosEnLetras;
use DateTime;
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

        return view('presupuesto.create',["clientes"=>$clientes,"productos"=>$productos]);

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
            $venta->fact_nro = 0;
            $venta->fecha = $fecha_hoy->toDateString();
            $venta->iva5 = $request->iva5;
            $venta->iva10 = $request->iva10;
            $venta->ivaTotal = $request->total_iva;
            $venta->exenta = $request->exenta;
            $venta->total = $request->total_pagar;
            $venta->tipo_factura = 0;
            $venta->estado = 0;
            $venta->user_id = auth()->user()->id;
            $venta->save();

            $producto_id=$request->producto_id;
            $cantidad = str_replace(",", ".", $request->cantidad);
            $precio = str_replace(".", "", $request->precio);

           
            $cont=0;

             while($cont < count($producto_id)){

                $detalle = new presupuesto_det();
                /*enviamos valores a las propiedades del objeto detalle*/
                /*al idcompra del objeto detalle le envio el id del objeto compra, que es el objeto que se ingresó en la tabla compras de la bd*/
                $detalle->venta_id = $venta->id;
                $detalle->producto_id = $producto_id[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio = str_replace(".", "", $precio[$cont]);
  
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
        ->select('vdet.cantidad','vdet.precio','p.descripcion as producto')
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
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento','c.id as cliente_id'
        ,DB::raw('sum(vdet.cantidad*precio) as total'))
        ->where('v.id','=',$id)
        ->orderBy('v.id', 'desc')
        ->groupBy('v.id','v.fact_nro','v.fecha','v.total','c.nombre','v.iva5',
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento','c.id')
        ->first();

        /*mostrar detalles*/
        $detalles=DB::table('presupuestos_det as vdet')
        ->join('productos as p','vdet.producto_id','=','p.id')
        ->select('vdet.cantidad','vdet.precio','p.descripcion as producto')
        ->where('vdet.venta_id','=',$id)
        ->orderBy('vdet.id', 'desc')->get();

        //dd($detalles);
        
        return view('presupuesto.editar',['ventas' => $ventas,'detalles' =>$detalles]);
    }

    public function obtenerPresupuesto($id)
    {

        $cuotas=DB::table('presupuestos_det as vdet')
        ->join('productos as p','vdet.producto_id','=','p.id')
        ->select('vdet.cantidad','vdet.precio','p.descripcion as producto','vdet.producto_id',
        'p.ArtCode')
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
            $venta->fact_nro = 0;
            $venta->fecha = $fecha_hoy->toDateString();
            $venta->iva5 = $request->iva5;
            $venta->iva10 = $request->iva10;
            $venta->ivaTotal = $request->total_iva;
            $venta->exenta = $request->exenta;
            $venta->total = $request->total_pagar;
            $venta->tipo_factura = 0;
            $venta->estado = 0;
            $venta->user_id = auth()->user()->id;
            $venta->save();

            $producto_id=$request->producto_id;
            $cantidad = str_replace(",", ".", $request->cantidad);
            $precio = str_replace(".", "", $request->precio);

           
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
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio = str_replace(".", "", $precio[$cont]);
  
                $detalle->save();
                $cont=$cont+1;                
            }
                
            DB::commit();

        } catch(Exception $e){
            
            DB::rollBack();
        }

        return Redirect::to('presupuesto');
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
        ->select('v.id','v.fact_nro','v.fecha','v.total','c.nombre','v.iva5',
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento'
        ,DB::raw('sum(vdet.cantidad*precio) as total'))
        ->where('v.id','=',$id)
        ->orderBy('v.id', 'desc')
        ->groupBy('v.id','v.fact_nro','v.fecha','v.total','c.nombre','v.iva5',
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento')
        ->first();

        $tot_pag_let=NumerosEnLetras::convertir($ventas->total,'Guaranies',false,'Centavos');
        //dd($tot_pag_let);
        /*mostrar detalles*/
        $detalles=DB::table('presupuestos_det as vdet')
        ->join('productos as p','vdet.producto_id','=','p.id')
        ->select('vdet.cantidad','vdet.precio','p.descripcion as producto')
        ->where('vdet.venta_id','=',$id)
        ->orderBy('vdet.id', 'desc')->get();
        
        return $pdf= \PDF::loadView('presupuesto.presuPDF',['ventas' => $ventas,'detalles' =>$detalles,
        'tot_pag_let'=>$tot_pag_let])
         ->setPaper('a4', 'portrait')
         ->stream('Presupuesto-'.$ventas->nombre.'.pdf');
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
