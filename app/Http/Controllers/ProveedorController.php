<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use DateTime;
use App\NumerosEnLetras;

class ProveedorController extends Controller
{
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
            $sql = str_replace(" ", "%", $sql);
            $proveedores=DB::table('proveedores as p')
            ->select('p.id','p.nombre','p.ruc','p.telefono',
            'p.direccion','p.email','p.whatsapp')
            ->where('p.nombre','LIKE','%'.$sql.'%')
            ->orwhere('p.ruc','LIKE','%'.$sql.'%')
            ->orderBy('p.id','desc')
            ->paginate(10);

            /*listar los roles en ventana modal*/
    

            return view('proveedor.index',["proveedores"=>$proveedores,"buscarTexto"=>$sql]);
            //return $proveedores;
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
         //VERIFICAR SU CEDULA YA ESTA REGISTRADA

         if($request->ruc != null){
            $yaexistedocumento = DB::select('select nombre,ruc,telefono from proveedores where ruc = ?',[$request->ruc]);
            if($yaexistedocumento != NULL)
                $yaexistedocu = $yaexistedocumento[0]->nombre.' - '.$yaexistedocumento[0]->ruc;
            else $yaexistedocu = '0';
        }//else $yaexistedocu = '0';//No cargo cedula

        if($yaexistedocu != '0'){
            //$mensaje = $yaexistedocu;
            return back()->with('msj', 'Proveedor: '.$yaexistedocu.' ya resgistrado');
        //}
                
        }
        else 
        {
            $proveedor= new Proveedor();
            $proveedor->nombre = strtoupper($request->nombre);
            $proveedor->ruc = $request->ruc;
            $proveedor->telefono = $request->telefono;
            $proveedor->whatsapp = $request->whatsapp;
            $proveedor->direccion = strtoupper($request->direccion);
            $proveedor->email = $request->email;
            $proveedor->user_id = auth()->user()->id;
    
            $proveedor->save();
            
            $desde = $request->desde_factura;

            if($desde == 1)
            {
                return Redirect::to("compra/create")->with('msj2', 'PROVEEDOR REGISTRADO');
            }
            else
            {
                return Redirect::to("proveedor")->with('msj2', 'PROVEEDOR REGISTRADO');
            }
            
                
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $proveedor= Proveedor::findOrFail($request->id_proveedor);
        $proveedor->nombre = strtoupper($request->nombre);
        $proveedor->ruc = $request->ruc;
        $proveedor->telefono = $request->telefono;
        $proveedor->whatsapp = $request->whatsapp;
        $proveedor->direccion = strtoupper($request->direccion);
        $proveedor->email = $request->email;
        $proveedor->user_id = auth()->user()->id;

        $proveedor->save();
        return Redirect::to("proveedor")->with('msj2', 'PROVEEDOR REGISTRADO');
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