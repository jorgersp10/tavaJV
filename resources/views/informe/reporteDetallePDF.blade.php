<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte por Detalle</title>
    
    <div class="card-body">
    <style> 
        #datos{
        text-align: left;
        font-size: 11px;
        font-family: "Times New Roman", Times, serif;
        LINE-HEIGHT:10px;
        /* font-weight: bold; */
        }
        #letratabla{
        text-align: left;
        font-size: 8px;
        font-family: "Times New Roman", Times, serif;
        LINE-HEIGHT:8px;
        /* font-weight: bold; */
        }
        #dictamen{
        text-align: left;
        font-size: 18px;
        font-family: "Times New Roman", Times, serif;
        /* font-weight: bold; */
        }
        #titulo{
        text-align: center;
        font-family: "Times New Roman", Times, serif;
        /* font-weight: bold; */
        }
        footer {
            /* background-color: black; */
            
            LINE-HEIGHT:5px;
            font-size: 9px;
            bottom: 0;
            width: 100%;
            height: 30px;
            position: fixed;
            /* color: white; */
            }
            hr {
            height: 0,3px;
            background-color: black;
            }
            .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.40rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 1px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 1px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }

        #hr{
		page-break-after: always;
		border: none;
		margin: 0;
		padding: 0;
	    }
        #totales{		
            background-color: rgba(255,255,0,1);
            font-size: 8px;
            font-family: "Times New Roman", Times, serif;
        }
        #totales2{		
            background-color: #FFFFFF;
            font-size: 11px;
            font-family: "Times New Roman", Times, serif;
        }
        #marco{
		
            page-break-inside: auto;
	    }
        body {
            margin: 1cm 1cm 1cm;
        }
    </style>
   
    <header>
        <h2 id="titulo" class="text-center">Informe General Sobre Ventas Cobradas</h2>   

    </header>
 
    @if(($date1 == null || $date2 == null))
        <h3 >Rango de Fecha: Todas las fechas</h3>
        @else
        <h3>Rango de Fecha: {{ date('d-m-Y', strtotime($date1)) }} al {{ date('d-m-Y', strtotime($date2)) }}</h3>
    @endif
    @if($pagos=="Vacio")
    <h4 >Cliente no posee cobros</h4>
    @else
    ***************************************************************************
    <section id="marco">
            <div>
            <table id="letratabla" class="table table-bordered table-striped table-sm"> 
            @php
                $producto ="vacio"; 
                $ultimo=1;

                $interes=0;
                $total_capital=0;
                $total_interes=0;
                $total_moratorio=0;
                $total_punitorio=0;
                $total_iva=0;
                $total_efectivo=0;
                $total_debito=0;
                $total_credito=0;
                $total_cheque=0;
                $total_transf=0;
                $total_cobrado=0;

                $sup_total_capital=0;
                $sup_total_interes=0;
                $sup_total_moratorio=0;
                $sup_total_punitorio=0;
                $sup_total_iva=0;
                $sup_total_efectivo=0;
                $sup_total_debito=0;
                $sup_total_credito=0;
                $sup_total_cheque=0;
                $sup_total_transf=0;
                $sup_total_cobrado=0;

            @endphp 

            @foreach($pagos as $p)
                @if($producto == "vacio")
                    @php
                        $producto=$p->inmueble_id;
                        $titulo=0;
                                $interes=$p->moratorio+$p->punitorio+$p->iva;
                                $total_capital=$total_capital + $p->capital;
                                $total_interes=$total_interes + $interes;
                                $total_moratorio=$total_moratorio + $p->moratorio;
                                $total_punitorio=$total_punitorio + $p->punitorio;
                                $total_iva=$total_iva + $p->iva;
                                $total_efectivo=$total_efectivo + $p->total_pagf;
                                $total_debito=$total_debito + $p->total_pagtd;
                                $total_credito=$total_credito + $p->total_pagtc;
                                $total_cheque=$total_cheque + $p->total_pagch;
                                $total_transf=$total_transf + $p->total_pagtr;
                                $total_cobrado=$total_cobrado + $p->totalpagado;
                           
                    @endphp 
                @else
                    @if($producto == $p->inmueble_id)
                        @php
                            $titulo=1;
                            $cambio=0;
                                $interes=$p->moratorio+$p->punitorio+$p->iva;
                                $total_capital=$total_capital + $p->capital;
                                $total_interes=$total_interes + $interes;
                                $total_moratorio=$total_moratorio + $p->moratorio;
                                $total_punitorio=$total_punitorio + $p->punitorio;
                                $total_iva=$total_iva + $p->iva;
                                $total_efectivo=$total_efectivo + $p->total_pagf;
                                $total_debito=$total_debito + $p->total_pagtd;
                                $total_credito=$total_credito + $p->total_pagtc;
                                $total_cheque=$total_cheque + $p->total_pagch;
                                $total_transf=$total_transf + $p->total_pagtr;
                                $total_cobrado=$total_cobrado + $p->totalpagado;
                            
                        @endphp
                    @else
                        @php
                            $producto=$p->inmueble_id;
                            $ultimo=0;
                            $titulo=0;
                            $cambio=1;

                        @endphp  
                        {{-- <tr>   
                            <td>"SI Cambio"</td> 
                            <td>{{$titulo}}</td> 
                            <td>{{$ultimo}}</td> 
                        </tr> --}}
                    @endif
                @endif

                    @if($titulo==0)      

                                @if($ultimo==0)   

                                    <tr id="totales">  
                                        <td></td> 
                                        <td><strong>TOTALES</strong></td>     
                                            <td><strong>Gs. {{number_format(($total_capital), 0, ",", ".")}}</strong></td> 
                                            <!-- <td><strong>Gs. {{number_format(($total_interes), 0, ",", ".")}}</strong></td>
                                            <td><strong>Gs. {{number_format(($total_moratorio), 0, ",", ".")}}</strong></td>    
                                            <td><strong>Gs. {{number_format(($total_punitorio), 0, ",", ".")}}</strong></td> 
                                            <td><strong>Gs. {{number_format(($total_iva), 0, ",", ".")}}</strong></td> -->
                                            <td><strong></strong></td> 
                                            <td><strong></strong></td> 
                                            <td><strong>Gs. {{number_format(($total_efectivo), 0, ",", ".")}}</strong></td>
                                            <td><strong>Gs. {{number_format(($total_debito), 0, ",", ".")}}</strong></td>
                                            <td><strong>Gs. {{number_format(($total_credito), 0, ",", ".")}}</strong></td>
                                            <td><strong>Gs. {{number_format(($total_cheque), 0, ",", ".")}}</strong></td>
                                            <td><strong>Gs. {{number_format(($total_transf), 0, ",", ".")}}</strong></td>
                                            <td><strong>Gs. {{number_format(($total_cobrado), 0, ",", ".")}}</strong></td>
                                            <td><strong>Gs. {{number_format(($total_cobrado/11), 0, ",", ".")}}</strong></td>    
                                       
                                    </tr>
                                    <tr id="totales2">   
                                    <td colspan="14">CLIENTE: {{$p->nombreCliente}} --- C.I.N째: {{$p->num_documento}}-{{$p->digito}}</td>  
                                    </tr>  
                                    @php
                                        $titulo=1; 
                                        $ultimo=1;

                                        if ($cambio==1){
                                            $interes=0;
                                            $total_capital=0;
                                            $total_interes=0;
                                            $total_moratorio=0;
                                            $total_punitorio=0;
                                            $total_iva=0;
                                            $total_efectivo=0;
                                            $total_debito=0;
                                            $total_credito=0;
                                            $total_cheque=0;
                                            $total_transf=0;
                                            $total_cobrado=0;

                                            $interes_D=0;
                                            $total_capital_D=0;
                                            $total_interes_D=0;
                                            $total_moratorio_D=0;
                                            $total_punitorio_D=0;
                                            $total_iva_D=0;
                                            $total_efectivo_D=0;
                                            $total_debito_D=0;
                                            $total_credito_D=0;
                                            $total_cheque_D=0;
                                            $total_transf_D=0;
                                            $total_cobrado_D=0;

                                            if($moneda == "GS")
                                            {
                                                $interes=$p->moratorio+$p->punitorio+$p->iva;
                                                $total_capital=$total_capital + $p->capital;
                                                $total_interes=$total_interes + $interes;
                                                $total_moratorio=$total_moratorio + $p->moratorio;
                                                $total_punitorio=$total_punitorio + $p->punitorio;
                                                $total_iva=$total_iva + $p->iva;
                                                $total_efectivo=$total_efectivo + $p->total_pagf;
                                                $total_debito=$total_debito + $p->total_pagtd;
                                                $total_credito=$total_credito + $p->total_pagtc;
                                                $total_cheque=$total_cheque + $p->total_pagch;
                                                $total_transf=$total_transf + $p->total_pagtr;
                                                $total_cobrado=$total_cobrado + $p->totalpagado;
                                            }
                                            else
                                            {
                                                $interes_D=$p->moratorio+$p->punitorio+$p->iva;
                                                $total_capital_D=$total_capital_D + $p->capital;
                                                $total_interes_D=$total_interes_D + $interes;
                                                $total_moratorio_D=$total_moratorio_D + $p->moratorio;
                                                $total_punitorio_D=$total_punitorio_D + $p->punitorio;
                                                $total_iva_D=$total_iva_D + $p->iva;
                                                $total_efectivo_D=$total_efectivo_D + $p->total_pagf;
                                                $total_debito_D=$total_debito_D + $p->total_pagtd;
                                                $total_credito_D=$total_credito_D + $p->total_pagtc;
                                                $total_cheque_D=$total_cheque_D + $p->total_pagch;
                                                $total_transf_D=$total_transf_D + $p->total_pagtr;
                                                $total_cobrado_D=$total_cobrado_D + $p->totalpagado;
                                            }
                                           

                                        }
                                    @endphp
                                    
                                @endif
                        @if($titulo==0)   

                        <thead>     

                            <tr>    
                                <th>CAJERO/A</th>                          
                                <!-- <th>CUOTA N째</th> -->
                                <th>FECHA</th>
                                <th>CAPITAL COBRADO</th>
                                <th>FACTURA N째</th>
                                <th>TOTAL FACTURA</th>
                                <!-- <th>INTERES COBRADO</th>
                                <th>MORATORIO</th> 
                                <th>PUNITORIO</th>
                                <th>IVA</th> -->
                                <th>EFECTIVO</th>
                                <th>T. DEBITO</th>
                                <th>T. CREDITO</th> 
                                <th>CHEQUE</th>
                                <th>TRANSFER.</th>
                                <th>TOTAL COBRADO</th>
                                <th>TOTAL IVA</th>
                            </tr>
                        </thead>    
                        <tr id="totales2">   
                        <td colspan="14">CLIENTE: {{$p->nombreCliente}} --- C.I.N째: {{$p->num_documento}}-{{$p->digito}}</td>  
                        </tr> 

                                
                        @endif 
                    @endif 
                        <tbody>    
                            <tr>       
                                <td>{{$p->name}}</td>                             
                                <!-- <td>{{$p->cuota_nro}}</td> -->
                                <td>{{ date('d-m-Y', strtotime($p->fec_vto)) }}</td>
                               
                                    <td>Gs. {{number_format(($p->capital), 0, ",", ".")}}</td>
                                    <!-- <td>Gs. {{number_format(($interes), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($p->moratorio), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($p->punitorio), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($p->iva), 0, ",", ".")}}</td> -->
                                    @if($p->contable == 1)
                                        <td><strong>Fact N°: {{$p->inmueble_id}}</strong></td> 
                                    @else
                                        <td><strong>Rec N°: {{$p->nro_recibo}}</strong></td> 
                                    @endif
                                    <td><strong>Gs. {{number_format(($p->total_fact), 0, ",", ".")}}</strong></td> 
                                    <td>Gs. {{number_format(($p->total_pagf), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($p->total_pagtd), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($p->total_pagtc), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($p->total_pagch), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($p->total_pagtr), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($p->totalpagado), 0, ",", ".")}}</td> 
                                    <td>Gs. {{number_format(($p->totalpagado/11), 0, ",", ".")}}</td> 
                                    @php    
                                        $sup_total_capital=$sup_total_capital + $p->capital;
                                        $sup_total_interes=$sup_total_interes + $interes;
                                        $sup_total_moratorio=$sup_total_moratorio + $p->moratorio;
                                        $sup_total_punitorio=$sup_total_punitorio + $p->punitorio;
                                        $sup_total_iva=$sup_total_iva + $p->iva;
                                        $sup_total_efectivo=$sup_total_efectivo + $p->total_pagf;
                                        $sup_total_debito=$sup_total_debito + $p->total_pagtd;
                                        $sup_total_credito=$sup_total_credito + $p->total_pagtc;
                                        $sup_total_cheque=$sup_total_cheque + $p->total_pagch;
                                        $sup_total_transf=$sup_total_transf + $p->total_pagtr;
                                        $sup_total_cobrado=$sup_total_cobrado + $p->totalpagado;
                                    @endphp
                                                                            
                            </tr>
                       
                            @if($loop->last)
                                <tr id="totales">  
                                    <td></td> 
                                    <td><strong>TOTALES</strong></td>   
                                        <td><strong>Gs. {{number_format(($total_capital), 0, ",", ".")}}</strong></td> 
                                        <td><strong></strong></td>
                                        <td><strong></strong></td> 
                                        <td><strong>Gs. {{number_format(($total_efectivo), 0, ",", ".")}}</strong></td>
                                        <td><strong>Gs. {{number_format(($total_debito), 0, ",", ".")}}</strong></td>
                                        <td><strong>Gs. {{number_format(($total_credito), 0, ",", ".")}}</strong></td>
                                        <td><strong>Gs. {{number_format(($total_cheque), 0, ",", ".")}}</strong></td>
                                        <td><strong>Gs. {{number_format(($total_transf), 0, ",", ".")}}</strong></td>
                                        <td><strong>Gs. {{number_format(($total_cobrado), 0, ",", ".")}}</strong></td>  
                                        <td><strong>Gs. {{number_format(($total_cobrado/11), 0, ",", ".")}}</strong></td> 
                                </tr>
                            @endif
                                  
                        </tbody>
                            
            @endforeach
                    
            </table>
            <!-- /* Total General */ -->
            <h3 style:"text-align: center;">Total General</h3>
            <table id="letratabla" class="table table-bordered table-striped table-sm">                                         
                <thead>                            
                    <tr>    
                        <th colspan="3"></th> 
                        <th></th> 
                        <th></th> 
                        <th>CAPITAL COBRADO</th>
                        <!-- <th>INTERES COBRADO</th>
                        <th>MORATORIO</th> 
                        <th>PUNITORIO</th>
                        <th>IVA</th> -->
                        <th>EFECTIVO</th>
                        <th>T. DEBITO</th>
                        <th>T. CREDITO</th> 
                        <th>CHEQUE</th>
                        <th>TRANSFER.</th>
                        <th>TOTAL COBRADO</th>
                        <th>TOTAL IVA</th>
                    </tr>
                </thead>
                <tbody>                                 
                    <tr id="totales">  
                            <td colspan="3"><strong>TOTALES</strong></td>  
                            <td><strong></strong></td> 
                            <td><strong></strong></td>
                               
                            <td><strong>Gs. {{number_format(($sup_total_capital), 0, ",", ".")}}</strong></td>  
                            <!-- <td><strong>Gs. {{number_format(($sup_total_interes), 0, ",", ".")}}</strong></td>
                            <td><strong>Gs. {{number_format(($sup_total_moratorio), 0, ",", ".")}}</strong></td>    
                            <td><strong>Gs. {{number_format(($sup_total_punitorio), 0, ",", ".")}}</strong></td> 
                            <td><strong>Gs. {{number_format(($sup_total_iva), 0, ",", ".")}}</strong></td> -->
                            <td><strong>Gs. {{number_format(($sup_total_efectivo), 0, ",", ".")}}</strong></td>
                            <td><strong>Gs. {{number_format(($sup_total_debito), 0, ",", ".")}}</strong></td>
                            <td><strong>Gs. {{number_format(($sup_total_credito), 0, ",", ".")}}</strong></td>
                            <td><strong>Gs. {{number_format(($sup_total_cheque), 0, ",", ".")}}</strong></td>
                            <td><strong>Gs. {{number_format(($sup_total_transf), 0, ",", ".")}}</strong></td>
                            <td><strong>Gs. {{number_format(($sup_total_cobrado), 0, ",", ".")}}</strong></td>
                            <td><strong>Gs. {{number_format(($sup_total_cobrado/11), 0, ",", ".")}}</strong></td>

                            @php    
                                $sup_total_capital=$sup_total_capital + $p->capital;
                                $sup_total_interes=$sup_total_interes + $interes;
                                $sup_total_moratorio=$sup_total_moratorio + $p->moratorio;
                                $sup_total_punitorio=$sup_total_punitorio + $p->punitorio;
                                $sup_total_iva=$sup_total_iva + $p->iva;
                                $sup_total_efectivo=$sup_total_efectivo + $p->total_pagf;
                                $sup_total_debito=$sup_total_debito + $p->total_pagtd;
                                $sup_total_credito=$sup_total_credito + $p->total_pagtc;
                                $sup_total_cheque=$sup_total_cheque + $p->total_pagch;
                                $sup_total_transf=$sup_total_transf + $p->total_pagtr;
                                $sup_total_cobrado=$sup_total_cobrado + $p->totalpagado;
                            @endphp  
                                                                  
                    </tr>    
                    
                                                      
                </tbody>
            </table>

     
            </div>
        </section>  
        @endif 
  </div><!--fin del div card body-->
  <footer>
    <hr>
    <p><b>LABPROF GROUP</b> <b>Usuario:</b> {{auth()->user()->name}}</p>
    <p><b>{{date('d-m-Y H:i:s')}}</b></p>
  </footer>
</html>