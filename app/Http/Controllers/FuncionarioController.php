<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use DateTime;
use App\NumerosEnLetras;

class FuncionarioController extends Controller
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
            $funcionarios=DB::table('funcionarios')
            ->select('funcionarios.id','funcionarios.nombre','funcionarios.num_documento',
            'funcionarios.nro_patronal','funcionarios.telefono','funcionarios.salario_basico',
            'funcionarios.ips')
            ->where('funcionarios.nombre','LIKE','%'.$sql.'%')
            ->orwhere('funcionarios.num_documento','LIKE','%'.$sql.'%')
            ->orderBy('funcionarios.id','desc')
            ->simplepaginate(10);

            /*listar los roles en ventana modal*/
    

            return view('funcionario.index',["funcionarios"=>$funcionarios,"buscarTexto"=>$sql]);
            //return $funcionarios;
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
        //dd($request);
        $docu=str_replace(".", "", $request->num_documento);
         if($docu != null){
            $yaexistedocumento = DB::select('select nombre,num_documento,telefono from funcionarios where num_documento = ?',[$docu]);
            if($yaexistedocumento != NULL)
                $yaexistedocu = $yaexistedocumento[0]->nombre.' - '.$yaexistedocumento[0]->num_documento;
            else $yaexistedocu = '0';
        }//else $yaexistedocu = '0';//No cargo cedula

        if($yaexistedocu != '0'){
            //$mensaje = $yaexistedocu;
            return back()->with('msj', 'Funcionario: '.$yaexistedocu.' ya existe');
        //}
                
        }
        else 
        {
            $funcionario= new Funcionario();
            $funcionario->nombre = strtoupper($request->nombre);
            $funcionario->num_documento = str_replace(".", "", $request->num_documento);
            $funcionario->nro_patronal = $request->nro_patronal;
            $funcionario->telefono = $request->telefono;
            $funcionario->salario_basico = str_replace(".","",$request->salario_basico);
            $funcionario->ips = round(($funcionario->salario_basico * 0.09),0);
    
            $funcionario->save();
            return Redirect::to("funcionario")->with('msj2', 'CLIENTE REGISTRADO');
                
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
        $funcionarios=DB::table('funcionarios')
        ->select('funcionarios.id as id_funcionario','funcionarios.nombre','funcionarios.num_documento',
        'funcionarios.nro_patronal','funcionarios.telefono','funcionarios.salario_basico',
        'funcionarios.ips')
        ->where('funcionarios.id','=',$id)
        ->first();

        /*listar los roles en ventana modal*/


        return view('funcionario.show',["funcionarios"=>$funcionarios]);
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
        $funcionario= Funcionario::findOrFail($request->id_funcionario); 
        $funcionario->nombre = strtoupper($request->nombre);
        $funcionario->num_documento = $request->num_documento;
        $funcionario->nro_patronal = $request->nro_patronal;
        $funcionario->telefono = $request->telefono;
        $funcionario->salario_basico = str_replace(".","",$request->salario_basico);
        $funcionario->ips = round(($funcionario->salario_basico * 0.09),0);

        $funcionario->save();
        return Redirect::to("funcionario")->with('msj2', 'CLIENTE ACTUALIZADO');
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
