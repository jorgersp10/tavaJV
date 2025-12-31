@extends('layouts.master')

@section('title') Vendedores @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') INICIO @endslot
        @slot('title') A&M INOX - HIERROS @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                       <h2>Lista de Vendedores</h2><br/>
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#abrirmodal">Agregar Vendedor</button>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'vendedor','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                                            <th  data-priority="1">Nombre</th>
                                            <th  data-priority="1">Documento</th>
                                            <th  data-priority="1">Email</th>
                                            <th  data-priority="1">Dirección</th>
                                            <th  data-priority="1">Telefono</th>
                                            <th  data-priority="1">Sucursal</th> 
                                            <th  data-priority="1">Condicion</th> 
                                            <th  data-priority="1">Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($vendedores as $ven)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del vendedor logueado
                                            Asi cada vendedor solo puede ver datos de su empresa -->
                                        
                                            <tr>                                    
                                                <td>{{$ven->name}}</td>
                                                <td>{{$ven->num_documento}}</td>
                                                <td>{{$ven->email}}</td>
                                                <td>{{$ven->direccion}}</td>
                                                <td>{{$ven->telefono}}</td>
                                                <td>{{$ven->sucursal}}</td>
                                                <td>
                                    
                                                @if($ven->condicion == 0)

                                                    <button type="button" class="btn btn-danger btn-sm" data-id_vendedor="{{$ven->id}}" data-bs-toggle="modal" data-bs-target="#cambiarEstado">
                                                        <i class="fa fa-times fa-1x"></i> Desactivado
                                                    </button>

                                                    @else

                                                    <button type="button" class="btn btn-success btn-sm" data-id_vendedor="{{$ven->id}}" data-bs-toggle="modal" data-bs-target="#cambiarEstado">
                                                        <i class="fa fa-lock fa-1x"></i> Activado
                                                    </button>

                                                    @endif
                                    
                                                </td>                                                                         
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-id_vendedor="{{$ven->id}}" 
                                                    data-name="{{$ven->name}}" data-email="{{$ven->email}}" data-num_documento="{{$ven->num_documento}}" 
                                                    data-direccion="{{$ven->direccion}}" data-telefono="{{$ven->telefono}}" 
                                                    data-fecha_nacimiento="{{$ven->fecha_nacimiento}}"
                                                    data-idsucursal="{{$ven->idsucursal}}" data-bs-toggle="modal" data-bs-target="#abrirmodalEditar">
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
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Nuevo Vendedor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('vendedor.store')}}" method="post" class="form-horizontal">
                                
                                        {{csrf_field()}}
                                        
                                        @include('vendedor.form')

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
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Actualizar vendedor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('vendedor.update','test')}}" method="post" class="form-horizontal">
                                        
                                        {{method_field('patch')}}
                                        {{csrf_field()}}

                                        <input type="hidden" id="id_vendedor" name="id_vendedor" value="">
                                        
                                        @include('vendedor.form')

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
                                        <h5 class="modal-title" id="staticBackdropLabel">Cambiar Estado del Vendedor</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('vendedor.destroy','test')}}" method="POST">
                                            {{method_field('delete')}}
                                            {{csrf_field()}} 

                                            <input type="hidden" id="id_vendedor" name="id_vendedor" value="">

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
            {{$vendedores->links()}} 
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

    <script>
     /*EDITAR VENDEDOR EN VENTANA MODAL*/
     $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        
        /*el button.data es lo que está en el button de editar*/
        var button = $(event.relatedTarget)
        
        var nombre_modal_editar = button.data('name')
        var email_modal_editar = button.data('email')
        var num_documento_modal_editar = button.data('num_documento')
        var direccion_modal_editar = button.data('direccion')
        var telefono_modal_editar = button.data('telefono')
        var fecha_nacimiento_modal_editar = button.data('fecha_nacimiento')
        var sucursal_modal_editar = button.data('idsucursal')
        var id_vendedor = button.data('id_vendedor')
        var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        /*los # son los id que se encuentran en el formulario*/
        modal.find('.modal-body #nombre').val(nombre_modal_editar);
        modal.find('.modal-body #email').val(email_modal_editar);
        modal.find('.modal-body #num_documento').val(num_documento_modal_editar);
        modal.find('.modal-body #direccion').val(direccion_modal_editar);
        modal.find('.modal-body #telefono').val(telefono_modal_editar);
        modal.find('.modal-body #fecha_nacimiento').val(fecha_nacimiento_modal_editar);
        modal.find('.modal-body #idsucursal').val(sucursal_modal_editar);
        modal.find('.modal-body #id_vendedor').val(id_vendedor);
    })

     /*INICIO ventana modal para cambiar el estado del vendedor*/
        
     $('#cambiarEstado').on('show.bs.modal', function (event) {       
        
        var button = $(event.relatedTarget) 
        var id_vendedor = button.data('id_vendedor')
        var modal = $(this)        
        modal.find('.modal-body #id_vendedor').val(id_vendedor);
        })
     
    /*FIN ventana modal para cambiar estado del vendedor*/
    </script> 
@endsection