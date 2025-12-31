@extends('layouts.master')

@section('title') Estado de Cuenta @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Clientes @endslot
        @slot('title') A&M INOX - HIERROS @endslot
    @endcomponent
<main class="main">
            <!-- Breadcrumb -->
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                       <h2>Detalle de pagos por Entrega y/o Cuota</h2><br/>                     
                    </div>
                    <div class="card-header">
                       <h5>Cliente: {{$cuotas[0]->cliente}} - Producto: {{$cuotas[0]->producto}}</h5><br/>                    
                    </div>
                    <div class="card-body">                       
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-hover">                               
                                    <thead>                            
                                        <tr>                                  
                                            <th  data-priority="1">Fecha Vencimiento</th>
                                            <th  data-priority="1">Fecha Pago</th>
                                            <th  data-priority="1">Operacion</th>
                                            <th  data-priority="1">Capital</th>
                                            <th  data-priority="1">Importe Pagado</th>
                                            <th  data-priority="1">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_cuotas=0;
                                            $total_pagos=0;
                                        @endphp
                                         @foreach($cuotas as $c)       
                                            @if((($c->fec_vto) <= now()->toDateString('Y-m-d')))                                                                        
                                                <tr class="table-danger"> 
                                                @else
                                                <tr class="table-primary"> 
                                            @endif
                                            @if($c->cuota_nro == 0)    
                                                <td>{{ date('d-m-Y', strtotime($c->fec_vto)) }}</td> 
                                                <td></td>     
                                                <td>Entrega</td>                                                 
                                                    <td>Gs. {{number_format(($c->capital), 0, ",", ".")}}</td>
                                                <td></td>
                                                <td></td> 
                                                @else                        
                                                <td>{{ date('d-m-Y', strtotime($c->fec_vto)) }}</td>   
                                                <td></td>  
                                                <td>{{$c->cuota_nro}} / {{$cantCuotas}}</td> 
                                                    <td>Gs. {{number_format(($c->capital), 0, ",", ".")}}</td>
                                                <td></td>
                                                <td></td>    
                                            @endif                                                                          
                                            </tr>
                                            @php
                                                $saldo=$c->capital;
                                                $total_cuotas=$total_cuotas+$c->capital;  
                                            @endphp
                                           
                                            @foreach($pagos as $p)
                                                @if($p->cuota_nro==$c->cuota_nro)
                                                    @php
                                                        $saldo=$saldo - $p->capital;
                                                        $total_pagos=$total_pagos+$p->capital;                                                        
                                                    @endphp
                                                    @if(($saldo > 0))                                                                        
                                                        <tr class="table-danger"> 
                                                        @else
                                                        <tr class="table-success"> 
                                                    @endif    
                                                    <td></td>                               
                                                    <td>{{ date('d-m-Y', strtotime($p->fechapago)) }}</td>
                                                    @if($c->cuota_nro == 0)     
                                                        <td></td>   
                                                        @else                       
                                                        <td></td>   
                                                    @endif
                                                    <td></td>
                                                        <td>Gs. {{number_format(($p->capital), 0, ",", ".")}}</td>
                                                        <td>Gs. {{number_format(($saldo), 0, ",", ".")}}</td>                                                                     
                                                </tr>  
                                                @endif
                                            @endforeach

                                        @endforeach
                                        <tr class="table-dark">   
  
                                                <td></td> 
                                                <td></td>     
                                                <td>Totales</td>                                                
                                                    <td>Gs. {{number_format(($total_cuotas), 0, ",", ".")}}</td> 
                                                    <td>Gs. {{number_format(($total_pagos), 0, ",", ".")}}</td>
                                                    <td>Gs. {{number_format(($total_cuotas-$total_pagos), 0, ",", ".")}}</td> 
                                                                                                 
                                            </tr>

                                    </tbody>
                                </table>
                            </div> 
                        </div> 
                    </div>
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