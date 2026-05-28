<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Precio_historico;
use App\Models\Factura;
use App\Models\Venta_det;
use App\Models\Cuota;
use App\Models\Cuota_det;
use App\Models\User;
use App\Models\Pago;
use App\Models\Empresa;
use App\Models\Recibo_Paramorden;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Codedge\Fpdf\Fpdf\Fpdf;
use Carbon\Carbon;
use App\NumerosEnLetras;
use DateTime;
use DB;
use PDF;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
      
        if($request){
        
            $sql=trim($request->get('buscarTexto'));
            $ventas=DB::table('ventas as v')
            ->join('ventas_det as vdet','v.id','=','vdet.venta_id')
            ->join('clientes as c','c.id','=','v.cliente_id')
            ->join('users as u','u.id','=','v.user_id')
             ->select('v.id','v.fact_nro','v.iva5','v.iva10','v.ivaTotal','v.exenta','v.fecha',
             'v.total','v.estado','c.nombre','v.contable','v.nro_recibo')
            ->where('v.fact_nro','LIKE','%'.$sql.'%')
            ->orwhere('c.nombre','LIKE','%'.$sql.'%')
            ->orderBy('v.id','desc')
            ->groupBy('v.id','v.fact_nro','v.iva5','v.iva10','v.ivaTotal','v.exenta','v.fecha',
            'v.total','v.estado','c.nombre','v.contable','v.nro_recibo')
            ->paginate(10);

            $fecha_iva = DB::table('iva_param as i')
            ->select('i.fecha_ini','i.fecha_fin')
            ->first();

            //SECTOR DE CONTABLE
            $ventas_iva = DB::table('ventas as v')
            ->select(DB::raw('sum(v.total) as total_venta'))
            ->where('v.estado', '=', "0")
            ->where('v.fact_nro', '>', "0")
            ->whereBetween('v.fecha', [$fecha_iva->fecha_ini, $fecha_iva->fecha_fin])
            ->first();
            
            isset($ventas_iva->total_venta) ? $total_venta = $ventas_iva->total_venta : $total_venta = 0;
           
            $compras = DB::table('compras as c')
            ->select(DB::raw('sum(c.total) as total_compra'))
            ->where('c.estado', '=', "0")
            ->where('c.contable', '=', "1")
            ->whereBetween('c.fecha', [$fecha_iva->fecha_ini, $fecha_iva->fecha_fin])
            ->first();

            isset($compras->total_compra) ? $total_compra = $compras->total_compra : $total_compra = 0;

            $gastos = DB::table('gastos as g')
            ->select(DB::raw('sum(g.total) as total_gasto'))
            ->where('g.estado', '=', "0")
            ->where('g.contable', '=', "1")
            ->whereBetween('g.fecha', [$fecha_iva->fecha_ini, $fecha_iva->fecha_fin])
            ->first();

            isset($gastos->total_gasto) ? $total_gasto = $gastos->total_gasto : $total_gasto = 0;

            $total_compra_gasto = $total_compra + $total_gasto;
            $saldoFactura = $total_compra_gasto - $total_venta;

             //SECTOR DE NO CONTABLE CONTABLE
            $ventas_siniva = DB::table('ventas as v')
            ->select(DB::raw('sum(v.total) as total_venta'))
            ->where('v.estado', '=', "0")
            ->where('v.fact_nro', '=', "0")
            ->whereBetween('v.fecha', [$fecha_iva->fecha_ini, $fecha_iva->fecha_fin])
            ->first();
            //dd($ventas_siniva);
            isset($ventas_siniva->total_venta) ? $total_venta_siniva = $ventas_siniva->total_venta : $total_venta_siniva = 0;
           
            $compras_siniva = DB::table('compras as c')
            ->select(DB::raw('sum(c.total) as total_compra'))
            ->where('c.estado', '=', "0")
            ->where('c.contable', '=', "0")
            ->whereBetween('c.fecha', [$fecha_iva->fecha_ini, $fecha_iva->fecha_fin])
            ->first();

            isset($compras_siniva->total_compra) ? $total_compra_siniva = $compras_siniva->total_compra : $total_compra_siniva = 0;

            $gastos_siniva = DB::table('gastos as g')
            ->select(DB::raw('sum(g.total) as total_gasto'))
            ->where('g.estado', '=', "0")
            ->where('g.contable', '=', "0")
            ->whereBetween('g.fecha', [$fecha_iva->fecha_ini, $fecha_iva->fecha_fin])
            ->first();

            isset($gastos_siniva->total_gasto) ? $total_gasto_siniva = $gastos_siniva->total_gasto : $total_gasto_siniva = 0;

            $total_compra_gasto_siniva = $total_compra_siniva + $total_gasto_siniva;
            //$saldoFactura_siniva = $total_compra_gasto_siniva - $ventas_siniva;
 
            return view('factura.index',["ventas"=>$ventas,"total_venta"=>$total_venta,
            "total_compra_gasto"=>$total_compra_gasto,"saldoFactura"=>$saldoFactura,
            "total_venta_siniva"=>$total_venta_siniva,"total_compra_gasto_siniva"=>$total_compra_gasto_siniva,
            "buscarTexto"=>$sql]);
            
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

        $nro_factura = DB::table('ventas as v')
        ->select(DB::raw('MAX(v.fact_nro) as fact_nro'))
        ->where('v.estado','=',0)
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

        return view('factura.create',["clientes"=>$clientes,"productos"=>$productos,
        "nro_factura"=>$nro_factura,"empresas"=>$empresas,"vendedores"=>$vendedores]);

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

    public function getProductos(Request $request)
    {
 
    	$search = $request->search;

        if($search == ''){
            $productos = Producto::orderby('descripcion','asc')
                    ->select('id','ArtCode','descripcion')
                    ->limit(10)
                    ->get();
        }else{
            $search = str_replace(" ", "%", $search);
            $productos = Producto::orderby('descripcion','asc')
                    ->select('id','ArtCode','descripcion')
                    ->where('ArtCode','like','%'.$search.'%')
                    //->orWhere('apellido','like','%'.$search.'%')
                    ->orWhere('descripcion','like','%'.$search.'%')
                    ->limit(10)
                    ->get();
        }

        $response = array();

        foreach($productos as $prod){
            $response[] = array(
                'id' => $prod->id,
                'text' => $prod->ArtCode." - ".$prod->descripcion
            );
        }
        return response()->json($response);
    }

    public function validarNumero(Request $request)
    {
        $request->validate([
            'fact_nro' => 'required'
        ]);
    
        $existe = DB::table('ventas')
            ->where('fact_nro', $request->fact_nro)
            ->exists();
    
        return response()->json([
            'exists' => $existe
        ]);
    }

   public function store(Request $request)
   {
        //dd($request);
        $fechaEmision= Carbon::now('America/Asuncion');

        $sucursal= auth()->user()->idsucursal;
        //dd($sucursal);
        $timbrados = DB::table('timbrados as t')
        ->select('id','ini_timbrado','fin_timbrado','suc_timbrado',
        'nrof_suc','nrof_expendio','nro_timbrado')
        ->where('estado','=',0)
        ->where('suc_timbrado','=',$sucursal)
        ->orderBy('id','desc')
        ->get();
        //dd( $timbrados);
        $nro_f = DB::table('ventas as v')
        ->select('v.fact_nro')
        ->where('v.fact_nro','=',$request->fact_nro)
        ->where('v.fact_nro','>',0)
        ->where('v.estado','=',0)
        ->first();

       if($fechaEmision <= $timbrados[0]->fin_timbrado)
       {
            if( $nro_f == null)
            {
                try{

                        DB::beginTransaction();

                        $fecha_hoy= Carbon::now('America/Asuncion');

                        $venta = new Venta();
                        $venta->cliente_id = $request->cliente_id;
                        $venta->empresa_id = $request->empresa_id;
                        $venta->vendedor_id = $request->vendedor_id == 0 ? null : $request->vendedor_id;
                        if(($request->fact_nro == null) || ($request->fact_nro== 0))
                            $venta->fact_nro = 0;
                        else
                            $venta->fact_nro = $request->fact_nro;
                            $venta->timbrado = $timbrados[0]->nro_timbrado;

                        if($request->contable == 1)
                        {
                            $venta->fact_nro = $request->fact_nro;
                            $venta->timbrado = $timbrados[0]->nro_timbrado;
                        }
                        else
                        {
                            $ids = DB::select('select id from recibos_paramorden where suc_recibo= ?',[1]);
                            $tran_rec= Recibo_Paramorden::findOrFail($ids[0]->id);
                            $tran_rec->nro_recibo=$tran_rec->nro_recibo+1;
                            $nrorec=$tran_rec->nro_recibo;
                            $tran_rec->update();
                            $venta->nro_recibo = $nrorec;
                        }
                        $venta->fecha = isset($request->fecha) ? $request->fecha : $fecha_hoy;
                        $venta->iva5 = $request->total_iva_5;
                        $venta->iva10 = $request->total_iva_10;
                        $venta->ivaTotal = $request->total_iva;
                        $venta->exenta = $request->total_exenta;
                        $venta->total = $request->total_pagar;
                        $venta->tipo_factura = $request->tipo_factura;
                        $venta->estado = 0;
                        $venta->user_id = auth()->user()->id;
                        $venta->suc_nro = $timbrados[0]->nrof_suc;
                        $venta->expendio_nro = $timbrados[0]->nrof_expendio;
                        $venta->contable = $request->contable;
                        //dd($venta);
                        $venta->save();
                        //dd($request->total_pagar);
                        $producto_id = $request->producto_id;
                        $servicio = $request->servicio;
                        $cantidad = str_replace(",", ".", $request->cantidad);

                        $precio = str_replace(".","",$request->precio);

                        $tipo_iva = $request->tipo_iva;
                    
                        $cont=0;

                        while($cont < count($producto_id)){

                           $detalle = new Venta_det();
                            /*enviamos valores a las propiedades del objeto detalle*/
                            /*al idcompra del objeto detalle le envio el id del objeto compra, que es el objeto que se ingresó en la tabla compras de la bd*/
                            $detalle->venta_id = $venta->id;
                            $detalle->producto_id = $producto_id[$cont];
                            $detalle->servicio = $servicio[$cont];
                            $detalle->cantidad = $cantidad[$cont];
                            $detalle->precio = str_replace(".","",$precio[$cont]);  
                            $detalle->tipo_iva = $tipo_iva[$cont];  
                            //dd($detalle);
                            $detalle->save();
                            $cont=$cont+1;                
                        }
                        //genera una o mas cuotas para utilizar la caja ya creada y cobrar
                        $cuota= new Cuota();
                        $cuota->factura_id=$venta->id;
                        $cuota->cliente_id=$request->cliente_id;
                        $cuota->tiempo=0;
                        $cuota->entrega=$request->entrega;
                        $cuota->precio_inm=$request->total_pagar;
                        if(($request->fact_nro == null) || ($request->fact_nro== 0))
                        $cuota->factura=0;
                        else
                        $cuota->factura=$request->fact_nro;
                        $cuota->suc_nro = $timbrados[0]->nrof_suc;
                        $cuota->expendio_nro = $timbrados[0]->nrof_expendio;
                        $cuota->usuario=auth()->user()->id;
                        //dd($cuota);
                        $cuota->save();
                            
                        $detalle = new Cuota_det();
                        $detalle->cuota_id=$cuota->id;
                        $detalle->cuota_nro=1;
                        $detalle->fec_vto=$fecha_hoy;
                        $detalle->fec_pag=$fecha_hoy;
                        $detalle->capital=round($request->total_pagar,0);
                        $detalle->interes=0;
                        $detalle->iva=round($request->total_iva,0);
                        $detalle->estado_cuota='P';
                        $detalle->total_cuota=$request->total_pagar;
                        
                        $detalle->save();                             
                            
                        DB::commit();

                    } catch(Exception $e){
                        
                        DB::rollBack();
                }
                return Redirect::to('factura')->with('msj2', 'FACTURA REGISTRADA');
            }                
            else
            {
                return Redirect::to('factura')->with('msj', 'N° FACTURA REPETIDO');
            }
       }
       else
       {
           return Redirect::to('factura')->with('msj', 'TIMBRADO VENCIDO');
       }

    }

    public function show($id)
    {
        $ventas=DB::table('ventas as v')
        ->join('ventas_det as vdet','v.id','=','vdet.venta_id')
        ->join('clientes as c','c.id','=','v.cliente_id')
        ->join('empresas as e','e.id','=','v.empresa_id')
        ->leftJoin('vendedores as ven','ven.id','=','v.vendedor_id')
        ->select('v.id','v.fact_nro','v.fecha','v.total','c.nombre','v.iva5',
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento',
        'v.empresa_id','e.nombre as empresa','v.timbrado','v.vendedor_id','ven.name as vendedor'
        ,DB::raw('sum(vdet.cantidad*precio) as total'))
        ->where('v.id','=',$id)
        ->orderBy('v.id', 'desc')
        ->groupBy('v.id','v.fact_nro','v.fecha','v.total','c.nombre','v.iva5',
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento',
        'v.empresa_id','e.nombre','v.timbrado','v.vendedor_id','ven.name')
        ->first();
        //dd($ventas);
        /*mostrar detalles*/
        $detalles=DB::table('ventas_det as vdet')
        ->join('productos as p','vdet.producto_id','=','p.id')
        ->select('vdet.cantidad','vdet.precio','p.descripcion','vdet.servicio as producto')
        ->where('vdet.venta_id','=',$id)
        ->orderBy('vdet.id', 'desc')->get();

        $empresas=DB::table('empresas as e')
        ->select('e.id','e.nombre')
        ->get();

        $vendedores=DB::table('vendedores as v')
        ->select('v.id','v.name')
        ->where('v.condicion','=',1)
        ->orWhere('v.id','=',$ventas->vendedor_id)
        ->orderBy('v.name','asc')
        ->get();

        $empresa_id=Empresa::findOrFail($ventas->empresa_id);
        $empresa_id = $empresa_id->id;
        
        return view('factura.show',['ventas' => $ventas,'detalles' =>$detalles,
        'empresas' =>$empresas, 'empresa_id' =>$empresa_id,'vendedores'=>$vendedores]);
    }

    public function imprimirTicket($id)
    {
        //dd($id);
        $cabVenta=DB::table('ventas as v')
        ->join('ventas_det as vdet','v.id','=','vdet.venta_id')
        ->join('clientes as c','c.id','=','v.cliente_id')
        ->join('empresas as e','e.id','=','v.empresa_id')
        ->select('v.id','v.fact_nro','v.fecha','v.total','c.nombre','v.iva5',
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento',
        'v.empresa_id','e.nombre as empresa','v.timbrado','v.nro_recibo'
        ,DB::raw('sum(vdet.cantidad*precio) as total'))
        ->where('v.id','=',$id)
        ->orderBy('v.id', 'desc')
        ->groupBy('v.id','v.fact_nro','v.fecha','v.total','c.nombre','v.iva5',
        'v.iva10','v.ivaTotal','v.exenta','v.tipo_factura','c.num_documento',
        'v.empresa_id','e.nombre','v.timbrado','v.nro_recibo')
        ->first();
        //dd($cabVenta);
        /*mostrar detalles*/
        $detallesVenta=DB::table('ventas_det as vdet')
        ->join('productos as p','vdet.producto_id','=','p.id')
        ->select('vdet.cantidad','vdet.precio','p.descripcion','vdet.servicio as producto')
        ->where('vdet.venta_id','=',$id)
        ->orderBy('vdet.id', 'desc')->get();
        //dd($detalles);
        $empresas=DB::table('empresas as e')
        ->select('e.id','e.nombre')
        ->get();

        $empresa_id=Empresa::findOrFail($cabVenta->empresa_id);
        $empresa_id = $empresa_id->id;

        //CREAMOS EL TICKET
        $fpdf = new Fpdf('P','mm',array(75,200));
        $fpdf->AddPage();
        // CABECERA
        $fpdf->SetFont('Helvetica','',10);
        $fpdf->Cell(40,4,$cabVenta->empresa,0,1,'C');
        $fpdf->Ln(1);
        $fpdf->SetFont('Helvetica','',8);
        // $fpdf->Cell(60,4,'Productos de limpieza, cobranzas y accesorios en gral.',0,1,'C');
        // $fpdf->Cell(60,4,'Calle Argentina, Arroyo Pora, Encarnacion',0,1,'C');
        // $fpdf->Cell(60,4,'Celular: 0982-111970',0,1,'C');
        // DATOS FACTURA        
        $fpdf->Ln(2);
        $fpdf->Cell(10,3,'Comprobante Nro: '.$cabVenta->nro_recibo,0,1,'');
        $textoCliente = 'Cliente: '.$cabVenta->nombre;
        $fpdf->MultiCell(60, 4, $textoCliente, 0, '');
        $fpdf->Cell(10,4,'Fecha: '.date('d-m-Y', strtotime($cabVenta->fecha)),0,1,'');
        //$fpdf->Cell(10,4,'Vendedor/a: '.$cabVenta->vendedor,0,1,'');
        $fpdf->Ln(0);
        // COLUMNAS
        $fpdf->SetFont('Helvetica', 'B', 8);
        $fpdf->Cell(20, 10, 'Articulo', 0);
        $fpdf->Cell(5, 10, 'Ud',0,0,'R');
        $fpdf->Cell(10, 10, 'Precio',0,0,'R');
        $fpdf->Cell(15, 10, 'Total',0,0,'R');
        $fpdf->Ln(8);
        $fpdf->Cell(50,0,'','T');
        $fpdf->Ln(0);                      
        
        $total_deuda=0;
        $total_pagos=0;
        $total_vencido=0;
        $total_cantidad=0;

        foreach($detallesVenta as $row)
        {
            $fpdf->SetFont('Helvetica', '', 7);
            $fpdf->MultiCell(20,4,$row->producto,0,'L'); 
            $fpdf->Cell(25, -5, number_format(($row->cantidad), 0, ",", "."),0,0,'R');
            $fpdf->Cell(10, -5, number_format(($row->precio), 0, ",", "."),0,0,'R');
            $fpdf->Cell(15, -5, "Gs. ".number_format(($row->precio*$row->cantidad), 0, ",", "."),0,0,'R');
            $fpdf->Ln(3);

            $total_cantidad = $total_cantidad + $row->cantidad;
            
        }  
        
        $fpdf->Ln(1);
        //HALLAMOS LOS PRECIOS EN OTRAS MONEDAS
        $totalGs = $cabVenta->total ;
        
        // $fpdf->SetFont('Helvetica', '', 7);
        // $fpdf->MultiCell(20,4,"Total ITEMS",0,'L'); 
        // $fpdf->Cell(25, -5, number_format(($total_cantidad), 0, ",", "."),0,0,'R');
        // $fpdf->Cell(10, -5, "-",0,0,'R');
        // $fpdf->Cell(15, -5, "Gs. ".number_format(($totalGs), 0, ",", "."),0,0,'R');
        
        // SUMATORIO DE LOS PRODUCTOS Y EL IVA
        $fpdf->Ln(4);
        $fpdf->Cell(50,0,'','T');
        $fpdf->Ln(2);               
        $fpdf->Cell(25, 7, 'TOTAL Gs. ', 0);    
        $fpdf->Cell(10, 7, '', 0);
        $fpdf->Cell(15, 7, "Gs. ".number_format(($totalGs), 0, ",", "."),0,0,'R');
        $fpdf->Ln(3);           
        $fpdf->Ln(4);
        $fpdf->Cell(50, 7, 'COMPROBANTE SIN VALOR CONTABLE. ', 0); 
        //$fpdf->Cell(0,10,'Printing line number '.$i,0,1);
        //$fpdf->Output('ficha.pdf','F');
        $fpdf->Output("OfficeForm.pdf","I");

        exit;
        
    }

     public function factura_pdf($id){

        //dd($id);    
        /*mostrar compra*/
        //$id = $request->id;
        $ventas=DB::table('ventas as v')
        ->join('ventas_det as vdet','v.id','=','vdet.venta_id')
        ->join('clientes as c','c.id','=','v.cliente_id')
        ->select('v.id','v.fact_nro','v.fecha','v.total','c.nombre','c.num_documento as ruc','c.digito',
        'c.direccion','c.telefono','v.iva5','v.iva10','v.ivaTotal','v.exenta','v.tipo_factura',
        'c.num_documento')
        ->where('v.id','=',$id)
        ->orderBy('v.id', 'desc')
        ->get();

        /*mostrar detalles*/
        $detalles=DB::table('ventas_det as vdet')
        ->join('productos as p','vdet.producto_id','=','p.id')
        ->select('vdet.id','vdet.precio','p.descripcion','vdet.servicio as producto','tipo_iva','p.ArtCode',
        DB::raw('sum(vdet.cantidad*precio) as subtotal'),
        DB::raw('sum(vdet.cantidad) as cantidad'))
        ->where('vdet.venta_id','=',$id)
        ->groupby('vdet.precio','p.descripcion','vdet.id','vdet.servicio','tipo_iva','p.ArtCode')
        ->orderBy('vdet.id', 'desc')->get();
        //dd($detalles);
        $fechaahora2 = Carbon::parse($ventas[0]->fecha);
        //dd($fechaahora2);
        //EL DIA DE LA FECHA FORMATEADO CON CARGBON
        $diafecha = Carbon::parse($ventas[0]->fecha)->format('d');
        //dd($diafecha);
        $mesLetra = ($fechaahora2->monthName); //y con esta obtengo el mes al fin en espaﾃｱol!
        //OBTENER EL Aﾃ前
        $agefecha = Carbon::parse($fechaahora2)->year;
        //dd($agefecha);

        $tp = $ventas[0]->total;
        //dd($tp);
       
        $tot_pag_let=NumerosEnLetras::convertir($tp,'Guaranies',false,'Centavos');
        
        //dd($detalles);
        //return view('factura.facturaPDF',['ventas' => $ventas,'detalles' =>$detalles]);
        return $pdf= PDF::loadView('factura.facturaPDF',['ventas' => $ventas,'detalles' =>$detalles,
        'diafecha' =>$diafecha,'mesLetra' =>$mesLetra,'agefecha' =>$agefecha,'tot_pag_let' =>$tot_pag_let])
         ->setPaper([0, 0, 702.2835, 1150.087], 'portrait')
         ->stream('Factura'.$id.'.pdf');
    }
    
    public function edit(Request $request){


            $venta = Venta::findOrFail($request->id_venta);
            $venta->estado = 1;
            $venta->save();
            return Redirect::to('factura');

    }

    public function obtenerPrecio(Request $request)
        {
            $precio = DB::select('select * from productos where id = ?', [$request->producto_id]);
            //$tipo_producto = DB::select('select * from productos where id = ?', [$request->producto_id]);
            return response()->json(['var'=>$precio]);
        }

    public function destroy($id)
    {
        
         try{

            DB::beginTransaction();


            $venta = Venta::findOrFail($id);
            //dd($venta);

            if($venta->estado == 1){

                $pagos = DB::table('pagos as p')
                ->select('id')
                ->where('p.factura_id', '=', $id)
                ->get();

                //dd($pagos);

                for($i = 0 ; $i < sizeof($pagos); $i++)
                {
                    Pago::destroy($pagos[$i]->id);
                }

                $cuotas = DB::table('cuotas as c')
                ->select('id')
                ->where('c.factura_id', '=', $id)
                ->first();
                //dd(isset($cuotas));
                if(isset($cuotas)){
                    $cuotas_det = DB::table('cuotas_det as cdet')
                    ->select('id')
                    ->where('cdet.cuota_id', '=', $cuotas->id)
                    ->get();

                    for ($i = 0; $i < sizeof($cuotas_det); $i++) {
                        Cuota_det::destroy($cuotas_det[$i]->id);
                    }
                    Cuota::destroy($cuotas->id);

                }
                
                $ventas = DB::table('ventas as v')
                ->select('id')
                ->where('v.id', '=', $id)
                ->first();

                if(isset($ventas)){
                    $ventas_det = DB::table('ventas_det as vdet')
                    ->select('id')
                    ->where('vdet.venta_id', '=', $id)
                    ->get();
                //dd($ventas_det);

                    for ($i = 0; $i < sizeof($ventas_det); $i++) {
                        Venta_det::destroy($ventas_det[$i]->id);
                    }
                    Venta::destroy($id);

                }
                //dd($ventas_det);

            }
            else{
                return Redirect::to('factura')->with('msj', 'FACTURA DEBE SER ANULADA ANTES DE BORRAR');

            }

            DB::commit();

        } catch(Exception $e){
            
            DB::rollBack();
        }

        return Redirect::to('factura')->with('msj2', 'FACTURA ELIMINADA');
    }

    public function update_facNro( Request $request){     
        
        $nro_f = DB::table('ventas as v')
        ->select('v.fact_nro')
        ->where('v.fact_nro','=',$request->fact_nro)
        ->where('v.fact_nro','>',0)
        ->where('v.estado','=',0)
        ->first();

        $venta = Venta::findOrFail($request->id_venta);
        $venta->fecha = $request->fecha;
        $venta->empresa_id = $request->empresa_id;
        $venta->vendedor_id = $request->vendedor_id == 0 ? null : $request->vendedor_id;
        $venta->timbrado = $request->timbrado;
        $venta->save();

        if($nro_f != null){
            return Redirect::to('factura')->with('msj', 'N° FACTURA REPETIDO');
        }
        else{
            $venta = Venta::findOrFail($request->id_venta);
            $venta->fact_nro = $request->fact_nro;
            $venta->fecha = $request->fecha;
            $venta->empresa_id = $request->empresa_id;
            $venta->vendedor_id = $request->vendedor_id == 0 ? null : $request->vendedor_id;
            $venta->save();

            return Redirect::to('factura')->with('msj2', 'FACTURA ACTUALIZADA');
        }       
        return Redirect::to('factura')->with('msj2', 'FACTURA ACTUALIZADA');
    }
     public function factura_pdf_orden($id)
     {
        //$id = $request->id;
        $ventas=DB::table('ventas as v')
        ->join('ventas_det as vdet','v.id','=','vdet.venta_id')
        ->join('clientes as c','c.id','=','v.cliente_id')
        ->select('v.id','v.fact_nro','v.fecha','v.total','c.nombre','c.num_documento as ruc','c.digito',
        'c.direccion','c.telefono','v.iva5','v.iva10','v.ivaTotal','v.exenta','v.tipo_factura',
        'c.num_documento','v.nro_recibo')
        ->where('v.id','=',$id)
        ->orderBy('v.id', 'desc')
        ->get();

        /*mostrar detalles*/
        $detalles=DB::table('ventas_det as vdet')
        ->join('productos as p','vdet.producto_id','=','p.id')
        ->select('vdet.id','vdet.precio','p.descripcion','vdet.servicio as producto',
        DB::raw('sum(vdet.cantidad*precio) as subtotal'),
        DB::raw('sum(vdet.cantidad) as cantidad'))
        ->where('vdet.venta_id','=',$id)
        ->groupby('vdet.precio','p.descripcion','vdet.id','vdet.servicio')
        ->orderBy('vdet.id', 'desc')->get();
        //dd($detalles);
        $fechaahora2 = Carbon::parse($ventas[0]->fecha);
        //dd($fechaahora2);
        //EL DIA DE LA FECHA FORMATEADO CON CARGBON
        $diafecha = Carbon::parse($ventas[0]->fecha)->format('d');
        //dd($diafecha);
        $mesLetra = ($fechaahora2->monthName); //y con esta obtengo el mes al fin en espaﾃｱol!
        //OBTENER EL Aﾃ前
        $agefecha = Carbon::parse($fechaahora2)->year;
        //dd($agefecha);

        $tp = $ventas[0]->total;
        //dd($tp);
       
        $tot_pag_let=NumerosEnLetras::convertir($tp,'Guaranies',false,'Centavos');
        
        //dd($detalles);
        //return view('factura.facturaPDF',['ventas' => $ventas,'detalles' =>$detalles]);
        return $pdf= PDF::loadView('factura.facturaOrdenPDF',['ventas' => $ventas,'detalles' =>$detalles,
        'diafecha' =>$diafecha,'mesLetra' =>$mesLetra,'agefecha' =>$agefecha,'tot_pag_let' =>$tot_pag_let])
         ->setPaper([0, 0, 702.2835, 1150.087], 'portrait')
         ->stream('Factura'.$id.'.pdf');
    }
}
