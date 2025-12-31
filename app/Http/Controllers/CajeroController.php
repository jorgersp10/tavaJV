<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cajero;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use DB;

class CajeroController extends Controller
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
            $cajeros=DB::table('cajeros as c')
            ->join('users','users.id','=','c.user_id')
            ->join('roles','roles.id','=','users.idrol')
            ->join('sucursales','users.idsucursal','=','sucursales.id')
            ->select('users.id','users.name','users.email','users.num_documento','users.direccion',
            'users.telefono','users.condicion','users.password','users.dob as fecha_nacimiento','users.avatar'
            ,'roles.nombre as rol','sucursales.sucursal as sucursal','roles.id as idrol','sucursales.id as idsucursal','c.caja_nro','c.user_id','c.id')
            ->where('users.name','LIKE','%'.$sql.'%')
            ->orwhere('users.num_documento','LIKE','%'.$sql.'%')
            ->orderBy('c.id','asc')
            ->paginate(25);

            /*listar los roles en ventana modal*/
            // $roles=DB::table('roles')
            // ->select('id','nombre','descripcion')
            // ->where('condicion','=','1')->get();  

            /*listar los usuarios en ventana modal*/
            $usuarios=DB::table('users')
            ->select('id','name','email','num_documento')
            ->where('id','!=','0')->get(); 

            // /*listar los sucursales en ventana modal*/
            // $sucursales=DB::table('sucursales')
            // ->select('id','sucursal')
            // ->where('id','!=','0')->get(); 

            return view('cajero.index',["usuarios"=>$usuarios,"cajeros"=>$cajeros,"buscarTexto"=>$sql]);
        
            //return $usuarios;
        }
    }
    
    public function store(Request $request)
    {
        $cajero= new Cajero();
        $cajero->user_id = $request->user_id;
        $cajero->caja_nro = $request->caja_nro;

        $cajero->save();
        return Redirect::to("cajero");
    }

    public function update(Request $request)
    {
        $cajero= Cajero::findOrFail($request->id_cajero);
        $cajero->user_id = $request->user_id;
        $cajero->caja_nro = $request->caja_nro;

        $cajero->save();
        return Redirect::to("cajero");
    }
}
