@extends('layouts.master')

@section('title') Ventas @endsection

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

                       <h2>Lista de Facturas Venta</h2><br/>                     
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>    
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>    
                        @endif
                    <a href="factura/create">
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#abrirmodal">Agregar Factura</button></a>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                            {!!Form::open(array('url'=>'factura','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
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
                        </div><br>
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                            
                                            <tr>      
                                            @if(auth()->user()->idrol == 1)   
                                            <th  data-priority="1">Borrar</th>
                                            @endif
                                            <th  data-priority="1">Accion</th>
                                            <th  data-priority="1">Ticket</th>
                                            <th  data-priority="1">Ver Detalle</th>
                                            <th  data-priority="1">Fecha</th>
                                            <th  data-priority="1">Fact. / Orden N°</th>
                                            <th  data-priority="1">Cliente</th>
                                            <th  data-priority="1">Total</th>
                                            <th  data-priority="1">Iva</th>
                                            <th  data-priority="1">Estado</th>
                                            <th  data-priority="1">Cambiar Estado</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($ventas as $ven)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>        
                                                @if(auth()->user()->idrol == 1)   
                                                <td>                                    
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistroFac-{{$ven->id}}">
                                                        <i class="fa fa-times fa-1x"></i> Borrar
                                                    </button>                                    
                                                </td>
                                                @endif
                                                @if($ven->contable == 1)
                                                <td>                                     
                                                <a href="{{URL::action('App\Http\Controllers\FacturaController@factura_pdf',$ven->id)}}" target="_blank">
                                                        <button type="button" class="btn btn-primary btn-sm" >
                                                            <i class="fa fa-print fa-1x"></i> IMPRI FACT
                                                        </button>
                                                    </a>
                                                </td>     
                                                @else
                                                <td> 
                                                <a href="{{URL::action('App\Http\Controllers\FacturaController@factura_pdf_orden',$ven->id)}}" target="_blank">
                                                        <button type="button" class="btn btn-warning btn-sm" >
                                                            <i class="fa fa-print fa-1x"></i> IMPRI ORD
                                                        </button>
                                                    </a>
                                                </td>    
                                                @endif
                                                <td> 
                                                <a href="{{url('/imprimirTicket',$ven->id)}}" target="_blank">
                                                        <button type="button" class="btn btn-success btn-sm" >
                                                            <i class="fa fa-print fa-1x"></i> GS
                                                        </button>
                                                    </a>
                                                </td>
                                                <td>                                     
                                                    <a href="{{URL::action('App\Http\Controllers\FacturaController@show', $ven->id)}}">
                                                        <button type="button" class="btn btn-success btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> Detalles
                                                        </button>
                                                    </a>
                                                </td>
                                                <td>{{$ven->fecha}}</td>
                                                @if($ven->contable == 1)
                                                    <td>{{$ven->fact_nro}}</td>
                                                @else
                                                    <td>{{$ven->nro_recibo}}</td>
                                                @endif
                                                <td>{{$ven->nombre}}</td>
                                                <td>Gs. {{number_format(($ven->total), 0, ",", ".")}}</td>
                                                <td>Gs. {{number_format(($ven->ivaTotal), 0, ",", ".")}}</td>
                                                <td>                                      
                                                    @if($ven->estado==0)
                                                        <button type="button" class="btn btn-primary btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> Registrado
                                                        </button>

                                                    @else
                                                    <button type="button" class="btn btn-danger btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> Anulado
                                                        </button>

                                                    @endif
                                                    
                                                    </td>
                                                    
                                                    <td>
                                                         @if($ven->estado==0)
                                                            <button type="button" class="btn btn-danger btn-sm" data-id_venta="{{$ven->id}}" data-bs-toggle="modal" data-bs-target="#cambiarEstadoVenta">
                                                                <i class="fa fa-times fa-1x"></i> Anular Venta
                                                            </button>

                                                            @else

                                                            <button type="button" class="btn btn-success btn-sm">
                                                                <i class="fa fa-lock fa-1x"></i> Anulado
                                                            </button>
                                                        @endif
                                                    
                                                    </td>  
                                            </tr> 
                                            @include('factura.delete') 
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

             <!-- CAMBIAR DE ESTADO -->
             <div class="modal fade" id="cambiarEstadoVenta" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Cambiar Estado de la venta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('factura.edit','test')}}" method="GET">
                                
                                {{csrf_field()}} 

                                <input type="hidden" id="id_venta" name="id_venta" value="">

                                <p>¿Estas seguro de cambiar el estado?</p>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Aceptar</button>
                                </div>

                            </form>
                        </div>                                    
                    </div>
                </div>
            </div>   

             <!-- CAMBIAR DE ESTADO -->
             <div class="modal fade" id="cuidadoFactura" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title w-100 text-center" id="staticBackdropLabel">CUIDADO!!</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>  
                        <div class="modal-header">
                            <h5 class="modal-title w-100 text-center" id="staticBackdropLabel">MONTO FACTURADO SUPERA A LA COMPRA DEL MES</h5>
                        </div>                                 
                    </div>
                </div>
            </div>   
        </main>

@endsection
@section('script')

    <script>
         /*INICIO ventana modal para cambiar estado de Compra*/
        
        $('#cambiarEstadoVenta').on('show.bs.modal', function (event) {
       
       //console.log('modal abierto');
       
       var button = $(event.relatedTarget) 
       var id_venta = button.data('id_venta')
       var modal = $(this)
       // modal.find('.modal-title').text('New message to ' + recipient)
       
       modal.find('.modal-body #id_venta').val(id_venta);
       })
        
       /*FIN ventana modal para cambiar estado de la compra*/
    </script>

    <!-- <script>
         /*INICIO ventana modal para cambiar estado de Compra*/
        $( document ).ready(function() {
             var saldoFact = document.getElementById("saldoFact").value
             if(saldoFact < 0)
                $('#cuidadoFactura').modal('toggle')
        });
        
       /*FIN ventana modal para cambiar estado de la compra*/
    </script> -->
        
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