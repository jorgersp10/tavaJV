<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orden Venta</title>
    <div id="body" class="body">

    <style>
        #seccion {
        height: 700px;
        }
        #encabezado{
        font-size: 12px;
        }
        #alturaDiv{
        font-size: 12px;
        height: 300px;
        }
        #cabecera{
        height: 120px;
        }
        #cabecera2{
        height: 370px;
        }
        #fecha{
        font-size: 13px;
        }
        #timbrado{
        font-size: 8px;
        }
        #dir{
        font-size: 8px;
        }
        #ruc{
        font-size: 12px;
        }
        #idtd{ border: 1px solid blue; width: 30px; word-wrap: break-word; }
        card-body {
            margin: 1cm 1cm 1cm;
        }

        th.titulo { 
            width: 100px !important;  
        }
            
        td.gfg { 
            word-break: break-all; 
        } 
        
        .alturatabla { 
                height: 140px !important; 
                margin: 0px 0px 0px 0px;
            }
        .Row
        {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-spacing: 10px;
        }
        .Column
        {
            display: table-cell;
        }
        .firma {
        float: right;
        }
        .total {
        float: right;
        font-size: 12px;
        }
        #numeroletra{
            padding-left: 120px;
            font-size: 12px;
        }
        th.cantidad { 
                width: 70px !important;  
        }
        td.desc { 
            width: 310px !important;  
        } 
        th.precioU { 
            width: 75px !important;  
        }
        th.exe { 
            width: 75px !important;  
        }
        th.cinco { 
            width: 75px !important;  
        }
        th.diez { 
            width: 75px !important;  
        }
        table{
            table-layout: fixed;
            width: 100%;
        }
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        word-wrap: break-word;
        }
        
    </style>

<section id="seccion">
        
        <div id="cabecera">
            <div class="Row">
                <div  class="Column" style="text-align:center;" id="timbrado">
                <img src="{{ public_path('assets/images/inox.jpg') }}" alt="logo" height="60px" width="150px" /><br>
                    <strong style="text-align:center;">Tomas R. Pereira C/ Avda Francia</strong> <br>
                    <strong style="text-align:center;">Tel.: (071) 207615 - (0986) 755440</strong> <br>
                    <strong style="text-align:center;">Encarnacion - Paraguay</strong> <br>
                </div>
                <div class="Column" id="ruc">
                    
                        <strong>RUC:</strong> 6698924-8<br>
                        <strong>ORDEN DE VENTA</strong><br>
                        <strong>NRO:</strong> {{$ventas[0]->nro_recibo}}<br>
                    
                </div>
                <div class="Column" id="ruc">
                    
                        <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                        <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                    
                </div>
        </div></br>
        
        <div class="Row">
            <div style="width:50%" class="Column" id="encabezado">                
                <strong>{{$diafecha}} de {{$mesLetra}} de {{$agefecha}}</strong><br>
                <strong>SEÑORES: {{$ventas[0]->nombre}} </strong><br>
                <strong>DIRECCION: {{$ventas[0]->direccion}} </strong><br>
            </div>
            <div class="Column" id="encabezado">
                
                <strong></strong><br>
                <strong></strong><br>
                <strong>TELEFONO: {{$ventas[0]->telefono}} </strong><br>
            </div>
            <div class="Column" id="encabezado">
                
                <strong></strong><br>
                <strong>RUC/CI: {{$ventas[0]->ruc}} -{{$ventas[0]->digito}}</strong><br>
            </div>
        </div>
        <div style="border: 1px solid #0F0807;" id="alturaDiv">
            <!-- <table class="table-borderless alturatabla> -->
            <table>
                <thead class = "table-light">
                    <tr>
                        <!-- <th class="titulo">TRANS.</th> -->
                        <th id="cant">CANT</th>
                        <th id="desc">DESCRIPCION</th>
                        <th id="precioU">PRECIO UNIT.</th>
                        <th id="diez">TOTAL</th>
                        
                    </tr>
                </thead>
                @foreach($detalles as $det)
                <tbody>
                        <tr>
                            <td style="text-align:center;" style="width:1%">{{$det->cantidad}}</td>
                            <td id="desc" style="width:60%">{{$det->producto}}</td>                    
                            <td id="exe" style="text-align:center;width:12%">{{number_format(($det->precio), 0, ",", ".")}}</td>
                            <td id="diez" style="text-align:center;width:15% ">{{number_format(($det->subtotal), 0, ",", ".")}}</td>
                        </tr>                              
                    
                </tbody>
                @endforeach
                
            </table><br>
            <img src="{{ public_path('assets/images/footerfact.png') }}" width="100%" />
        </div>
        <div id="encabezado">
            <table>
                <tr>
                        <td style="text-align:center;" style="width:1%"></td>
                        <td id="desc" style="width:40%"></td> 
                        <td colspan=2 id="exe" style="text-align:center;">SUBTOTALES</td>
                        <td id="cinco" style="width:50"></td>
                        <td id="cinco" style="width:50"></td>
                        <td id="diez" style="text-align:center;width:15% ">{{number_format(($ventas[0]->total), 0, ",", ".")}}</td>
                </tr>
                <tr>
                        <td style="text-align:center;" style="width:1%"></td>
                        <td id="desc" style="width:40%"></td>                    
                        <td colspan=2 id="exe" style="text-align:center;">TOTAL A PAGAR</td>
                        <td id="cinco" style="width:50"></td>
                        <td id="cinco" style="width:50"></td>
                        <td id="diez" style="text-align:center;width:15% ">{{number_format(($ventas[0]->total), 0, ",", ".")}}</td>
                            
                </tr>
            </table><br>
        </div>
        <div id="numeroletra">
            <strong></strong>TOTAL GUARANIES:{{$tot_pag_let}}<br>
        </div>
    </div>

</section> 

<!-- DUPLICADO DE FACTURA -->

<section id="seccion">
        
        <div id="cabecera">
            <div class="Row">
                <div  class="Column" style="text-align:center;" id="timbrado">
                <img src="{{ public_path('assets/images/inox.jpg') }}" alt="logo" height="60px" width="150px" /><br>
                    <strong style="text-align:center;">Tomas R. Pereira C/ Avda Francia</strong> <br>
                    <strong style="text-align:center;" >Tel.: (071) 207615 - (0986) 755440</strong> <br>
                    <strong style="text-align:center;">Encarnacion - Paraguay</strong> <br>
                </div>
                <div class="Column" id="ruc">
                    
                        <strong>RUC:</strong> 6698924-8<br>
                        <strong>ORDEN DE VENTA</strong><br>
                        <strong>NRO:</strong> {{$ventas[0]->nro_recibo}}<br>
                    
                </div>
                <div class="Column" id="ruc">
                    
                        <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                        <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                    
                </div>
        </div></br>
        
        <div class="Row">
            <div style="width:50%" class="Column" id="encabezado">                
                <strong>{{$diafecha}} de {{$mesLetra}} de {{$agefecha}}</strong><br>
                <strong>SEÑORES: {{$ventas[0]->nombre}} </strong><br>
                <strong>DIRECCION: {{$ventas[0]->direccion}} </strong><br>
            </div>
            <div class="Column" id="encabezado">
                
                <strong></strong><br>
                <strong></strong><br>
                <strong>TELEFONO: {{$ventas[0]->telefono}} </strong><br>
            </div>
            <div class="Column" id="encabezado">
                
                <strong></strong><br>
                <strong>RUC/CI: {{$ventas[0]->ruc}} -{{$ventas[0]->digito}}</strong><br>
            </div>
        </div>
        <div style="border: 1px solid #0F0807;" id="alturaDiv">
            <!-- <table class="table-borderless alturatabla> -->
            <table>
                <thead class = "table-light">
                    <tr>
                        <!-- <th class="titulo">TRANS.</th> -->
                        <th id="cant">CANT</th>
                        <th id="desc">DESCRIPCION</th>
                        <th id="precioU">PRECIO UNIT.</th>
                        <th id="diez">TOTAL</th>
                        
                    </tr>
                </thead>
                @foreach($detalles as $det)
                <tbody>
                        <tr>
                            <td style="text-align:center;" style="width:1%">{{$det->cantidad}}</td>
                            <td id="desc" style="width:60%">{{$det->producto}}</td>                    
                            <td id="exe" style="text-align:center;width:12%">{{number_format(($det->precio), 0, ",", ".")}}</td>
                            <td id="diez" style="text-align:center;width:15% ">{{number_format(($det->subtotal), 0, ",", ".")}}</td>
                        </tr>                              
                    
                </tbody>
                @endforeach
                
            </table><br>
            <img src="{{ public_path('assets/images/footerfact.png') }}" width="100%" />
        </div>
        <div id="encabezado">
            <table>
                <tr>
                        <td style="text-align:center;" style="width:1%"></td>
                        <td id="desc" style="width:40%"></td> 
                        <td colspan=2 id="exe" style="text-align:center;">SUBTOTALES</td>
                        <td id="cinco" style="width:50"></td>
                        <td id="cinco" style="width:50"></td>
                        <td id="diez" style="text-align:center;width:15% ">{{number_format(($ventas[0]->total), 0, ",", ".")}}</td>
                </tr>
                <tr>
                        <td style="text-align:center;" style="width:1%"></td>
                        <td id="desc" style="width:40%"></td>                    
                        <td colspan=2 id="exe" style="text-align:center;">TOTAL A PAGAR</td>
                        <td id="cinco" style="width:50"></td>
                        <td id="cinco" style="width:50"></td>
                        <td id="diez" style="text-align:center;width:15% ">{{number_format(($ventas[0]->total), 0, ",", ".")}}</td>
                            
                </tr>
            </table><br>
        </div>
        <div id="numeroletra">
            <strong></strong>TOTAL GUARANIES:{{$tot_pag_let}}<br>
        </div>
    </div>

</section>
          
</html>
