@extends('layouts.master')

@section('title') Detalle Presupuesto @endsection

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
                <h2>Estado de Cuenta</h2><br/>                     
            </div>

            <div class="card-body">
                <h4 class="text-left">Detalle de Presupuesto</h4><br/>
            
                <div class="form-group row">
                    <label class="col-md-2 form-control-label"><b>Cliente:</b></label>
                    <div class="col-md-3">
                            <p>{{$ventas->nombre}}</p>     
                    </div>
                    <label class="col-md-2 form-control-label"><b>Documento:</b></label>
                    <div class="col-md-3">
                            <p>{{$ventas->num_documento}}</p>     
                    </div>
                    <div class="col-md-2">
                        <a href="{{action('App\Http\Controllers\PresupuestoController@presuPDF', $ventas->id)}}" target="_blank">
                        <button type="button" class="btn btn-danger btn-sm" >
                                <i class="fa fa-file fa-2x"></i> Imprimir
                            </button>                            
                        </a> 
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 form-control-label"><b>Factura N°:</b></label>
                    <div class="col-md-3">
                            <p>{{$ventas->fact_nro}}</p>     
                    </div>
                    <label class="col-md-2 form-control-label"><b>Fecha de Compra:</b></label>
                    <div class="col-md-3">
                            <p>{{ date('d-m-Y', strtotime($ventas->fecha)) }}</p>     
                    </div>
                </div>

        <div class="form-group row border">

              <h3>Detalle de Ventas</h3>

              <div class="table-responsive col-md-12">
                <table id="detalles" class="table table-bordered table-striped table-sm">
                <thead>
                    <tr class="bg-info">
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio (Gs.)</th>                        
                        <th>SubTotal (Gs.)</th>
                    </tr>
                </thead>
                 
                <tfoot>

                    <tr>
                        <th  colspan="3"><p align="right">TOTAL:</p></th>
                        <th><p align="right">Gs. {{number_format(($ventas->total), 0, ",", ".")}}</p></th>
                    </tr>

                    <tr>
                        <th colspan="3"><p align="right">TOTAL IMPUESTO (10%):</p></th>
                        <th><p align="right">Gs. {{number_format(($ventas->total/11), 0, ",", ".")}}</p></th>
                    </tr>

                    <tr>
                        <th  colspan="3"><p align="right">TOTAL PAGAR:</p></th>
                        <th><p align="right">Gs. {{number_format($ventas->total, 0, ",", ".")}}</p></th>
                    </tr> 

                </tfoot>

                <tbody>
                   
                   @foreach($detalles as $det)

                    <tr>
                      <td>{{$det->cantidad}}</td>
                      <td>{{$det->producto}}</td>
                      <td>Gs. {{number_format(($det->precio), 0, ",", ".")}}</td>
                      <td>Gs. {{number_format(($det->cantidad*$det->precio), 0, ",", ".")}}</td>
                    </tr> 


                   @endforeach
                   
                </tbody>
                
                
                </table>
              </div>
            
            </div>

               
            </div> 
        </div>  
    </div>
    <!-- Fin ejemplo de tabla Listado -->    
</main>

@endsection