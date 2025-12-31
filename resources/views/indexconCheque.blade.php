@extends('layouts.master')

@section('title') @lang('translation.Dashboards') @endsection
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
        @slot('li_1') Sistema de Gestión de Cobros @endslot
        @slot('title') LABPROF GROUP @endslot
    @endcomponent
   
    <main class="main">
            <!-- Breadcrumb -->
           <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                       <h2>Bienvenido</h2><br/>
                    </div>
                    @if(auth()->user()->idrol == 1) 
                    <div class="card-header">
                       <h3>Cheques próximos a vencer y Facturas por cobrar por caja</h3><br/>
                    </div>
                    @endif
                </div>
            @if(auth()->user()->idrol == 1) 
                    <div class="card-body">
                         <h4>Cheques recibidos</h4><br/>
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                            
                                            <tr>                              
                                            <th  data-priority="1">N° Cheque</th>
                                            <th  data-priority="1">Librador</th> 
                                            <th  data-priority="1">Importe</th>
                                            <th  data-priority="1">Vencimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($cheques_recibidos as $c)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        @php 
                                            $date1 = $now;
                                            $date2 = $c->fec_venc;
                                            $diff = $date1->diffInDays($date2);                                            
                                        @endphp
                                        @if($diff<=2)
                                            <tr style ='color:red' >
                                                <td>{{$c->nro_cheque}}</td>
                                                <td>{{$c->librador}}</td> 
                                                <td>Gs. {{number_format(($c->importe_cheque), 0, ",", ".")}}</td>
                                                <td>{{ date('d-m-Y', strtotime($c->fec_venc)) }}</td>                                                
                                            </tr>
                                        @endif
                                    @endforeach
                                    
                                    </tbody>
                                </table>
                                
                            </div> 
                        </div> 
                        
                    </div>

                    <div class="card-body">
                         <h4>Cheques emitidos</h4><br/>
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                            
                                            <tr>                              
                                            <th  data-priority="1">N° Cheque</th>
                                            <th  data-priority="1">A la orden de:</th> 
                                            <th  data-priority="1">Importe</th>
                                            <th  data-priority="1">Vencimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($cheques_emitidos as $c)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        @php 
                                            $date1 = $now;
                                            $date2 = $c->fec_venc;
                                            $diff = $date1->diffInDays($date2);                                            
                                        @endphp
                                        @if($diff<=2)
                                            <tr style ='color:red' >
                                                <td>{{$c->nro_cheque}}</td>
                                                <td>{{$c->librador}}</td> 
                                                <td>Gs. {{number_format(($c->importe_cheque), 0, ",", ".")}}</td>
                                                <td>{{ date('d-m-Y', strtotime($c->fec_venc)) }}</td>                                                
                                            </tr>
                                        @endif
                                    @endforeach
                                    
                                    </tbody>
                                </table>
                                
                            </div> 
                        </div> 
                        
                    </div>
                    @endif
                     <div class="card-body">
                         <h4>Facturas por cobrar por caja</h4><br/>
                        <div class="table-rep-plugin">
                            <div id="encabezado" class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>                            
                                            <tr>                              
                                            <th  data-priority="1">N° Fact</th>
                                            <th  data-priority="1">Cliente</th> 
                                            <th  data-priority="1">Fecha</th> 
                                            <th  data-priority="1">Total Fact</th>
                                            <th  data-priority="1">Total Pagado</th>
                                            <th  data-priority="1">Saldo a Pagar</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($cuotas_pagar as $c)                                       
                                            <tr style ='color:red' >
                                                <td>{{$c->factura}}</td>
                                                <td>{{$c->nombre}}</td>
                                                <td>{{$c->fecha}}</td>
                                                <td>{{number_format(($c->total), 0, ",", ".")}}</td>
                                                <td>{{number_format(($c->pagado), 0, ",", ".")}}</td>
                                                <td>{{number_format(($c->saldo), 0, ",", ".")}}</td>
                                            </tr>
                                    @endforeach
                                    
                                    </tbody>
                                </table>
                                
                            </div> 
                        </div> 
                        
                    </div>
                </div>
        
        </div><br>   
        </main>

@endsection
@section('script')

<script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                language: {
                    decimal: ',',
                    thousands: '.',
                },
            });
        });
    </script>
        
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/producto/show.js') }}"></script>
    {{-- <script src="{{ URL::asset('/assets/js/inmueble/cuotas.js') }}"></script> --}}
    <script src="{{ URL::asset('/assets/js/moment.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
        <!-- Table Editable plugin -->
    <script src="{{ URL::asset('/assets/libs/table-edits/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/table-editable.int.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/producto/show_tab.js') }}" defer></script>
    <script src="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" defer></script>
        
@endsection
