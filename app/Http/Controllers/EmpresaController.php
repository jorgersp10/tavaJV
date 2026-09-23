<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
        ->select('e.id as id','e.nombre','e.ruc','e.direccion','e.logo')
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

    public function logo($id)
    {
        $empresa = Empresa::findOrFail($id);
        $path = $empresa->logo ? storage_path('app/public/' . $empresa->logo) : null;

        if (!$path || !is_file($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $empresa= new Empresa();        
        $empresa->nombre = $request->nombre;
        $empresa->ruc = $request->ruc;
        $empresa->direccion = $request->direccion;
        if ($request->hasFile('logo')) {
            $empresa->logo = $request->file('logo')->store('empresas/logos', 'public');
        }

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
        ->select('e.id as id','e.nombre','e.ruc','e.direccion','e.logo')
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
        $request->validate([
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $empresa= Empresa::findOrFail($request->id_empresa);
        $empresa->nombre = $request->nombre;
        $empresa->ruc = $request->ruc;
        $empresa->direccion = $request->direccion;
        if ($request->hasFile('logo')) {
            if ($empresa->logo) {
                Storage::disk('public')->delete($empresa->logo);
            }
            $empresa->logo = $request->file('logo')->store('empresas/logos', 'public');
        }

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
