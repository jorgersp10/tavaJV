@extends('layouts.master')

@section('title') Clientes @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') LABPROF GROUP @endslot
    @endcomponent
<main class="main">
 <!-- Breadcrumb -->
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <h2>Estado de Cuenta</h2><br/>                     
            </div>

            <div class="card-body">
                <h4 class="text-left">Datos del Cliente</h4><br/>
            
                <div class="form-group row">
                    <label class="col-md-2 form-control-label"><b>Nombre y Apellido:</b></label>
                    <div class="col-md-3">
                            <p>{{$client->cliente}}</p>     
                    </div>
                    <label class="col-md-2 form-control-label"><b>Documento N°:</b></label>
                    <div class="col-md-3">
                            <p>{{$client->documento}} - {{$client->digito}}</p>     
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 form-control-label"><b>Dirección:</b></label>
                    <div class="col-md-3">
                            <p>{{$client->direccion}}</p>     
                    </div>
                    <label class="col-md-2 form-control-label"><b>Teléfono:</b></label>
                    <div class="col-md-3">
                            <p>{{$client->telefono}}</p>     
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 form-control-label"><b>Estado Civil:</b></label>
                    <div class="col-md-2">
                            <p>{{$client->estado_civil}}</p>     
                    </div>
                    <label class="col-md-2 form-control-label"><b>Sexo:</b></label>
                    <div class="col-md-2">
                            <p>{{$client->sexo}}</p>     
                    </div>
                    <label class="col-md-1 form-control-label"><b>Edad:</b></label>
                    <div class="col-md-1">
                            <p>{{$edadcliente}}</p>     
                    </div>
                </div>

                @if($cuotasdet == "vacio")
                        <h4 class="text-left">No posee compras</h4><br/>
                @else
                        <h4 class="text-left">Datos de las compras</h4><br/>

                        @foreach($cuotasdet as $cd)
                        
                                <form id="form_mora" action="{{route('cliente.mora')}}" method="POST"> 

                                        {{csrf_field()}}
                                        
                                <div class="form-group row">
                                        <label class="col-md-2 form-control-label"><b>Factura Nro:</b></label>
                                        <div class="col-md-3">
                                                <p>{{$cd->fact_nro}}</p>     
                                        </div>

                                </div>

                                <div class="form-group row">
                                        <label class="col-md-2 form-control-label"><b>Precio Total:</b></label>
                                        <div class="col-md-3">
                                                <p>Gs. {{number_format(($cd->deuda), 0, ",", ".")}} </p> 
                                        </div>
                                        <!-- <label class="col-md-2 form-control-label"><b>Calculo Mora:</b></label>
                                        <div class="col-md-3">
                                                <input type="date" 
                                                value="{{ date('Y-m-d') }}" class="form-control"  name="diaCalculo" id="">
                                        </div>    -->
                                        <!-- <div class="col-md-2">
                                                <button type="submit" class="btn btn-success btn-sm" >
                                                        <i class="fa fa-success fa-1x"></i>Ver Mora
                                                </button>
                                        </div> -->
                                        <div hidden class="col-md-2">
                                                <a href="{{URL::action('App\Http\Controllers\ClienteController@pagare', $cd->cuota_id)}}" target="_blank">
                                                        <button type="button" class="btn btn-danger btn-sm" >
                                                                <i class="fa fa-success fa-1x"></i> Pagaré
                                                        </button>
                                                </a>                                         
                                        </div>   
                                
                                </div><br><br>
                                @php
                                        $saldofinal=0;
                                        $i=0; 
                                @endphp
                        
                        
                                @if($hayPagos=="SI")
                                        @foreach($pagos as $p)
                                                @if($cd->cuota_id==$p->cuota_id)
                                                <div class="form-group row">
                                                        <label class="col-md-2 form-control-label"><b>Saldo a pagar:</b></label>
                                                        <div class="col-md-3">
                                                        @php
                                                                $saldofinal=$cd->deuda - $p->pagos;
                                                                
                                                        @endphp
                                                                <p>Gs. {{number_format(($saldofinal), 0, ",", ".")}} </p>  
                                                        </div>   
                                                        <!-- <label class="col-md-1 form-control-label"><b>Días de atraso:</b></label>
                                                        <div class="col-md-2">
                                                                @if($p->diasMora<0)
                                                                        <p> 0 días </p>
                                                                @else    
                                                                        <p> {{$p->diasMora}} días </p> 
                                                                @endif                                    
                                                        </div>   -->
                                                        @php
                                                                $i=$i+1;
                                                        @endphp
                                                       
                                                        <input type="hidden" name="cuota_id" value={{$p->cuota_id}} >
                                                        <div class="col-md-2">
                                                                <a href="{{URL::action('App\Http\Controllers\ClienteController@detalleCuotas', $p->cuota_id)}}">
                                                                        <button type="button" class="btn btn-success btn-sm" >
                                                                                <i class="fa fa-success fa-1x"></i> Ver Detalles
                                                                        </button>
                                                                </a>                                         
                                                        </div>     
                                                                      
                                                </div>
                                                @endif
                                        @endforeach

                                        @php 
                                                $tienepagos="NO";
                                        @endphp
                                        @foreach($pagos as $p) 
                                                @if($cd->cuota_id==$p->cuota_id)   
                                                        @php  
                                                        $tienepagos="SI";
                                                        @endphp
                                                @endif                      
                                        @endforeach
                                        @if($tienepagos=="NO")
                                                 <div class="form-group row">
                                                        <label class="col-md-2 form-control-label"><b>Saldo a pagar:</b></label>
                                                        <div class="col-md-3">
                                                        @php
                                                                $saldofinal=$cd->deuda;
                                                                
                                                        @endphp
                                                                <p>Gs. {{number_format(($saldofinal), 0, ",", ".")}} </p>  
                                                        </div>   
                                                        <!-- <label class="col-md-1 form-control-label"><b>Días de atraso:</b></label>
                                                        <div class="col-md-2">
                                                                @if($p->diasMora<0)
                                                                        <p> 0 días </p>
                                                                @else    
                                                                        <p> {{$p->diasMora}} días </p> 
                                                                @endif                                    
                                                        </div>   -->
                                                        @php
                                                                $i=$i+1;
                                                        @endphp
                                                       
                                                        <input type="hidden" name="cuota_id" value={{$cd->cuota_id}} >
                                                        <div class="col-md-2">
                                                                <a href="{{URL::action('App\Http\Controllers\ClienteController@detalleCuotas', $cd->cuota_id)}}">
                                                                        <button type="button" class="btn btn-success btn-sm" >
                                                                                <i class="fa fa-success fa-1x"></i> Ver Detalles
                                                                        </button>
                                                                </a>                                         
                                                        </div>     
                                                                      
                                                </div>
                                                @endif
                                        <!-- APARTIR DE ACA COMENTAMOS
                                     
                                @else
                                        <div class="form-group row">
                                        <label class="col-md-2 form-control-label"><b>Saldo a pagar:</b></label>
                                        <div class="col-md-3">
                                        @php
                                                $saldofinal=$cd->deuda;
                                                
                                        @endphp
                                                <p>Gs. {{number_format(($saldofinal), 0, ",", ".")}} </p>  
                                        </div>   
                                        <label class="col-md-2 form-control-label"><b>Días de atraso:</b></label>
                                        <div class="col-md-2">
                                                @if($diasMora[$i]<0)
                                                        <p> 0 días </p>
                                                @else    
                                                        <p> {{$diasMora[$i]}} días </p> 
                                                @endif                                    
                                        </div>  
                                        @php
                                               $i=$i+1;
                                        @endphp
                                        
                                                <input type="hidden" name="cuota_id" value={{$cd->cuota_id}} >
                                                <div class="col-md-2">
                                                        <a href="{{URL::action('App\Http\Controllers\ClienteController@detalleCuotas', $cd->cuota_id)}}">
                                                                <button type="button" class="btn btn-success btn-sm" >
                                                                        <i class="fa fa-success fa-1x"></i> Ver Detalles
                                                                </button>
                                                        </a>                                         
                                                </div>                   
                                        </div>

                                @endif  -->
                                </form>
                                <p> *****************************************************************
                                ******************************************************************** </p> 
                        @endforeach 
                @endif 
                <div class="d-print-none">
                        <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i
                                        class="fa fa-print"></i></a>
                        </div>
                </div>
            </div> 
        </div>  
    </div>
    <!-- Fin ejemplo de tabla Listado -->    
</main>

@endsection