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

                       <h2>Nuevo Cheque Emitido</h2><br/>
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>
                        @endif

                    </div>

                    <div class="card-body">
                        <form id="form_mora" action="{{route('cheque_emitido.store')}}" method="POST">
                            {{csrf_field()}} 
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="col-md-3 form-control-label" for="nro_cheque">N° Cheque</label>
                                    <div class="mb-3">
                                        <input type="text" id="nro_cheque" name="nro_cheque" class="form-control" placeholder="Ingrese número" evaluar(); required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-7 form-control-label" for="cuenta_corriente">Cuenta Corriente N°</label>
                                    <select class="form-control" name="cuenta_corriente" id="cuenta_corriente" onchange="obtenerBanco()">                                     
                                        <option value="0" readonly>Seleccione</option>                                    
                                        @foreach($cuentas_corriente as $cc)
                                            <option value="{{$cc->id}}">{{$cc->nro_cuenta}}</option>
                                        @endforeach
                                    </select>
                                </div>                               
                                <input type="hidden" id="banco_id" name="banco_id" class="form-control" placeholder="Ingrese número">
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="col-md-5 form-control-label" for="tipo_cheque_id">Tipo Cheque</label>
                                    <div class="mb-3">
                                        <select class="form-control" name="tipo_cheque_id" id="tipo_cheque_id">                                     
                                            <option value="0" disabled>Seleccione</option>                                    
                                            @foreach($tipo_cheques as $tc)
                                                <option value="{{$tc->id}}">{{$tc->tipo_cheque}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="col-md-5 form-control-label" for="importe_cheque">Importe</label>
                                    <div class="mb-3">
                                        <input type="text" id="importe_cheque" name="importe_cheque" class="form-control number" placeholder="Ingrese importe" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label class="col-md-6 form-control-label" for="librador_id">A la orden de:</label>
                                    
                                    <div class="mb-3">
                                    
                                        <select class="form-control" name="cliente_id" id="cliente_id" onchange="verificarCli(),evaluar()" style= "width:350px" requerid>
                                                                            
                                            <option value="0" disabled>Seleccionar Librador</option>

                                        </select>
                                    
                                    </div>

                                    <div class="mb-3">
                                    
                                        <select class="form-control" name="proveedor_id" id="proveedor_id" onchange="verificarPro(),evaluar()" style= "width:350px">
                                                                            
                                            <option value="0" disabled>Seleccionar Librador</option>

                                        </select>
                                    
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-5 form-control-label" for="fec_venc">Vencimiento</label>
                                    <div class="mb-3">
                                        <input type="date" id="fec_venc" name="fec_venc" class="form-control">
                                    </div>
                                </div>
                            </div>
                                
                            <div class="modal-footer" id="guardar">
                                <button type="submit" class="btn btn-light" href="{{ URL::previous() }}" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary"  >Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>

        </div><br>   
                     
    </main>

@endsection
@section('script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $("#guardar").hide();
    evaluar();
</script>
<script>

function obtenerBanco()//funcion para enviar datos de la empresa al form
    {
        
        var cuenta_corriente = document.getElementById("cuenta_corriente").value //aca nos trae el id del medidor para consultar  
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                    }
                });

        $.ajax({
                //headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type:  'post',
                dataType: 'json',
                data:  {cuenta_corriente:cuenta_corriente},
                url:   '{{ url('/obtenerBanco') }}', //URL que indica la ruta en web.php                                    
                        
                success:  function (data) {

                    console.log((data.var[0].banco_id));
                    //document.getElementById("banco").value = data.var[0].banco;
                    document.getElementById("banco_id").value = data.var[0].banco_id;
                    
                }
                
        });
        
    }

</script>

<script>
    function evaluar(){
        console.log("Entro aca");
        const cliente_id = document.getElementById('cliente_id').value;
        const proveedor_id = document.getElementById('proveedor_id').value;
            if(cliente_id > 0 || proveedor_id >0){
   
              $("#guardar").show();
   
            } else{
                 
              $("#guardar").hide();
            }
        }
</script>

<script>

function verificarCli()//funcion para enviar datos de la empresa al form
    {
        const cliente_id = document.getElementById('cliente_id').value;
        console.log(cliente_id);
        if(cliente_id > 0){
            proveedor_id.setAttribute('disabled','true');
        }     
        else   {
            proveedor_id.removeAttribute("disabled");
        } 
    }
function verificarPro()//funcion para enviar datos de la empresa al form
    {
        const proveedor_id = document.getElementById('proveedor_id').value;
        console.log(proveedor_id);
        if(proveedor_id > 0){
            cliente_id.setAttribute('disabled','true');
        }     
        else   {
            cliente_id.removeAttribute("disabled");
        } 
    }
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
     <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#cliente_id').select2({
                placeholder: 'Seleccione Cliente',
                allowClear: true,
                ajax:{
                    url:"{{route('getClienteEm') }}",
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
            $('#proveedor_id').select2({
                placeholder: 'Seleccione Proveedor',
                allowClear: true,
                ajax:{
                    url:"{{route('getProveedorEm') }}",
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