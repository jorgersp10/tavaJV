@extends('layouts.master')

@section('title') Usuarios @endsection

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
                       <h2>Lista de Usuarios</h2><br/>
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#abrirmodal">Agregar Usuario</button>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'user','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                                            <th  data-priority="1">Editar</th>
                                            <th  data-priority="1">Nombre</th>
                                            <th  data-priority="1">Documento</th>
                                            <th  data-priority="1">Sucursal</th> 
                                            <th  data-priority="1">Rol</th> 
                                            <th  data-priority="1">Email</th>
                                            <th  data-priority="1">Dirección</th>
                                            <th  data-priority="1">Telefono</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($usuarios as $user)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>            
                                             <td>
                                    
                                                @if($user->condicion == 0)

                                                    <button type="button" class="btn btn-danger btn-sm" data-id_usuario="{{$user->id_user}}" data-bs-toggle="modal" data-bs-target="#cambiarEstado">
                                                        <i class="fa fa-times fa-1x"></i> Desactivado
                                                    </button>

                                                    @else

                                                    <button type="button" class="btn btn-success btn-sm" data-id_usuario="{{$user->id_user}}" data-bs-toggle="modal" data-bs-target="#cambiarEstado">
                                                        <i class="fa fa-lock fa-1x"></i> Activado
                                                    </button>

                                                    @endif
                                    
                                                </td>                                                                         
                                                <td>
                                                    <a href="{{URL::action('App\Http\Controllers\UserController@show', $user->id_user)}}">
                                                        <button type="button" class="btn btn-success btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> Editar
                                                        </button>
                                                    </a>
                                                </td>  
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->num_documento}}</td>
                                                <td>{{$user->sucursal}}</td>
                                                <td>{{$user->rol}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->direccion}}</td>
                                                <td>{{$user->telefono}}</td>
                                                
                                                 
                                                                              
                                            </tr>  
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                                {{$usuarios->render()}}
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
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Nuevo Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('user.store')}}" method="post" class="form-horizontal">
                                
                                        {{csrf_field()}}
                                        
                                        @include('user.form')

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
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Actualizar usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('user.update','test')}}" method="post" class="form-horizontal">
                                        
                                        {{method_field('patch')}}
                                        {{csrf_field()}}

                                        <input type="hidden" id="id_usuario" name="id_usuario" value="">
                                        
                                        @include('user.form')

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
                                        <h5 class="modal-title" id="staticBackdropLabel">Cambiar Estado del Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('user.destroy','test')}}" method="POST">
                                            {{method_field('delete')}}
                                            {{csrf_field()}} 

                                            <input type="hidden" id="id_usuario" name="id_usuario" value="">

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
            {{$usuarios->links()}} 
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
@endsection