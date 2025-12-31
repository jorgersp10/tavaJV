@extends('layouts.master')

@section('title') @lang('Recibos') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Recibos @endslot
        @slot('title') Recibo de dinero @endslot
    @endcomponent
    <style>
        #encabezado{
        font-size: 9px;
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
            width: 110px !important;  
        }
            
        td.gfg { 
            word-break: break-all; 
        } 
        
        .alturatabla { 
                height: 120px !important; 
                margin: 0px 0px 0px 0px
            }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="responsive">
                    <div class="row">
                        <!-- <h4 class="float-end font-size-16">Order # 12345</h4> -->
                        <div id="timbrado" style="text-align:center;"  class="col-sm-3 mt-1">
                            <img src="{{ URL::asset('/assets/images/logoFactura.png') }}" alt="logo" height="50px" width="200px" /><br>
                            <strong style="text-align:center;" >Avda. Caballero 560 c/ Lomas Valentinas</strong> <br>
                            <strong style="text-align:center;" >Tel.: (071) 201.840</strong> <br>
                            <strong style="text-align:center;">Encarnacion - Paraguay</strong> <br>
                        </div>
                        <div id="ruc"class="col-sm-2 mt-1">
                            <address>
                                <strong>RUC:</strong> 80054423-4<br>
                                <strong>RECIBO DE DINERO</strong><br>
                                <strong>NRO:</strong> {{$rec[0]->nro_recibo}}<br>
                            </address>
                        </div>
                        <div id="ruc" class="col-sm-3 mt-1">
                            <address>
                                <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                                <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                            </address>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-5 mt-1">
                            <address id="encabezado">
                            <h5 class="font-size-11 font-weight-bold">Recibi(mos) de {{$rec[0]->nombre_cli}} </h5>
                                @if($rec[0]->moneda=="GS")    
                                    <strong>la cantidad de : {{$tot_pag_let}} guaranies</strong><br>
                                    @else
                                    <strong>la cantidad de : {{$tot_pag_let}} dolares</strong><br>
                                @endif
                                <strong>En concepto de pago de lo detallado a continuacion :</strong><br>
                            </address>
                        </div>
                        <div class="col-sm-3 mt-1">
                            <address id="encabezado">
                                <strong>FORMA DE COBRO</strong> <br>
                                @if($rec[0]->moneda=="GS") 
                                    <strong>Efectivo:</strong> Gs. {{number_format(($rec[0]->total_pagf), 0, ",", ".")}}<br>
                                    <strong>Cheque  :</strong> Gs. {{number_format(($rec[0]->total_pagch), 0, ",", ".")}}<br>
                                    <strong>Tarj. Credito:</strong> Gs. {{number_format(($rec[0]->total_pagtc), 0, ",", ".")}}<br>
                                    <strong>Tarj. Debito :</strong> Gs. {{number_format(($rec[0]->total_pagtd), 0, ",", ".")}}<br>
                                    @else
                                    <strong>Efectivo:</strong> U$S. {{number_format(($rec[0]->total_pagf), 2, ",", ".")}}<br>
                                    <strong>Cheque  :</strong> U$S. {{number_format(($rec[0]->total_pagch), 2, ",", ".")}}<br>
                                    <strong>Tarj. Credito:</strong> U$S. {{number_format(($rec[0]->total_pagtc), 2, ",", ".")}}<br>
                                    <strong>Tarj. Debito :</strong> U$S. {{number_format(($rec[0]->total_pagtd), 2, ",", ".")}}<br>
                                @endif
                            </address>
                        </div>
                    </div>
                    <div id="encabezado" class="table-responsive">
                        <table class="table-borderless alturatabla">
                            <thead class = "table-light">
                                <tr>
                                    <th class="titulo">TRANS.</th>
                                    <th class="titulo">FACTURA NRO</th>
                                    <th class="titulo">CUOTA NRO</th>
                                    <th class="titulo">FECHA</th>
                                    <th class="titulo">IMPORTE</th>
                                    <th class="titulo">IMPORTE PAGADO</th>
                                    <th></th>
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
                                    <td>{{$r->tran_inmo}}</td>
                                    <td>{{$r->factura}}</td>
                                    <td>{{$rec[0]->pcc}}-{{$rec[0]->ucc}} de {{$rec[0]->plazo}}</td>
                                    <td>{{date('d-m-Y')}}</td>
                                    @if($r->moneda=="GS")
                                        <td>{{number_format(($total_capital), 0, ",", ".")}}</td>                                    
                                        <td>{{number_format(($total_capital), 0, ",", ".")}}</td>
                                        @else
                                        <td>{{number_format(($total_capital), 2, ",", ".")}}</td>                                    
                                        <td>{{number_format(($total_capital), 2, ",", ".")}}</td>
                                    @endif
                                </tr>                                
                                <tr><td colspan="4" class="gfg" style="width:180px">{{$r->descripcion_fac}}</td>
                                <td></td><td></td><td></td></tr></br>
                                <tr id="encabezado">
                                    <td colspan="5" class="border-0 text-end">
                                        <strong>Total</strong></td>                                        
                                        @if($r->moneda=="GS")                                     
                                            <td>Gs. {{number_format(($total_recibo), 0, ",", ".")}}</td>
                                            @else
                                            <td>U$S. {{number_format(($total_recibo), 2, ",", ".")}}</td>
                                        @endif
                                </tr>
                                
                            </tbody>
                            
                        </table><br><br>
                        
                        <div id="encabezado" class="col-sm-8 float-end">
                            <address class="mt-2 mt-sm-0">
                                <strong style="text-align:left;">__________________________</strong><br> 
                                <strong style="text-align:left;">Cobrador Autorizado</strong><br> 
                                <strong style="text-align:left;">{{auth()->user()->name}}</strong><br>                             
                            </address>
                        </div>
                    </div>
                </div>
                <!-- Aqui empieza la copia (duplicado) -->


                <!-- Aqui termina la copia (duplicado) -->
                
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i
                                    class="fa fa-print"></i></a>
                        </div>
                    </div>
                </div><br><br>
<!-- *********************************************DUPLICADO DE RECIBO**************************** -->
                <div class="card-body">
                    <div class="invoice-title row">
                        <!-- <h4 class="float-end font-size-16">Order # 12345</h4> -->
                        <div style="text-align:center;" id="timbrado" class="col-sm-3">
                            <img src="{{ URL::asset('/assets/images/logoFactura.png') }}" alt="logo" height="50px" width="200px" /><br>
                            <strong style="text-align:center;" >Avda. Caballero 560 c/ Lomas Valentinas  -  Tel.: (071) 201.840</strong> <br>
                            <strong style="text-align:center;">Encarnacion - Paraguay</strong> <br>
                        </div>
                        <div id="ruc"class="col-sm-2">
                            <address>
                                <strong>RUC:</strong> 80054423-4<br>
                                <strong>RECIBO DE DINERO</strong><br>
                                <strong>NRO:</strong> {{$rec[0]->nro_recibo}}<br>
                            </address>
                        </div>
                        <div id="ruc" class="col-sm-3 text-sm-start">
                            <address>
                                <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                                <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                            </address>
                        </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6 mt-1">
                            <address id="encabezado">
                            <h5 class="font-size-11 font-weight-bold">Recibi(mos) de {{$rec[0]->nombre_cli}} </h5>
                            @if($rec[0]->moneda=="GS")    
                                <strong>la cantidad de : {{$tot_pag_let}} guaranies</strong><br>
                                @else
                                <strong>la cantidad de : {{$tot_pag_let}} dolares</strong><br>
                            @endif
                                <strong>En concepto de pago de lo detallado a continuacion :</strong><br>
                            </address>
                        </div>
                        <div class="col-sm-3 mt-1">
                            <address id="encabezado">
                                <strong>FORMA DE COBRO</strong> <br>
                                @if($rec[0]->moneda=="GS") 
                                    <strong>Efectivo:</strong> Gs. {{number_format(($rec[0]->total_pagf), 0, ",", ".")}}<br>
                                    <strong>Cheque  :</strong> Gs. {{number_format(($rec[0]->total_pagch), 0, ",", ".")}}<br>
                                    <strong>Tarj. Credito:</strong> Gs. {{number_format(($rec[0]->total_pagtc), 0, ",", ".")}}<br>
                                    <strong>Tarj. Debito :</strong> Gs. {{number_format(($rec[0]->total_pagtd), 0, ",", ".")}}<br>
                                    @else
                                    <strong>Efectivo:</strong> U$S. {{number_format(($rec[0]->total_pagf), 2, ",", ".")}}<br>
                                    <strong>Cheque  :</strong> U$S. {{number_format(($rec[0]->total_pagch), 2, ",", ".")}}<br>
                                    <strong>Tarj. Credito:</strong> U$S. {{number_format(($rec[0]->total_pagtc), 2, ",", ".")}}<br>
                                    <strong>Tarj. Debito :</strong> U$S. {{number_format(($rec[0]->total_pagtd), 2, ",", ".")}}<br>
                                @endif
                            </address>
                        </div>
                    </div>
                    <div id="encabezado" class="table-responsive">
                        <table class="table-borderless alturatabla">
                            <thead class = "table-light">
                                <tr>
                                    <th class="titulo">TRANS.</th>
                                    <th class="titulo">FACTURA NRO</th>
                                    <th class="titulo">CUOTA NRO</th>
                                    <th class="titulo">FECHA</th>
                                    <th class="titulo">IMPORTE</th>
                                    <th class="titulo">IMPORTE PAGADO</th>
                                    <th></th>
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
                                    <td>{{$r->tran_inmo}}</td>
                                    <td>{{$r->factura}}</td>
                                    <td>{{$rec[0]->pcc}}-{{$rec[0]->ucc}} de {{$rec[0]->plazo}}</td>
                                    <td>{{date('d-m-Y')}}</td>
                                    @if($r->moneda=="GS")
                                        <td>{{number_format(($total_capital), 0, ",", ".")}}</td>                                    
                                        <td>{{number_format(($total_capital), 0, ",", ".")}}</td>
                                        @else
                                        <td>{{number_format(($total_capital), 2, ",", ".")}}</td>                                    
                                        <td>{{number_format(($total_capital), 2, ",", ".")}}</td>
                                    @endif
                                </tr>                           
                                <tr><td colspan="4" class="gfg" style="width:180px">{{$r->descripcion_fac}}</td>
                                <td></td><td></td><td></td></tr></br>
                                <tr id="encabezado">
                                    <td colspan="5" class="border-0 text-end">
                                        <strong>Total</strong></td>   
                                        @if($r->moneda=="GS")                                     
                                            <td>Gs. {{number_format(($total_recibo), 0, ",", ".")}}</td>
                                            @else
                                            <td>U$S. {{number_format(($total_recibo), 2, ",", ".")}}</td>
                                        @endif
                                </tr>
                                
                            </tbody>
                            
                        </table><br><br>
                        
                        <div id="encabezado" class="col-sm-8 float-end">
                            <address class="mt-2 mt-sm-0">
                                <strong style="text-align:left;">__________________________</strong><br> 
                                <strong style="text-align:left;">Cobrador Autorizado</strong><br> 
                                <strong style="text-align:left;">{{auth()->user()->name}}</strong><br>                             
                            </address>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
    <!-- end row -->

@endsection
