@extends('layouts.master')

@section('title') Caja @endsection

@section('css') 
        <!-- DataTables -->        
       <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <meta name='csrf-token' content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') INICIO @endslot
        @slot('title') IMPRESION DE COMPROBANTES @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">


                    <div class="card-body">
                        <div class="form-group row">
                  
                        <form id="fecha_comp" action="{{route('comprobante')}}" method="POST"> 
                                {{csrf_field()}}      
                                <h4>Rango de fecha</h4><br/>                      
                                <label class="col-md-3 form-control-label" for="loteamiento">Seleccione Fechas</label>
                                    <div class="row mb-4">
                                        <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Inicio</label>
                                        <div class="col-sm-3">
                                            <input type="date" id="fecha1" name="fecha1" class="form-control">
                                        </div>
                                        <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                        <div class="col-sm-3">
                                            <input type="date" id="fecha2" name="fecha2" class="form-control">
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="submit" class="btn btn-primary float-left"><i class="fa fa-file fa-1x"></i> Filtrar</button>
                                        </div>
                                    </div>
                                     <div class="row mb-6">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Cliente</label>

                                            <select id='idcliente' name='idcliente' style= "width:400px">
                                                <option value="0">--Seleccionar Cliente </option>    
                                            </select>
                                    </div>
                                    <br> <br>
                                    
                                </form>
                         
                            <div>
                                <table  class="table table-editable table-nowrap align-middle table-edits">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Nro Comprobante</th>
                                            <th>Cliente</th>
                                            <th>Importe</th>
                                            <th>Tipo Comprobante</th>

                                            <th>Factura</th>
                                        </tr>
                                    </thead>
                                    <tbody id="comrobantes">
                                        @foreach($compro as $c)
                                        <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                        Asi cada usuario solo puede ver datos de su empresa -->
                                    
                                        <tr>                                    
                                            <td>{{ date('d-m-Y', strtotime($c->fecha)) }}</td>
                                            <td>{{$c->nro_com}}</td>
                                            <td>{{$c->doc_cli}}</td>
                                            <td>{{number_format(($c->total), 0, ",", ".")}}</td>
                                            <td>{{$c->tipo_com}}</td>
                                            <td>
                            
                                                <a href="{{url('/comprobante_imp',array($c->id,$c->tipo_com))}}" target="_blank">
                                                    <button type="button" class="btn btn-success btn-sm" >
                                                        <i class="fa fa-print fa-1x"></i> Imprimir
                                                    </button>
                                                </a>
                                
                                            </td>                                                                         
                                                                          
                                        </tr>  
                                     
                                    @endforeach
                    
                                    </tbody>
                                    
                                </table>

                            </div>
                        </div><br>
                            

                        
                    </div>
                </div>
        </div><br>   

                 
    </main>

@endsection
@section('script')
     <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#idcliente').select2({
                ajax:{
                    url:"{{route('getClientecaja') }}",
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
    <script>
       /*
        $(function(){
            $('#seleccionar-todos').change(function() {
            $('#listado > input[type=checkbox]').prop('checked', $(this).is(':checked'));
            });
        });
   */
    </script>
        
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
    <!-- Init js-->
        <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/moment.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/caja/caja.js') }}" defer></script>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection