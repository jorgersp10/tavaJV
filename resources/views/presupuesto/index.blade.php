@extends('layouts.master')

@section('title') Presupuestos @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') A&M INOX - HIERROS @endslot
    @endcomponent
<main class="main">
            <!-- Breadcrumb -->
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Lista de Presupuestos</h2><br/>                     
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>    
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>    
                        @endif
                    <a href="presupuesto/create">
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#abrirmodal">Agregar Presupuesto</button></a>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'presupuesto','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div><br>
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                            
                                        <tr>    
                                            <th  data-priority="1">Borrar</th> 
                                            <th  data-priority="1">Editar</th> 
                                            <th  data-priority="1">Ver Detalle</th>
                                            <th  data-priority="1">Fecha</th>
                                            <th  data-priority="1">Fact. N°</th>
                                            <th  data-priority="1">Cliente</th>
                                            <th  data-priority="1">Total</th>
                                            <th  data-priority="1">Iva</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($ventas as $ven)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>            
                                                <td>                                    
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistro-{{$ven->id}}">
                                                        <i class="fa fa-times fa-1x"></i> Borrar
                                                    </button>                                    
                                                </td>       
                                                <td>
                                                    <a
                                                        href="{{URL::action('App\Http\Controllers\PresupuestoController@editar', $ven->id)}}">
                                                        <button type="button" class="btn btn-warning btn-sm">
                                                            <i class="fa fa-edit fa-1x"></i> Editar
                                                        </button>
                                                    </a>
                                                </td>
                                                <td>                                     
                                                    <a href="{{URL::action('App\Http\Controllers\PresupuestoController@show', $ven->id)}}">
                                                        <button type="button" class="btn btn-success btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> Detalles
                                                        </button>
                                                    </a>
                                                </td>
                                                <td>{{$ven->fecha}}</td>
                                                <td>{{$ven->fact_nro}}</td>
                                                <td>{{$ven->nombre}}</td>
                                                <td>Gs. {{number_format(($ven->total), 0, ",", ".")}}</td>
                                                <td>Gs. {{number_format(($ven->ivaTotal), 0, ",", ".")}}</td>
                                                
                                            </tr>  
                                            @include('presupuesto.delete')
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                            </div> 
                        </div> 
                        {{$ventas->render()}}
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
  
        </main>

@endsection
@section('script')

        
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script> 
        <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection