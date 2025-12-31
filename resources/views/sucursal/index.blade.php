@extends('layouts.master')

@section('title') Sucursales @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') INICIO @endslot
        @slot('title') INMOBILIARIA @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                       <h2>Lista de Sucursales</h2><br/>
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#abrirmodal">Agregar Sucursal</button>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'sucursal','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                                            <th  data-priority="1">ID</th>
                                            <th  data-priority="1">Sucursal</th> 
                                            <th  data-priority="1">Borrar</th> 
                                            <th  data-priority="1">Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($sucursales as $suc)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>                                    
                                                <td>{{$suc->id}}</td>
                                                <td>{{$suc->sucursal}}</td>
                                                <td>
                                    
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistro-{{$suc->id}}">
                                                        <i class="fa fa-times fa-1x"></i> Borrar
                                                    </button>
                                    
                                                </td>                                                                         
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-id_sucursal="{{$suc->id}}" 
                                                    data-sucursal="{{$suc->sucursal}}" data-bs-toggle="modal" data-bs-target="#abrirmodalEditar">
                                                    <i class="fa fa-edit fa-1x"></i> Editar
                                                    </button> &nbsp;
                                                </td>    
                                                                              
                                            </tr>  
                                            @include('sucursal.delete')
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
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Nueva Sucursal</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('sucursal.store')}}" method="post" class="form-horizontal">
                                
                                        {{csrf_field()}}
                                        
                                        @include('sucursal.form')

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
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Actualizar sucursal</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('sucursal.update','test')}}" method="post" class="form-horizontal">
                                        
                                        {{method_field('patch')}}
                                        {{csrf_field()}}

                                        <input type="hidden" id="id_sucursal" name="id_sucursal" value="">
                                        
                                        @include('sucursal.form')

                                    </form>                                  
                                </div>
                                
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

            {{$sucursales->links()}} 
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