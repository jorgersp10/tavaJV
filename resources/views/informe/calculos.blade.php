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
        @slot('li_1') Tables @endslot
        @slot('title') A&M INOX - HIERROS @endslot
    @endcomponent
<main class="main">
            <!-- Breadcrumb -->
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Cálculo mensual</h2><br/>                     
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>    
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>    
                        @endif
                   
                    </div>

                    <div class="card-body">
                        
                        <form id="form_mora" action="{{route('informe.store')}}" method="POST"> 
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="col-md-5 form-control-label" for="cantidad">Total Venta</label>
                                    <div class="mb-3">
                                        <input type="text" id="tot_venta" name="tot_venta" class="form-control number" placeholder="Ingrese ventas">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-5 form-control-label" for="precio">Total compra</label>
                                    <div class="mb-3">
                                        <input type="text" id="tot_compra" name="tot_compra" class="form-control number2" placeholder="Ingrese compras">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-5 form-control-label" for="precio">Total gastos</label>
                                    <div class="mb-3">
                                        <input type="text" id="tot_gasto" name="tot_gasto" class="form-control number3" placeholder="Ingrese gastos">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="col-md-12 form-control-label" for="precio">Diferencia entre venta y lo demas</label>
                                    <div class="mb-3">
                                        <input type="text" id="tot_dif" name="tot_dif" class="form-control number4">
                                    </div>
                                </div>
                                 <div class="col-md-3"> 
                                    <label class="col-md-3 form-control-label" for="precio"></label> 
                                    <div class="mb-3">                 
                                        <button type="button" id="agregar" class="btn btn-primary"><i class="fa fa-plus fa-1x"></i> Calcular Diferencia</button>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="col-md-12 form-control-label" for="precio">Porcentaje</label>
                                    <div class="mb-3">
                                        <input type="text" id="porce" name="porce" class="form-control number4" placeholder="Ingrese %">
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <label class="col-md-3 form-control-label" for="precio"></label> 
                                    <div class="mb-3">                 
                                        <button type="button" id="resultado" class="btn btn-primary"><i class="fa fa-plus fa-1x"></i> Calcular Resultado</button>
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-md-4">
                                <label class="col-md-12 form-control-label" for="precio">Resultado Final</label>
                                <div class="mb-3">
                                    <input type="text" id="resul_final" name="resul_final" class="form-control number4">
                                </div>
                            </div>
                        </form>  
                    
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>

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
     
     $(document).ready(function(){
        
        $("#agregar").click(function(){
   
            agregar();
        });
   
     });
   
        function agregar(){
   
             total_ventas= $("#tot_venta").val();
             total_compras= $("#tot_compra").val();
             total_gastos= $("#tot_gasto").val();
         
             if(total_ventas =="" || total_compras=="" || total_gastos==""){
                Swal.fire({
                type: 'error',
                title: 'Cuidado',
                text: 'Complete todo los campos'
                })
                
            }else{
                ventas =  parseFloat(total_ventas.replaceAll(".",""));
                compras =  parseFloat(total_compras.replaceAll(".",""));
                gastos =  parseFloat(total_gastos.replaceAll(".",""));
                dif_total = ventas - (compras + gastos);

                //funcion para agregar separador de miles
               var formatNumber = {
                    separador: ".", // separador para los miles
                    sepDecimal: ',', // separador para los decimales
                    formatear:function (num){
                    num +='';
                    var splitStr = num.split('.');
                    var splitLeft = splitStr[0];
                    //var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
                    var regx = /(\d+)(\d{3})/;
                    while (regx.test(splitLeft)) {
                    splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
                    }
                    return this.simbol + splitLeft;
                    },
                    new:function(num, simbol){
                    this.simbol = simbol ||'';
                    return this.formatear(num);
                    }
                }

               //totales para la vista
                diferencia=formatNumber.new(dif_total);
                $("#tot_dif").val(diferencia);
            }
            
        }

    </script>

    <script>
     
     $(document).ready(function(){
        
        $("#resultado").click(function(){
   
            resultadp();
        });
   
     });

        function resultadp(){
   
             porcentaje= $("#porce").val();
             total_diferencia= $("#tot_dif").val();
         
             if(porcentaje =="" || total_diferencia ==""){
                Swal.fire({
                type: 'error',
                title: 'Cuidado',
                text: 'Ingrese porcentaje/diferencia'
                })
                
            }else{
                porcen =  parseFloat(porcentaje.replaceAll(".",""));
                difer =  parseFloat(total_diferencia.replaceAll(".",""));
                rest_tot = (difer*porcen)/100

                 //funcion para agregar separador de miles
               var formatNumber = {
                    separador: ".", // separador para los miles
                    sepDecimal: ',', // separador para los decimales
                    formatear:function (num){
                    num +='';
                    var splitStr = num.split('.');
                    var splitLeft = splitStr[0];
                    //var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
                    var regx = /(\d+)(\d{3})/;
                    while (regx.test(splitLeft)) {
                    splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
                    }
                    return this.simbol + splitLeft;
                    },
                    new:function(num, simbol){
                    this.simbol = simbol ||'';
                    return this.formatear(num);
                    }
                }

               //totales para la vista
                result_final=formatNumber.new(rest_tot);
                $("#resul_final").val(result_final);
            }
            
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
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
  
@endsection