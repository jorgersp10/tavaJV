<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\Recibo_funcionario;
use App\Models\Recibo_Param2;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use DateTime;
use App\NumerosEnLetras;

class Recibo_funcionarioController extends Controller
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
                $recibos=DB::table('recibo_funcionarios as r')
                ->join('funcionarios as f','r.funcionario_id','=','f.id')
                ->select('f.nombre','f.num_documento','f.nro_patronal','r.id','f.salario_basico',
                'f.ips','r.otros_desc','r.comisiones','r.horas_extra','r.otros_ingre','r.total_desc','r.salario_cobrar',
                'r.fecha_recibo','mes_pago')
                ->where('f.num_documento','LIKE','%'.$sql.'%')
                ->orWhere('f.nombre','LIKE','%'.$sql.'%')
                ->orderBy('r.id','desc')
                ->simplepaginate(12);

                return view('recibo_funcionario.index',["recibos"=>$recibos,"buscarTexto"=>$sql]);
                //return $recibos;
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
        return view('recibo_funcionario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ids = DB::select('select id from recibos_param2 where suc_recibo= 1');
        $tran_rec= Recibo_Param2::findOrFail($ids[0]->id);
        $tran_rec->nro_recibo=$tran_rec->nro_recibo+1;
        $nrorec=$tran_rec->nro_recibo;
        //dd($tran_rec->nro_recibo,$nrorec);
        $tran_rec->update();
        $mes = date('m',strtotime($request->mes_pago));
        $age = date('Y',strtotime($request->mes_pago));
        //dd($mes);

        $adelantos=DB::table('adelantos as a')
        ->select('a.funcionario_id','a.adelanto','a.mes_pago')
        ->where('a.funcionario_id','=',$request->funcionario_id)
        ->where('a.mes','=',$mes)
        ->where('a.age','=',$age)
        ->get();
        //dd($adelantos);
        $total_adelanto = 0;
        for($i = 0 ; $i < sizeof($adelantos); $i++){
            $total_adelanto = $total_adelanto + $adelantos[$i]->adelanto;
        }
        //dd($total_adelanto);

        $rec_func= new Recibo_funcionario();
        $rec_func->funcionario_id = $request->funcionario_id;
        $rec_func->nro_recibo = $nrorec;

        $funcionarios=DB::table('funcionarios as f')
        ->select('f.salario_basico','f.ips')
        ->where('f.id','=',$request->funcionario_id)
        ->first();

        $rec_func->salario_basico = $funcionarios->salario_basico;
        $rec_func->ips = $funcionarios->ips;
        //$rec_func->salario_basico = str_replace(".","",$request->salario_basico);
        if($request->horas_extra == null)
            $rec_func->horas_extra = 0;
        else
            $rec_func->horas_extra = str_replace(".","",$request->horas_extra);

        if($request->otros_ingre == null)
            $rec_func->otros_ingre = 0;
        else
            $rec_func->otros_ingre = str_replace(".","",$request->otros_ingre);

        if($request->otros_desc == null)
            $rec_func->otros_desc = $total_adelanto;
        else
            $rec_func->otros_desc = str_replace(".","",$request->otros_desc) + $total_adelanto;

        if($request->comisiones == null) 
            $rec_func->comisiones = 0;
        else
        $rec_func->comisiones = str_replace(".","",$request->comisiones);
        $rec_func->total_desc = $rec_func->ips + $rec_func->otros_desc;
        $total_ingresos = $rec_func->salario_basico + $rec_func->horas_extra + $rec_func->otros_ingre + $rec_func->comisiones;

        $rec_func->salario_cobrar = $total_ingresos - $rec_func->total_desc;
        $rec_func->fecha_recibo = Carbon::now();
        $rec_func->mes_pago = $request->mes_pago;

        $rec_func->save();
        return Redirect::to("recibo_funcionario")->with('msj2', 'RECIBO REGISTRADO');
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
        $recibos=DB::table('recibo_funcionarios as r')
        ->join('funcionarios as f','r.funcionario_id','=','f.id')
        ->select('f.id as funcionario_id','f.nombre','f.num_documento','f.nro_patronal','r.id as id_recibo','f.salario_basico',
        'f.ips','r.otros_desc','r.comisiones','r.horas_extra','r.otros_ingre','r.total_desc','r.salario_cobrar',
        'r.fecha_recibo','mes_pago')
        ->where('r.id','=',$id)
        ->first();

        $funcionarios=DB::table('funcionarios as f')
        ->select('f.id as funcionario_id','f.nombre','f.num_documento')
        ->get();
        //dd($recibos);
        return view('recibo_funcionario.show',["recibos"=>$recibos,"funcionarios"=>$funcionarios]);
    }

    public function recibo_func($id)
    {
        //dd($id);
        $recibos=DB::table('recibo_funcionarios as r')
        ->join('funcionarios as f','r.funcionario_id','=','f.id')
        ->select('f.id as funcionario_id','f.nombre','f.num_documento','f.nro_patronal','r.id as id_recibo','f.salario_basico',
        'f.ips','r.otros_desc','r.comisiones','r.horas_extra','r.otros_ingre','r.total_desc','r.salario_cobrar',
        'r.fecha_recibo','mes_pago','r.nro_recibo')
        ->where('r.id','=',$id)
        ->first();

        $fechames = Carbon::parse($recibos->mes_pago);
        $mesLetra = ($fechames->monthName);
        //return view('recibo_funcionario.show',["recibos"=>$recibos]);
        return $pdf= \PDF::loadView('recibo_funcionario.reciboPrueba',["recibos"=>$recibos,"mesLetra"=>$mesLetra])
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
        $mes = date('m',strtotime($request->mes_pago));
        $age = date('Y',strtotime($request->mes_pago));
        //dd($mes);

        $adelantos=DB::table('adelantos as a')
        ->select('a.funcionario_id','a.adelanto','a.mes_pago')
        ->where('a.funcionario_id','=',$request->funcionario_id)
        ->where('a.mes','=',$mes)
        ->where('a.age','=',$age)
        ->get();
        //dd($adelantos);
        $total_adelanto = 0;
        for($i = 0 ; $i < sizeof($adelantos); $i++){
            $total_adelanto = $total_adelanto + $adelantos[$i]->adelanto;
        }

        $rec_func= Recibo_funcionario::findOrFail($request->id_recibo);
        $rec_func->funcionario_id = $request->funcionario_id;

        $funcionarios=DB::table('funcionarios as f')
        ->select('f.salario_basico','f.ips')
        ->where('f.id','=',$request->funcionario_id)
        ->first();
        $rec_func->salario_basico = $funcionarios->salario_basico;
        $rec_func->ips = $funcionarios->ips;
        //$rec_func->salario_basico = str_replace(".","",$request->salario_basico);
        if($request->horas_extra == null)
            $rec_func->horas_extra = 0;
        else
            $rec_func->horas_extra = str_replace(".","",$request->horas_extra);

        if($request->otros_ingre == null)
            $rec_func->otros_ingre = 0;
        else
            $rec_func->otros_ingre = str_replace(".","",$request->otros_ingre);

        if($request->otros_desc == null)
            $rec_func->otros_desc = $total_adelanto;
        else
            $rec_func->otros_desc = str_replace(".","",$request->otros_desc) + $total_adelanto;

        if($request->comisiones == null) 
            $rec_func->comisiones = 0;
        else
        $rec_func->comisiones = str_replace(".","",$request->comisiones);
        $rec_func->total_desc = $rec_func->ips + $rec_func->otros_desc;
        $total_ingresos = $rec_func->salario_basico + $rec_func->horas_extra + $rec_func->otros_ingre + $rec_func->comisiones;

        $rec_func->salario_cobrar = $total_ingresos - $rec_func->total_desc;
        $rec_func->fecha_recibo = Carbon::now();
        $rec_func->mes_pago = $request->mes_pago;
        //dd($rec_func->salario_cobrar);
        $rec_func->save();
        return Redirect::to("recibo_funcionario")->with('msj2', 'RECIBO ACTUALIZADO');
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
        Recibo_funcionario::destroy($id);
        return Redirect::to("recibo_funcionario");
    }

    public function obtenerDatos(Request $request)
        {
            $datos = DB::select('select * from funcionarios where id = ?', [$request->funcionario_id]);
            return response()->json(['var'=>$datos]);
        }
}
