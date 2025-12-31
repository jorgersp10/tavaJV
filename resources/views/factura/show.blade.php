@extends('layouts.master')

@section('title') Detalle Venta @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
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
                <h2>Estado de Cuenta</h2><br/>                     
            </div>

            <div class="card-body">
                <h4 class="text-left">Detalle de Venta</h4><br/>
                <form id="form_venta" action="{{route('update_facNro')}}" method="POST">
                    {{csrf_field()}} 
                    <input type="hidden" id="id_venta" name="id_venta" class="form-control" value="{{$ventas->id}}">  

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label"><b>Cliente:</b></label>
                        <div class="col-md-3">
                                <p>{{$ventas->nombre}}</p>     
                        </div>
                        <label class="col-md-2 form-control-label"><b>Documento:</b></label>
                        <div class="col-md-3">
                                <p>{{$ventas->num_documento}}</p>     
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label"><b>Factura N°:</b></label>
                        <div class="col-md-3">
                            <input type="text" id="fact_nro" name="fact_nro" class="form-control" value="{{$ventas->fact_nro}}">  
                        </div>
                        <label class="col-md-2 form-control-label"><b>Fecha de Venta:</b></label>
                        <div class="col-md-3">
                            <input type="date" id="fecha" name="fecha" class="form-control" value="{{$ventas->fecha}}">     
                        </div>
                    </div><br>

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label"><b>Tipo Factura:</b></label>
                        <div class="col-md-3">
                            @if($ventas->tipo_factura == 0)
                                <p>Contado</p>  
                                @else
                                <p>Crédito</p>     
                            @endif
                        </div>
                        <label class="col-md-2 form-control-label"><b>Timbrado N°:</b></label>
                        <div class="col-md-3">
                            <input type="text" id="timbrado" name="timbrado" class="form-control" value="{{$ventas->timbrado}}">  
                        </div>                        
                    </div>
                     <div class="form-group row">                       
                        <label class="col-md-2 form-control-label"><b>Cargado a:</b></label>
                        <div class="col-md-3">
                            <select class="form-control" name="empresa_id" id="empresa_id">
                                @foreach($empresas as $e)
                                    <option value="{{$e->id}}" @php
                                            echo ($e->id==$empresa_id)?"selected":"";
                                        @endphp>{{$e->nombre}}</option>  
                                @endforeach  
                            </select>
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
                            <th colspan="3"><p align="right">TOTAL IMPUESTO (5%):</p></th>
                            <th><p align="right">Gs. {{number_format(($ventas->iva5), 0, ",", ".")}}</p></th>
                        </tr>

                        <tr>
                            <th colspan="3"><p align="right">TOTAL IMPUESTO (10%):</p></th>
                            <th><p align="right">Gs. {{number_format(($ventas->iva10), 0, ",", ".")}}</p></th>
                        </tr>

                        <tr>
                            <th colspan="3"><p align="right">TOTAL EXENTA:</p></th>
                            <th><p align="right">Gs. {{number_format(($ventas->exenta), 0, ",", ".")}}</p></th>
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
                <div class="modal-footer">
                    <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>
            </div> 
        </div>  
    </div>
    <!-- Fin ejemplo de tabla Listado -->    
</main>

@endsection