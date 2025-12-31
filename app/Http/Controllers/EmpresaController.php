<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\Redirect;
use DB;
class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {       
        $empresas=DB::table('empresas as e')
        ->select('e.id as id','e.nombre','e.ruc','e.direccion')
        ->orderBy('e.id','asc')
        ->get();

        return view('empresa.index',["empresas"=>$empresas]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empresa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa= new Empresa();        
        $empresa->nombre = $request->nombre;
        $empresa->ruc = $request->ruc;
        $empresa->direccion = $request->direccion;

        $empresa->save();
        return Redirect::to("empresa");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresas=DB::table('empresas as e')
        ->select('e.id as id','e.nombre','e.ruc','e.direccion')
        ->where('e.id','=',$id)
        ->first();

        //dd($clientes);
        return view('empresa.show',["empresas"=>$empresas]);
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
        $empresa= Empresa::findOrFail($request->id_empresa);
        $empresa->nombre = $request->nombre;
        $empresa->ruc = $request->ruc;
        $empresa->direccion = $request->direccion;

        $empresa->update();
        return Redirect::to("empresa");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
        Empresa::destroy($id);

        return Redirect::to("empresa")->with('msj2', 'EMPRESA ELIMINADA');
    }
}
