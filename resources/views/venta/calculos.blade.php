@extends('layouts.master')

@section('title') Calculos para Venta @endsection

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
        <div class="card-body" data-content id="men_ven">

            <form action="{{route('proforma.calcularCuota')}}" method="post" class="form-horizontal">
                                    
                {{csrf_field()}}

                {{-- <input type="hidden" class="form-control" name="cuotas_arr" id="cuotas_arr"> --}}
                <input type="hidden" class="form-control" name="desde" id="desde" value="calculos">
                <input type="hidden" class="form-control" name="idcliente" id="idcliente" value=0>
                <input type="hidden" class="form-control" name="precio_mue" id="precio_mue" value=0>
    
                <div class="container-fluid">

    
                    <div class="row mt-3">
                        <div class="card-header">
                            <h2>Venta de Inmueble</h2>
                            {{--Precio plazo Entrega y Vto Entrega --}}
                        </div>
                            <div class="row">
                            <div class="form-group  col-xs-5 col-md-6">
                                <label class="col-md-2 form-control-label" for="titulo">Cliente</label>
                                <input type="text" class="form-control" name="cliente_nom" id="cliente_nom">
                            </div></br>
                            </div>

                             <div class="row">
                                <div class="form-group  col-xs-5 col-md-3">
                                    <label for="precio">Precio del Inmueble</label>
                                    <input type="text" class="form-control" name="precio_inm" id="precio_inm" >
                                </div>
                                <div class="form-group  col-xs-5 col-md-3">
                                    <label for="tiempo">Tiempo en Meses</label>
                                    <input type="text" class="form-control" id="tiempo" name="tiempo" placeholder="Cantidad Meses">
                                </div>
                                <div class="form-group  col-xs-5 col-md-3">
                                    <label for="primer_vto">Primer Vto</label>
                                    <input type="date" class="form-control" id="primer_vto" name="primer_vto" value="{{ date('d-m-Y') }}" >
                                </div>
                                <div class="form-group  col-xs-5 col-md-3">
                                    <label for="interes">Tasa de Interes</label>
                                    <input type="text" class="form-control" id="interes" name="interes" placeholder="Tasa Interes">
                                </div>
                            </div>
                            <br/>
                            
                            {{--Entrega y Vto Entrega --}}
                            <div class="row">
                                <div class="form-group  col-xs-5 col-md-3">
                                    <label for="entrega">Entrega</label>
                                    <input type="text" class="form-control" id="entrega" name="entrega" placeholder="Monto Entrega">
                                </div>
                                <div class="form-group  col-xs-5 col-md-3">
                                    <label for="entrega_vto">Vto Entrega</label>
                                    <input type="date" class="form-control" id="entrega_vto" name="entrega_vto" value="{{ date('d-m-Y') }}">
                                </div>
                                <br/>
                                {{--Refuerzo Cantidad Periodo y Vto Primer Refuerzo --}}
                                <div class="form-group  col-xs-5 col-md-3">
                                    <label for="refuerzo">Importe de Refuerzos</label>
                                    <input type="text" disabled class="form-control" name="refuerzo" id="refuerzo" >
                                </div>
                                <div class="form-group  col-xs-5 col-md-3">
                                    <label for="can_ref">Cantidad de Refuerzos</label>
                                    <input type="text" disabled class="form-control" name="can_ref"  id="can_ref" placeholder="Cantidad Refuerzo">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group  col-xs-5 col-md-3">
                                    <label for="per_ref">Periodo Ref.</label>
                                    <input type="text" disabled class="form-control" name="per_ref" id="per_ref" placeholder="Cantidad Meses">
                                </div>
    
                                <div class="form-group  col-xs-5 col-md-3">
                                    <label for="refuerzo_vto">Vto 1er Ref.</label>
                                    <input type="date"  disabled class="form-control" name="refuerzo_vto" id="refuerzo_vto" value="{{ date('d-m-Y') }}"
                                    >
                                </div>
                                <div class="form-group  col-xs-5 col-md-3">
                                    <label class="col-md-2 form-control-label">Moneda</label>
                                    <select style= "width:330px" class="form-control" name="mon" id="mon" required>                     
                                        <option value="GS">Guaranies</option>    
                                        <option value="US">Dolares</option>   
                                    </select>
                                </div>
                            </div>
      
    
                            <br/>
                            <div class="row">
                                <div class="form-group  col-xs-5 col-md-3 mt-3">
                                    <div class="form-check form-switch ">
                                        <input class="form-check-input" type="checkbox" id="con_iva" name="con_iva">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Con Iva</label>
                                    </div>
                                </div>
                         
                            </div>
                            
                            <div class="modal-footer">
                                <button type="submitt" class="btn btn-primary" name="btnCalcular" id="btnCalcular">Calcular Cuotas </button>
                        </div>                          
                            <br/>
    

    
                    </div>
                </div>
            </form>
        </div>  
                     
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


