@extends('layouts.master')

@section('title') Cheques @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') A&M INOX - HIERROS @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                       <h2>Lista de Cheques Emitidos</h2><br/>
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>    
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>    
                        @endif
                        <a href="cheque_emitido/create">
                            <button type="button" class="btn btn-primary waves-effect waves-light">Agregar Cheque</button>
                        </a>
                    </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'cheque','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                                            <th  data-priority="1">Borrar</th>
                                            <th  data-priority="1">Ver</th>
                                            <!-- <th  data-priority="1">Editar</th>    -->
                                            <th  data-priority="1">Estado</th> 
                                            <th  data-priority="1">Cambiar Estado</th>                            
                                            <th  data-priority="1">N° Cheque</th>
                                            <th  data-priority="1">A la orden de</th> 
                                            <th  data-priority="1">Importe</th>
                                            <th  data-priority="1">Tipo Cheque</th>
                                            <th  data-priority="1">Banco</th> 
                                            <th  data-priority="1">Cta. Cte. N°</th>
                                            <th  data-priority="1">Autor</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($cheques as $c)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>
                                                <td>
                                    
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistro-{{$c->id}}">
                                                        <i class="fa fa-times fa-1x"></i> Borrar
                                                    </button>
                                    
                                                </td>                                                                         
                                                <td>
                                                    <a href="{{URL::action('App\Http\Controllers\Cheque_emitidoController@edit', $c->id)}}">
                                                        <button type="button" class="btn btn-info btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> ver
                                                        </button>
                                                    </a>
                                                </td>   
                                                <!-- <td>
                                                    <a href="{{URL::action('App\Http\Controllers\Cheque_emitidoController@show', $c->id)}}">
                                                        <button type="button" class="btn btn-success btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> Editar
                                                        </button>
                                                    </a>
                                                </td>  -->
                                                <td>                                      
                                                    @if($c->estado==0)
                                                        <button type="button" class="btn btn-primary btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> COBRADO
                                                        </button>

                                                    @else
                                                    <button type="button" class="btn btn-danger btn-sm" >
                                                            <i class="fa fa-success fa-1x"></i> PENDIENTE
                                                        </button>

                                                    @endif
                                                    
                                                    </td>
                                                    
                                                    <td>
                                                         @if($c->estado==1)
                                                            <button type="button" class="btn btn-danger btn-sm" data-id_cheque="{{$c->id}}" data-bs-toggle="modal" data-bs-target="#cambiarEstadoCheque">
                                                                <i class="fa fa-times fa-1x"></i> COBRAR CHEQUE
                                                            </button>

                                                            @else
                                                            <button type="button" class="btn btn-info btn-sm" data-id_cheque="{{$c->id}}" data-bs-toggle="modal" data-bs-target="#cambiarEstadoCheque">
                                                                <i class="fa fa-lock fa-1x"></i> CAMBIAR A PENDIENTE
                                                            </button>
                                                        @endif
                                                    
                                                    </td>
                                                <td>{{$c->nro_cheque}}</td>
                                                <td>{{$c->librador}}</td> 
                                                <td>Gs. {{number_format(($c->importe_cheque), 0, ",", ".")}}</td>
                                                @if($c->estado == 1)
                                                    <td>PENDIENTE</td>
                                                @else
                                                    <td>COBRADO</td>
                                                @endif
                                                <td>{{$c->tipo_cheque}}</td>
                                                <td>{{$c->banco}}</td>
                                                <td>{{$c->cuenta_corriente}}</td>
                                                
                                                <td>{{$c->usuario}}</td>                       
                                            </tr>  
                                            @include('cheque_emitido.delete')
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                                
                            </div> 
                        </div> 
                        
                    </div>
                </div>
            
            {{$cheques->links()}} 
        </div><br>   

         <!-- CAMBIAR DE ESTADO -->
             <div class="modal fade" id="cambiarEstadoCheque" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Cambiar Estado del Cheque</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form_mora" action="{{route('cobrarCheque')}}" method="POST">
                            {{csrf_field()}} 

                                <input type="hidden" id="id_cheque" name="id_cheque" value="">

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
                     
    </main>

@endsection
@section('script')

<script>
         /*INICIO ventana modal para cambiar estado de Compra*/
        
        $('#cambiarEstadoCheque').on('show.bs.modal', function (event) {
       
       //console.log('modal abierto');
       
       var button = $(event.relatedTarget) 
       var id_cheque = button.data('id_cheque')
       var modal = $(this)
       // modal.find('.modal-title').text('New message to ' + recipient)
       
       modal.find('.modal-body #id_cheque').val(id_cheque);
       })
        
       /*FIN ventana modal para cambiar estado de la compra*/
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