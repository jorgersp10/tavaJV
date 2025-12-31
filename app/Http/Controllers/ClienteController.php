<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Inmueble;
use App\Models\Loteamiento;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use DateTime;
use App\NumerosEnLetras;

class ClienteController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if($request){
            //Buscador de texto en el view y tambien la consula para mostrar datos en el index
            $sql=trim($request->get('buscarTexto'));
            $sql = str_replace(" ", "%", $sql);
            $clientes=DB::table('clientes')
            ->select('clientes.fecha_nacimiento','clientes.edad','clientes.id',
            'clientes.nombre','clientes.nombres12','clientes.apellido','clientes.tipo_documento','clientes.num_documento',
            'clientes.direccion','clientes.telefono','clientes.whatsapp','clientes.email',
            'clientes.estado_civil','clientes.digito',
            'clientes.sexo','clientes.user')
            ->where('clientes.nombre','LIKE','%'.$sql.'%')
            ->orwhere('clientes.num_documento','LIKE','%'.$sql.'%')
            ->orderBy('clientes.id','desc')
            ->paginate(10);

            /*listar los roles en ventana modal*/
    

            return view('cliente.index',["clientes"=>$clientes,"buscarTexto"=>$sql]);
            //return $clientes;
        }
        
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //VERIFICAR SU CEDULA YA ESTA REGISTRADA

        if($request->num_documento != null){
            $yaexistedocumento = DB::select('select nombre,num_documento,telefono from clientes where num_documento = ?',[$request->num_documento]);
            if($yaexistedocumento != NULL)
                $yaexistedocu = $yaexistedocumento[0]->nombre.' - '.$yaexistedocumento[0]->num_documento;
            else $yaexistedocu = '0';
        }//else $yaexistedocu = '0';//No cargo cedula

        if($yaexistedocu != '0'){
            //$mensaje = $yaexistedocu;
            return back()->with('msj', 'Cliente: '.$yaexistedocu.' ya existe');
        //}
                
        }
        else 
        {
            $cliente= new Cliente();
            $cliente->nombre = strtoupper($request->nombre.' '.$request->apellido);
            $cliente->nombres12 = strtoupper($request->nombre);
            $cliente->apellido = strtoupper($request->apellido);
            $cliente->tipo_documento = $request->tipo_documento;
            $cliente->num_documento = $request->num_documento;
            $cliente->digito = $request->digito;
            $cliente->telefono = $request->telefono;
            $cliente->whatsapp = $request->whatsapp;
            $cliente->email = $request->email;
            $cliente->direccion = strtoupper($request->direccion);
            
            //$cliente->idempresa = $request->id_empresa; 
            $cliente->estado_civil = $request->estado_civil;
            $cliente->sexo = $request->sexo;
            $cliente->fecha_nacimiento = $request->fecha_nacimiento;
            //$edad = \Carbon\Carbon::parse($request->fecha_nacimiento)->age;
            //$cliente->edad = $request->edad;
            $cliente->user = auth()->user()->email;
    
            $cliente->save();
            if($request->lugar == 2)
                return Redirect::to("cliente")->with('msj2', 'CLIENTE REGISTRADO');
            else
                return Redirect::to("factura/create")->with('msj2', 'CLIENTE REGISTRADO');
        }

        
       
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
        //
        $cliente= Cliente::findOrFail($request->id_cliente); 
        $cliente->nombre = strtoupper($request->nombre.' '.$request->apellido);
        $cliente->nombres12 = strtoupper($request->nombre);
        $cliente->apellido = strtoupper($request->apellido);
        $cliente->tipo_documento = $request->tipo_documento;
        $cliente->num_documento = $request->num_documento;
        $cliente->digito = $request->digito;
        $cliente->telefono = $request->telefono;
        $cliente->whatsapp = $request->whatsapp;
        $cliente->email = $request->email;
        $cliente->direccion = strtoupper($request->direccion);
        
        //$cliente->idempresa = $request->id_empresa; 
        $cliente->estado_civil = $request->estado_civil;
        $cliente->sexo = $request->sexo;
        $cliente->fecha_nacimiento = $request->fecha_nacimiento;
        //$edad = \Carbon\Carbon::parse($request->fecha_nacimiento)->age;
        //$cliente->edad = $request->edad;
        $cliente->user = auth()->user()->email;

        $cliente->save();
        return Redirect::to("cliente")->with('msj2', 'CLIENTE ACTUALIZADO');
                
        
    }

    public function show($id){

        $existe = DB::select('select cliente_id from cuotas where cliente_id = ? ',[$id]);
        if($existe == NULL){
            //Calculamos la edad del cliente
            $fechanacimiento = DB::select('select fecha_nacimiento from clientes where id = ?',[$id]);
            $fechanacimiento = $fechanacimiento[0]->fecha_nacimiento;
            $edadcliente = \Carbon\Carbon::parse($fechanacimiento)->age;

            //Traemos los datos del cliente
            $client=DB::table('clientes')
            ->select('edad','estado_civil','sexo','direccion','telefono','whatsapp','nombre as cliente',
            'num_documento as documento','digito','user')
            ->where('id','=',$id)->first();

            $cuotasdet="vacio";
            //dd($cuotasdet);
            //dd($client);
            return view('cliente.show',["client"=>$client, "edadcliente"=>$edadcliente,
         "cuotasdet"=>$cuotasdet]);
        }
        else{
            //Calculamos la edad del cliente
            $fechanacimiento = DB::select('select fecha_nacimiento from clientes where id = ?',[$id]);
            $fechanacimiento = $fechanacimiento[0]->fecha_nacimiento;
            $edadcliente = \Carbon\Carbon::parse($fechanacimiento)->age;

            //Traemos los datos del cliente
            $client=DB::table('clientes as cli')
            ->select('cli.estado_civil','cli.sexo','cli.direccion','cli.telefono',
            'cli.nombre as cliente','cli.num_documento as documento','digito')
            ->where('cli.id','=',$id)
            ->first();

            $cuotasdet=DB::table('cuotas_det as cdet')
            ->join('cuotas as c','cdet.cuota_id','=','c.id')
            ->join('ventas as v','c.factura_id','=','v.id')
            ->join('clientes as cli','c.cliente_id','=','cli.id')
            ->select('cdet.cuota_id as cuota_id','v.fact_nro','cli.nombre as cliente', 
            DB::raw('sum(cdet.capital)  as deuda'))
            ->where('cli.id','=',$id)
            ->groupby('cli.id','v.fact_nro','cli.nombre','cdet.cuota_id')
            ->get();
            //dd($cuotasdet);

            $pagos=DB::table('pagos as p')
            ->join('cuotas as c','p.cuota_id','=','c.id')
            ->join('ventas as v','c.factura_id','=','v.id')
            ->select('p.cuota_id','v.fact_nro',
            DB::raw('sum(p.capital) as pagos'),
            DB::raw('0 as diasMora'))
            ->where('c.cliente_id','=',$id)
            ->groupby('p.cuota_id','v.fact_nro')
            ->get();
            //dd($pagos);
            
            //SALDO PENDIENTE Y DIAS DE ATRASO

            if($pagos->isEmpty())
            {
                $hayPagos="NO";
            }               
            else{
                $hayPagos="SI";
            }

            $fec_cuota=DB::table('cuotas_det as cdet')
            ->join('cuotas as c','cdet.cuota_id','=','c.id')
            //->join('inmuebles as i','c.inmueble_id','=','i.id')
            ->join('clientes as cli','c.cliente_id','=','cli.id')
            ->select('cdet.cuota_id',
            DB::raw('min(cdet.fec_vto) as fec_vto'))
            ->where('cdet.estado_cuota','=',"P")
            ->where('cli.id','=',$id)
            ->groupby('cdet.cuota_id')
            ->get();
            
            if($fec_cuota->isEmpty()){
                //dd("entro");
                $diasMora="-1";
                //dd($diasMora);
                return view('cliente.show',["client"=>$client, "edadcliente"=>$edadcliente,
                "cuotasdet"=>$cuotasdet,"pagos"=>$pagos,"diasMora"=>$diasMora,"hayPagos"=>$hayPagos]);
                
            }
            else{
                $fecha_hoy= Carbon::now('America/Asuncion');
                //HALLAR LOS DIAS DE ATRASO

                $cantidad_pagos=sizeof($pagos);
                $cantidad_pagos--;
               
                for($i = 0 ; $i < sizeof($fec_cuota); $i++)
                {

                    $diasMora[$i] = date_diff(new Carbon($fec_cuota[$i]->fec_vto), $fecha_hoy)->format('%R%a');
                    if ($i<=$cantidad_pagos)
                    {
                        $pagos[$i]->diasMora=$diasMora[$i];
                    }
                      
                }
                //dd($diasMora);
                
                
                return view('cliente.show',["client"=>$client, "edadcliente"=>$edadcliente,
                "cuotasdet"=>$cuotasdet,"pagos"=>$pagos,"diasMora"=>$diasMora,"hayPagos"=>$hayPagos]);
            }
            

            // $fec_pago=DB::table('pagos as p')
            // ->join('cuotas as c','p.cuota_id','=','c.id')
            // ->join('inmuebles as i','p.inmueble_id','=','i.id')
            // ->select('p.cuota_id',
            // DB::raw('max(p.fec_pag) as fec_pag'))
            // ->where('c.cliente_id','=',$id)
            // ->groupby('p.cuota_id')
            // ->get();
            
            
        }
       
        //dd($client,$edadcliente);

    }
    
     public function detalleCuotasMora(Request $request){

          //DETALLES DEL O LOS INMUEBLES
          //dd($request);
          //$inm= Inmueble::findOrFail($request->id_inmueble);
          $param_mora= Loteamiento::findOrFail(1);
          //dd($param_mora);
          $clienteNombre=DB::table('cuotas as c')
          ->join('clientes as cli','c.cliente_id','=','cli.id')
          ->select('cli.nombre', 'cli.num_documento','cli.digito')
          ->where('c.id','=',$request->cuota_id)
          ->get();
          //dd($clienteNombre);
          $cantCuotas=DB::table('cuotas_det')
          ->select('cuota_nro')
          ->where('cuota_id','=',$request->cuota_id)
          ->count('cuota_nro');
        //dd($cantCuotas);
          $cuotaCero=DB::table('cuotas_det')
          ->select('cuota_nro')
          ->where('cuota_id','=',$request->cuota_id)
          ->get();
          //dd($cuotaCero);
          if($cuotaCero[0]->cuota_nro == 0)
              $cantCuotas=$cantCuotas-1;
              else
              $cantCuotas=$cantCuotas;
              //dd($cantCuotas);
        $fh=  new Carbon($request->diaCalculo);   
          
          $cuotas=DB::table('cuotas as c')
          ->join('cuotas_det as cdet','cdet.cuota_id','=','c.id')
          //->join('inmuebles as i','c.inmueble_id','=','i.id')
          ->join('clientes as cli','c.cliente_id','=','cli.id')
          ->select('cdet.cuota_nro as cuota_nro','cdet.capital as capital','cdet.interes as interes',
          'cdet.fec_vto as fec_vto','cdet.fec_pag as fec_pag','cli.num_documento','cli.digito',
          'c.producto as producto','cli.nombre as cliente','cdet.estado_cuota as estado_cuota',
          DB::raw('0 as mora'),
          DB::raw('0 as punitorio'),
          DB::raw('0 as iva'),
          DB::raw('0 as total_c'),
          DB::raw('0 as capital_pagado'),
          DB::raw('0 as interes_pagado'),
          DB::raw('0 as moratorio_pagado'),
          DB::raw('0 as punitorio_pagado'),
          DB::raw('0 as iva_pagado') )
          ->where('cuota_id','=',$request->cuota_id)
          ->where('estado_cuota','=','P')
          ->where('cdet.fec_vto','<=',$fh)
          ->get();
        //dd($cuotas);
          if (sizeof($cuotas)>0){
            $bandera=1;
            $pagos=DB::table('pagos as p')
            ->select('p.cuota_id','p.cuota','p.fec_pag','p.cuota as cuota_nro',
            DB::raw('sum(total_pag) as totalpagado'),
            DB::raw('sum(capital) as capital_pagado'),
            DB::raw('sum(interes) as interes_pagado'),
            DB::raw('sum(moratorio) as moratorio_pagado'),
            DB::raw('sum(punitorio) as punitorio_pagado'))
            //->where('p.inmueble_id','=',$request->id_inmueble)
            ->where('p.cuota_id','=',$request->cuota_id)
            ->groupby('p.cuota_id','p.cuota','p.fec_pag','p.cuota')
            ->get();
            //sdd($pagos);
        

        for($i = 0 ; $i < sizeof($cuotas); $i++)
        {
            //$fecha_hoy= Carbon::now('America/Asuncion');
            $fecha_hoy=  new Carbon($request->diaCalculo);   
            $fecha_vto= new Carbon($cuotas[$i]->fec_vto);    
            $fecha_pag= new Carbon($cuotas[$i]->fec_pag); 
            if  ($fecha_pag>$fecha_vto) {
                $fecha_vto=$fecha_pag;
            }
           
            $ivamora=0;               
            $ivapunitorio=0;        
            $cap_calc=$cuotas[$i]->capital;
            $int_calc=$cuotas[$i]->interes;

            for($j = 0 ; $j < sizeof($pagos); $j++)
            {
                if($pagos[$j]->cuota==$cuotas[$i]->cuota_nro)
                {

                        $cuotas[$i]->capital=round(($cuotas[$i]->capital-$pagos[$j]->capital_pagado),0);
                        $cuotas[$i]->interes=round(($cuotas[$i]->interes-$pagos[$j]->interes_pagado),0);

                    $cap_calc=$cap_calc-$pagos[$j]->capital_pagado;
                    $int_calc=$int_calc-$pagos[$j]->interes_pagado;
                    //$cuotas[$i]->capital=$cuotas[$i]->capital-$pagos[$j]->capital_pagado;
                    //$cuotas[$i]->interes=$cuotas[$i]->interes-$pagos[$j]->interes_pagado;
                    if ($pagos[$j]->fec_pag>$cuotas[$i]->fec_pag){
                        $cuotas[$i]->moratorio_pagado=$cuotas[$i]->moratorio_pagado+$pagos[$j]->moratorio_pagado;
                        $cuotas[$i]->punitorio_pagado=$cuotas[$i]->punitorio_pagado+$pagos[$j]->punitorio_pagado;
                    }

                }

            }
                                
            $diasMora = date_diff($fecha_vto, $fecha_hoy)->format('%R%a');
            if ($diasMora>0)
            {
                
                    $cuotas[$i]->mora = round((($cap_calc*$param_mora->mora_gs*$diasMora)/36500),0);
                $ivamora=round((($cuotas[$i]->mora*10)/100),0);

                    $cuotas[$i]->punitorio = round((($cuotas[$i]->mora *$param_mora->pun_gs)/100),0);

                $cuotas[$i]->mora =$cuotas[$i]->mora +$ivamora;
        
                $ivapunitorio=round((($cuotas[$i]->punitorio *10)/100),0);
                $cuotas[$i]->punitorio =$cuotas[$i]->punitorio +$ivapunitorio;

                $cuotas[$i]->mora = $cuotas[$i]->mora -$cuotas[$i]->moratorio_pagado;
                $cuotas[$i]->punitorio = $cuotas[$i]->punitorio -$cuotas[$i]->punitorio_pagado;
                //$ivamora=round((($cuotas[$i]->mora*10)/100),0);
                //$ivapunitorio=round((($cuotas[$i]->punitorio *10)/100),0);
                $cuotas[$i]->iva =  $ivamora+$ivapunitorio;
            }
            $cuotas[$i]->total_c = $cuotas[$i]->capital+$cuotas[$i]->interes+$cuotas[$i]->mora+ $cuotas[$i]->punitorio;
        }
    

        return view('cliente.detalleCuotasMora',["bandera"=>$bandera,"cuotas"=>$cuotas, "pagos"=>$pagos, "cantCuotas"=>$cantCuotas]);
        }
        else{
            $bandera=0;
            $pagos=0;
            //dd($cantCuotas);
            return view('cliente.detalleCuotasMora',["bandera"=>$bandera, "pagos"=>$pagos, "clienteNombre"=>$clienteNombre]);

        }
    }

    public function detalleCuotas($id){
        
        //DETALLES DEL O LOS INMUEBLES
        $cantCuotas=DB::table('cuotas_det')
        ->select('cuota_nro')
        ->where('cuota_id','=',$id)
        ->count('cuota_nro');

        $cuotaCero=DB::table('cuotas_det')
        ->select('cuota_nro')
        ->where('cuota_id','=',$id)
        ->get();
        if($cuotaCero[0]->cuota_nro == 0)
            $cantCuotas=$cantCuotas-1;
            else
            $cantCuotas=$cantCuotas;
        
        $cuotas=DB::table('cuotas as c')
        ->join('cuotas_det as cdet','cdet.cuota_id','=','c.id')
        ->join('ventas as v','c.factura_id','=','v.id')
        //->join('loteamientos as l','i.loteamiento_id','=','l.id')
        ->join('clientes as cli','c.cliente_id','=','cli.id')
        ->select('cdet.cuota_nro as cuota_nro','cdet.capital as capital','cdet.fec_vto as fec_vto',
        'v.fact_nro','cli.nombre as cliente')
        ->where('cuota_id','=',$id)
        ->get();


        $pagos=DB::table('pagos as p')
        ->select('p.fec_pag as fechapago','p.cuota as cuota_nro','p.cuota_id as cuota_id',
        'p.total_pag as totalpagado','p.cuota as capitalcuota','p.capital as capital',
        DB::raw('0 as saldo'))
        ->where('p.cuota_id','=',$id)
        ->get();

        
        return view('cliente.detalleCuotas',["cuotas"=>$cuotas, "pagos"=>$pagos, "cantCuotas"=>$cantCuotas]);
    }
    //RESUMEN DE CLIENTES Y SALDOS
    public function resumenClientes(){
        
        //DETALLES DEL O LOS INMUEBLES
        $cantCuotas=DB::table('cuotas_det')
        ->select('cuota_nro')
        ->where('cuota_id','=',$id)
        ->count('cuota_nro');

        $cuotaCero=DB::table('cuotas_det')
        ->select('cuota_nro')
        ->where('cuota_id','=',$id)
        ->get();
        if($cuotaCero[0]->cuota_nro == 0)
            $cantCuotas=$cantCuotas-1;
            else
            $cantCuotas=$cantCuotas;
        
        $cuotas=DB::table('cuotas as c')
        ->join('cuotas_det as cdet','cdet.cuota_id','=','c.id')
        ->join('inmuebles as i','c.inmueble_id','=','i.id')
        ->join('loteamientos as l','i.loteamiento_id','=','l.id')
        ->join('clientes as cli','c.cliente_id','=','cli.id')
        ->select('cdet.cuota_nro as cuota_nro','cdet.capital as capital','cdet.fec_vto as fec_vto',
        'i.descripcion as descripcion','cli.nombre as cliente','l.descripcion as urba')
        ->where('cuota_id','=',$id)
        ->get();


        $pagos=DB::table('pagos as p')
        ->select('p.fec_pag as fechapago','p.cuota as cuota_nro','p.cuota_id as cuota_id',
        'p.total_pag as totalpagado','p.cuota as capitalcuota',
        DB::raw('0 as saldo'))
        ->where('p.cuota_id','=',$id)
        ->get();

        
        return view('cliente.detalleCuotas',["cuotas"=>$cuotas, "pagos"=>$pagos, "cantCuotas"=>$cantCuotas]);
    }

    public function pagare($id){
        
        //DETALLES DEL O LOS INMUEBLES
        $cantCuotas=DB::table('cuotas_det')
        ->select('cuota_nro')
        ->where('cuota_id','=',$id)
        ->count('cuota_nro');

        $cuotaCero=DB::table('cuotas_det')
        ->select('cuota_nro')
        ->where('cuota_id','=',$id)
        ->get();
        if($cuotaCero[0]->cuota_nro == 0)
            $cantCuotas=$cantCuotas-1;
            else
            $cantCuotas=$cantCuotas;
        
        $cuotas=DB::table('cuotas as c')
        ->join('cuotas_det as cdet','cdet.cuota_id','=','c.id')
        ->join('ventas as v','c.factura_id','=','v.id')
        //->join('loteamientos as l','i.loteamiento_id','=','l.id')
        ->join('clientes as cli','c.cliente_id','=','cli.id')
        ->select('cdet.cuota_nro as cuota_nro','cdet.capital as capital','cdet.fec_vto as fec_vto',
        'v.fact_nro','cli.nombre as cliente','c.factura','cli.nombre','cli.num_documento','cli.telefono')
        ->where('cuota_id','=',$id)
        ->get();
        //Total a pagar
        $total_pagar=0;
        for($i = 0 ; $i < sizeof($cuotas); $i++)
        {
            $total_pagar=$total_pagar+$cuotas[$i]->capital;
            if($i==0){
                $fecha_ini=$cuotas[$i]->fec_vto;
                //dd($fecha_ini);
            }
                $fecha_fin=$cuotas[$i]->fec_vto;
                $montoCuota=$cuotas[$i]->capital;
        }
        if($cuotas[0]->cuota_nro == 0){
            $fecha_ini=$cuotas[1]->fec_vto;
            $montoCuota=$cuotas[1]->capital;
        }
        //dd($montoCuota);
        //total en letras
        $tot_pag_let=NumerosEnLetras::convertir($total_pagar);
        //dia de pago de cada mes
        $diafecha = Carbon::parse($cuotas[0]->fec_vto)->format('d');

        
        return $pdf= \PDF::loadView('cliente.pagarePDF',["total_pagar"=>$total_pagar,
        "total_pag_let"=>$tot_pag_let,"cuotas"=>$cuotas,"diafecha"=>$diafecha,
        "cantCuotas"=>$cantCuotas,"fecha_ini"=>$fecha_ini,"fecha_fin"=>$fecha_fin,
        "montoCuota"=>$montoCuota])
        ->setPaper([0, 0, 612.2835, 907.087], 'portrait')
        ->stream('Pagare'.$id.'pdf');
    }
    
    public function destroy($id)
    {
        //dd($id);
        Cliente::destroy($id);
        return Redirect::to("cliente");
    }
}