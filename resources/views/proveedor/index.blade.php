@extends('layouts.master')

@section('title') Proveedores @endsection

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

                       <h2>Lista de Proveedores</h2><br/>                     
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>    
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>    
                        @endif
            
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target="#abrirmodalProv">Agregar Proveedor</button>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'proveedor','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                                            <th  data-priority="1">Editar</th>
                                            <th  data-priority="1">Proveedor</th>
                                            <th  data-priority="1">Ruc</th>
                                            <th  data-priority="1">Telefono/WhatsApp</th>
                                            <th  data-priority="1">Email</th>
                                            <th  data-priority="1">Direccion</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($proveedores as $pro)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>                  
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-id_proveedor="{{$pro->id}}" data-nombre="{{$pro->nombre}}" 
                                                    data-ruc="{{$pro->ruc}}"data-direccion="{{$pro->direccion}}" data-telefono="{{$pro->telefono}}" data-whatsapp="{{$pro->whatsapp}}"
                                                    data-email="{{$pro->email}}" data-bs-toggle="modal" data-bs-target="#abrirmodalEditarPro">
                                                    <i class="fa fa-edit fa-1x"></i> Editar
                                                    </button> &nbsp;
                                                </td>  
                                                
                                                <td>{{$pro->nombre}}</td>
                                                <td>{{$pro->ruc}}</td>
                                                <td>{{$pro->telefono}} / {{$pro->whatsapp}}</td>
                                                <td>{{$pro->email}}</td>
                                                <td>{{$pro->direccion}}</td>
                                            </tr>  
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                            </div> 
                        </div> 
                        {{$proveedores->render()}}
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar-->
            <div class="modal fade" id="abrirmodalProv" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">Nuevo Proveedor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('proveedor.store')}}" method="post" class="form-horizontal">
                            
                                    {{csrf_field()}}
                                    
                                    @include('proveedor.form')

                                </form>                                    
                            </div>
                            
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


             <!--Inicio del modal actualizar-->

             <div class="modal fade" id="abrirmodalEditarPro" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">Actualizar proveedor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('proveedor.update','test')}}" method="post" class="form-horizontal">
                                    
                                    {{method_field('patch')}}
                                    {{csrf_field()}}

                                    <input type="hidden" id="id_proveedor" name="id_proveedor" value="">
                                    
                                    @include('proveedor.form')

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

    <script>
         /*EDITAR CLIENTE EN VENTANA MODAL*/
         $('#abrirmodalEditarPro').on('show.bs.modal', function (event) {
        
        /*el button.data es lo que est�� en el button de editar*/
        var button = $(event.relatedTarget)        
        var nombreprov_modal_editar = button.data('nombre')
        var ruc_modal_editar = button.data('ruc')
        var direccion_modal_editar = button.data('direccion')
        var telefono_modal_editar = button.data('telefono')
        var whatsapp_modal_editar = button.data('whatsapp')
        var email_modal_editar = button.data('email')
        var id_proveedor = button.data('id_proveedor')
        var modal = $(this)
        console.log(nombreprov_modal_editar);
        // modal.find('.modal-title').text('New message to ' + recipient)
        /*los # son los id que se encuentran en el formulario*/
        modal.find('.modal-body #nombre').val(nombreprov_modal_editar);
        modal.find('.modal-body #ruc').val(ruc_modal_editar);
        modal.find('.modal-body #direccion').val(direccion_modal_editar);
        modal.find('.modal-body #telefono').val(telefono_modal_editar);
        modal.find('.modal-body #whatsapp').val(whatsapp_modal_editar);
        modal.find('.modal-body #email').val(email_modal_editar);
        modal.find('.modal-body #id_proveedor').val(id_proveedor);
        // console.log(modal.find('.modal-body #nombre').val(nombrecli_modal_editar));
    })
    </script>
        
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