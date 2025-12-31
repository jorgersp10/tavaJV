<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timbrado;
use Illuminate\Support\Facades\Redirect;
use DB;
class TimbradoController extends Controller
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
            $timbrados=DB::table('timbrados as t')
            ->join('sucursales as s','t.suc_timbrado','=','s.id')
            ->select('t.id as id_timbrado','s.sucursal as suc_timbrado','s.id as idsucursal',
            't.nro_timbrado as nro_timbrado','t.ini_timbrado as ini_timbrado','t.fin_timbrado as fin_timbrado',
            't.nro_factura_ini as nro_factura_ini','t.nrof_factura as nro_factura','t.nrof_suc','nrof_expendio',
            't.estado' )
            ->where('t.suc_timbrado','LIKE','%'.$sql.'%')
            ->orderBy('t.id','asc')
            ->simplePaginate(20);

            /*listar los sucursales en ventana modal*/
            $sucursales=DB::table('sucursales')
            ->select('id','sucursal')
            ->where('id','!=','0')->get(); 

            //dd($clientes);
            return view('timbrado.index',["timbrados"=>$timbrados,"sucursales"=>$sucursales,"buscarTexto"=>$sql]);
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
        $timbrado= new Timbrado();        
        $timbrado->suc_timbrado = $request->suc_timbrado;
        $timbrado->ini_timbrado = $request->ini_timbrado;
        $timbrado->fin_timbrado = $request->fin_timbrado;
        $timbrado->nro_timbrado = $request->nro_timbrado;
        $timbrado->nrof_suc = $request->nrof_suc;
        $timbrado->nrof_expendio = $request->nrof_expendio;
        // $timbrado->nro_factura_ini = 0;
        // $timbrado->nro_factura = 0;

        $timbrado->save();
        return Redirect::to("timbrado");
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
        $timbrado= Timbrado::findOrFail($request->id_timbrado);
        $timbrado->suc_timbrado = $request->suc_timbrado;
        $timbrado->ini_timbrado = $request->ini_timbrado;
        $timbrado->fin_timbrado = $request->fin_timbrado;
        $timbrado->nro_timbrado = $request->nro_timbrado;
        $timbrado->nrof_suc = $request->nrof_suc;
        $timbrado->nrof_expendio = $request->nrof_expendio;
        // $timbrado->nro_factura_ini = 0;
        // $timbrado->nro_factura = 0;

        $timbrado->save();
        return Redirect::to("timbrado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //dd($id);
    //     Timbrado::destroy($id);
    //     return Redirect::to("timbrado");
    // }

    public function destroy(Request $request)
    {
        //dd($request);
        $timbrado= Timbrado::findOrFail($request->id_timbrado);
         
         if($timbrado->estado=="1"){

                $timbrado->estado= '0';
                $timbrado->save();
                return Redirect::to("timbrado");

           }else{

                $timbrado->estado= '1';
                $timbrado->save();
                return Redirect::to("timbrado");

            }
    }
}
