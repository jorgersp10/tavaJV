@extends('layouts.master')

@section('title') Ventas @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <meta name='csrf-token' content="{{ csrf_token() }}">
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

                    <div class="card-body">
                       <h2>Ventas</h2><br/>
                       
                       <!-- <div class="form-group row ">
                        <div class="col-md-6">

                        </div>
                            <form action="{{route('venta.index')}}" method="get" class="form-horizontal">
                                {{csrf_field()}}
    
                                <label class="col-md-2 form-control-label" for="titulo">Cliente</label>
                                
            
                                <select id='idCliente' name='idCliente' style= "width:400px">
                                    <option value="0">--Seleccionar Cliente </option>    
                                </select>
                                <div class="col-md-4">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Encontrar Inmuebles</button>
                                </div>
                            </form>

                         </div>
                        </div> -->
                    <h4>Productos</h4><br/>
                    <div >
                        <div class="table-responsive mb-0" >
                            <table id="tech-companies-1" class="table table-striped">                               
                                <thead>                            
                                        <tr>                                  
                                        <th >ID</th>
                                        <th >Descripcion</th>  
                                        <th >Comprador</th> 
                                        <th >Precio</th> 
                                        <th >Vender</th> 

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($proforma as $pro)
                                        <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                        Asi cada usuario solo puede ver datos de su empresa -->
                                    
                                        <tr>                                    
                                            <td>{{$pro->id}}</td>
                                            <td>{{$pro->producto}}</td> 
                                            <td>{{$pro->nombre}}</td>
                                            <td>{{number_format(($pro->precio_inm), 0, ",", ".")}}</td>
                                            <td>
                                                <a href="{{URL::action('App\Http\Controllers\VentaController@show', $pro->id)}}">
                                                    <button type="button" class="btn btn-success btn-sm" >
                                                        <i class="fa fa-success fa-1x"></i> Vender
                                                    </button>
                                                </a>
                                            </td>
                                            
                    
                                        </tr>  
                                        
                                    @endforeach

                                </tbody>
                            </table>
                            
                        </div> 
                    </div><br/> 

                        
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
                

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

    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/moment.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
        <!-- Table Editable plugin -->
    <script src="{{ URL::asset('/assets/libs/table-edits/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/table-editable.int.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#idCliente').select2({
                ajax:{
                    url:"{{route('getClientesVen') }}",
                    type: 'post',
                    dataType: 'json',
                    delay: 100,
                    data: function(params){
                        return{
                            _token: CSRF_TOKEN,
                            search:params.term
                        }
                    },
                    processResults: function(response){
                        return{
                            results: response
                        }
                    },
                    cache: true
                }
            });
        });
    
    </script>
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


