<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo Producto</title>
    <div id="body" class="body">

    <style>
        #seccion2 {
            /* margin: 145px 1px 1px 0px; */
            padding-top: 182px;
        }
        #encabezado{
        font-size: 11px;
        }
        #timbrado{
        font-size: 8px;
        }
        #dir{
        font-size: 8px;
        }
        #ruc{
        font-size: 11px;
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
                height: 220px !important; 
                margin: 0px 0px 0px 0px
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
        #totalAl{
            padding-left: 555px;
        }
    </style>

<section id="seccion1">
        
        <div class="Row">
            <!-- <h4 class="float-end font-size-16">Order # 12345</h4> -->
            <div  class="Column" style="text-align:center;" id="timbrado">
            <img src="{{ public_path('assets/images/inox.jpg') }}" alt="logo" height="45px" width="200px" /><br>
                <strong style="text-align:center;" >Ruta 1 - Segunda Paralela al este</strong> <br>
                <strong style="text-align:center;" >Tel.: (071) 207615 - (0986) 755440</strong> <br>
                <strong style="text-align:center;">Encarnacion - Paraguay</strong> <br>
            </div>
            <div class="Column" id="ruc">
                
                    <strong>RUC:</strong> 6698924-8<br>
                    <strong>RECIBO DE DINERO</strong><br>
                    <strong>NRO:</strong> {{$rec[0]->nro_recibo}}<br>
                
            </div>
            <div class="Column" id="ruc">
                
                    <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                    <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                
            </div>
        </div></br>
        
        <div class="Row">
            <div class="Column" id="encabezado">
                
                <h5 class="font-size-12 font-weight-bold">Recibi(mos) de {{$rec[0]->nombre_cli}} </h5>
                    @if($rec[0]->moneda=="GS")    
                        <strong>la cantidad de : {{$tot_pag_let}}</strong><br>
                        @else
                        <strong>la cantidad de : {{$tot_pag_let}}</strong><br>
                    @endif
                    <strong>En concepto de pago de lo detallado a continuacion :</strong><br>
                
            </div>
            <div class="Column" id="encabezado">
                
                <h5 class="font-size-12 font-weight-bold">RUC: {{$rec[0]->ruc}} </h5>
                <strong>TOTAL ORIGINAL : Gs. {{number_format(($rec[0]->total_original), 0, ",", ".")}}</strong><br>
            </div>
        </div>
        <div id="encabezado" class="table-responsive">
            <table class="table-borderless alturatabla>
                <thead class = "table-light">
                    <tr>
                        <!-- <th class="titulo">TRANS.</th> -->
                        <th class="titulo">FACTURA NRO</th>
                        <!-- <th class="titulo">CUOTA NRO</th> -->
                        <th class="titulo">PAGO NRO</th>
                        <th class="titulo">FECHA</th>
                        <th class="titulo">SALDO</th>
                        <th class="titulo">PAGADO</th>
                        <th class="titulo">SALDO A PAGAR</th>
                        
                    </tr>
                </thead>
                <tbody>
                @php
                    $total_recibo=0;
                    $total_capital=0;
                @endphp
                @foreach($rec as $r)
                    
                    @php
                        $total_recibo=$total_recibo + $r->capital;
                        $total_capital= $total_capital + $r->capital;
                    @endphp
                @endforeach
                    <tr>
                        <!-- <td align="center">{{$r->tran_inmo}}</td> -->
                        @if($r->factura > 00)
                            <td align="center">001-000{{$r->factura}}</td>
                            @else
                            <td align="center">XXXX</td>
                        @endif
                        <!-- <td align="center">{{$rec[0]->pcc}}-{{$rec[0]->ucc}} de {{$rec[0]->plazo}}</td> -->
                        <td align="center">{{$rec[0]->nro_pago}}</td>
                        <td align="center">{{ date('d-m-Y', strtotime($rec[0]->fec_vto))}}</td>
                        @if($rec[0]->nro_pago == 1)
                            <td align="center">{{number_format(($rec[0]->total_original), 0, ",", ".")}}</td>
                        @else
                        <td align="center">{{number_format(($rec[0]->capital), 0, ",", ".")}}</td> 
                        @endif                          
                        <td align="center">{{number_format(($rec[0]->total), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($rec[0]->saldo), 0, ",", ".")}}</td>                                    

                    </tr>                              
                    
                </tbody>
                
            </table><br>
            
            <table class="table-borderless alturatabla>
                <thead class = "table-light">
                    <tr>
                        <th class="titulo">CANT.</th>
                        <th class="titulo">DESCRIPCION</th>
                        <th class="titulo">P. UNITARIO</th>
                        <th class="titulo">TOTAL</th>
                        <th></th>
                    </tr>
                </thead>
                @foreach($rec as $r)
                <tbody>

                    <tr>
                        <td align="center">{{$r->cantidad}}</td>                        
                        <td style="width:230px">{{$r->producto}}</td>
                        <td align="center">{{number_format(($r->precio_venta), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($r->precio_venta*$r->cantidad), 0, ",", ".")}}</td>
                    </tr>                              
                    
                </tbody>
                @endforeach
            </table><br><br>

            <table id="totalAl">
                    <tr>
                        <td colspan="4" > <strong>TOTAL PAGADO</strong></td>                                        
                            @if($r->moneda=="GS")                                     
                                <td>Gs. {{number_format(($rec[0]->total), 0, ",", ".")}}</td>
                                @else
                                <td>U$S. {{number_format(($rec[0]->total), 2, ",", ".")}}</td>
                            @endif
                    </tr>
                    <tr>
                        <td colspan="4" > <strong>SALDO A PAGAR</strong></td>                                                                          
                        <td>Gs. {{number_format(($rec[0]->saldo), 0, ",", ".")}}</td>
                                
                    </tr>
            </table><br>
            <div id="encabezado" class="firma">
                <address class="mt-2 mt-sm-0">
                    <strong style="text-align:right;">__________________________</strong><br> 
                    <strong style="text-align:right;">Cobrador Autorizado</strong><br> 
                    <strong style="text-align:right;">{{auth()->user()->name}}</strong><br>                             
                </address>
            </div>
        </div>
    </div>
    <!-- Aqui empieza la copia (duplicado) -->

    </div><br><br>
</section> 
<!-- *********************************************DUPLICADO DE RECIBO**************************** -->
<section id="seccion2">

<div class="Row">
            <!-- <h4 class="float-end font-size-16">Order # 12345</h4> -->
            <div  class="Column" style="text-align:center;" id="timbrado">
            <img src="{{ public_path('assets/images/inox.jpg') }}" alt="logo" height="45px" width="200px" /><br>
                <strong style="text-align:center;" >Ruta 1 - Segunda Paralela al este</strong> <br>
                <strong style="text-align:center;" >Tel.: (071) 207615 - (0986) 755440</strong> <br>
                <strong style="text-align:center;">Encarnacion - Paraguay</strong> <br>
            </div>
            <div class="Column" id="ruc">
                
                    <strong>RUC:</strong> 6698924-8<br>
                    <strong>RECIBO DE DINERO</strong><br>
                    <strong>NRO:</strong> {{$rec[0]->nro_recibo}}<br>
                
            </div>
            <div class="Column" id="ruc">
                
                    <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                    <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                
            </div>
        </div></br>
        
        <div class="Row">
            <div class="Column" id="encabezado">
                
                <h5 class="font-size-12 font-weight-bold">Recibi(mos) de {{$rec[0]->nombre_cli}} </h5>
                    @if($rec[0]->moneda=="GS")    
                        <strong>la cantidad de : {{$tot_pag_let}}</strong><br>
                        @else
                        <strong>la cantidad de : {{$tot_pag_let}}</strong><br>
                    @endif
                    <strong>En concepto de pago de lo detallado a continuacion :</strong><br>
                
            </div>

            <div class="Column" id="encabezado">
                
                <h5 class="font-size-12 font-weight-bold">RUC: {{$rec[0]->ruc}} </h5>
                <strong>TOTAL ORIGINAL : Gs. {{number_format(($rec[0]->total_original), 0, ",", ".")}}</strong><br>

            </div>
        </div>
        <div id="encabezado" class="table-responsive">
            <table class="table-borderless alturatabla>
                <thead class = "table-light">
                    <tr>
                        <!-- <th class="titulo">TRANS.</th> -->
                        <th class="titulo">FACTURA NRO</th>
                        <!-- <th class="titulo">CUOTA NRO</th> -->
                        <th class="titulo">PAGO NRO</th>
                        <th class="titulo">FECHA</th>
                        <th class="titulo">SALDO</th>
                        <th class="titulo">PAGADO</th>
                        <th class="titulo">SALDO A PAGAR</th>
                        
                    </tr>
                </thead>
                <tbody>
                @php
                    $total_recibo=0;
                    $total_capital=0;
                @endphp
                @foreach($rec as $r)
                    
                    @php
                        $total_recibo=$total_recibo + $r->capital;
                        $total_capital= $total_capital + $r->capital;
                    @endphp
                @endforeach
                    <tr>
                        <!-- <td align="center">{{$r->tran_inmo}}</td> -->
                        @if($r->factura > 00)
                            <td align="center">001-000{{$r->factura}}</td>
                            @else
                            <td align="center">XXXX</td>
                        @endif
                        <!-- <td align="center">{{$rec[0]->pcc}}-{{$rec[0]->ucc}} de {{$rec[0]->plazo}}</td> -->
                        <td align="center">{{$rec[0]->nro_pago}}</td>
                        <td align="center">{{ date('d-m-Y', strtotime($rec[0]->fec_vto))}}</td>
                        @if($rec[0]->nro_pago == 1)
                            <td align="center">{{number_format(($rec[0]->total_original), 0, ",", ".")}}</td>
                        @else
                            <td align="center">{{number_format(($rec[0]->capital), 0, ",", ".")}}</td> 
                        @endif                         <td align="center">{{number_format(($rec[0]->total), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($rec[0]->saldo), 0, ",", ".")}}</td> 
                    </tr>                              
                    
                </tbody>
                
            </table><br><br>
            
            <table class="table-borderless alturatabla>
                <thead class = "table-light">
                    <tr>
                        <th class="titulo">CANT.</th>
                        <th class="titulo">DESCRIPCION</th>
                        <th class="titulo">P. UNITARIO</th>
                        <th class="titulo">TOTAL</th>
                        <th></th>
                    </tr>
                </thead>
                @foreach($rec as $r)
                <tbody>

                    <tr>
                        <td align="center">{{$r->cantidad}}</td>                        
                        <td style="width:230px">{{$r->producto}}</td>
                        <td align="center">{{number_format(($r->precio_venta), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($r->precio_venta*$r->cantidad), 0, ",", ".")}}</td>
                    </tr>                               
                    
                </tbody>
                @endforeach
            </table><br>

            <table id="totalAl">
                    <tr>
                        <td colspan="4" > <strong>TOTAL PAGADO</strong></td>                                        
                            @if($r->moneda=="GS")                                     
                                <td>Gs. {{number_format(($rec[0]->total), 0, ",", ".")}}</td>
                                @else
                                <td>U$S. {{number_format(($rec[0]->total), 2, ",", ".")}}</td>
                            @endif
                    </tr>
                    <tr>
                        <td colspan="4" > <strong>SALDO A PAGAR</strong></td>                                         
                        <td>Gs. {{number_format(($rec[0]->saldo), 0, ",", ".")}}</td>
                    </tr>
            </table><br>
            <!-- <div id="encabezado" class="table-responsive">
            <h4>FORMAS DE PAGO</h4>
            <table class="table-borderless alturatabla>
                <thead class = "table-light">
                    
                    <tr>
                        <th class="titulo">EFECTIVO</th>
                        <th class="titulo">CHEQUE</th>
                        <th class="titulo">TARJ. CREDITO</th>
                        <th class="titulo">TARJ. CREDITO</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    @if($rec[0]->moneda=="GS") 
                        <td align="center">Gs. {{number_format(($rec[0]->total_pagf), 0, ",", ".")}}</td>
                        <td align="center">Gs. {{number_format(($rec[0]->total_pagch), 0, ",", ".")}}</td>
                        <td align="center">Gs. {{number_format(($rec[0]->total_pagtc), 0, ",", ".")}}</td>
                        <td align="center">Gs. {{number_format(($rec[0]->total_pagtd), 0, ",", ".")}}</td>
                    @else
                        <td align="center">U$S. {{number_format(($rec[0]->total_pagf), 2, ",", ".")}}</td>
                        <td align="center">U$S. {{number_format(($rec[0]->total_pagch), 2, ",", ".")}}</td>
                        <td align="center">U$S. {{number_format(($rec[0]->total_pagtc), 2, ",", ".")}}</td>
                        <td align="center">U$S. {{number_format(($rec[0]->total_pagtd), 2, ",", ".")}}</td>
                    @endif
                    </tr>                              
                    
                </tbody>
                
            </table><br><br> -->
            <div id="encabezado" class="firma">
                <address class="mt-2 mt-sm-0">
                    <strong style="text-align:right;">__________________________</strong><br> 
                    <strong style="text-align:right;">Cobrador Autorizado</strong><br> 
                    <strong style="text-align:right;">{{auth()->user()->name}}</strong><br>                             
                </address>
            </div>
        </div>
    </div>
    <!-- Aqui empieza la copia (duplicado) -->    
    </div>
    </section>
</html>
