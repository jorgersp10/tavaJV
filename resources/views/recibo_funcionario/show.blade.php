@extends('layouts.master')

@section('title') Recibos @endsection

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
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
                                    

                <div class="card-header">

                    <h2>Actualizar Liquidación de salarios</h2><br/>                     
                    
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                    
                        </div>
                    </div><br>
                    <form action="{{route('recibo_funcionario.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">                               
                    {{method_field('patch')}}
                    @csrf
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="rol">Empleado</label>
                                
                                <div class="mb-3">
                                
                                    <select class="form-control" name="funcionario_id" id="funcionario_id" value=" {{$recibos->funcionario_id}}" style= "width:330px" onchange="obtenerDatos()">
                                                                        
                                        @foreach($funcionarios as $f)
                                            <option value="{{$f->funcionario_id}}">{{$f->nombre}} - {{$f->num_documento}}</option>
                                        @endforeach 

                                    </select>
                                
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Salario Basico</label>
                            <div class="col-sm-6">
                                <input type="text" id="salario_basico" name="salario_basico" value=" {{number_format(($recibos->salario_basico), 0, ",", ".")}}" class="form-control number1">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Horas Extras</label>
                            <div class="col-sm-6">
                                <input type="text" id="horas_extra" name="horas_extra" class="form-control number3" value=" {{number_format(($recibos->horas_extra), 0, ",", ".")}}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Comision</label>
                            <div class="col-sm-6">
                                <input type="text" id="comisiones" name="comisiones" class="form-control number4" value=" {{number_format(($recibos->comisiones), 0, ",", ".")}}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Otros Ingresos</label>
                            <div class="col-sm-6">
                                <input type="text" id="otros_ingre" name="otros_ingre" class="form-control number5" value=" {{number_format(($recibos->otros_ingre), 0, ",", ".")}}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">IPS</label>
                            <div class="col-sm-6">
                                <input type="text" id="ips" name="ips" class="form-control" value=" {{number_format(($recibos->ips), 0, ",", ".")}}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Otros Descuentos</label>
                            <div class="col-sm-6">
                                <input type="text" id="otros_desc" name="otros_desc" class="form-control number6" onBlur="salarioFinal()" value=" {{number_format(($recibos->otros_desc), 0, ",", ".")}}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Salario a cobrar</label>
                            <div class="col-sm-6">
                                <input type="text" id="salario_cobrar" name="salario_cobrar" class="form-control number7" value=" {{number_format(($recibos->salario_cobrar), 0, ",", ".")}}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Fecha/Mes</label>
                            <div class="col-sm-6">
                                <input type="date" id="mes_pago" name="mes_pago" class="form-control" value={{$recibos->mes_pago}}>
                            </div>
                        </div>

                        <input type="hidden" id="funcionario_id_hidden" name="funcionario_id_hidden" 
                        value="{{$recibos->funcionario_id}}" class="form-control" >

                        <input type="hidden" id="id_recibo" name="id_recibo" 
                        value="{{$recibos->id_recibo}}" class="form-control" >

                        <div class="modal-footer">
                            <a href="{{ url()->previous() }}">
                                <button type="button" class="btn btn-primary">Salir</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</main>

@endsection

@section('script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function obtenerDatos()//funcion para enviar datos de la empresa al form
    {
        
        var funcionario_id = document.getElementById("funcionario_id").value //aca nos trae el id del medidor para consultar  
        console.log(funcionario_id);
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                    }
                });

        $.ajax({
                //headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type:  'post',
                dataType: 'json',
                data:  {funcionario_id:funcionario_id},
                url:   '{{ url('/obtenerDatos') }}', //URL que indica la ruta en web.php                                    
                        
                success:  function (data) {

                    console.log(data.var[0].ips);
                    //console.log(data.var[0].id);
                    //$("#cliente").html(data.var1[0].nombre);
                    //Aca se rellenan los input de arriba en el form
                    document.getElementById("salario_basico").value = data.var[0].salario_basico;
                    document.getElementById("ips").value = data.var[0].ips;
                    
                    
                    
                }
                
        });
        
    }

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
<script>
    const number6 = document.querySelector('.number6');

    function formatNumber (n) {
        n = String(n).replace(/\D/g, "");
    return n === '' ? n : Number(n).toLocaleString();
    }
    number6.addEventListener('keyup', (e) => {
        const element = e.target;
        const value = element.value;
    element.value = formatNumber(value);
    });
</script>
<script>
    const number7 = document.querySelector('.number7');

    function formatNumber (n) {
        n = String(n).replace(/\D/g, "");
    return n === '' ? n : Number(n).toLocaleString();
    }
    number7.addEventListener('keyup', (e) => {
        const element = e.target;
        const value = element.value;
    element.value = formatNumber(value);
    });
</script>

<script>

function salarioFinal()//funcion para enviar datos de la empresa al form
    {
        var salario_basico = (document.getElementById("salario_basico").value); //aca nos trae el id del medidor para consultar  
        var horas_extra = (document.getElementById("horas_extra").value); 
        var comision = (document.getElementById("comisiones").value); 
        var otros_ingre = (document.getElementById("otros_ingre").value); 
        var ips = (document.getElementById("ips").value); 
        var otros_desc = (document.getElementById("otros_desc").value); 
        
        total_ingre = salario_basico + horas_extra + comision + otros_ingre;
        total_desc = ips + otros_desc;
        salario_final = total_ingre - total_desc;
        document.getElementById("salario_cobrar").value = salario_final;
    }

</script>
        
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script> 
        <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/recibos_func/recibos_func.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
  
@endsection