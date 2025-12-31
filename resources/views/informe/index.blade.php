@extends('layouts.master')

@section('title') Resumen @endsection

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

                       <h2>Resumen de Clientes - Saldos y Atrasos</h2><br/>    
                                        
                    </div>
                       <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            
                                <div class="input-group">
                                <div class="d-print-none">
                                <div class="float-end">
                                    <a href="{{URL::action('App\Http\Controllers\PdfController@index')}}" target="_blank">
                                        <button type="button" class="btn btn-success btn-sm" >
                                            <i class="fa fa-print fa-2x"></i> PDF Reporte
                                        </button>
                                    </a>
                                </div>
                    </div>
                                    
                                </div>
                            
                            </div>
                        </div><br>
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-hover table-bordered">                               
                                    <thead>                            
                                        <tr>                                  
                                            <th  data-priority="1">Cliente</th>
                                            <th  data-priority="1">N° Factura</th>
                                            <th  data-priority="1">Precio</th>
                                            <th  data-priority="1">Pagado</th>
                                            <th  data-priority="1">Saldo</th>
                                            <!--<th  data-priority="1">Saldo Vencido</th> -->
                                            <!--<th  data-priority="1">Cuotas atrasadas</th>-->
                                            <th  data-priority="1">Estado Cuenta</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($cuotas as $c)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>                                    
                                                <td>{{$c->cliente}}</td>
                                                <td>{{$c->fact_nro}}</td>
                                                <td>Gs. {{number_format(($c->deuda), 0, ",", ".")}}</td>
                                                <td>Gs. {{number_format(($c->pagos), 0, ",", ".")}}</td>
                                                <td>Gs. {{number_format(($c->deuda - $c->pagos), 0, ",", ".")}}</td>
                                                <td>                                     
                                                    <a href="{{URL::action('App\Http\Controllers\ClienteController@show', $c->cliente_id)}}">
                                                        <button type="button" class="btn btn-success btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> Detalles
                                                        </button>
                                                    </a>
                                                </td> 
                                                                        
                                            </tr>
                                        @endforeach                                        
                                    </tbody>
                                </table>
                            </div> 
                        </div> 
                        
                    </div>
                    {{$cuotas->links()}}
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar-->
            <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">Nuevo Cliente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('cliente.store')}}" method="post" class="form-horizontal">
                            
                                    {{csrf_field()}}
                                    
                                    @include('cliente.form')

                                </form>                                    
                            </div>
                            
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


             <!--Inicio del modal actualizar-->

             <div class="modal fade" id="abrirmodalEditar" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">Actualizar cliente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('cliente.update','test')}}" method="post" class="form-horizontal">
                                    
                                    {{method_field('patch')}}
                                    {{csrf_field()}}

                                    <input type="hidden" id="id_cliente" name="id_cliente" value="">
                                    
                                    @include('cliente.form')

                                </form>                                  
                            </div>
                            
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

             

           
            
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