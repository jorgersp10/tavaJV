@extends('layouts.master')

@section('title') Gastos @endsection

@section('css')
        <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <meta name='csrf-token' content="{{ csrf_token() }}">
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

                       <h2>Factura de compra GASTOS</h2><br/>
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>
                        @endif

                    </div>

                    <div class="card-body">
                        <form id="form_mora" action="{{route('gasto.store')}}" method="POST">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="rol">Proveedor</label>

                                <div class="mb-3">

                                    <select class="form-control" name="proveedor_id" id="proveedor_id" style= "width:300px">

                                        <option value="0" disabled>Seleccionar Proveedor</option>

                                    </select>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="precio">N° Factura</label>
                                <div class="mb-3">
                                    <input type="text" id="fact_compra" name="fact_compra" class="form-control" placeholder="Ingrese nro de factura" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-5 form-control-label" for="precio">Tildar si tiene valor contable</label>
                                <div class="col-sm-3 form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="contable" name="contable">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Contable</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-5">
                            <label class="col-md-3 form-control-label" for="nombre">Concepto</label>
                            <div class="mb-3">
                                    <select class="form-control" name="concepto_id" id="concepto_id" style= "width:400px">

                                        <option value="0" disabled>Seleccionar Concepto</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="cantidad">Cantidad</label>
                                <div class="mb-3">
                                    <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="Ingrese cantidad">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="precio">Precio</label>
                                <div class="mb-3">
                                    <input type="text" id="precio" name="precio" class="form-control number" placeholder="Ingrese precio">
                                </div>
                            </div>
                            <div class="col-md-3">
                            <label class="col-md-3 form-control-label" for="precio"></label>
                                <div class="mb-3">
                                    <button type="button" id="agregar" class="btn btn-primary"><i class="fa fa-plus fa-1x"></i> Agregar detalle</button>
                                </div>
                            </div>
                        </div><br>
                        <div class="form-group row border">

                            <h3>Lista de Compras a Proveedores</h3>

                            <div class="table-responsive col-md-12">
                                <table id="detalles" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>Eliminar</th>
                                            <th>Concepto</th>
                                            <th>Precio(Gs)</th>
                                            <th>Cantidad</th>
                                            <th>SubTotal (Gs)</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th  colspan="4"><p align="right">TOTAL:</p></th>
                                            <th><p align="right"><span id="total_html">Gs. 0.00</span></th>
                                        </tr>

                                        <tr>
                                            <th colspan="4"><p align="right">TOTAL IVA (5%):</p></th>
                                            <th><p align="right"><span id="total_iva_5_html">Gs. 0.00</span><input type="hidden" name="total_iva_5" id="total_iva_5"></p></th>
                                        </tr>

                                        <tr>
                                            <th colspan="4"><p align="right">TOTAL IVA (10%):</p></th>
                                            <th><p align="right"><span id="total_iva_html">Gs. 0.00</span><input type="hidden" name="total_iva" id="total_iva"></p></th>
                                        </tr>

                                        <tr>
                                            <th  colspan="4"><p align="right">TOTAL PAGAR:</p></th>
                                            <th><p align="right"><span align="right" id="total_pagar_html">Gs. 0.00</span> <input type="hidden" name="total_pagar" id="total_pagar"></p></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            </div>

                            <div class="modal-footer form-group row" id="guardar">

                            <div class="col-md">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                                <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Registrar</button>

                            </div>

                        </div>
                        </form>
                    </div>
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

    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#proveedor_id').select2({
                ajax:{
                    url:"{{route('getProveedores') }}",
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
            $('#concepto_id').select2({
                ajax:{
                    url:"{{route('getConceptos') }}",
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
<script>

     $(document).ready(function(){

        $("#agregar").click(function(){

            agregar();
        });

     });

      var cont=0;
      total=0;
      subtotal=[];
      totalVista=0;
      subtotalVista=[];

      $("#guardar").hide();

        function agregar(){

             concepto_id= $("#concepto_id").val();
             producto= $("#concepto_id").val();
             cantidad= $("#cantidad").val();
             precio= $("#precio").val();
             console.log(precio);
             stockpro = $("#stock").val();
             precio_minimo= $("#precio_min").val();
             precio_maximo= $("#precio_max").val();
             iva=11;

             if(stockpro < cantidad){
                Swal.fire({
                type: 'error',
                title: 'Cuidado',
                text: 'Stock insuficiente!'
                })

            }

            if(concepto_id !="" && cantidad!="" && cantidad>0 && precio!=""){
               precioFinal = precio.replaceAll(".","");
               console.log(precioFinal);
               subtotal[cont]=Math.round(cantidad*precioFinal);
               total= total+subtotal[cont];
               console.log(subtotal[cont]);
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
               subtotalVista[cont]=formatNumber.new(subtotal[cont]);
               totalVista=formatNumber.new (total);
               console.log(subtotalVista[cont]);

               var fila= '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar('+cont+');"><i class="fa fa-times fa-2x"></i></button></td> <td><input type="hidden" name="concepto_id[]" value="'+concepto_id+'">'+producto+'</td> <td><input readonly type="text" id="precio[]" name="precio[]"  value="'+precio+'"> </td>  <td><input readonly type="number" name="cantidad[]" value="'+cantidad+'"> </td> <td>Gs. '+subtotalVista[cont]+' </td></tr>';
               cont++;
               limpiar();
               totales();

               evaluar();
               $('#detalles').append(fila);

               }else{

                   Swal.fire({
                   type: 'error',
                   //title: 'Oops...',
                   text: 'Rellene todos los campos del detalle de la venta',

                   })

               }

        }


        function limpiar(){

           $("#cantidad").val("");
           $("#precio").val("");


        }

        function totales(){

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

           $("#total_html").html("Gs. " + formatNumber.new(total));
           $("#total").html("Gs. " + total);
           //total_iva=total*iva/100;
           total_iva=Math.round(total/iva);
           total_pagar=total;
           $("#total_iva_html").html("Gs. " + formatNumber.new(total_iva));
           $("#total_pagar_html").html("Gs. " + formatNumber.new(total_pagar));
           $("#total_pagar").val(total_pagar);
           $("#total_iva").val(total_iva);

        }



        function evaluar(){

            if(total>0){

              $("#guardar").show();

            } else{

              $("#guardar").hide();
            }
        }

        function eliminar(index){

           total=total-subtotal[index];
           //total_iva= total*11/100;
           total_iva=Math.round(total/iva);
           total_pagar_html = total;

           $("#total_html").html("Gs." + total);
           $("#total_iva_html").html("Gs." + total_iva);
           $("#total_pagar_html").html("Gs." + total_pagar_html);
           $("#total_pagar").val(total_pagar_html);

           $("#fila" + index).remove();
           evaluar();
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
