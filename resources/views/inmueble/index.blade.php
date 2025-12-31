@extends('layouts.master')

@section('title') Inmuebles @endsection

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
                       <h2>Lista de Inmuebles</h2><br/>
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#abrirmodal">Agregar Inmueble</button>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                            {!!Form::open(array('url'=>'inmueble','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                            <label class="col-md-4 form-control-label" for="rol">Texto</label>
                                <div class="input-group">                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        
                        
                            <div class="col-md-4">
                                {!!Form::open(array('url'=>'inmueble','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <label class="col-md-4 form-control-label" for="rol">Urbanización</label>
                                <div class="input-group">
                                
                                <select class="form-control" name="filtroLoteamiento" id="filtroLoteamiento">                                     
                                    <option value="0">Todos</option>
                                    
                                    @foreach($loteamientos as $lot)
                                        <option value="{{$lot->id}}">{{$lot->descripcion}}</option>
                        
                                    @endforeach
                                   
                                </select>
                                <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Filtrar</button>
                                </div>
                                {{Form::close()}}
                            </div>

                            <div class="col-md-4">
                                {!!Form::open(array('url'=>'inmueble','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <label class="col-md-4 form-control-label" for="rol">Estado</label>
                                <div class="input-group">
                                <select class="form-control" name="filtroEstado" id="filtroEstado">                                     
                                    <option value="0">Todos</option>
                                    
                                    @foreach($estados as $es)
                                        <option value="{{$es->id}}">{{$es->estado}}</option>
                        
                                    @endforeach
                                   
                                </select>
                                <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Filtrar</button>
                                </div>
                                {{Form::close()}}
                            </div>
                         </div>
                        <br>
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                            
                                            <tr>                                  
                                            <th  data-priority="1">ID</th>
                                            <th  data-priority="1">Nombre</th> 
                                            <th  data-priority="1">Tipo Inmueble</th> 
                                            <th  data-priority="1">Moneda</th> 
                                            <th  data-priority="1">Precio</th> 
                                            <th  data-priority="1">Estado</th> 
                                            <th  data-priority="1">Ver</th>
                                            <th  data-priority="1">Ver</th> 

                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($inmuebles as $inm)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            @if(($inm->est_des)=="VENDIDO")                                                                        
                                                <tr class="table-danger"> 
                                                @else
                                                <tr> 
                                            @endif                                   
                                                <td>{{$inm->id}}</td>
                                                <td>{{$inm->descripcion}}</td>
                                                <td>{{$inm->loteamiento}}</td> 
                                                <td>{{$inm->moneda}}</td> 
                                                <td>{{number_format(($inm->precio), 0, ",", ".")}}</td> 
                                                @if(($inm->est_des)=="VENDIDO")
                                                    <td ><button type="button" class="btn btn-danger btn-sm" >
                                                        <i class="fa fa-success fa-1x"></i> {{$inm->est_des}}</button><td>
                                                        @elseif (($inm->est_des)=="DISPONIBLE")
                                                            <td ><button type="button" class="btn btn-success btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> {{$inm->est_des}}</button><td>
                                                            @elseif (($inm->est_des)=="CANCELADO")
                                                                <td ><button type="button" class="btn btn-warning btn-sm" >
                                                                <i class="fa fa-success fa-1x"></i> {{$inm->est_des}}</button><td>
                                                                @else
                                                                    <td ><button type="button" class="btn btn-info btn-sm" >
                                                                    <i class="fa fa-success fa-1x"></i> {{$inm->est_des}}</button><td>
                                                            
                                                @endif
                                                    <!-- Detalles -->
                                                    
                                                    <a href="{{URL::action('App\Http\Controllers\InmuebleController@show', $inm->id)}}">
                                                        <button type="button" class="btn btn-success btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> Detalles
                                                        </button>
                                                    </a>

                                                </td> 
                                                <td>
                                                @if(($inm->est_des)=="VENDIDO")
                                                    <a href="{{URL::action('App\Http\Controllers\InmuebleController@detalleCuotasInm', $inm->id)}}">
                                                        <button type="button" class="btn btn-success btn-sm" >
                                                                <i class="fa fa-success fa-1x"></i> Cuotas
                                                        </button>
                                                    </a> 
                                                @endif 
                                                    <!-- Borrar -
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistro-{{$inm->id}}">
                                                        <i class="fa fa-times fa-1x"></i> Borrar
                                                    </button>
                                                     -->
                                                </td>                                                                         
                     
                                            </tr>  
                                            @include('inmueble.delete')
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
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Nuevo Inmueble</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('inmueble.store')}}" method="post" class="form-horizontal">
                                
                                        {{csrf_field()}}
                                        
                                        @include('inmueble.form')

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
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Actualizar Inmueble</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('inmueble.update','test')}}" method="post" class="form-horizontal">
                                        
                                        {{method_field('patch')}}
                                        {{csrf_field()}}

                                        <input type="hidden" id="id_inmueble" name="id_inmueble" value="">
                                        
                                        @include('inmueble.form')

                                    </form>                                  
                                </div>
                                
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

            {{$inmuebles->links()}} 
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
    <script src="{{ URL::asset('/assets/js/inmueble/show.js') }}"></script>
    {{-- <script src="{{ URL::asset('/assets/js/inmueble/cuotas.js') }}"></script> --}}
    <script src="{{ URL::asset('/assets/js/moment.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
        <!-- Table Editable plugin -->
    <script src="{{ URL::asset('/assets/libs/table-edits/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/table-editable.int.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/inmueble/show_tab.js') }}" defer></script>
        

 

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

