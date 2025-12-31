@extends('layouts.master')

@section('title') Pagos @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <style>
            .btn-toolbar {
                display: none !important;
            }
        </style>
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

                       <h2>Lista de Pagos</h2><br/>                     
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>    
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>    
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            
                            </div>
                        </div><br>
                        <div class="table-rep-plugin">
                            <div id="encabezado" class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap">                              
                                    <thead>                            
                                            <tr>      
                                            <th  data-priority="1">Borrar</th>
                                            <th  data-priority="1">Cliente</th>
                                            <th  data-priority="1">Fac Nro</th>
                                            <th  data-priority="1">Fecha</th>
                                            <th  data-priority="1">Total</th>
                                            <th  data-priority="1">Total Pag.</th>
                                            <th  data-priority="1">Saldo a Pagar</th>
                                            <th  data-priority="1">Efectivo</th>
                                            <th  data-priority="1">Transf</th>
                                            <th  data-priority="1">Cheque</th>
                                            <th  data-priority="1">T. Debito</th>
                                            <th  data-priority="1">T. Crédito</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($pagos as $p)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>        
                                                <td>                                    
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistro-{{$p->id}}">
                                                        <i class="fa fa-times fa-1x"></i> Borrar
                                                    </button>                                    
                                                </td>
                                                <td>{{$p->nombre}}</td>
                                                <td>{{$p->fact_nro}}</td>
                                                <td>{{ date('d-m-Y', strtotime($p->fec_pag)) }}</td>                                                
                                                <td>{{number_format($p->total, 0, ",", ".")}}</td>
                                                <td>{{number_format($p->total_pag, 0, ",", ".")}}</td>
                                                <td>{{number_format($p->saldo, 0, ",", ".")}}</td>
                                                <td>{{number_format($p->total_pagf, 0, ",", ".")}}</td>
                                                <td>{{number_format($p->total_pagtr, 0, ",", ".")}}</td>
                                                <td>{{number_format($p->total_pagch, 0, ",", ".")}}</td>
                                                <td>{{number_format($p->total_pagtd, 0, ",", ".")}}</td>
                                                <td>{{number_format($p->total_pagtc, 0, ",", ".")}}</td>
                                            </tr> 
                                            @include('pago.delete') 
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                            </div> 
                        </div> 
                    
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