<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Factura Venta</title>
    <div id="body" class="body">

    <style>
        #seccion {
            height: 400px;
            width: 800px
        }
        #encabezado{
        font-size: 10px;
        }
        #alturaDiv{
        font-size: 10px;
        height: 144px;
        }
        #alturaDiv2{
        margin-top: 3px;
        font-size: 10px;
        height: 138px;
        }
        #alturaDiv3{
        margin-top: 6px;
        font-size: 10px;
        height: 141px;
        }
        #alturaDet{
        height: 70px;
        }
        #cabecera{
        height: 128px;
        }
        #cabecera2{
        height: 236px;
        }
        #cabecera3{
        height: 346px;
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
            width: 200px !important;  
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
           
        </div></br>
        
        <div id="alturaDet" class="Row">
            <div class="Column" id="encabezado">                
                <strong></strong><br>
                <strong></strong><br>
                <strong></strong><br>
            </div>
            <div style="width:50%" class="Column" id="encabezado">                
                <strong>{{$diafecha}} de {{$mesLetra}} de {{$agefecha}}</strong><br>
                <strong>{{$ventas[0]->nombre}} </strong><br>
                <strong>{{$ventas[0]->ruc}} -{{$ventas[0]->digito}}</strong><br>
            </div>
            <div class="Column" id="encabezado">
                
                <strong></strong><br>
                <strong>{{$ventas[0]->telefono}}</strong><br>
                <strong> </strong><br>
            </div>
            <div class="Column" id="encabezado">
                @if($ventas[0]->tipo_factura == 0)
                    <strong>****-xx</strong><br>
                @else
                    <strong> </strong><br>
                    <strong>****-xx</strong><br>
                @endif
                <strong></strong><br>
                <strong></strong><br>
                
            </div>
        </div>
        <div style="border: 0px solid #0F0807;" id="alturaDiv">
            <!-- <table class="table-borderless alturatabla> -->
            <table style="border: 0px solid #0F0807;">
                <thead class = "table-light">
                    <tr style="border: 0px solid #0F0807;">
                        <th style="border: 0px solid #0F0807;"id="cant"></th>
                        <th style="border: 0px solid #0F0807;"id="cant"></th>
                        <!-- <th class="titulo">CUOTA NRO</th> -->
                        <th style="border: 0px solid #0F0807;"id="desc"></th>
                        <th style="border: 0px solid #0F0807;"id="precioU"></th>
                        <th style="border: 0px solid #0F0807;"id="exe"></th>
                        <th style="border: 0px solid #0F0807;"id="cinco"></th>
                        <th style="border: 0px solid #0F0807;"id="diez"></th>
                        
                    </tr>
                </thead>
                @php
                    $total_5 = 0;
                    $total_10 = 0;
                    $total_exenta = 0;
                @endphp
                @foreach($detalles as $det)
                <tbody style="border: 0px solid #0F0807;">
                        <tr>
                            <td style="border: 0px; width: 9%; padding-left: 17px;">{{$det->ArtCode}}</td>
                            <td style="border: 0px" style="width:1%">{{$det->cantidad}}</td>
                            <td id="desc" style="width:40%;border: 0px">{{$det->producto}}</td>                    
                            <td id="exe" style="text-align:center;width:12%;border: 0px">{{number_format(($det->precio), 0, ",", ".")}}</td>
                            @if($det->tipo_iva == 1)
                            <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($det->subtotal), 0, ",", ".")}}</td>
                            <td id="cinco" style="text-align:center;width:10%;border: 0px ">0</td>
                            <td id="diez" style="text-align:center;width:10% ;border: 0px">0</td>
                            @php
                                $total_exenta = $total_exenta + $det->subtotal;
                            @endphp
                            @endif
                            @if($det->tipo_iva == 21)
                            <td id="cinco" style="text-align:center;width:10%;border: 0px">0</td>
                            <td id="cinco" style="text-align:center;width:10%;border: 0px ">{{number_format(($det->subtotal), 0, ",", ".")}}</td>
                            <td id="diez" style="text-align:center;width:10%;border: 0px ">0</td>
                            @php
                                $total_5 = $total_5 + $det->subtotal;
                            @endphp
                            @endif
                            @if($det->tipo_iva == 11)
                            <td id="cinco" style="text-align:center;width:10%;border: 0px">0</td>
                            <td id="cinco" style="text-align:center;width:10%;border: 0px ">0</td>
                            <td id="diez" style="text-align:center;width:10%;border: 0px ">{{number_format(($det->subtotal), 0, ",", ".")}}</td>
                            @php
                                $total_10 = $total_10 + $det->subtotal;
                            @endphp
                            @endif
                        </tr>                              
                    
                </tbody>
                @endforeach
                
            </table><br>
            
        </div>
        <div id="encabezado">
            <table style="border: 0px solid #0F0807;">
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td id="desc" style="width:45%;border: 0px"></td>                    
                        <td id="exe" style="text-align:center;width:12%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($total_exenta), 0, ",", ".")}}</td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($total_5), 0, ",", ".")}}</td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($total_10), 0, ",", ".")}}</td>
                </tr>
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td id="desc" style="text-align:center;width:45%;border: 0px">{{$tot_pag_let}}</td>                    
                        <td id="exe" style="text-align:center;width:12%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($ventas[0]->total), 0, ",", ".")}}</td>
                </tr>
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td id="desc" style="width:40%;border: 0px"></td>                    
                        <td id="exe" style="width:12%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="width:10%;border: 0px"></td>
                </tr>
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px; width:20%" >.</td>
                        <td id="desc" style="width:12%;border: 0px">{{number_format(($ventas[0]->iva5), 0, ",", ".")}}</td>                    
                        <td id="exe" style="width:12%;border: 0px">{{number_format(($ventas[0]->iva10), 0, ",", ".")}}</td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="width:10%;border: 0px">{{number_format(($ventas[0]->ivaTotal), 0, ",", ".")}}</td>
                </tr>
                
            </table><br>
        </div>           
    </div>

</section> 

<!-- DUPLICADO DE FACTURA -->

<section id="seccion">
        
        <div id="cabecera2">
           
        </div></br>
        
        <div id="alturaDet" class="Row">
            <div class="Column" id="encabezado">                
                <strong></strong><br>
                <strong></strong><br>
                <strong></strong><br>
            </div>
            <div style="width:50%" class="Column" id="encabezado">                
                <strong>{{$diafecha}} de {{$mesLetra}} de {{$agefecha}}</strong><br>
                <strong>{{$ventas[0]->nombre}} </strong><br>
                <strong>{{$ventas[0]->ruc}} -{{$ventas[0]->digito}}</strong><br>
            </div>
            <div class="Column" id="encabezado">
                
                <strong></strong><br>
                <strong>{{$ventas[0]->telefono}}</strong><br>
                <strong> </strong><br>
            </div>
            <div class="Column" id="encabezado">
                @if($ventas[0]->tipo_factura == 0)
                    <strong>****-xx</strong><br>
                @else
                    <strong> </strong><br>
                    <strong>****-xx</strong><br>
                @endif
                <strong></strong><br>
                <strong></strong><br>
                
            </div>
        </div>
        <div style="border: 0px solid #0F0807;" id="alturaDiv">
            <!-- <table class="table-borderless alturatabla> -->
            <table style="border: 0px solid #0F0807;">
                <thead class = "table-light">
                    <tr style="border: 0px solid #0F0807;">
                        <th style="border: 0px solid #0F0807;"id="cant"></th>
                        <th style="border: 0px solid #0F0807;"id="cant"></th>
                        <!-- <th class="titulo">CUOTA NRO</th> -->
                        <th style="border: 0px solid #0F0807;"id="desc"></th>
                        <th style="border: 0px solid #0F0807;"id="precioU"></th>
                        <th style="border: 0px solid #0F0807;"id="exe"></th>
                        <th style="border: 0px solid #0F0807;"id="cinco"></th>
                        <th style="border: 0px solid #0F0807;"id="diez"></th>
                        
                    </tr>
                </thead>
                @php
                    $total_5 = 0;
                    $total_10 = 0;
                    $total_exenta = 0;
                @endphp
                @foreach($detalles as $det)
                <tbody style="border: 0px solid #0F0807;">
                        <tr>
                            <td style="border: 0px; width: 9%; padding-left: 20px;">{{$det->ArtCode}}</td>
                            <td style="border: 0px" style="width:1%">{{$det->cantidad}}</td>
                            <td id="desc" style="width:40%;border: 0px">{{$det->producto}}</td>                    
                            <td id="exe" style="text-align:center;width:12%;border: 0px">{{number_format(($det->precio), 0, ",", ".")}}</td>
                            @if($det->tipo_iva == 1)
                            <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($det->subtotal), 0, ",", ".")}}</td>
                            <td id="cinco" style="text-align:center;width:10%;border: 0px ">0</td>
                            <td id="diez" style="text-align:center;width:10% ;border: 0px">0</td>
                            @php
                                $total_exenta = $total_exenta + $det->subtotal;
                            @endphp
                            @endif
                            @if($det->tipo_iva == 21)
                            <td id="cinco" style="text-align:center;width:10%;border: 0px">0</td>
                            <td id="cinco" style="text-align:center;width:10%;border: 0px ">{{number_format(($det->subtotal), 0, ",", ".")}}</td>
                            <td id="diez" style="text-align:center;width:10%;border: 0px ">0</td>
                            @php
                                $total_5 = $total_5 + $det->subtotal;
                            @endphp
                            @endif
                            @if($det->tipo_iva == 11)
                            <td id="cinco" style="text-align:center;width:10%;border: 0px">0</td>
                            <td id="cinco" style="text-align:center;width:10%;border: 0px ">0</td>
                            <td id="diez" style="text-align:center;width:10%;border: 0px ">{{number_format(($det->subtotal), 0, ",", ".")}}</td>
                            @php
                                $total_10 = $total_10 + $det->subtotal;
                            @endphp
                            @endif
                        </tr>                              
                    
                </tbody>
                @endforeach
                
            </table><br>
            
        </div>
        <div id="encabezado">
            <table style="border: 0px solid #0F0807;">
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td id="desc" style="width:45%;border: 0px"></td>                    
                        <td id="exe" style="text-align:center;width:12%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($total_exenta), 0, ",", ".")}}</td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($total_5), 0, ",", ".")}}</td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($total_10), 0, ",", ".")}}</td>
                </tr>
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td id="desc" style="text-align:center;width:45%;border: 0px">{{$tot_pag_let}}</td>                    
                        <td id="exe" style="text-align:center;width:12%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($ventas[0]->total), 0, ",", ".")}}</td>
                </tr>
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td id="desc" style="width:40%;border: 0px"></td>                    
                        <td id="exe" style="width:12%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="width:10%;border: 0px"></td>
                </tr>
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px; width:20%" >.</td>
                        <td id="desc" style="width:12%;border: 0px">{{number_format(($ventas[0]->iva5), 0, ",", ".")}}</td>                    
                        <td id="exe" style="width:12%;border: 0px">{{number_format(($ventas[0]->iva10), 0, ",", ".")}}</td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="width:10%;border: 0px">{{number_format(($ventas[0]->ivaTotal), 0, ",", ".")}}</td>
                </tr>
                
            </table><br>
        </div>           
    </div>

</section> 

<!-- TRIPLICADO DE FACTURA -->

<section id="seccion">
        
        <div id="cabecera3">
           
        </div></br>
        
        <div id="alturaDet" class="Row">
            <div class="Column" id="encabezado">                
                <strong></strong><br>
                <strong></strong><br>
                <strong></strong><br>
            </div>
            <div style="width:50%" class="Column" id="encabezado">                
                <strong>{{$diafecha}} de {{$mesLetra}} de {{$agefecha}}</strong><br>
                <strong>{{$ventas[0]->nombre}} </strong><br>
                <strong>{{$ventas[0]->ruc}} -{{$ventas[0]->digito}}</strong><br>
            </div>
            <div class="Column" id="encabezado">
                
                <strong></strong><br>
                <strong>{{$ventas[0]->telefono}}</strong><br>
                <strong> </strong><br>
            </div>
            <div class="Column" id="encabezado">
                @if($ventas[0]->tipo_factura == 0)
                    <strong>****-xx</strong><br>
                @else
                    <strong> </strong><br>
                    <strong>****-xx</strong><br>
                @endif
                <strong></strong><br>
                <strong></strong><br>
                
            </div>
        </div>
        <div style="border: 0px solid #0F0807;" id="alturaDiv3">
            <!-- <table class="table-borderless alturatabla> -->
            <table style="border: 0px solid #0F0807;">
                <thead class = "table-light">
                    <tr style="border: 0px solid #0F0807;">
                        <th style="border: 0px solid #0F0807;"id="cant"></th>
                        <th style="border: 0px solid #0F0807;"id="cant"></th>
                        <!-- <th class="titulo">CUOTA NRO</th> -->
                        <th style="border: 0px solid #0F0807;"id="desc"></th>
                        <th style="border: 0px solid #0F0807;"id="precioU"></th>
                        <th style="border: 0px solid #0F0807;"id="exe"></th>
                        <th style="border: 0px solid #0F0807;"id="cinco"></th>
                        <th style="border: 0px solid #0F0807;"id="diez"></th>
                        
                    </tr>
                </thead>
                @php
                    $total_5 = 0;
                    $total_10 = 0;
                    $total_exenta = 0;
                @endphp
                @foreach($detalles as $det)
                <tbody style="border: 0px solid #0F0807;">
                        <tr>
                            <td style="border: 0px; width: 9%; padding-left: 18px;">{{$det->ArtCode}}</td>
                            <td style="border: 0px" style="width:1%">{{$det->cantidad}}</td>
                            <td id="desc" style="width:40%;border: 0px">{{$det->producto}}</td>                    
                            <td id="exe" style="text-align:center;width:12%;border: 0px">{{number_format(($det->precio), 0, ",", ".")}}</td>
                            @if($det->tipo_iva == 1)
                            <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($det->subtotal), 0, ",", ".")}}</td>
                            <td id="cinco" style="text-align:center;width:10%;border: 0px ">0</td>
                            <td id="diez" style="text-align:center;width:10% ;border: 0px">0</td>
                            @php
                                $total_exenta = $total_exenta + $det->subtotal;
                            @endphp
                            @endif
                            @if($det->tipo_iva == 21)
                            <td id="cinco" style="text-align:center;width:10%;border: 0px">0</td>
                            <td id="cinco" style="text-align:center;width:10%;border: 0px ">{{number_format(($det->subtotal), 0, ",", ".")}}</td>
                            <td id="diez" style="text-align:center;width:10%;border: 0px ">0</td>
                            @php
                                $total_5 = $total_5 + $det->subtotal;
                            @endphp
                            @endif
                            @if($det->tipo_iva == 11)
                            <td id="cinco" style="text-align:center;width:10%;border: 0px">0</td>
                            <td id="cinco" style="text-align:center;width:10%;border: 0px ">0</td>
                            <td id="diez" style="text-align:center;width:10%;border: 0px ">{{number_format(($det->subtotal), 0, ",", ".")}}</td>
                            @php
                                $total_10 = $total_10 + $det->subtotal;
                            @endphp
                            @endif
                        </tr>                              
                    
                </tbody>
                @endforeach
                
            </table><br>
            
        </div>
        <div id="encabezado">
            <table style="border: 0px solid #0F0807;">
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td id="desc" style="width:45%;border: 0px"></td>                    
                        <td id="exe" style="text-align:center;width:12%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($total_exenta), 0, ",", ".")}}</td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($total_5), 0, ",", ".")}}</td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($total_10), 0, ",", ".")}}</td>
                </tr>
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td id="desc" style="text-align:center;width:45%;border: 0px">{{$tot_pag_let}}</td>                    
                        <td id="exe" style="text-align:center;width:12%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px">{{number_format(($ventas[0]->total), 0, ",", ".")}}</td>
                </tr>
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td id="desc" style="width:40%;border: 0px"></td>                    
                        <td id="exe" style="width:12%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="width:10%;border: 0px"></td>
                </tr>
                <tr>
                        <td style="text-align:center;border: 0px" style="width:1%">.</td>
                        <td style="text-align:center;border: 0px; width:20%" >.</td>
                        <td id="desc" style="width:12%;border: 0px">{{number_format(($ventas[0]->iva5), 0, ",", ".")}}</td>                    
                        <td id="exe" style="width:12%;border: 0px">{{number_format(($ventas[0]->iva10), 0, ",", ".")}}</td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="text-align:center;width:10%;border: 0px"></td>
                        <td id="cinco" style="width:10%;border: 0px">{{number_format(($ventas[0]->ivaTotal), 0, ",", ".")}}</td>
                </tr>
                
            </table><br>
        </div>           
    </div>

</section> 


          
</html>
