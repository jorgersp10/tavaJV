@extends('layouts.master')

@section('title') Sucursales @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <meta name='csrf-token' content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') INICIO @endslot
        @slot('title') A&M INOX - HIERROS @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                       <h2>Reporte Cuotas a Vencer</h2><br/>              
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <form id="detalle_pdf" action="{{route('reporteCuotasVencerPDF')}}" method="POST"target="_blank"> 
                                {{csrf_field()}}    
                                <!-- FECHAS DE INICIO Y FIN  -->
                                <div class="row mb-3">
                                    <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Inicio</label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fecha1" name="fecha1" class="form-control">
                                    </div>
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                    </div>
                                </div>
                                <!-- SUCURSALES -->
                                {{-- <div class="row mb-3">
                                    <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Sucursal</label>
                                    <div class="col-sm-5">
                                        <!-- Aquí selecciona el usuario del cual quiere sacar el reporte -->
                                        <select style= "width:280px" class="form-control" name="sucursal" id="sucursal">
                                            <option readonly value="null">Seleccione</option>
                                            <option value="0">TODAS</option>                                  
                                            @foreach($sucursales as $s)                                    
                                                <option value="{{$s->id}}">{{$s->sucursal}}</option>                                        
                                            @endforeach
                                        </select>  
                                    </div>

                                </div>                               --}}
                                {{-- TIPO DE URBANIZACION 
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Producto</label>
                                        <!-- Aquí selecciona el usuario del cual quiere sacar el reporte -->
                                    <div class="col-sm-4">
                                        <select style= "width:280px" class="form-control" name="urba" id="urba">  
                                            <option readonly value="null">Seleccione</option>
                                            <option value="0">TODOS</option>                                  
                                            @foreach($loteamientos as $l)                                    
                                                <option value="{{$l->id}}">{{$l->descripcion}}</option>                                        
                                            @endforeach
                                        </select>                                
                                    </div>
                                    <!-- CLIENTE -->
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Cliente</label>
                                        <div class="col-sm-4">
                                            <!-- Aquí selecciona el usuario del cual quiere sacar el reporte -->
                                            <select id='_cliente' class="form-control" name='_cliente' style= "width:350px">
                                                <!-- <option readonly value="null">Seleccione</option>
                                                <option value="0">TODOS</option>     -->
                                            </select>                                
                                        </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Mueble</label>
                                        <!-- Aquí selecciona el usuario del cual quiere sacar el reporte -->
                                    <div class="col-sm-4">
                                        <select style= "width:280px" class="form-control" name="mueble" id="mueble">  
                                            <option readonly value="null">Seleccione</option>
                                            <option value="0">TODOS</option>                                  
                                            @foreach($muebles as $mue)                                    
                                                <option value="{{$mue->id}}">{{$mue->descripcion}}</option>                                        
                                            @endforeach
                                        </select>                                
                                    </div>
            
                                </div>    
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Acuerdos</label>
                                        <!-- Aquí selecciona el usuario del cual quiere sacar el reporte -->
                                    <div class="col-sm-4">
                                        <select style= "width:280px" class="form-control" name="acuerdo" id="acuerdo">  
                                            <option readonly value="null">Seleccione</option>
                                            <option value="0">TODOS</option>                                  
                                            @foreach($acuerdos as $acue)                                    
                                                <option value="{{$acue->id}}">{{$acue->descripcion}}</option>                                        
                                            @endforeach
                                        </select>                                
                                    </div>
                                </div>
                                <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Moneda</label>
                                    <div class="col-sm-3">
                                        <!-- Aquí selecciona el usuario del cual quiere sacar el reporte -->
                                        <select style= "width:280px" class="form-control" name="moneda" id="moneda">
                                            <option readonly value="null">Seleccione</option> 
                                            <option value="0">TODAS</option>  
                                            <option value="GS">Guaraníes</option>   
                                            <option value="US">Dólares</option>
                                        </select>                                
                                    </div>
                                </div> --}}
                                
                                <br> <br>
                                <div>
                                    <button type="submit" class="btn btn-danger float-left"><i class="fa fa-file fa-1x"></i> Generar PDF</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->         
        </div><br>                    
    </main>

@endsection
@section('script')

<script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#idcliente').select2({
                ajax:{
                    url:"{{route('getClienteInforme') }}",
                    type: 'post',
                    dataType: 'json',
                    delay: 200,
                    data: function(params){
                        return{
                            _token: CSRF_TOKEN,
                            search:params.term
                        }
                    },
                    processResults: function(response){
                        return{
                            results: response
                        }
                    },
                    cache: true
                }
            });
        });
    
    </script>
        
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script> 
        <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/informe/reporte_detalle.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection