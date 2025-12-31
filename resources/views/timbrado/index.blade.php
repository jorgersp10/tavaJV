@extends('layouts.master')

@section('title') Timbrado @endsection

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
                       <h2>Lista de Timbrados</h2><br/>
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#abrirmodal">Agregar Timbrado</button>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'timbrado','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div><br>
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                            
                                            <tr>                                  
                                            <th  data-priority="1">Condicion</th> 
                                            <th  data-priority="1">Sucursal</th> 
                                            <th  data-priority="1">Inicio</th> 
                                            <th  data-priority="1">Fin</th>
                                            <th  data-priority="1">Timbrado</th>
                                            <th  data-priority="1">N° Local</th>
                                            <th  data-priority="1">N° Expedición</th>
                                            <th  data-priority="1">Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($timbrados as $t)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>                                    
                                                <td>
                                    
                                                    @if($t->estado == 0)

                                                    <button type="button" class="btn btn-success btn-sm" data-id_timbrado="{{$t->id_timbrado}}" data-bs-toggle="modal" data-bs-target="#cambiarEstado">
                                                        <i class="fa fa-times fa-1x"></i> Activo
                                                    </button>

                                                    @else

                                                    <button type="button" class="btn btn-danger btn-sm" data-id_timbrado="{{$t->id_timbrado}}" data-bs-toggle="modal" data-bs-target="#cambiarEstado">
                                                        <i class="fa fa-lock fa-1x"></i> Desactivado
                                                    </button>

                                                    @endif
                                    
                                                </td>  
                                                <td>{{$t->suc_timbrado}}</td>
                                                <td>{{$t->ini_timbrado}}</td>
                                                <td>{{$t->fin_timbrado}}</td>
                                                <td>{{$t->nro_timbrado}}</td>
                                                <td>{{$t->nrof_suc}}</td>
                                                <td>{{$t->nrof_expendio}}</td>                                                                        
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-id_timbrado="{{$t->id_timbrado}}" 
                                                    data-suc_timbrado="{{$t->idsucursal}}" data-ini_timbrado="{{$t->ini_timbrado}}"
                                                    data-fin_timbrado="{{$t->fin_timbrado}}" data-nro_timbrado="{{$t->nro_timbrado}}"
                                                    data-nro_factura_ini="{{$t->nro_factura_ini}}" data-nro_factura="{{$t->nro_factura}}"
                                                    data-nrof_suc="{{$t->nrof_suc}}" data-nrof_expendio="{{$t->nrof_expendio}}"
                                                    data-bs-toggle="modal" data-bs-target="#abrirmodalEditar">
                                                    <i class="fa fa-edit fa-1x"></i> Editar
                                                    </button> &nbsp;
                                                </td>    
                                                                              
                                            </tr>  
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                                
                            </div> 
                        </div> 
                        
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
                <!--Inicio del modal agregar-->
                <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Nuevo Timbrado</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('timbrado.store')}}" method="post" class="form-horizontal">
                                
                                        {{csrf_field()}}
                                        
                                        @include('timbrado.form')

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
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Actualizar timbrado</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('timbrado.update','test')}}" method="post" class="form-horizontal">
                                        
                                        {{method_field('patch')}}
                                        {{csrf_field()}}

                                        <input type="hidden" id="id_timbrado" name="id_timbrado" value="">
                                        
                                        @include('timbrado.form')

                                    </form>                                  
                                </div>
                                
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- CAMBIAR DE ESTADO -->
                    <div class="modal fade" id="cambiarEstado" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Cambiar Estado del Timbrado</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('timbrado.destroy','test')}}" method="POST">
                                            {{method_field('delete')}}
                                            {{csrf_field()}} 

                                            <input type="text" id="id_timbrado" name="id_timbrado" value="">

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

            {{$timbrados->links()}} 
        </div><br>   
                     
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

    <!-- //EDITAR TIMBRADO EN VENTANA MODAL -->
    <script>
         $('#abrirmodalEditar').on('show.bs.modal', function (event) {        
            /*el button.data es lo que está en el button de editar*/
            var button = $(event.relatedTarget)
            
            var sucursal_modal_editar = button.data('suc_timbrado')
            var ini_timbrado_modal_editar = button.data('ini_timbrado')
            var fin_timbrado_modal_editar = button.data('fin_timbrado')
            var nro_timbrado_modal_editar = button.data('nro_timbrado')
            var nro_factura_ini_modal_editar = button.data('nro_factura_ini')
            var nro_factura_modal_editar = button.data('nro_factura')
            var nrof_suc_modal_editar = button.data('nrof_suc')
            var nrof_expendio_modal_editar = button.data('nrof_expendio')
            var id_timbrado = button.data('id_timbrado')
            var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            /*los # son los id que se encuentran en el formulario*/
            modal.find('.modal-body #suc_timbrado').val(sucursal_modal_editar);
            modal.find('.modal-body #ini_timbrado').val(ini_timbrado_modal_editar);
            modal.find('.modal-body #fin_timbrado').val(fin_timbrado_modal_editar);
            modal.find('.modal-body #nro_timbrado').val(nro_timbrado_modal_editar);
            modal.find('.modal-body #nro_factura_ini').val(nro_factura_ini_modal_editar);
            modal.find('.modal-body #telefono').val(nro_factura_modal_editar);
            modal.find('.modal-body #nro_factura').val(nro_factura_modal_editar);
            modal.find('.modal-body #nrof_suc').val(nrof_suc_modal_editar);
            modal.find('.modal-body #nrof_expendio').val(nrof_expendio_modal_editar);
            modal.find('.modal-body #id_timbrado').val(id_timbrado);
        })
    </script>

    <script>
        $('#cambiarEstado').on('show.bs.modal', function (event) {       
        
            var button = $(event.relatedTarget) 
            var id_timbrado = button.data('id_timbrado')
            var modal = $(this)        
            modal.find('.modal-body #id_timbrado').val(id_timbrado);
            })
    </script>
@endsection