@extends('layouts.master')

@section('title') Clientes @endsection

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

                       <h2>Lista de Clientes</h2><br/>                     
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>    
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>    
                        @endif
            
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target="#abrirmodal">Agregar Clientes</button>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'cliente','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                                            <th  data-priority="1">Estado Cuenta</th>
                                            <!-- <th  data-priority="1">Documentos</th> -->
                                            @if(auth()->user()->idrol == 1)  
                                                <th  data-priority="1">Borrar</th>
                                            @endif
                                            <th  data-priority="1">Cliente</th>
                                            <th  data-priority="1">Documento</th>
                                            <th  data-priority="1">Telefono/whatsApp</th>
                                            <th  data-priority="1">Email</th>
                                            <th  data-priority="1">Direccion</th>
                                            <th  data-priority="1">Autor</th> 
                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($clientes as $client)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>                  
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-id_cliente="{{$client->id}}" data-nombre="{{$client->nombre}}" 
                                                        data-tipo_documento="{{$client->tipo_documento}}" data-digito="{{$client->digito}}" data-num_documento="{{$client->num_documento}}" 
                                                        data-direccion="{{$client->direccion}}" data-telefono="{{$client->telefono}}" data-whatsapp="{{$client->whatsapp}}"
                                                        data-email="{{$client->email}}" data-estado_civil="{{$client->estado_civil}}" 
                                                        data-sexo="{{$client->sexo}}" data-edad="{{$client->edad}}" 
                                                        data-fecha_nacimiento="{{$client->fecha_nacimiento}}"  data-bs-toggle="modal" 
                                                        data-nombres12="{{$client->nombres12}}" data-apellido="{{$client->apellido}}"
                                                        data-bs-target="#abrirmodalEditarcli">
                                                    <i class="fa fa-edit fa-1x"></i> Editar
                                                    </button> &nbsp;
                                                </td>  
                                                <!-- <td>                                     
                                                    <a href="{{URL::action('App\Http\Controllers\DocumentoController@show', $client->id)}}">
                                                        <button type="button" class="btn btn-success btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> Documentos
                                                        </button>
                                                    </a>
                                                </td>    -->
                                                <td>                                     
                                                    <a href="{{URL::action('App\Http\Controllers\ClienteController@show', $client->id)}}">
                                                        <button type="button" class="btn btn-success btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> Detalles
                                                        </button>
                                                    </a>
                                                </td> 
                                                @if(auth()->user()->idrol == 1)  
                                                <td>                                    
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistro-{{$client->id}}">
                                                        <i class="fa fa-times fa-1x"></i> Borrar
                                                    </button>                                    
                                                </td>
                                                @endif
                                                <td>{{$client->nombre}}</td>
                                                <td>{{$client->tipo_documento}} - {{$client->num_documento}} - {{$client->digito}}</td>
                                                <td>{{$client->telefono}} / {{$client->whatsapp}}</td>
                                                <td>{{$client->email}}</td>
                                                <td>{{$client->direccion}}</td>
                                                <td>{{$client->user}}</td>      
                                            </tr>  
                                            @include('cliente.delete')
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                            </div> 
                        </div> 
                        {{$clientes->render()}}
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar-->
            <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">Nuevo Cliente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('cliente.store')}}" method="post" class="form-horizontal">
                                <input type="hidden" id="lugar" name="lugar"  value=2>
                                    {{csrf_field()}}
                                    
                                    @include('cliente.form')

                                </form>                                    
                            </div>
                            
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


             <!--Inicio del modal actualizar-->

             <div class="modal fade" id="abrirmodalEditarcli" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">Actualizar cliente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('cliente.update','test')}}" method="post" class="form-horizontal">
                                    
                                    {{method_field('patch')}}
                                    {{csrf_field()}}

                                    <input type="hidden" id="id_cliente" name="id_cliente" value="">
                                    
                                    @include('cliente.form')

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
         $('#abrirmodalEditarcli').on('show.bs.modal', function (event) {
        
        /*el button.data es lo que est�� en el button de editar*/
        var button = $(event.relatedTarget)        
        var nombrecli_modal_editar = button.data('nombres12')
        var apellidocli_modal_editar = button.data('apellido')
        var tipo_documento_modal_editar = button.data('tipo_documento')
        var num_documento_modal_editar = button.data('num_documento')
        var digito_modal_editar = button.data('digito')
        var direccion_modal_editar = button.data('direccion')
        var telefono_modal_editar = button.data('telefono')
        var whatsapp_modal_editar = button.data('whatsapp')
        var email_modal_editar = button.data('email')
        var id_cliente = button.data('id_cliente')
        var estado_civil = button.data('estado_civil')
        var sexo = button.data('sexo')
        var fecha_nacimiento_modal_editar = button.data('fecha_nacimiento')
        var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        /*los # son los id que se encuentran en el formulario*/
        modal.find('.modal-body #nombre').val(nombrecli_modal_editar);
        modal.find('.modal-body #apellido').val(apellidocli_modal_editar);
        modal.find('.modal-body #tipo_documento').val(tipo_documento_modal_editar);
        modal.find('.modal-body #num_documento').val(num_documento_modal_editar);
        modal.find('.modal-body #digito').val(digito_modal_editar);
        modal.find('.modal-body #direccion').val(direccion_modal_editar);
        modal.find('.modal-body #telefono').val(telefono_modal_editar);
        modal.find('.modal-body #whatsapp').val(whatsapp_modal_editar);
        modal.find('.modal-body #email').val(email_modal_editar);
        modal.find('.modal-body #id_cliente').val(id_cliente);
        modal.find('.modal-body #estado_civil').val(estado_civil);
        modal.find('.modal-body #sexo').val(sexo);
        modal.find('.modal-body #fecha_nacimiento').val(fecha_nacimiento_modal_editar);
        console.log(modal.find('.modal-body #nombre').val(nombrecli_modal_editar));
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