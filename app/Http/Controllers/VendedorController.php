<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendedor;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DateTime;
use DB;

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        if($request){

            $sql=trim($request->get('buscarTexto'));
            $vendedores=DB::table('vendedores')
            ->join('sucursales','vendedores.idsucursal','=','sucursales.id')
            ->select('vendedores.id','vendedores.name','vendedores.email','vendedores.num_documento','vendedores.direccion',
            'vendedores.telefono','vendedores.condicion','vendedores.dob as fecha_nacimiento',
            'sucursales.sucursal as sucursal','sucursales.id as idsucursal')
            ->where('vendedores.name','LIKE','%'.$sql.'%')
            ->orwhere('vendedores.num_documento','LIKE','%'.$sql.'%')
            ->orderBy('vendedores.id','desc')
            ->paginate(10);

            /*listar los sucursales en ventana modal*/
            $sucursales=DB::table('sucursales')
            ->select('id','sucursal')
            ->where('id','!=','0')->get(); 

            return view('vendedor.index',["vendedores"=>$vendedores,"sucursales"=>$sucursales,"buscarTexto"=>$sql]);
        
            //return $vendedores;
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
        $vendedor= new Vendedor();
        $vendedor->name = strtoupper($request->nombre);
        $vendedor->num_documento = $request->num_documento;
        $vendedor->direccion = $request->direccion;
        $vendedor->telefono = $request->telefono;
        $vendedor->email = $request->email;        
        $vendedor->dob = $request->fecha_nacimiento;
        $vendedor->idsucursal = $request->idsucursal;
        $vendedor->condicion = '1'; 

        $vendedor->save();
        return Redirect::to("vendedor");
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
        $vendedor= Vendedor::findOrFail($request->id_vendedor);
        $vendedor->name = strtoupper($request->nombre);
        $vendedor->num_documento = $request->num_documento;
        $vendedor->direccion = $request->direccion;
        $vendedor->telefono = $request->telefono;
        $vendedor->email = $request->email;        
        $vendedor->dob = $request->fecha_nacimiento;
        $vendedor->idsucursal = $request->idsucursal;
        $vendedor->condicion = '1'; 

        $vendedor->save();
        return Redirect::to("vendedor");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $vendedor= Vendedor::findOrFail($request->id_vendedor);
         
         if($vendedor->condicion=="1"){

                $vendedor->condicion= '0';
                $vendedor->save();
                return Redirect::to("vendedor");

           }else{

                $vendedor->condicion= '1';
                $vendedor->save();
                return Redirect::to("vendedor");

            }
    }
}
