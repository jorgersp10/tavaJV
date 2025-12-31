@php
    $sis_desde="";
    $extension='layouts.master';
    $tit_desde='A&M INOX - HIERROS';
    $sis_desde=session()->get('sis_desde');
    if ($sis_desde == "electro")
    {
        $extension='layouts.masterElectro';
        $tit_desde='ELECTRODOMESTICOS';
    }
@endphp

@extends($extension)

@section('title') Productos @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') INICIO @endslot
        @slot('title') {{$tit_desde}} @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">

                    <div class="card-header">
                        <h2>Lista de Productos con problemas de stock</h2><br/>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                           
                         </div>
                        <br>
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">                              
                             
                                    <thead>                            
                                        <tr>                            
                                            <th  data-priority="1">Codigo</th>
                                            <th  data-priority="1">Nombre</th> 
                                            <th  data-priority="1">Stock</th> 
                                            <th  data-priority="1">Stock Inicial</th>
                                            <th  data-priority="1">Compra</th> 
                                            <th  data-priority="1">Venta</th> 
                                            <th  data-priority="1">Saldo STOCK</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($product as $prod)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                            <tr>
                                                <td>{{$prod->ArtCode}}</td>
                                                <td>{{$prod->descripcion}}</td>
                                                <td>{{$prod->stock}}</td> 
                                                <td>{{$prod->stock_inicial}}</td> 
                                                <td>{{$prod->compras}}</td> 
                                                <td>{{$prod->ventas}}</td> 
                                                <td>{{$prod->saldo_pro}}</td>                             
                     
                                            </tr>
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                                
                            </div> 
                        </div> 
                        
                    </div>
                </div>
         
        </div><br>   
                     
    </main>

@endsection
@section('script')

    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                language: {
                    decimal: ',',
                    thousands: '.',
                },
            });
        });
    </script>

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

