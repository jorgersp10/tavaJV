@extends('layouts.master')

@section('title') Clientes @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') LABPROF GROUP @endslot
    @endcomponent
<main class="main">
            <!-- Breadcrumb -->
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Lista de Facturas Compra</h2><br/>                     
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>    
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>    
                        @endif
                   
                    </div>

                    <div class="card-body">
                        <form id="form_pago" action="{{route('pagarFactCompra')}}" method="POST"> 
                        {{csrf_field()}}  
                        <div class="row mb-4">
                            <div class="col-sm-9">
                                <input type="hidden"  id="id_factura" name="id_factura" value="{{$id}}" class="form-control">
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" id="saldo" name="saldo" value="{{$saldo_pagar}}" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Fact. N°</label>
                            <div class="col-sm-4">
                                <input readonly="readonly"type="text" value="{{$compras->fact_compra}}" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Proveedor</label>
                            <div class="col-sm-4">
                                <input readonly="readonly" type="text" value="{{$compras->nombre}}"  class="form-control">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Total</label>
                            <div class="col-sm-4">
                                <input readonly="readonly"type="text" value="Gs. {{number_format(($compras->total), 0, ",", ".")}}" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Saldo a Pagar</label>
                            <div class="col-sm-3">
                                <input readonly="readonly" type="text" value="Gs. {{number_format(($saldo_pagar), 0, ",", ".")}}" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Total Efectivo </label>
                            <div class="col-sm-3">
                                <input type="text" id="total_pagadof" name="total_pagadof" class="form-control number">
                            </div>
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nro Cheque </label>
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Banco </label>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Total Cheque </label>
                            <div class="col-sm-3">
                                <input type="text" id="total_pagadoch" name="total_pagadoch" class="form-control number2">
                            </div>
                            
                            <div class="col-sm-3">
                                <input type="text" id="nro_cheque" name="nro_cheque" class="form-control">
                            </div>
                            
                            <div class="col-sm-3">
                            <select class="form-control" name="ban_che_id" id="ban_che_id">                                     
                                <option value="0" readonly>Seleccione</option>                                
                                @foreach($bancos as $ban)
                                    <option value="{{$ban->id}}">{{$ban->descripcion}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Total T. Credito </label>
                            <div class="col-sm-3">
                                <input type="text" id="total_pagadotc" name="total_pagadotc" class="form-control number3">
                            </div>
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nro Tarjeta </label>
                            <div class="col-sm-3">
                                <input type="text" id="nro_tcredito" name="nro_tcredito" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Total T. Debito </label>
                            <div class="col-sm-3">
                                <input type="text" id="total_pagadotd" name="total_pagadotd" class="form-control number4">
                            </div>
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nro Tarjeta </label>
                            <div class="col-sm-3">
                                <input type="text" id="nro_tdebito" name="nro_tdebito" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Total Transferencia </label>
                            <div class="col-sm-3">
                                <input type="text" id="total_pagadotr" name="total_pagadotr" value=0 class="form-control number5">
                            </div>
                            <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">N° Cuenta.</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="cuenta_id" id="cuenta_id">                                     
                                    <option value="0">Seleccione</option>                                        
                                    @foreach($cuentas as $cc)
                                        <option value="{{$cc->id}}">{{$cc->nro_cuenta}} - {{$cc->banco}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button id="boton_guardar" type="submit" class="btn btn-primary" >Aceptar </button>
                        </div>

                    </form>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div> 
        </main>

@endsection
@section('script')

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

    <script>
         /*INICIO ventana modal para cambiar estado de Compra*/
        
        $('#cambiarEstadoCompra').on('show.bs.modal', function (event) {
       
       //console.log('modal abierto');
       
       var button = $(event.relatedTarget) 
       var id_compra = button.data('id_compra')
       var modal = $(this)
       // modal.find('.modal-title').text('New message to ' + recipient)
       
       modal.find('.modal-body #id_compra').val(id_compra);
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