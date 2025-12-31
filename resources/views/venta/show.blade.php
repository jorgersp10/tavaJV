@extends('layouts.master')

@section('title') Venta de Producto @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
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
                       <h2>Venta de Producto</h2><br/>
                       
                       <div class="form-group row ">
                        <div class=" col-md-8">
                            <div class="row mb-8">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Comprador</label>
                                <div class="col-sm-9">
                                    @foreach($proforma as $pro)
                                        <h4>{{$pro->nombre}}</h4>
                                    @endforeach
                                </div>
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Producto</label>
                                <div class="col-sm-9">
                                    @foreach($proforma as $pro)
                                        <h4>{{$pro->producto}}</h4>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-12">                                
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Total a Pagar</label>
                                <div class="col-sm-3">
                                    @foreach($totales as $tot)
                                        <h4>{{number_format(($tot->tc_a_pagar), 0, ",", ".")}}</h4>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row mb-12">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Precio</label>
                                <div class="col-sm-9">
                                    @foreach($proforma as $pro)
                                        <h4>{{number_format(($pro->precio_inm), 0, ",", ".")}} Gs.</h4>
                                    @endforeach

                                    <div class="row mb-8">
                                        <div class="col-sm-6" mt-2 mb-2>
                                            <button type="button" class="btn btn-success btn-sm"  data-tc_a_pagar="{{$tot->tc_a_pagar}}"  data-bs-toggle="modal" data-bs-target="#grabarVenta">
                                                <i class="fa fa-edit fa-1x"></i> Vender
                                                </button> &nbsp;
                                     
                                    </div>
                                </div>
                            </div>
                 
                            </div>

                        </div>


                    </div>
                    </div>

                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                            
                                            <tr>                                  
                                            <th  data-priority="1">Cuota</th>
                                            <th  data-priority="1">Vencimiento</th>  
                                            <th  data-priority="1">Capital</th> 
                                            <th  data-priority="1">Interes</th> 
                                            <th  data-priority="1">Total</th> 

                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($cuotas as $cuota)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>                                    
                                                <td>{{$cuota->cuota_nro}}</td> 
                                                <td>{{$cuota->fec_vto}}</td>
                                                <td>{{$cuota->capital}}</td>
                                                <td>{{$cuota->interes}}</td>
                                                <td>{{$cuota->total_cuota}}</td>
                                            </tr>  
                                           
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                                
                            </div> 
                        </div> 
                        
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->

                <!--Inicio del modal actualizar-->

                <div class="modal fade" id="grabarVenta" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Grabar Venta</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('venta.store')}}" method="POST" class="form-horizontal">
                                        
                                        <input type="hidden" id="proforma_id" name="proforma_id"  value={{$nro_prof}}>
                                        {{csrf_field()}}

                                        <div class="row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Seleccione Vendedor</label>
        
                                            <select style= "width:400px" class="js-example-basic-single js-states form-control" name="vendedor_id" id="vendedor_id">                        
                                                <option value="0" disabled>Seleccione</option>                                               
                                                @foreach($vendedores as $v)
                                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Total Factura GS.</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" value="{{number_format(($tot->tc_a_pagar), 0, ",", ".")}}" id="tc_a_pagar" name="tc_a_pagar" placeholder="Total a Pagar">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Factura N°</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="factura" name="factura" placeholder="Número de factura">
                                            </div>
                                        </div>

                                        <h5>Esta usted seguro de grabar la venta ? </h5>
                                        
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal">No Guardar</button>
                                            <button type="submit" class="btn btn-danger">Guardar Venta</button>
                                        </div>
                                    </form>                                  
                                </div>
                                
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


        </div><br>   
                     
    </main>

@endsection
@section('script')

    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/moment.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
        <!-- Table Editable plugin -->
    <script src="{{ URL::asset('/assets/libs/table-edits/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/table-editable.int.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- Datatable init js -->

    <script>
        /*EDITAR CLIENTE EN VENTANA MODAL*/
        $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        
            /*el button.data es lo que está en el button de editar*/
            var button = $(event.relatedTarget)
            
            var nombre_descripcion = button.data('descripcion')
            console.log(nombre_descripcion)

            var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            /*los # son los id que se encuentran en el formulario*/
            modal.find('.modal-body #descripcion').val(nombre_descripcion);
        })
    

    </script>


@endsection


