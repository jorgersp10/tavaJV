@extends('layouts.master')

@section('title') Usuarios @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <meta name='csrf-token' content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') LABPROF GROUP @endslot
    @endcomponent
<main class="main">
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <form action="{{route('user.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">                               
                {{method_field('patch')}}
                @csrf
                <div class="card-header">

                    <h2>Actualizar Usuario</h2><br/>                     
                    
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                    
                        </div>
                    </div><br>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-6">
                                <input type="text" id="nombre" value="{{$usuarios->name}}"
                                name="nombre" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Correo</label>
                            <div class="col-sm-6">
                                <input type="text" id="email" value="{{$usuarios->email}}"
                                name="email" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Numero Documento</label>
                            <div class="col-sm-6">
                                <input type="text" id="num_documento" value="{{$usuarios->num_documento}}"
                                name="num_documento" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Direccion</label>
                            <div class="col-sm-6">
                                <input type="text" id="direccion" value="{{$usuarios->direccion}}"
                                name="direccion" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Telefono</label>
                            <div class="col-sm-6">
                                <input type="text" id="telefono" value="{{$usuarios->telefono}}"
                                name="telefono" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Fecha Nacimiento</label>
                            <div class="col-sm-6">
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{$usuarios->fecha_nacimiento}}"  class="form-control" placeholder="Ingrese la fecha">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Sucursal</label>
                            <div class="col-sm-3">
                                <select id='idsucursal' name='idsucursal' style= "width:246px" class="form-control">
                                    @foreach($sucursales as $suc)
                                        <option value="{{$suc->id}}">{{$suc->sucursal}}</option>
                                    @endforeach   
                                </select>
                            </div>

                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Rol</label>
                            <div class="col-sm-3">
                                <select id='id_rol' name='id_rol' style= "width:246px" class="form-control">
                                    @foreach($roles as $r)
                                        <option value="{{$r->id}}">{{$r->descripcion}}</option>
                                    @endforeach   
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-4">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Ingrese el password">
                            </div>
                            <div class="col-sm-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="cambiar" name="cambiar">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Cambiar contraseña</label>
                            </div>
                        </div>


                        <input type="hidden" id="id_user" name="id_user" 
                        value={{$usuarios->id_user}} class="form-control" >

                        <input type="hidden" id="sucursal_id_hidden" name="sucursal_id_hidden" 
                        value={{$usuarios->idsucursal}} class="form-control" >

                        <input type="hidden" id="rol_id_hidden" name="rol_id_hidden" 
                        value={{$usuarios->idrol}} class="form-control" >
                        
                        <div class="modal-footer">
                            <a href="{{ url()->previous() }}">
                                <button type="button" class="btn btn-primary">Salir</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</main>

    @endsection

@section('script')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
       
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
    <script src="{{ URL::asset('/assets/js/moment.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/usuarios/usuarios.js') }}"></script>
    
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection