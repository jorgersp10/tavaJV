<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use DB;

class UserController extends Controller
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
            $sql = str_replace(" ", "%", $sql);
            $usuarios=DB::table('users')
            ->join('roles','users.idrol','=','roles.id')
            ->join('sucursales','users.idsucursal','=','sucursales.id')
            ->select('users.id as id_user','users.name','users.email','users.num_documento','users.direccion',
            'users.telefono','users.condicion','users.password','users.dob as fecha_nacimiento','users.avatar',
            'roles.nombre as rol','sucursales.sucursal as sucursal','roles.id as idrol','sucursales.id as idsucursal')
            ->where('users.name','LIKE','%'.$sql.'%')
            ->orwhere('users.num_documento','LIKE','%'.$sql.'%')
            ->orderBy('users.id','desc')
            ->simplepaginate(20);

             /*listar los roles en ventana modal*/
            $roles=DB::table('roles')
            ->select('id','nombre','descripcion')
            ->where('condicion','=','1')->get();  

            /*listar los sucursales en ventana modal*/
            $sucursales=DB::table('sucursales')
            ->select('id','sucursal')
            ->where('id','!=','0')->get(); 

            return view('user.index',["usuarios"=>$usuarios,"roles"=>$roles,"sucursales"=>$sucursales,"buscarTexto"=>$sql]);
        
            //return $usuarios;
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
        $user= new User();
        $user->name = strtoupper($request->nombre);
        $user->num_documento = $request->num_documento;
        $user->direccion = $request->direccion;
        $user->telefono = $request->telefono;
        $user->email = $request->email;        
        $user->dob = $request->fecha_nacimiento;
        $user->idrol = $request->id_rol; 
        $user->idsucursal = $request->idsucursal;
        $user->password = bcrypt( $request->password);
        $user->condicion = '1'; 

        $user->save();
        return Redirect::to("user");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuarios=DB::table('users')
        ->join('roles','users.idrol','=','roles.id')
        ->join('sucursales','users.idsucursal','=','sucursales.id')
        ->select('users.id as id_user','users.name','users.email','users.num_documento','users.direccion',
        'users.telefono','users.condicion','users.password','users.dob as fecha_nacimiento','users.avatar',
        'roles.nombre as rol','sucursales.sucursal as sucursal','roles.id as idrol','sucursales.id as idsucursal')
        ->where('users.id','=',$id)
        ->first();

         /*listar los roles en ventana modal*/
        $roles=DB::table('roles')
        ->select('id','nombre','descripcion')
        ->get();  

        /*listar los sucursales en ventana modal*/
        $sucursales=DB::table('sucursales')
        ->select('id','sucursal')
        ->get(); 

        return view('user.show',["usuarios"=>$usuarios,"roles"=>$roles,"sucursales"=>$sucursales]);
    
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
        //dd($request->cambiar);
        $user= User::findOrFail($request->id_user);
        $user->name = strtoupper($request->nombre);
        $user->num_documento = $request->num_documento;
        $user->direccion = $request->direccion;
        $user->telefono = $request->telefono;
        $user->email = $request->email;        
        $user->dob = $request->fecha_nacimiento;
        $user->idrol = $request->id_rol; 
        $user->idsucursal = $request->idsucursal;
        if($request->cambiar == "on")
            $user->password = bcrypt( $request->password);
        
        $user->condicion = '1'; 

        $user->save();
        return Redirect::to("user");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user= User::findOrFail($request->id_usuario);
         
         if($user->condicion=="1"){

                $user->condicion= '0';
                $user->save();
                return Redirect::to("user");

           }else{

                $user->condicion= '1';
                $user->save();
                return Redirect::to("user");

            }
    }
}
