@extends('layouts.master')

@section('title') @lang('Facturas') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Facturas @endslot
        @slot('title') Factura de Venta @endslot
    @endcomponent
    <style>
        #encabezado{
        font-size: 9px;
        }
        #timbrado{
        font-size: 8px;
        }
        th.cantidad { 
            width: 70px !important;  
        }
        th.descripcion { 
            width: 330px !important;  
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
        td.gfg { 
            word-break: break-all; 
        }
        td.valorParcial { 
            width: 110 !important; 
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title row">
                        <!-- <h4 class="float-end font-size-16">Order # 12345</h4> -->
                        <div style="text-align:center;" id="timbrado" class="col-sm-4">
                            <img src="{{ URL::asset('/assets/images/logoFactura.png') }}" alt="logo" height="60" /><br>
                            <strong style="text-align:center;" >Avda. Caballero 560 c/ Lomas Valentinas  -  Tel.: (071) 201.840</strong> <br>
                            <strong style="text-align:center;">Encarnación - Paraguay</strong> <br>
                        </div>
                        <div id="timbrado" class="col-sm-5">
                            <address>
                                <strong>TIMBRADO N°:</strong> {{$fac[0]->timbrado}}<br>
                                <strong>Fecha Inicio Vigencia:</strong> 28-12-2020<br>
                                <strong>Fecha Fin Vigencia:</strong> 31-12-2021<br>
                                <strong>RUC:</strong> 80054423-4<br>
                                <strong>FACTURA</strong> <br>
                                <strong>N°:</strong> {{$fac[0]->nro_com}}<br>
                            </address>
                        </div>
                    </div>
                    <hr>
                    <div id="encabezado" class="row">
                        <div class="table-responsive">
                            <table class="table-borderless">
                                    @if($fac[0]->tipo_factura == "CR")
                                        <tr id="encabezado">
                                            <td colspan="2"><strong>ENCARNACIÓN</strong></td>
                                            <td>{{date('d')}} de {{$mesLetra}} de {{date('Y')}}</td>
                                            <td ></td>
                                            <td><strong>COND. DE VENTA: CONTADO ( )  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp   CREDITO (*)</strong></td>
                                        </tr>
                                    @else
                                        <tr id="encabezado">
                                            <td colspan="2"><strong>ENCARNACIÓN</strong></td>
                                            <td>{{date('d')}} de {{$mesLetra}} de {{date('Y')}}</td>
                                            <td ></td>
                                            <td><strong>COND. DE VENTA: CONTADO (*)  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp   CREDITO ( )</strong></td>
                                        </tr>
                                    @endif
                                    <tr id="encabezado">
                                        <td colspan="4"><strong>SEÑOR(ES): </strong>{{$fac[0]->doc_cli}}</td>
                                        <td><strong>CI O RUC: </strong>{{$fac[0]->num_documento}}</td>
                                    </tr>
                                    <tr id="encabezado">
                                        <td colspan="3"><strong>DIRECCIÓN: </strong>{{$fac[0]->direccion}}</td>
                                        <td ></td>
                                        <td ><strong>TEL.: </strong> {{$fac[0]->telefono}}</td>
                                        <td colspan="2"><strong>NOTA DE REMISION N°: </strong></td>
                                        <td ></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>

                    @php
                        $total_exenta=0;
                        $total_iv5=0;
                        $total_iv10=0;
                    @endphp
                   
                    <div id="encabezado" class="table-responsive">
                        <table class="table-borderless">
                            <thead class = "table-light">
                                <tr>
                                    <th class="cantidad text-center hidden">CANT</th>
                                    <th class="descripcion">MERCADERIAS Y/O SERVICIOS</th>
                                    <th class="precioU text-center">P. UNITARIO</th>
                                    <th class="exe text-center">EXENTAS</th>
                                    <th class="cinco text-center">5%</th>
                                    <th class="diez text-center">10%</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($fac as $f)
                                <tr>
                                    <td class="text-center">{{$f->cantidad}}</td>
                                    @if($f->merca == 10)
                                        <td>Recargo {{$f->descripcion}}</td> 
                                        <td>{{number_format(($f->precio_uni), 0, ",", ".")}}</td>
                                    @endif                                   
                                    @if($f->merca == 20)
                                        <td>Recargo {{$f->descripcion}}</td>
                                        <td>{{number_format(($f->precio_uni), 0, ",", ".")}}</td> 
                                    @endif
                                    @if($f->merca == 30)
                                        <td>{{$f->descripcion}}</td>
                                        <td>{{number_format(($f->precio_uni), 0, ",", ".")}}</td> 
                                    @endif
                                    @if($f->merca == 40)
                                        <td>{{$f->descripcion}}</td>
                                        <td>{{number_format(($f->precio_uni), 0, ",", ".")}}</td> 
                                    @endif
                                    <td class="text-center">{{number_format(($f->precio_exe), 0, ",", ".")}}</td>
                                    <td class="text-center">{{number_format(($f->precio_iv5), 0, ",", ".")}}</td>
                                    <td class="text-center">{{number_format(($f->precio_iv10), 0, ",", ".")}}</td>
                                </tr>
                                @php
                                    $total_exenta=$total_exenta + $f->precio_exe;
                                    $total_iv5=$total_iv5 + $f->precio_iv5;
                                    $total_iv10= $total_iv10 + $f->precio_iv10;
                                @endphp
                            @endforeach
                                        
                                <tr id="encabezado">
                                    <td class="valorPacial" ><strong>VALOR PARCIAL</strong></td>
                                    <td ></td>
                                    <td ></td>
                                    <td class="text-center">{{number_format(($total_exenta), 0, ",", ".")}}</td>
                                    <td class="text-center">{{number_format(($total_iv5), 0, ",", ".")}}</td>
                                    <td class="text-center">{{number_format(($total_iv10), 0, ",", ".")}}</td>
                                </tr>
                                <tr id="encabezado">
                                    <td ><strong>TOTAL A PAGAR</strong></td>
                                    <td>{{$tot_pag_let}}</td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td class="text-center">{{number_format(($f->total_gral), 0, ",", ".")}}</td>
                                </tr>
                                @php
                                    $tota_iva= $total_iv10 + $total_iv5;
                                @endphp
                                <tr id="encabezado">
                                    <td ><strong>LIQUIDACIÓN DEL IVA:</strong></td>
                                    <td><strong>(5%):</strong> {{number_format(($fac[0]->iv5), 0, ",", ".")}}</td>
                                    <td><strong>(10%):</strong> {{number_format(($fac[0]->iv10), 0, ",", ".")}}</td>
                                    <td ><strong>TOTAL IVA:</strong> {{number_format(($fac[0]->iv5+$fac[0]->iv10), 0, ",", ".")}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Aqui empieza la copia (duplicado) -->


                <!-- Aqui termina la copia (duplicado) -->
                
                    <div class="float-end">
                        <a href="{{URL::action('App\Http\Controllers\CajaController@facturapdf',$f->id)}}" target="_blank">
                            <button type="button" class="btn btn-success btn-sm" >
                                <i class="fa fa-print fa-2x"></i> IMPRIMIR FACTURA
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
