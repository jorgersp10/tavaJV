@extends('layouts.master')

@section('title') Cheques @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <meta name='csrf-token' content="{{ csrf_token() }}">
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

                       <h2>Detalles Cheque N° {{$cheques->nro_cheque}}</h2><br/>
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>
                        @endif

                    </div>

                    <div class="card-body">
                        <input type="hidden" id="id" name="id"  value="{{$cheques->id}}">
                        <input type="hidden" id="banco_id_hidden" name="banco_id_hidden"  value="{{$cheques->banco_id}}">
                        <input type="hidden" id="librador_id_hidden" name="librador_id_hidden"  value="{{$cheques->librador_id}}">
                       
                        <input type="hidden" id="tipo_cheque_id_hidden" name="tipo_cheque_id_hidden"  value="{{$cheques->tipo_cheque_id}}">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="col-md-3 form-control-label" for="nro_cheque">N° Cheque</label>
                                    <div class="mb-3">
                                        <input readonly type="text" id="nro_cheque" name="nro_cheque" class="form-control" value="{{$cheques->nro_cheque}}" placeholder="Ingrese número" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-3 form-control-label" for="banco">Banco</label>
                                    <input readonly type="text" id="banco" name="banco" class="form-control" value="{{$cheques->banco}}">
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-5 form-control-label" for="tipo_cheque">Tipo Cheque</label>
                                    <input readonly type="text" id="tipo_cheque" name="tipo_cheque" class="form-control" value="{{$cheques->tipo_cheque}}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                    <label class="col-md-3 form-control-label" for="cuenta_corriente">Cuenta Corriente N°</label>
                                    <div class="col-md-5">
                                    
                                    <input readonly type="text" class="form-control" id="cuenta_corriente" name="cuenta_corriente" value="{{$cheques->nro_cuenta}}" placeholder="Ingrese número de cuenta">
                                        
                                    </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                    <label class="col-md-5 form-control-label" for="tipo_cheque">A la orden de:</label>
                                    <input readonly type="text" id="librador" name="librador" class="form-control" value="{{$cheques->librador}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                    <label class="col-md-5 form-control-label" for="importe_cheque">Importe</label>
                                    <input readonly type="text" id="importe_cheque" name="importe_cheque" class="form-control" value="{{number_format(($cheques->importe_cheque), 0, ",", ".")}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-md-5 form-control-label" for="fec_venc">Vencimiento</label>
                                    <div class="mb-3">
                                        <input readonly type="date" id="fec_venc" name="fec_venc" value="{{$cheques->fec_venc}}" class="form-control">
                                    </div>
                                </div>
                                 @php 
                                    if($cheques->estado == 1)
                                        $estadoCheque = "PENDIENTE";
                                    else
                                        $estadoCheque = "COBRADO";
                                @endphp
                                <div class="col-md-4">
                                    <label class="col-md-3 form-control-label" for="estado">Estado</label>
                                    <div class="mb-3">
                                        <input readonly type="text" id="estado" name="estado" class="form-control" value="{{$estadoCheque}}" required placeholder="Ingrese calificacion">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="col-md-5 form-control-label" for="user_id">Cargado por</label>
                                    <div class="mb-3">
                                        <input readonly type="text" id="user_id" name="user_id" class="form-control" value="{{$cheques->usuario}}" required placeholder="Ingrese calificacion">
                                    </div>
                                </div>
                            </div>
                           
                           
                                <div class="modal-footer">
                                 <a href={{ URL::previous() }} class="btn btn-info"> Volver</a>
                                </div>
                        </div>
                    </div>
                </div>

        </div><br>   
                     
    </main>

@endsection
@section('script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        const number = document.querySelector('.number');
        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
        return n === '' ? n : Number(n).toLocaleString();
        }
        number.addEventListener('keyup', (e) => {
            const element = e.target;
            const value = element.value;
        element.value = formatNumber(value);
        });
    </script>
     <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#librador_id').select2({
                ajax:{
                    url:"{{route('getClientesLib') }}",
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
     <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#endosante_id').select2({
                ajax:{
                    url:"{{route('getClientesEnd') }}",
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
    <script src="{{ URL::asset('/assets/js/cheque/show.js') }}"></script>
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