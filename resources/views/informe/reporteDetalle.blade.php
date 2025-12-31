@extends('layouts.master')

@section('title') Informe @endsection

@section('css')
        <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <meta name='csrf-token' content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') INICIO @endslot
        @slot('title') LABPROF GROUP @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->               
               
                <div class="card">
                    <div class="card-header">
                       <h2>Ventas Realizadas por rango de fecha</h2><br/>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <form id="detalle_pdf" action="{{route('reporteVentaPDF')}}" method="POST"target="_blank">
                                {{csrf_field()}}
                                <!-- FECHAS DE INICIO Y FIN  -->
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Inicio</label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fecha1" name="fecha1" class="form-control">
                                    </div>
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                    </div>
                                </div>
                                <!-- SUCURSALES -->
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Cliente</label>
                                    <div class="col-md-4">
                                        <div class="mb-3">

                                            <select class="form-control" name="cliente_id" id="cliente_id" style= "width:430px">

                                                <option value="0" disabled>Seleccionar Cliente</option>

                                            </select>

                                        </div>
                                    </div>

                                </div>
                                <div>
                                    <button type="submit" class="btn btn-danger float-left"><i class="fa fa-file fa-1x"></i> Generar PDF</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                       <h2>Ventas Cobradas por rango de fecha</h2><br/>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <form id="detalle_pdf" action="{{route('reporteDetallePDF')}}" method="POST"target="_blank">
                                {{csrf_field()}}
                                <!-- FECHAS DE INICIO Y FIN  -->
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Inicio</label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fecha1" name="fecha1" class="form-control">
                                    </div>
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                    </div>
                                </div>
                                <!-- SUCURSALES -->
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Cliente</label>
                                    <div class="col-md-4">
                                        <div class="mb-3">

                                            <select class="form-control" name="cliente_id" id="cliente_id" style= "width:330px">

                                                <option value="0" disabled>Seleccionar Cliente</option>

                                            </select>

                                        </div>
                                    </div>

                                </div>
                                <div>
                                    <button type="submit" class="btn btn-danger float-left"><i class="fa fa-file fa-1x"></i> Generar PDF</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                       <h2>Ventas Pendientes de Cobro por rango de fecha</h2><br/>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <form id="detalle_pdf" action="{{route('reporteVentaPendientePDF')}}" method="POST"target="_blank">
                                {{csrf_field()}}
                                <!-- FECHAS DE INICIO Y FIN  -->
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Inicio</label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fecha1" name="fecha1" class="form-control">
                                    </div>
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                    </div>
                                </div>
                                <!-- SUCURSALES -->
                                <div>
                                    <button type="submit" class="btn btn-danger float-left"><i class="fa fa-file fa-1x"></i> Generar PDF</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                       <h2>Compras por rango de fecha</h2><br/>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <form id="detalle_compra_pdf" action="{{route('reporteCompraPDF')}}" method="POST"target="_blank">
                                {{csrf_field()}}
                                <!-- FECHAS DE INICIO Y FIN  -->
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Inicio</label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fecha1" name="fecha1" class="form-control">
                                    </div>
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                    </div>
                                </div>
                                <!-- SUCURSALES -->
                                <div>
                                    <button type="submit" class="btn btn-danger float-left"><i class="fa fa-file fa-1x"></i> Generar PDF</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                       <h2>Compras Cobradas por rango de fecha</h2><br/>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <form id="detalle_compra_pdf" action="{{route('reporteCompraCobradaPDF')}}" method="POST"target="_blank">
                                {{csrf_field()}}
                                <!-- FECHAS DE INICIO Y FIN  -->
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Inicio</label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fecha1" name="fecha1" class="form-control">
                                    </div>
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                    </div>
                                </div>
                                <!-- SUCURSALES -->
                                <div>
                                    <button type="submit" class="btn btn-danger float-left"><i class="fa fa-file fa-1x"></i> Generar PDF</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                       <h2>Compras Pendientes de Pago por rango de fecha</h2><br/>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <form id="detalle_compra_pdf" action="{{route('reporteCompraPendientePDF')}}" method="POST"target="_blank">
                                {{csrf_field()}}
                                <!-- FECHAS DE INICIO Y FIN  -->
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Inicio</label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fecha1" name="fecha1" class="form-control">
                                    </div>
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                    </div>
                                </div>
                                <!-- SUCURSALES -->
                                <div>
                                    <button type="submit" class="btn btn-danger float-left"><i class="fa fa-file fa-1x"></i> Generar PDF</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="card">
                    <div class="card-header">
                       <h2>Productos mas vendidos (CANTIDAD) por rango de fecha</h2><br/>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <form id="detalle_producto_pdf" action="{{route('reporteProductoPDF')}}" method="POST"target="_blank">
                                {{csrf_field()}}
                                <!-- FECHAS DE INICIO Y FIN  -->
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Inicio</label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fecha1" name="fecha1" class="form-control">
                                    </div>
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                    </div>
                                </div>
                                <!-- SUCURSALES -->
                                <div>
                                    <button type="submit" class="btn btn-danger float-left"><i class="fa fa-file fa-1x"></i> Generar PDF</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                       <h2>Productos mas vendidos (MONTO EN GS) por rango de fecha</h2><br/>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <form id="detalle_producto_pdf" action="{{route('reporteProductoGSPDF')}}" method="POST"target="_blank">
                                {{csrf_field()}}
                                <!-- FECHAS DE INICIO Y FIN  -->
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Inicio</label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fecha1" name="fecha1" class="form-control">
                                    </div>
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                    </div>
                                </div>
                                <!-- SUCURSALES -->
                                <div>
                                    <button type="submit" class="btn btn-danger float-left"><i class="fa fa-file fa-1x"></i> Generar PDF</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                       <h2>Deuda a crédito o contado por rango de fecha</h2><br/>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <form id="detalle_producto_pdf" action="{{route('reporteCreditoPDF')}}" method="POST"target="_blank">
                                {{csrf_field()}}
                                <!-- FECHAS DE INICIO Y FIN  -->
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Inicio</label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fecha1" name="fecha1" class="form-control">
                                    </div>
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                    </div>
                                </div>
                                <!-- SUCURSALES -->
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <label class="col-md-5 form-control-label" for="documento">Tipo de Factura</label>
                                        <select class="form-control" name="tipo_fac" id="tipo_fac">                                                    
                                            <option value="7" disabled>Seleccione</option>
                                            <option value="0">CONTADO</option>
                                            <option value="1">CREDITO</option>
                                            <option value="2">TODAS LAS FACTURAS</option>
                                        </select>
                                    </div>
                                </div>
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
        $('#cliente_id').select2({
            placeholder: "Selecccione Cliente",
            allowClear: true,
            ajax:{
                url:"{{ route('getClienteInforme') }}",
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


<script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#producto_id').select2({
                ajax:{
                    url:"{{route('getProInforme') }}",
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
