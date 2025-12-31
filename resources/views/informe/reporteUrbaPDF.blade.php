<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resumen por Urbanizacion</title>
    
    <div class="card-body">
    <style> 
        #datos{
        text-align: left;
        font-size: 12px;
        font-family: "Times New Roman", Times, serif;
        LINE-HEIGHT:10px;
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
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
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
            font-size: 14px;
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
        <h2 id="titulo" class="text-center">{{$urbaNombre}}</h2>
        <h2 id="titulo" class="text-center">Resumen de Clientes - Saldos y Atrasos - GUARANIES</h2><br/>   

    </header>
    
    <section id="marco">
            <div>
            <table class="table table-bordered table-striped table-sm">                               
                    <thead>                            
                        <tr>                                  
                            <th>Cliente</th>
                            <th>Inmueble</th>
                            <th>Precio</th>
                            <th>Pagado</th>
                            <th>Saldo</th>
                            <th>Saldo Vencido</th> 
                            <th>Cuotas atrasadas</th>
                        </tr>
                    </thead>
                    <tbody>
                                @php    
                                    $total_preciopdf=0;        
                                    $total_pagadopdf=0;
                                    $total_saldopdf=0;
                                    $total_saldo_venpdf=0;
                                @endphp

                            @foreach($cuotas_gs as $cgs)
                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                            Asi cada usuario solo puede ver datos de su empresa -->
                                @php    
                                    $total_preciopdf=$total_preciopdf + $cgs->deuda;        
                                    $total_pagadopdf=$total_pagadopdf + $cgs->pagos;
                                    $total_saldopdf=$total_saldopdf + ($cgs->deuda - $cgs->pagos);
                                    $total_saldo_venpdf=$total_saldo_venpdf + ($cgs->saldo_ven - $cgs->pagos_ven);
                                @endphp
                            <tr>                                    
                                <td>{{$cgs->cliente}}</td>
                                <td>{{$cgs->descripcion}}</td>
                                @if($cgs->moneda == "GS")
                                    <td>Gs. {{number_format(($cgs->deuda), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($cgs->pagos), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($cgs->deuda - $cgs->pagos), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($cgs->saldo_ven - $cgs->pagos_ven), 0, ",", ".")}}</td> 
                                    @else
                                    <td>U$s. {{number_format(($cgs->deuda), 0, ",", ".")}}</td>
                                    <td>U$s. {{number_format(($cgs->pagos), 0, ",", ".")}}</td>
                                    <td>U$s. {{number_format(($cgs->deuda - $cgs->pagos), 0, ",", ".")}}</td>
                                    <td>U$s. {{number_format(($cgs->saldo_ven - $cgs->pagos_ven), 0, ",", ".")}}</td>
                                @endif
                                @php            
                                    $atraso=0;
                                @endphp
                                @foreach($cuotasatrasadas_gs as $ctgs)   
                                    @if($cgs->inmueble_id == $ctgs->inmueble_id)  
                                        @php            
                                            $atraso=$ctgs->cuotasAt;
                                        @endphp   
                                    @endif
                                @endforeach
                                <td>{{$atraso}}</td>
                                                        
                            </tr>
                        @endforeach
                        <tr id="totales">   
  
                            <td></td> 
                            <td><strong>TOTALES</strong></td>     
                            <td><strong>Gs. {{number_format(($total_preciopdf), 0, ",", ".")}}</strong></td>                                                 
                            <td><strong>Gs. {{number_format(($total_pagadopdf), 0, ",", ".")}}</strong></td> 
                            <td><strong>Gs. {{number_format(($total_saldopdf), 0, ",", ".")}}</strong></td>
                            <td><strong>Gs. {{number_format(($total_saldo_venpdf), 0, ",", ".")}}</strong></td>    
                                                                                
                        </tr>                                        
                    </tbody>
                </table>
            </div>
        </section>
    <hr id="hr"> <!-- Salto de página -->
    <h2 id="titulo" class="text-center">{{$urbaNombre}}</h2>
    <h2 id="titulo" class="text-center">Resumen de Clientes - Saldos y Atrasos - DÓLARES</h2><br/>   
    
    <section>
            <div>
            <table class="table table-bordered table-striped table-sm">                               
                    <thead>                            
                        <tr>                                  
                            <th>Cliente</th>
                            <th>Inmueble</th>
                            <th>Precio</th>
                            <th>Pagado</th>
                            <th>Saldo</th>
                            <th>Saldo Vencido</th> 
                            <th>Cuotas atrasadas</th>
                        </tr>
                    </thead>
                    <tbody>
                                @php    
                                    $total_preciopdf=0;        
                                    $total_pagadopdf=0;
                                    $total_saldopdf=0;
                                    $total_saldo_venpdf=0;
                                @endphp
                            @foreach($cuotas_us as $cus)
                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                            Asi cada usuario solo puede ver datos de su empresa -->
                                @php    
                                    $total_preciopdf=$total_preciopdf + $cus->deuda;        
                                    $total_pagadopdf=$total_pagadopdf + $cus->pagos;
                                    $total_saldopdf=$total_saldopdf + ($cus->deuda - $cus->pagos);
                                    $total_saldo_venpdf=$total_saldo_venpdf + ($cus->saldo_ven - $cus->pagos_ven);
                                @endphp
                            <tr>                                    
                                <td>{{$cus->cliente}}</td>
                                <td>{{$cus->descripcion}}</td>
                                @if($cus->moneda == "GS")
                                    <td>Gs. {{number_format(($cus->deuda), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($cus->pagos), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($cus->deuda - $cus->pagos), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($cus->saldo_ven - $cus->pagos_ven), 0, ",", ".")}}</td> 
                                    @else
                                    <td>U$s. {{number_format(($cus->deuda), 2, ",", ".")}}</td>
                                    <td>U$s. {{number_format(($cus->pagos), 2, ",", ".")}}</td>
                                    <td>U$s. {{number_format(($cus->deuda - $cus->pagos), 2, ",", ".")}}</td>
                                    <td>U$s. {{number_format(($cus->saldo_ven - $cus->pagos_ven), 2, ",", ".")}}</td>
                                @endif
                                @php            
                                    $atraso=0;
                                @endphp
                                @foreach($cuotasatrasadas_us as $ctus)   
                                    @if($cus->inmueble_id == $ctus->inmueble_id)  
                                        @php            
                                            $atraso=$ctus->cuotasAt;
                                        @endphp   
                                    @endif
                                @endforeach
                                <td>{{$atraso}}</td>
                                                        
                            </tr>
                        @endforeach    
                        
                        <tr id="totales">   
  
                            <td></td> 
                            <td><strong>TOTALES</strong></td>     
                            <td><strong>U$s. {{number_format(($total_preciopdf), 2, ",", ".")}}</strong></td>                                                 
                            <td><strong>U$s. {{number_format(($total_pagadopdf), 2, ",", ".")}}</strong></td> 
                            <td><strong>U$s. {{number_format(($total_saldopdf), 2, ",", ".")}}</strong></td>
                            <td><strong>U$s. {{number_format(($total_saldo_venpdf), 2, ",", ".")}}</strong></td>        
                                                                                
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
   
  </div><!--fin del div card body-->
  <footer>
  <hr>
    <p><b>Credipar S.A.</b> <b>Usuario:</b> {{auth()->user()->name}}</p>
    <p><b>{{date('d-m-Y H:i:s')}}</b></p>
  </footer>
</html>