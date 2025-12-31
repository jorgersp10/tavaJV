<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concepto;
use Illuminate\Support\Facades\Redirect;
use DB;
class ConceptoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){
            //Buscador de texto en el view y tambien la consula para mostrar datos en el index
            $sql=trim($request->get('buscarTexto'));
            $sql = str_replace(" ", "%", $sql);
            $conceptos=DB::table('conceptos as s')
            //->join('empresas','clientes.idempresa','=','empresas.id')
            ->select('s.id as id','s.descripcion as concepto')
            ->where('s.descripcion','LIKE','%'.$sql.'%')
            ->orderBy('s.id','asc')
            ->simplePaginate(10);

            //dd($clientes);
            return view('concepto.index',["conceptos"=>$conceptos,"buscarTexto"=>$sql]);
            //return $clientes;
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
        $concepto= new Concepto();        
        $concepto->descripcion = $request->descripcion;

        $concepto->save();
        return Redirect::to("concepto");
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
        $concepto= Concepto::findOrFail($request->id_concepto);
        $concepto->descripcion = $request->descripcion;

        $concepto->save();
        return Redirect::to("concepto");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        Concepto::destroy($id);
        return Redirect::to("concepto");
    }
}
