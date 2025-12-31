@extends('layouts.master')

@section('title') Funcionarios @endsection

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
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
                                    

                <div class="card-header">

                    <h2>Comision</h2><br/>                     
                    
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                    
                        </div>
                    </div><br>
                    <form action="{{route('comision.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">                               
                        @csrf
                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Meta del mes</label>
                            <div class="col-sm-6">
                                <input type="text" id="meta" name="meta" class="form-control number1">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Total de la venta</label>
                            <div class="col-sm-6">
                                <input type="text" id="total_venta" name="total_venta" class="form-control number2">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">% Comision</label>
                            <div class="col-sm-6">
                                <input type="text" id="porcentaje_comi" name="porcentaje_comi" class="form-control" onBlur="obtenerComision()">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Fecha/Mes</label>
                            <div class="col-sm-6">
                                <input type="date" id="fecha" name="fecha" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Comision</label>
                            <div class="col-sm-6">
                                <input type="text" id="comision" name="comision" class="form-control number3">
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <a href="{{ url()->previous() }}">
                                <button type="button" class="btn btn-primary">Salir</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form> 
                    </div>
            </form>
        </div>
    </div>
</main>

@endsection

@section('script')
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

function obtenerComision()//funcion para enviar datos de la empresa al form
    {
        var meta = (document.getElementById("meta").value).replaceAll(".",""); //aca nos trae el id del medidor para consultar  
        var total_venta = (document.getElementById("total_venta").value).replaceAll(".",""); 
        var porc_comi = (document.getElementById("porcentaje_comi").value).replaceAll(".",""); 

        if(total_venta >= meta){
                diferencia = total_venta - meta
                com_mes = (diferencia * porc_comi)/100;
            }
            else
                com_mes = 0;
        document.getElementById("comision").value = com_mes;
        
    }

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
    
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection