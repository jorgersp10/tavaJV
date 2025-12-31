<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Tipo_iva;
use Illuminate\Support\Facades\Redirect;
use DB;
class ProductoController extends Controller
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
        //$prod = DB::connection('mysqlOrange')->table('Item')->limit(10)->orderBy('ArtCode')->get();
        //dd($prod);

        if($request){
            //Buscador de texto en el view y tambien la consula para mostrar datos en el index
            $sql=trim($request->get('buscarTexto'));
            $sql = str_replace(" ", "%", $sql);
            $productos=DB::table('productos')
            //$productos=Producto::join('categorias','productos.categoria_id','=','categorias.id')
            ->select('productos.id','productos.descripcion','productos.ArtCode','productos.stock'
            ,'productos.precio_compra','productos.precio_venta','productos.precio_min','productos.precio_max')
            ->where('productos.descripcion','LIKE','%'.$sql.'%')
            ->orWhere('productos.ArtCode','LIKE','%'.$sql.'%')
            ->orderBy('productos.descripcion','asc')
            ->get();

            $categorias=DB::table('categorias')
            ->select('id','codigo','descripcion')->get();

            $marcas=DB::table('marcas')
            ->select('id','descripcion')->get();

            $tipos_iva=DB::table('ivas as i')
            ->select('i.id','i.descripcion','i.iva')
            ->get();

            $ruta=rand(1, 20000);

            //dd($ruta);
            return view('producto.index',["productos"=>$productos,"categorias"=>$categorias,
            "marcas"=>$marcas,"tipos_iva"=>$tipos_iva,$ruta,"buscarTexto"=>$sql]);
            //return $clientes;
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
        $producto= new Producto();
        $producto->descripcion = strtoupper($request->descripcion);
        if ($producto->stock==null)
            $producto->stock = 0;
        else
            $producto->stock = $request->stock;

        // $prodcod=DB::table('productos')
        // ->select('ArtCode')->where()
 //dd($request);
        if($request->ArtCode == null)
        {
            $prodcod = Producto::whereRaw('ArtCode = (select max(`ArtCode`) from productos)')->first();
            if($prodcod == null)
            {
                $producto->ArtCode = '000000' . strval( + 1);              
            }
            else
            {
                if ($prodcod->ArtCode < 9) 
                 {
                        $ArtCo = '000000' . strval($prodcod->ArtCode + 1);
                    } elseif ($prodcod->ArtCode < 99) {
                        $ArtCo = '00000' . strval($prodcod->ArtCode + 1);
                    } elseif ($prodcod->ArtCode < 999) {
                        $ArtCo = '0000' . strval($prodcod->ArtCode + 1);
                    } elseif ($prodcod->ArtCode < 9999) {
                        $ArtCo = '000' . strval($prodcod->ArtCode + 1);
                    } elseif ($prodcod->ArtCode < 99999) {
                        $ArtCo = '00' . strval($prodcod->ArtCode + 1);
                }
                    $producto->ArtCode = $ArtCo;
            }
        }
        else
        {
            $producto->ArtCode = $request->ArtCode; 
        }

        $producto->iva_id = $request->tipo_iva; 
        $iva=Tipo_iva::findOrFail($request->tipo_iva);
        $producto->iva = $iva->iva; 
    
        if ($request->precio_venta==null)
            $producto->precio_venta = 0;
        else
            $producto->precio_venta = str_replace(".","",$request->precio_venta);
            
        if ($request->precio_compra==null)
            $producto->precio_compra = 0;
        else
            $producto->precio_compra = str_replace(".","",$request->precio_compra);
        
        if ($request->precio_min==null)
            $producto->precio_min = 0;
        else
        $producto->precio_min = str_replace(".","",$request->precio_min);

        if ($request->precio_max==null)
            $producto->precio_max = 0;
        else
            $producto->precio_max = str_replace(".","",$request->precio_max);

        if ($request->comentarios==null)
            $producto->comentarios = "";
        else   
        $producto->comentarios = strtoupper($request->comentarios);
        $producto->user_mod = auth()->user()->id;
        $producto->tipo_producto = $request->tipo_producto;

        $producto->save();
        return Redirect::to("producto")->with('msj2', 'PRODUCTO REGISTRADO');
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
        //dd($request);
        $producto=Producto::findOrFail($request->id_producto);

        $producto->descripcion = strtoupper($request->descripcion);
        if ($producto->stock == null) {
            $producto->stock = 0;
        } else {
            $producto->stock = $request->stock;
        }
        if ($request->ArtCode == null) {
            $producto->ArtCode = 0;
        } else {
            $producto->ArtCode = str_replace(".", "", $request->ArtCode);
        }

        $producto->iva_id = $request->tipo_iva; 
        $iva=Tipo_iva::findOrFail($request->tipo_iva);
        $producto->iva = $iva->iva;
        
        if ($request->precio_venta==null)
            $producto->precio_venta = 0;
        else
            $producto->precio_venta = str_replace(".","",$request->precio_venta);
            
        if ($request->precio_compra==null)
            $producto->frente = 0;
        else
            $producto->precio_compra = str_replace(".","",$request->precio_compra);
        
        if ($request->precio_min==null)
            $producto->contrafrente = 0;
        else
        $producto->precio_min = str_replace(".","",$request->precio_min);

        if ($request->precio_max==null)
            $producto->precio_max = 0;
        else
            $producto->precio_max = str_replace(".","",$request->precio_max);

        if ($request->comentarios==null)
            $producto->comentarios = "";
        else   
        $producto->comentarios = strtoupper($request->comentarios);
        $producto->user_mod = auth()->user()->id;
        $producto->tipo_producto = $request->tipo_producto;
        $producto->veri_stock = $request->veri_stock;
        //dd($producto);
        $producto->update();
        return Redirect::to("producto")->with('msj2', 'PRODUCTO ACTUALIZADO');
    }
    

    public function show($id)
    {
        $producto=DB::table('productos')
        //$producto=Producto::join('categorias','productos.categoria_id','=','categorias.id')
        ->select('productos.id','productos.descripcion','productos.ArtCode','productos.stock'
        ,'productos.precio_compra','productos.precio_venta','productos.precio_min',
        'productos.precio_max','productos.comentarios','productos.iva_id','productos.tipo_producto',
        'productos.veri_stock')
        ->where('productos.id','=',$id)
        ->orderBy('productos.descripcion','desc')->first();

        $categorias=DB::table('categorias')
        ->select('id','codigo','descripcion')->get();

        $marcas=DB::table('marcas')
        ->select('id','descripcion')->get();

        $tipos_iva=DB::table('ivas as i')
        ->select('i.id','i.descripcion','i.iva')
        ->get();

        //$producto->iva_id = $request->tipo_iva; 
        $iva=Tipo_iva::findOrFail($producto->iva_id);
        $tipo_iva = $iva->id; 

        // $imagenes=DB::table('electro_img')
        // ->select('id','imagen')
        // ->where('electro_id','=',$id)->get();

        // Desde el open orange
        // $precios = DB::connection('mysqlOrange')
        // ->table('Price')
        // ->select('ArtCode','PriceList','Price','internalId')
        // ->where('ArtCode','=',$producto->ArtCode)
        // ->get();
    

        // Desde el 
        // $precios = DB::table('Price')
        // ->select('ArtCode','PriceList','Price')
        // ->get();


        return view('producto.show',["producto"=>$producto,"marcas"=>$marcas,
        "categorias"=>$categorias,"tipos_iva"=>$tipos_iva,"tipo_iva"=>$tipo_iva]);

    }

    public function detalleCuotasInm($id){
        
        //dd($id);
        //DETALLES DEL O LOS INMUEBLES
        $id_cuota=DB::table('cuotas')
        ->select('id')
        ->where('inmueble_id','=',$id)
        ->first();
        $id_cuota_pdf= $id_cuota->id;
        //dd($id_cuota_pdf);
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

        
        return view('inmueble.detalleCuotas',["cuotas"=>$cuotas, "pagos"=>$pagos,
        "cantCuotas"=>$cantCuotas,"id_cuota_pdf"=>$id_cuota_pdf]);
    }

    public function detalleCuotasInmPDF($id){
        
        //dd($id);
        //DETALLES DEL O LOS INMUEBLES

        $id_inmueble=DB::table('cuotas')
        ->select('inmueble_id')
        ->where('id','=',$id)
        ->first();
        $id_inmueble = $id_inmueble ->inmueble_id;

        $cantCuotas=DB::table('cuotas_det')
        ->select('cuota_nro')
        ->where('cuota_id','=',$id)
        ->count('cuota_nro');

        $cuotaCero=DB::table('cuotas_det')
        ->select('cuota_nro')
        ->where('cuota_id','=',$id)
        ->get();
        //dd($cuotaCero);
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
        ->where('inmueble_id','=',$id_inmueble)
        ->orderBy('cdet.cuota_nro')
        ->get();
        //dd($cuotas);

        $pagos=DB::table('pagos as p')
        ->join('inmuebles as i','i.id','=','p.inmueble_id')
        ->select('p.fec_pag as fechapago','p.cuota as cuota_nro','p.cuota_id as cuota_id',
        'p.total_pag as totalpagado','p.cuota as capitalcuota',
        DB::raw('0 as saldo'))
        ->where('p.inmueble_id','=',$id_inmueble)
        ->orderBy('p.cuota')
        ->get();

        //dd($pagos);
        //return view('inmueble.detalleCuotas',["cuotas"=>$cuotas, "pagos"=>$pagos,"cantCuotas"=>$cantCuotas]);
        return $pdf= \PDF::loadView('inmueble.detalleCuotasPDF',["cuotas"=>$cuotas, "pagos"=>$pagos,"cantCuotas"=>$cantCuotas])
        ->setPaper('a4', 'portrait')
        ->stream('detalleCuotasInmPDF.pdf');
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

    public function destroy($id)
    {
        //dd($id);
        Producto::destroy($id);
        return Redirect::to("producto");
    }
}