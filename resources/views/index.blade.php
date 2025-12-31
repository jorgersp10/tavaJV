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
            </div>
            <div class="card-body">
                <div class="form-group row">
                    @if(auth()->user()->idrol == 1) 
                    <div class="col-md-4" style="text-align:right;">
                        <h4>Total Facturado: Gs. {{number_format(($total_venta), 0, ",", ".")}}</h4>
                        <h4>Total Compras: Gs. {{number_format(($total_compra_gasto), 0, ",", ".")}}</h4>
                        @if($saldoFactura > 0)
                            <h4 class="alert alert-success">Saldo: Gs. {{number_format(($saldoFactura), 0, ",", ".")}}</h4>
                        @else
                        <h4 class="alert alert-danger">Saldo: Gs. {{number_format(($saldoFactura), 0, ",", ".")}}</h4>
                        @endif
                        <input type="hidden" id="saldoFact" name="saldoFact" class="form-control" value="{{$saldoFactura}}">  

                    </div>
                    <div class="col-md-4" style="text-align:right;">
                        <h4>Total sin Fact: Gs. {{number_format(($total_venta_siniva), 0, ",", ".")}}</h4>
                        <h4>Total Compras sin Fac.: Gs. {{number_format(($total_compra_gasto_siniva), 0, ",", ".")}}</h4>
                        <h4 class="alert alert-success">Total Vendido: Gs. {{number_format(($total_venta_siniva + $total_venta), 0, ",", ".")}}</h4>
                    </div>
                    @endif
                </div>
            </div>
                <div class="card-body">
                    <h4>Facturas por cobrar por caja</h4><br/>
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="" class="display table table-bordered dt-responsive  nowrap w-100">                                                                                         
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
                <div class="card-body">
                    <h4>Totales de Compras y Ventas del Mes</h4><br/>
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="" class="display table table-bordered dt-responsive  nowrap w-100">                                                                                         
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
        </div>
    </main>

@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('table.display').DataTable();
         order: [[0, 'desc']]
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
