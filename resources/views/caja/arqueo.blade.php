@extends('layouts.master')

@section('title') Caja @endsection

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
        @slot('li_1') INICIO @endslot
        @slot('title')  @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-body">
                         <h2>Facturas del Día por cobrar en caja</h2><br/>
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">                              
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
                                                <td>{{ date('d-m-Y', strtotime($c->fecha)) }}</td>
                                                <td>Gs. {{number_format(($c->total), 0, ",", ".")}}</td>
                                                <td>Gs. {{number_format(($c->pagado), 0, ",", ".")}}</td>
                                                <td>Gs. {{number_format(($c->saldo), 0, ",", ".")}}</td>
                                            </tr>
                                    @endforeach
                                    
                                    </tbody>
                                </table>
                                
                            </div> 
                        </div> 
                        
                    </div>
                    <div class="card-header">
                        <h2>Arqueo del dia: {{ date('d-m-Y', strtotime($fechaahora)) }} - Hasta 12:00 hs - Cajero: {{ $cajeroNombre }}</h2><br/>    
                        
                    </div>
                    <div class="card-body">
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                               
                                        <tr>
                                            <th data-priority="1">Fecha</th>
                                            <th data-priority="1">Cliente</th>
                                            <th data-priority="1">Pago / Factura Nro</th>
                                            <th data-priority="1">Importe</th>
                                            <th data-priority="1">Efectivo</th>
                                            <th data-priority="1">Transf</th>
                                            <th data-priority="1">Cheque</th>
                                            <th data-priority="1">T. Debito</th>
                                            <th data-priority="1">T. Crédito</th>
                                        </tr>    
                                    </thead>
                                    
                                    <tbody>
                                    @php
                                        $totaldia = 0;
                                        $totalefe = 0;
                                        $totaltran = 0;
                                        $totalche = 0;
                                        $totaltd = 0;
                                        $totaltc = 0;                   
                                    @endphp
                                    @if($arqueo=="Vacio")
                                        <tr><td><h3>NO HUBO COBROS</h3></td></tr>
                                        </tbody>
                                        @else
                                            @foreach($arqueo as $ar)
                                                <tr>                                    
                                                    <td>{{ date('d-m-Y', strtotime($ar->fechapago)) }}</td>
                                                    <td>{{$ar->cliente}}</td>
                                                    <td>Pago {{$ar->cuota}} / {{$ar->producto}}</td>
                                                    <td>{{number_format(($ar->importe), 0, ",", ".")}} </td>  
                                                    <td>{{number_format($ar->total_pagf, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagtr, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagch, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagtd, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagtc, 0, ",", ".")}}</td>                          
                                                </tr>  
                                                @php
                                                    $totaldia=$totaldia + $ar->importe;  
                                                    $totalefe=$totalefe + $ar->total_pagf; 
                                                    $totaltran=$totaltran + $ar->total_pagtr; 
                                                    $totalche=$totalche + $ar->total_pagch; 
                                                    $totaltd=$totaltd + $ar->total_pagtd; 
                                                    $totaltc=$totaltc + $ar->total_pagtc;                                                       
                                                @endphp
                                        @endforeach
                                        <tr class="table-dark">  
                                            <td></td> 
                                            <td></td>     
                                            <td>Total</td>                                                 
                                            <td>Gs. {{number_format(($totaldia), 0, ",", ".")}}</td>  
                                            <td>Gs. {{number_format(($totalefe), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltran), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totalche), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltd), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltc), 0, ",", ".")}}</td>                                               
                                        </tr>
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="card">
                    <div class="card-header">
                        <h2>Arqueo del dia: {{ date('d-m-Y', strtotime($fechaahora)) }} - Después 12:00 hs - Cajero: {{ $cajeroNombre }}</h2><br/>    
                        
                    </div>
                    <div class="card-body">
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                               
                                        <tr>
                                            <th data-priority="1">Fecha</th>
                                            <th data-priority="1">Cliente</th>
                                            <th data-priority="1">Pago / Factura Nro</th>
                                            <th data-priority="1">Importe</th>
                                            <th data-priority="1">Efectivo</th>
                                            <th data-priority="1">Transf</th>
                                            <th data-priority="1">Cheque</th>
                                            <th data-priority="1">T. Debito</th>
                                            <th data-priority="1">T. Crédito</th>
                                        </tr>    
                                    </thead>
                                    
                                    <tbody>
                                    @php
                                        $totaldiaTarde = 0;
                                        $totalefeTarde = 0;
                                        $totaltranTarde = 0;
                                        $totalcheTarde = 0;
                                        $totaltdTarde = 0;
                                        $totaltcTarde = 0;                   
                                    @endphp
                                    @if($arqueoTarde=="Vacio")
                                        <tr><td><h3>NO HUBO COBROS</h3></td></tr>
                                        </tbody>
                                        @else
                                            @foreach($arqueoTarde as $ar)
                                                <tr>                                    
                                                    <td>{{ date('d-m-Y', strtotime($ar->fechapago)) }}</td>
                                                    <td>{{$ar->cliente}}</td>
                                                    <td>Pago {{$ar->cuota}} / {{$ar->producto}}</td>
                                                    <td>{{number_format(($ar->importe), 0, ",", ".")}} </td>  
                                                    <td>{{number_format($ar->total_pagf, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagtr, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagch, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagtd, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagtc, 0, ",", ".")}}</td>                          
                                                </tr>  
                                                @php
                                                    $totaldiaTarde=$totaldiaTarde + $ar->importe;  
                                                    $totalefeTarde=$totalefeTarde + $ar->total_pagf; 
                                                    $totaltranTarde=$totaltranTarde + $ar->total_pagtr; 
                                                    $totalcheTarde=$totalcheTarde + $ar->total_pagch; 
                                                    $totaltdTarde=$totaltdTarde + $ar->total_pagtd; 
                                                    $totaltcTarde=$totaltcTarde + $ar->total_pagtc;                                                       
                                                @endphp
                                        @endforeach
                                        <tr class="table-dark">  
                                            <td></td> 
                                            <td></td>     
                                            <td>Total</td>                                                 
                                            <td>Gs. {{number_format(($totaldiaTarde), 0, ",", ".")}}</td>  
                                            <td>Gs. {{number_format(($totalefeTarde), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltranTarde), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totalcheTarde), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltdTarde), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltcTarde), 0, ",", ".")}}</td>                                               
                                        </tr>
                                    </tbody>
                                    @endif
                                </table>                                
                            </div>
                        </div>
                    <div class="card-body">
                        <h3>TOTAL DEL ARQUEO DEL DIA</h3>
                         <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                               
                                        <tr>
                                            <th data-priority="1">Fecha</th>
                                            <th data-priority="1">Cliente</th>
                                            <th data-priority="1">Pago / Factura Nro</th>
                                            <th data-priority="1">Importe</th>
                                            <th data-priority="1">Efectivo</th>
                                            <th data-priority="1">Transf</th>
                                            <th data-priority="1">Cheque</th>
                                            <th data-priority="1">T. Debito</th>
                                            <th data-priority="1">T. Crédito</th>
                                        </tr>    
                                    </thead>
                                    <tr class="table-dark">  
                                            <td></td> 
                                            <td></td>     
                                            <td>Total</td>                                                 
                                            <td>Gs. {{number_format(($totaldia+$totaldiaTarde), 0, ",", ".")}}</td>  
                                            <td>Gs. {{number_format(($totalefe+$totalefeTarde), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltran+$totaltranTarde), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totalche+$totalcheTarde), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltd+$totaltdTarde), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltc+$totaltcTarde), 0, ",", ".")}}</td>                                               
                                    </tr>
                                </table>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2>Arqueo de dias anteriores</h2><br/>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-12">
                        <form id="detalle_producto_pdf" action="{{route('arqueo_dias')}}" method="POST"target="_blank">
                        {{csrf_field()}}
                        <!-- FECHAS DE INICIO Y FIN  -->
                        <div class="row mb-2">
                            <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fecha</label>
                            <div class="col-sm-4">
                                <input type="date" id="fecha1" name="fecha1" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Cajero</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="cajero_id" id="cajero_id">                                     
                                    <option value="0">TODOS</option>                            
                                    @foreach($cajeros as $ban)
                                        <option value="{{$ban->id}}">{{$ban->name}}</option>
                                    @endforeach
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
    <script src="{{ URL::asset('/assets/js/caja/caja.js') }}" defer></script>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection