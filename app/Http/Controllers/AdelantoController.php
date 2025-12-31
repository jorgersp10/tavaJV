<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\Adelanto;
use App\Models\Recibo_Param2;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use DateTime;
use App\NumerosEnLetras;

class AdelantoController extends Controller
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
                $adelantos=DB::table('adelantos as a')
                ->join('funcionarios as f','a.funcionario_id','=','f.id')
                ->select('a.id','f.nombre','f.num_documento','a.adelanto',
                'a.fecha_adelanto','a.mes_pago','a.comentario')
                ->where('f.num_documento','LIKE','%'.$sql.'%')
                ->orWhere('f.nombre','LIKE','%'.$sql.'%')
                ->orderBy('a.id','desc')
                ->simplepaginate(12);

                return view('adelanto.index',["adelantos"=>$adelantos,"buscarTexto"=>$sql]);
                //return $adelantos;
            }
        }

        public function getFuncionarios(Request $request)
        {
     
            $search = $request->search;
    
            if($search == ''){
                $funcionarios = Funcionario::orderby('nombre','asc')
                        ->select('id','nombre','num_documento')
                        ->limit(5)
                        ->get();
            }else{
                $search = str_replace(" ", "%", $search);
                $funcionarios = Funcionario::orderby('nombre','asc')
                        ->select('id','nombre','num_documento')
                        ->where('nombre','like','%'.$search.'%')
                        //->orWhere('apellido','like','%'.$search.'%')
                        ->orWhere('num_documento','like','%'.$search.'%')
                        ->limit(5)
                        ->get();
            }
    
            $response = array();
    
            foreach($funcionarios as $func){
                $response[] = array(
                    'id' => $func->id,
                    'text' => $func->nombre." - ".$func->num_documento
                );
            }
            return response()->json($response);
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adelanto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $adelanto= new Adelanto();
        $adelanto->funcionario_id = $request->funcionario_id;
        $adelanto->adelanto = str_replace(".","",$request->adelanto);
        $adelanto->fecha_adelanto = Carbon::now();
        $adelanto->mes_pago = $request->mes_pago;
        $adelanto->mes = date('m',strtotime($request->mes_pago));
        $adelanto->age = date('Y',strtotime($request->mes_pago));
        if($request->comentario == null)
            $adelanto->comentario = "Ninguno";
        else
            $adelanto->comentario = $request->comentario;

        $adelanto->save();
        return Redirect::to("adelanto")->with('msj2', 'RECIBO REGISTRADO');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd($id);
        $adelantos=DB::table('adelantos as a')
        ->join('funcionarios as f','a.funcionario_id','=','f.id')
        ->select('f.id as funcionario_id','f.nombre','f.num_documento','f.nro_patronal',
        'a.id as id_adelanto','a.fecha_adelanto','a.mes_pago','a.comentario','a.adelanto')
        ->where('a.id','=',$id)
        ->first();

        $funcionarios=DB::table('funcionarios as f')
        ->select('f.id as funcionario_id','f.nombre','f.num_documento')
        ->get();
        //dd($adelantos);
        return view('adelanto.show',["adelantos"=>$adelantos,"funcionarios"=>$funcionarios]);
    }

    public function recibo_adelanto($id)
    {
        //dd($id);
        $adelantos=DB::table('adelantos as a')
        ->join('funcionarios as f','a.funcionario_id','=','f.id')
        ->select('a.id as id_adelanto','f.id as funcionario_id','f.nombre','f.num_documento','f.nro_patronal','a.id as id_adelanto',
        'a.fecha_adelanto','a.mes_pago','a.comentario','a.adelanto')
        ->where('a.id','=',$id)
        ->first();
        
        $fechames = Carbon::parse($adelantos->mes_pago);
        $mesLetra = ($fechames->monthName);
        //return view('adelanto.show',["adelantos"=>$adelantos]);
        return $pdf= \PDF::loadView('adelanto.reciboPrueba',["adelantos"=>$adelantos,"mesLetra"=>$mesLetra])
            ->setPaper([0, 0, 612.2835, 907.087], 'portrait')
            ->stream('Recibo'.$id.'pdf');
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
        //dd($request);
        $adelanto= Adelanto::findOrFail($request->id_adelanto);
        $adelanto->funcionario_id = $request->funcionario_id;
        $adelanto->adelanto = str_replace(".","",$request->adelanto);
        $adelanto->fecha_adelanto = Carbon::now();
        $adelanto->mes_pago = $request->mes_pago;
        $adelanto->mes = date('m',strtotime($request->mes_pago));
        $adelanto->age = date('Y',strtotime($request->mes_pago));
        if($request->comentario == null)
            $adelanto->comentario = "Ninguno";
        else
            $adelanto->comentario = $request->comentario;

        $adelanto->save();
        return Redirect::to("adelanto")->with('msj2', 'RECIBO ACTUALIZADO');
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
        Adelanto::destroy($id);
        return Redirect::to("adelanto")->with('msj2', 'ADELANTO BORRADO');
    }
}
