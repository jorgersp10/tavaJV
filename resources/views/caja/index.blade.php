@extends('layouts.master')

@section('title') Caja @endsection

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
                    <div class="card-header">
                       <h2>Caja N° {{$caja_nro}} - {{auth()->user()->name}}</h2><br/>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                  
                            <div class="row mb-6">
                                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Cliente</label>

                                    <select id='idcliente' name='idcliente' style= "width:400px">
                                        <option value="0">--Seleccionar Cliente </option>    
                                    </select>
                            </div>
                            <div>
                                <button type="submit" id="buscar_inmueble" class="btn btn-primary"> Buscar </button>
                            </div>
                         
                            <div class="table-responsive">
                                <table  class="table table-editable table-nowrap align-middle table-edits">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">N° Factura</th>
                                            <!-- <th data-priority="1">Moneda</th> -->
                                            <th data-priority="1">Importe</th>
                                            <th data-priority="1">Vencimiento</th>

                                            <th data-priority="1">Pagar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="clientes_inmuebles">
      
                    
                                    </tbody>
                                    
                                </table>
                                @include('caja.form_pago')
                            </div>                        
                    </div>
                </div>
        </div><br>   

                 
    </main>

@endsection
@section('script')
    <script type="text/javascript">
        
        $(document).ready(function() {
             $("#tipo_mov").select2({
                 placeholder:'Seleccione el Tipo de Mov.',
                 allowClear: true
             });
        });
    </script> 

    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#idcliente').select2({
                ajax:{
                    url:"{{route('getClientecaja') }}",
                    type: 'post',
                    dataType: 'json',
                    delay: 200,
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

        <script>
        const number1 = document.querySelector('.number1');
        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
        return n === '' ? n : Number(n).toLocaleString();
        }
        number1.addEventListener('keyup', (e) => {
            const element = e.target;
            const value = element.value;
        element.value = formatNumber(value);
        });
    </script>

        <script>
        const number2 = document.querySelector('.number2');
        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
        return n === '' ? n : Number(n).toLocaleString();
        }
        number2.addEventListener('keyup', (e) => {
            const element = e.target;
            const value = element.value;
        element.value = formatNumber(value);
        });
    </script>

        <script>
        const number3 = document.querySelector('.number3');
        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
        return n === '' ? n : Number(n).toLocaleString();
        }
        number3.addEventListener('keyup', (e) => {
            const element = e.target;
            const value = element.value;
        element.value = formatNumber(value);
        });
    </script>

        <script>
        const number4 = document.querySelector('.number4');
        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
        return n === '' ? n : Number(n).toLocaleString();
        }
        number4.addEventListener('keyup', (e) => {
            const element = e.target;
            const value = element.value;
        element.value = formatNumber(value);
        });
    </script>

        <script>
        const number5 = document.querySelector('.number5');
        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
        return n === '' ? n : Number(n).toLocaleString();
        }
        number5.addEventListener('keyup', (e) => {
            const element = e.target;
            const value = element.value;
        element.value = formatNumber(value);
        });
    </script>

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
    <script src="{{ URL::asset('/assets/js/caja/caja.js') }}" defer></script>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection