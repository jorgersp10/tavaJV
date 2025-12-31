@extends('layouts.master')

@section('title') Urbanizaciones @endsection

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
                       <h2>Lista de Urbanizaciones</h2><br/>
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#abrirmodal">Agregar Urbanización</button>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'loteamiento','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                                            <th  data-priority="1">Urbanización</th> 
                                            <th  data-priority="1">Mora GS</th>
                                            <th  data-priority="1">Mora U$s</th>
                                            <th  data-priority="1">Borrar</th> 
                                            <th  data-priority="1">Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($loteamientos as $lot)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>                                    
                                                <td>{{$lot->id}}</td>
                                                <td>{{$lot->descripcion}}</td>
                                                <td>{{$lot->mora_gs}}</td>
                                                <td>{{$lot->mora_us}}</td>
                                                <td>
                                    
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistro-{{$lot->id}}">
                                                        <i class="fa fa-times fa-1x"></i> Borrar
                                                    </button>
                                    
                                                </td>                                                                         
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-id_loteamiento="{{$lot->id}}" 
                                                    data-descripcion="{{$lot->descripcion}}" data-mora_gs="{{$lot->mora_gs}}"
                                                    data-mora_us="{{$lot->mora_us}}" 
                                                    data-bs-toggle="modal" data-bs-target="#abrirmodalEditar">
                                                    <i class="fa fa-edit fa-1x"></i> Editar
                                                    </button> &nbsp;
                                                </td>    
                                                                              
                                            </tr>  
                                            @include('loteamiento.delete')
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
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Nueva Urbanización</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('loteamiento.store')}}" method="post" class="form-horizontal">
                                
                                        {{csrf_field()}}
                                        
                                        @include('loteamiento.form')

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
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Actualizar Urbanización</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('loteamiento.update','test')}}" method="post" class="form-horizontal">
                                        
                                        {{method_field('patch')}}
                                        {{csrf_field()}}

                                        <input type="hidden" id="id_loteamiento" name="id_loteamiento" value="">
                                        
                                        @include('loteamiento.form')

                                    </form>                                  
                                </div>
                                
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

            {{$loteamientos->links()}} 
        </div><br>   
                     
    </main>

@endsection
@section('script')
    <script>
    /*EDITAR LOTEAMIENTO EN VENTANA MODAL*/
    $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        
        /*el button.data es lo que está en el button de editar*/
        var button = $(event.relatedTarget)
        
        var loteamiento_modal_editar = button.data('descripcion')
        var mora_gs_modal_editar = button.data('mora_gs')
        var mora_us_modal_editar = button.data('mora_us')
        var id_loteamiento = button.data('id_loteamiento')
        var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        /*los # son los id que se encuentran en el formulario*/
        modal.find('.modal-body #descripcion').val(loteamiento_modal_editar);
        modal.find('.modal-body #mora_gs').val(mora_gs_modal_editar);
        modal.find('.modal-body #mora_us').val(mora_us_modal_editar);
        modal.find('.modal-body #id_loteamiento').val(id_loteamiento);
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