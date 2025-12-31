@extends('layouts.master')

@section('title') Compras @endsection

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

                       <h2>Factura de compra</h2><br/>
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>
                        @endif

                    </div>

                    <div class="card-body">
                        <form id="form_mora" action="{{route('compra.store')}}" method="POST">
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="col-md-4 form-control-label" for="precio">Empresa</label>
                                <select class="form-control" name="empresa_id" id="empresa_id">                                     
                                    <option value="0" disabled>Seleccione</option>                                    
                                    @foreach($empresas as $e)
                                        <option value="{{$e->id}}">{{$e->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="col-md-4 form-control-label" for="cantidad">Fecha Factura</label>
                                <div class="mb-3">
                                    <input type="date" id="fecha" name="fecha" class="form-control" required>
                                </div>
                            </div>   
                            <div class="col-md-2">
                                <label class="col-md-4 form-control-label" for="documento">TIPO FACT</label>
                                
                                <div class="mb-3">
                                
                                    <select class="form-control" name="tipo_fact" id="tipo_fact">                                                                        
                                        <option disabled>Seleccione</option>
                                        <option value="1">CRÉDITO</option>
                                        <option value="0">CONTADO</option>

                                    </select>
                                
                                </div>
                            </div>   
                            <div class="col-md-2">
                                <label class="col-md-4 form-control-label" for="cantidad">N° PAGOS</label>
                                <div class="mb-3">
                                    <input type="number" id="cuota" name="cuota" class="form-control" placeholder="Ingrese cant. de pagos">
                                </div>
                            </div>                                                
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="rol">Proveedor</label>
                                <div class="mb-3">
                                    <select class="form-control" name="proveedor_id" id="proveedor_id" style= "width:100%">
                                        <option value="0" disabled>Seleccionar Proveedor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-md-6 form-control-label" for="rol">Agregar Proveedor</label>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#abrirmodalProv">Nuevo</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-md-3 form-control-label" for="precio">N° Factura</label>
                                <div class="mb-3">
                                    <input type="text" id="fact_compra" name="fact_compra" class="form-control" placeholder="Ingrese nro de factura" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="col-md-3 form-control-label" for="precio">Timbrado</label>
                                <div class="mb-3">
                                    <input type="text" id="timbrado" name="timbrado" class="form-control" placeholder="Ingrese nro de timbrado" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-4 form-control-label" for="cantidad">Fecha Timbrado</label>
                                <div class="mb-3">
                                    <input type="date" id="fecha_timbrado" name="fecha_timbrado" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-6 form-control-label" for="precio">Tildar si tiene valor contable</label>
                                <div class="col-sm-3 form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="contable" name="contable">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Contable</label>
                                </div>
                            </div>
                        </div><br>
                        <div class="form-group row border">
                            <div class="col-md-5">
                            <label class="col-md-3 form-control-label" for="nombre">Producto</label>
                            <div class="mb-3">
                                    <select class="form-control" name="producto_id" id="producto_id" onchange="obtenerPrecio()" style= "width:100%">
                                        <option value="0" disabled>Seleccionar Producto</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-md-4 form-control-label" for="cantidad">Cantidad</label>
                                <div class="mb-3">
                                    <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="Ingrese cantidad">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="precio">Precio</label>
                                <div class="mb-3">
                                    <input type="text" id="precio" name="precio" class="form-control number" placeholder="Ingrese precio">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-md-6 form-control-label" for="precio">Descuento</label>
                                <div class="mb-3">
                                    <input type="text" id="descuento" name="descuento" value="0" class="form-control number2"
                                        placeholder="Ingrese descuento">
                                </div>
                            </div>
                             <div hidden class="col-md-3">
                                <label class="col-md-3 form-control-label" for="precio">IVA</label>
                                <div class="mb-3">
                                    <input readonly type="text" id="iva" name="iva" class="form-control" placeholder="Iva">
                                </div>
                            </div>
                            <div class="col-md-3">
                            <label class="col-md-3 form-control-label" for="precio"></label>
                                <div class="mb-3">
                                    <button type="button" id="agregar" class="btn btn-primary"><i class="fa fa-plus fa-1x"></i> Agregar detalle</button>
                                </div>
                            </div>
                        </div><br>
                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Descripción de Fact.</label>
                            <div class="col-sm-9">
                                <textarea id="descripcion_fact"  name="descripcion_fact" class="form-control" placeholder="Ingrese descripcion de la factura ..." required></textarea>    
                            </div>
                        </div>
                        <div class="form-group row border">

                            <h3>Lista de Compras a Proveedores</h3>

                            <div class="table-responsive col-md-12">
                                <table id="detalles" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>Eliminar</th>
                                            <th>Producto</th>
                                            <th>Precio(Gs)</th>
                                            <th>Cantidad</th>
                                            <th>Descuento</th>
                                            <th>SubTotal (Gs)</th>
                                        </tr>
                                    </thead>
                                    <tfoot>                             
                                        <tr>
                                            <th  colspan="5"><p align="right">TOTAL:</p></th>
                                            <th><p align="right"><span id="total_html">Gs. 0.00</span>
                                                <input type="hidden" name="total" id="total"></th>
                                                
                                        </tr>

                                        <tr>
                                            <th colspan="5"><p align="right">TOTAL IVA (5%):</p></th>
                                            <th><p align="right"><span id="total_iva_5_html">Gs. 0.00</span><input type="hidden" name="total_iva_5" id="total_iva_5"></p></th>
                                        </tr>

                                        <tr>
                                            <th colspan="5"><p align="right">TOTAL IVA (10%):</p></th>
                                            <th><p align="right"><span id="total_iva_10_html">Gs. 0.00</span><input type="hidden" name="total_iva_10" id="total_iva_10"></p></th>
                                        </tr>

                                        <tr>
                                            <th colspan="5"><p align="right">TOTAL IVA:</p></th>
                                            <th><p align="right"><span id="total_iva_html">Gs. 0.00</span><input type="hidden" name="total_iva" id="total_iva"></p></th>
                                        </tr>

                                        <tr>
                                            <th colspan="5"><p align="right">TOTAL EXENTA:</p></th>
                                            <th><p align="right"><span id="total_exenta_html">Gs. 0.00</span><input type="hidden" name="total_exenta" id="total_exenta"></p></th>
                                        </tr>

                                        <tr>
                                            <th colspan="5">
                                                <p align="right">ENTREGA:</p>
                                            </th>
                                            <th>
                                                <p align="right"><span align="right" id="entrega_html">Gs. 0.00</span>
                                                    <input type="hidden" name="total_entrega" id="total_entrega">
                                                </p>
                                            </th>
                                        </tr>

                                        <tr>
                                            <th  colspan="5"><p align="right">TOTAL PAGAR:</p></th>
                                            <th><p align="right"><span align="right" id="total_pagar_html">Gs. 0.00</span> 
                                            <input type="hidden" name="total_pagar" id="total_pagar"></p></th>
                                        </tr>  
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            </div>
                            <div class="form-group row mb-5">
                                <div class="col-md-4">
                                    <label class="col-md-5 form-control-label" for="precio_cuota">Descuento Gral</label>
                                    <div class="mb-3">
                                        <input type="text" id="entrega" name="entrega" value="0" class="form-control number2">
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <label class="col-md-3 form-control-label" for="precio"></label>
                                    <div class="mb-3">
                                        <button type="button" id="agregar_entrega" class="btn btn-primary"><i
                                                class="fa fa-plus fa-1x"></i> Aplicar Descuento Gral</button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-md-3 form-control-label" for="precio"></label>
                                    <div class="mb-3">
                                        <button type="button" id="eliminar_entrega" class="btn btn-danger"><i
                                                class="fa fa-trash fa-1x"></i> Eliminar Descuento Gral</button>
                                    </div>
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

              <!--Inicio del modal agregar-->
              <div class="modal fade" id="abrirmodalProv" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalScrollableTitle">Nuevo Proveedor</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"
                              aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <form action="{{route('proveedor.store')}}" method="post" class="form-horizontal">
                            <input type="hidden" id="desde_factura" name="desde_factura" value=1 class="form-control">
                              {{csrf_field()}}
                              
                              @include('proveedor.form')

                          </form>                                    
                      </div>
                      
                  </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

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

<script>
    $(document).ready(function(){
        
        $("#agregar_entrega").click(function(){
   
            agregar_entrega();
        });
   
     });

        function agregar_entrega(){
            entrega= $("#entrega").val();
            entrega = entrega.replaceAll(".","");
            console.log("Descuento Gral = "+entrega);
            total_total= $("#total").val();
            console.log("TOTAL = "+total_total);
            total_pagar_nuevo= total_total - entrega;
            console.log("TOTAL NUEVO = "+total_pagar_nuevo);
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

            $("#total_pagar_html").html("Gs. " + formatNumber.new(total_pagar_nuevo));
            $("#total_pagar").val(total_pagar_nuevo);

            $("#entrega_html").html("Gs. " + formatNumber.new(entrega));
            $("#total_entrega").val(entrega);

        }
</script>

<script>
    $(document).ready(function(){
        
        $("#eliminar_entrega").click(function(){
   
            eliminar_entrega();
        });
   
     });

        function eliminar_entrega(){
            entrega= $("#entrega").val();
            entrega = entrega.replaceAll(".","");

            total_total= $("#total").val();
            //total_total = total_total.replaceAll(".","");           

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

            $("#total_pagar_html").html("Gs. " + formatNumber.new(total_total));
            $("#total_pagar").val(total_total);

            $("#entrega_html").html("Gs. " + 0);
            $("#total_entrega").val(0);
            $("#entrega").val(0);

        }
</script>

<script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#producto_id').select2({
                ajax:{
                    url:"{{route('getProductosCompra') }}",
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
      total_iva5=0;
      total_iva10=0;
      total_exenta=0;
      subtotal=[];
      iva_linea=[];
      iva_aux=[];
      exenta=0;
      totalVista=0;
      subtotalVista=[];

      $("#guardar").hide();
   
        function agregar(){
   
             producto_id= $("#producto_id").val();
             producto= $("#producto_id option:selected").text();
             cantidad= $("#cantidad").val();
             precio= $("#precio").val();
             descuento= $("#descuento").val();
             descuento=descuento.replaceAll(".","");
             stockpro = $("#stock").val();
             precio_minimo= $("#precio_min").val();
             precio_maximo= $("#precio_max").val();
             iva=$("#iva").val();

             entrega= $("#entrega").val();
             entregaFinal = entrega.replaceAll(".","");

             if(parseFloat(stockpro) < parseFloat(cantidad)){
    
                Swal.fire({
                type: 'error',
                title: 'Cuidado',
                text: 'Stock insuficiente!'
                })
                
            }
             
            if(producto_id !="" && cantidad!="" && cantidad>0 && precio!="" && precio!="null"){
               precioFinal = precio.replaceAll(".","");
               subtotal[cont]=Math.round(cantidad*precioFinal) - descuento;
               if(iva == 11)
               {
                    console.log("entro 10");
                    iva_linea[cont] = Math.round(subtotal[cont] / iva);
                    total_iva10 = total_iva10 + iva_linea[cont];
                    iva_aux[cont] = iva;

               }
               if(iva == 21)
               {
                    console.log("entro 5");
                    iva_linea[cont]= Math.round(subtotal[cont] / iva);
                    total_iva5 = total_iva5 + iva_linea[cont];
                    iva_aux[cont] = iva;
               }

               if(iva == 1)
               {
                    console.log("entro EXT");
                    iva_linea[cont]= 0;
                    total_exenta = total_exenta + subtotal[cont];
                    iva_aux[cont] = iva;
               }
               total= total+subtotal[cont];

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
         
                
               var fila= '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar('+cont+
               ');"><i class="fa fa-times fa-2x"></i></button></td> <td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+
               '</td> <input type="hidden" name="servicio[]" value="'+producto+'"> <td><input style="width:75px" readonly type="text" id="precio[]" name="precio[]"  value="'+precio+
               '"> </td>  <td><input style="width:75px" readonly type="number" name="cantidad[]" value="'+cantidad+
               '"> </td> <td><input style="width:75px" readonly type="text" name="descuento[]" value="'+descuento+
               '"> </td> <td hidden ><input hidden readonly type="number" name="tipo_iva[]" value="'+iva+
               '"> </td> <td>Gs. '+subtotalVista[cont]+' </td></tr>';
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
           $("#total").val(total);  
           //IVA 10
           $("#total_iva_10_html").html("Gs. " + formatNumber.new(total_iva10));
           $("#total_iva_10").val(total_iva10);
           //IVA 5
           $("#total_iva_5_html").html("Gs. " + formatNumber.new(total_iva5));
           $("#total_iva_5").val(total_iva5);
            //TOTAL IVA
            total_iva = total_iva10 + total_iva5;
           $("#total_iva_html").html("Gs. " + formatNumber.new(total_iva));
           $("#total_iva").val(total_iva);

           $("#total_exenta_html").html("Gs. " + formatNumber.new(total_exenta));
           $("#total_exenta").val(total_exenta);

           $("#entrega_html").html("Gs. " + formatNumber.new(entregaFinal));
           $("#total_entrega").val(entregaFinal);

           total_pagar=total - entregaFinal;

           $("#total_pagar_html").html("Gs. " + formatNumber.new(total_pagar));
           $("#total_pagar").val(total_pagar);

           
           
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
           

           console.log("ivalineaBorrado= "+iva_linea[index]);
     

           total_pagar_html = total;
          
           $("#total_html").html("Gs." + total);

           

           if(iva_aux[index]==21)
           {
                total_iva5=(total_iva5) - iva_linea[index];
                $("#total_iva_5_html").html("Gs." + total_iva5);
                $("#total_iva_5").val(total_iva5);

           }

           if(iva_aux[index]==11)
           {
                total_iva10=(total_iva10) - iva_linea[index];
                $("#total_iva_10_html").html("Gs." + total_iva10);
                $("#total_iva_10").val(total_iva10);

           }

           if(iva_aux[index]==1)
           {
                total_exenta=(total_exenta) - subtotal[index];
                $("#total_exenta_html").html("Gs." + total_exenta);
                $("#total_exenta").val(total_exenta);

           }

           total_iva=total_iva - iva_linea[index];
           $("#total_iva_html").html("Gs." + total_iva);
           $("#total_iva").val(total_iva);

           console.log("Total_iva= "+total_iva);
           console.log("iva5= "+total_iva5);
           console.log("iva10= "+total_iva10);
           console.log("EXENTA= "+total_exenta);
           console.log("***************");
           

           $("#total_pagar_html").html("Gs." + total_pagar_html);
           $("#total_pagar").val(total_pagar_html);
           $("#entrega_html").html("Gs. " + 0);
           $("#total_entrega").val(0);
          
           $("#fila" + index).remove();
           evaluar();
        }
   
</script>
<script>

    function obtenerPrecio()//funcion para enviar datos de la empresa al form
    {
        
        var producto_id = document.getElementById("producto_id").value //aca nos trae el id del medidor para consultar  
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                    }
                });

        $.ajax({
                //headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type:  'post',
                dataType: 'json',
                data:  {producto_id:producto_id},
                url:   '{{ url('/obtenerPrecio') }}', //URL que indica la ruta en web.php                                    
                        
                success:  function (data) {

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
                    //let numero1 =  (data.var[0].precio_venta).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    document.getElementById("iva").value = data.var[0].iva;
                    
                }
                
        });
        
    }

</script>

<script>
    $(document).ready(function(){
   
        $("#tipo_fact").change( function() {
            if ($(this).val() === "0") {
                $("#cuota").prop("readonly", true);
            } else {
                $("#cuota").prop("readonly", false);
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
