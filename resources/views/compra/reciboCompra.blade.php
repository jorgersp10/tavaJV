<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo Compra</title>
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
        height: 150px;
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
                        <strong>RECIBO DE COMPRA</strong><br>
                        <strong>NRO:</strong> {{$compras->nro_recibo}}<br>
                    
                </div>
                <div class="Column" id="ruc">
                    
                        <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                        <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                        {{-- <strong>PAGO N°:</strong> {{$compras->nro_pago}}/{{$compras->cuota}}<br> --}}
                </div>
        </div></br>
        
        <div class="Row">
            <div style="width:50%" class="Column" id="encabezado">                
                <strong>{{$diafecha}} de {{$mesLetra}} de {{$agefecha}}</strong><br>
                <strong>SEÑORES: {{$compras->nombre}} </strong><br>
                <strong>DIRECCION: {{$compras->direccion}} </strong><br>
            </div>
            <div class="Column" id="encabezado">
                
                <strong></strong><br>
                <strong></strong><br>
                <strong>TELEFONO: {{$compras->telefono}} </strong><br>
            </div>
            <div class="Column" id="encabezado">
                
                <strong></strong><br>
                <strong>RUC/CI: {{$compras->ruc}}</strong><br>
            </div>
        </div>
        <div style="border: 1px solid #0F0807;" id="alturaDiv">
            <!-- <table class="table-borderless alturatabla> -->
            <table>
                <thead class = "table-light">
                    <tr>
                        <!-- <th class="titulo">TRANS.</th> -->
                        <th id="cant">FACT N°</th>
                        <th id="desc">PAGO N°</th>
                        <th id="precioU">IMPORTE</th>
                        
                    </tr>
                </thead>
                @foreach($pagos as $det)
                <tbody>
                        <tr>
                            <td style="text-align:center;" style="width:1%">{{$det->fact_compra}}</td>
                            @if($det->cuota == 0)
                            <td id="desc" style="width:20%">{{$det->nro_pago}} / 1</td> 
                            @else
                            <td id="desc" style="width:20%">{{$det->nro_pago}} / {{$det->cuota}}</td>  
                            @endif                      
                            <td id="exe" style="text-align:center;width:12%">{{number_format(($det->capital_pagado), 0, ",", ".")}}</td>
                        </tr>                              
                    
                </tbody>
                @endforeach
                
            </table><br>
            {{-- <img src="{{ public_path('assets/images/footerfact.png') }}" width="100%" /> --}}
        </div>
        <div id="encabezado" class="table-responsive">
            <h4>FORMAS DE PAGO</h4>
            <table class="table-borderless alturatabla2">
                <thead class = "table-light">
                    <tr>
                        <th class="titulo2">EFECTIVO</th>
                        <th class="titulo2">CHEQUE</th>
                        <th class="titulo2">T.CREDITO</th>
                        <th class="titulo2">T.DEBITO</th>
                        <th class="titulo2">TRANSFERENCIA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="center">Gs. {{number_format(($pagosDetalle->total_pagf), 0, ",", ".")}}</td>
                        <td align="center">Gs. {{number_format(($pagosDetalle->total_pagch), 0, ",", ".")}}</td>
                        <td align="center">Gs. {{number_format(($pagosDetalle->total_pagtc), 0, ",", ".")}}</td>
                        <td align="center">Gs. {{number_format(($pagosDetalle->total_pagtd), 0, ",", ".")}}</td>
                        <td align="center">Gs. {{number_format(($pagosDetalle->total_pagtr), 0, ",", ".")}}</td>
                    </tr>                              
                    
                </tbody>
                
            </table>
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
                        <strong>RECIBO DE COMPRA</strong><br>
                        <strong>NRO:</strong> {{$compras->nro_recibo}}<br>
                    
                </div>
                <div class="Column" id="ruc">
                    
                        <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                        <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                        {{-- <strong>PAGO N°:</strong> {{$compras->nro_pago}}/{{$compras->cuota}}<br> --}}
                </div>
        </div></br>
        
        <div class="Row">
            <div style="width:50%" class="Column" id="encabezado">                
                <strong>{{$diafecha}} de {{$mesLetra}} de {{$agefecha}}</strong><br>
                <strong>SEÑORES: {{$compras->nombre}} </strong><br>
                <strong>DIRECCION: {{$compras->direccion}} </strong><br>
            </div>
            <div class="Column" id="encabezado">
                
                <strong></strong><br>
                <strong></strong><br>
                <strong>TELEFONO: {{$compras->telefono}} </strong><br>
            </div>
            <div class="Column" id="encabezado">
                
                <strong></strong><br>
                <strong>RUC/CI: {{$compras->ruc}}</strong><br>
            </div>
        </div>
        <div style="border: 1px solid #0F0807;" id="alturaDiv">
            <!-- <table class="table-borderless alturatabla> -->
            <table>
                <thead class = "table-light">
                    <tr>
                        <!-- <th class="titulo">TRANS.</th> -->
                        <th id="cant">FACT N°</th>
                        <th id="desc">PAGO N°</th>
                        <th id="precioU">IMPORTE</th>
                        
                    </tr>
                </thead>
                @foreach($pagos as $det)
                <tbody>
                        <tr>
                            <td style="text-align:center;" style="width:1%">{{$det->fact_compra}}</td>
                            @if($det->cuota == 0)
                            <td id="desc" style="width:20%">{{$det->nro_pago}} / 1</td> 
                            @else
                            <td id="desc" style="width:20%">{{$det->nro_pago}} / {{$det->cuota}}</td>  
                            @endif                  
                            <td id="exe" style="text-align:center;width:12%">{{number_format(($det->capital_pagado), 0, ",", ".")}}</td>
                        </tr>                              
                    
                </tbody>
                @endforeach
                
            </table><br>
            {{-- <img src="{{ public_path('assets/images/footerfact.png') }}" width="100%" /> --}}
        </div>
        <div id="encabezado" class="table-responsive">
            <h4>FORMAS DE PAGO</h4>
            <table class="table-borderless alturatabla2">
                <thead class = "table-light">
                    <tr>
                        <th class="titulo2">EFECTIVO</th>
                        <th class="titulo2">CHEQUE</th>
                        <th class="titulo2">T.CREDITO</th>
                        <th class="titulo2">T.DEBITO</th>
                        <th class="titulo2">TRANSFERENCIA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="center">Gs. {{number_format(($pagosDetalle->total_pagf), 0, ",", ".")}}</td>
                        <td align="center">Gs. {{number_format(($pagosDetalle->total_pagch), 0, ",", ".")}}</td>
                        <td align="center">Gs. {{number_format(($pagosDetalle->total_pagtc), 0, ",", ".")}}</td>
                        <td align="center">Gs. {{number_format(($pagosDetalle->total_pagtd), 0, ",", ".")}}</td>
                        <td align="center">Gs. {{number_format(($pagosDetalle->total_pagtr), 0, ",", ".")}}</td>
                    </tr>                              
                    
                </tbody>
                
            </table>
        </div>
    </div>

</section>
          
</html>
