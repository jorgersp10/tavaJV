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
        @slot('title') A&M INOX - HIERROS @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">

                    <div class="card-header">
                       <h2>Cargar Venta</h2><br/>
                        
                    </div>

                    <div class="card-body">
                        <form action="{{route('proforma.calcularCuota')}}" method="post" class="form-horizontal">
                                                
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" name="desde" id="desde" value="tab_show">

                            <div class="container-fluid">
                            
                                <input type="hidden" id="precio_mue" name="precio_mue"  value=0>

                                <div class="row mt-3">
                                    
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-control-label" for="titulo">Cliente</label>
                                        <div class="form-group  col-xs-5 col-md-3">
                                            <select id='idcliente' name='idcliente' style= "width:400px">
                                                <option value="0">--Seleccionar Cliente </option>    
                                            </select>
                                        </div></br>
                                    </div></br>
                                    <div class="row mb-4">
                                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Producto/os</label>
                                        <div class="col-sm-6">
                                            <textarea type="text" id="producto" name="producto" class="form-control" placeholder="Ingrese el producto"></textarea>
                                            
                                        </div>
                                    </div>
                                        <div class="row mb-4">
                                            <div class="form-group  col-xs-5 col-md-3">
                                                <label for="precio">Precio del producto</label>                                
                                                <input type="text" class="form-control number3" name="precio_inm" id="precio_inm" placeholder="Precio del producto" required>
                                            </div>
                                            <div class="form-group  col-xs-5 col-md-3">
                                                <label for="tiempo">Tiempo en Meses</label>
                                                <input type="text" class="form-control" id="tiempo" name="tiempo" placeholder="Cantidad Meses" required>
                                            </div>
                                            <div class="form-group  col-xs-5 col-md-3">
                                                <label for="primer_vto">Primer Vto</label>
                                                <input type="date" class="form-control" id="primer_vto" name="primer_vto" value="{{ date('d-m-Y') }}" >
                                            </div>
                                            <div class="form-group  col-xs-5 col-md-3">
                                                <label for="interes">Tasa de Interes</label>
                                                <input type="text" class="form-control" id="interes" name="interes" placeholder="Tasa Interes" required>
                                            </div>
                                        </div>
                                        <br/>
                                        
                                        {{--Entrega y Vto Entrega --}}
                                        <div class="row mb-4">
                                            <div class="form-group  col-xs-5 col-md-3">
                                                <label for="entrega">Entrega</label>
                                                <input type="text" class="form-control number" id="entrega" name="entrega" placeholder="Monto Entrega">
                                            </div>
                                            <div class="form-group  col-xs-5 col-md-3">
                                                <label for="entrega_vto">Vto Entrega</label>
                                                <input type="date" class="form-control" id="entrega_vto" name="entrega_vto" value="{{ date('d-m-Y') }}">
                                            </div>
                                            <br/>
                                            {{--Refuerzo Cantidad Periodo y Vto Primer Refuerzo --}}
                                            <div class="form-group  col-xs-5 col-md-3">
                                                <label for="refuerzo">Importe de Refuerzos</label>
                                                <input type="text" class="form-control number2" name="refuerzo" id="refuerzo" placeholder="Importe de refuerzos">
                                            </div>
                                            <div class="form-group  col-xs-5 col-md-3">
                                                <label for="can_ref">Cantidad de Refuerzos</label>
                                                <input type="text" class="form-control" name="can_ref"  id="can_ref" placeholder="Cantidad Refuerzo">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="form-group  col-xs-5 col-md-3">
                                                <label for="per_ref">Periodo Ref.</label>
                                                <input type="text" class="form-control" name="per_ref" id="per_ref" placeholder="Cantidad Meses">
                                            </div>

                                            <div class="form-group  col-xs-5 col-md-3">
                                                <label for="refuerzo_vto">Vto 1er Ref.</label>
                                                <input type="date" class="form-control" name="refuerzo_vto" id="refuerzo_vto" value="{{ date('d-m-Y') }}"
                                                >
                                            </div>
                        
                                        </div></br>
                                        <div class="row mb-4">
                                            <div class="form-group  col-xs-5 col-md-3 mt-3">
                                                <div class="form-check form-switch ">
                                                    <input class="form-check-input" type="checkbox" id="con_iva" name="con_iva">
                                                    <label class="form-check-label" for="flexSwitchCheckDefault">Con Iva</label>
                                                </div>
                                            </div>
                                        </div>


                                        <br/>
                                        
                                        <div class="modal-footer">
                                                <button type="submitt" class="btn btn-primary" name="btnCalcular" id="btnCalcular">Calcular Cuotas </button>
                                        </div>                        
                                        <br/>

                                </div>
                            </div>
                        </form>                        
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
                
        </div><br>   
                     
    </main>

@endsection
@section('scripts')

<script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#idcliente').select2({
                ajax:{
                    url:"{{route('getClientesVen') }}",
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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

