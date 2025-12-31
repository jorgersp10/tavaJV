<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Compras por Fechas</title>
    
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
        font-size: 12px;
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
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
            font-weight: bold;
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
        <h2 id="titulo" class="text-center">Compras por rango de Fecha</h2>   

    </header>
 
    @if(($date1 == null || $date2 == null))
        <h3 >Rango de Fecha: Todas las fechas</h3>
        @else
        <h3>Rango de Fecha: {{ date('d-m-Y', strtotime($date1)) }} al {{ date('d-m-Y', strtotime($date2)) }}</h3>
    @endif
    @if($compras=="Vacio")
    <h4 >No posee compras</h4>
    @else
    <h3 id="titulo" class="text-center">Compras de materiales</h3>
    ***************************************************************************
    <section id="marco">
        <div>
            <table id="letratabla" class="table table-bordered table-striped table-sm">  
            @php
                $total_iva=0;
                $total_compra=0;
            @endphp
            
                <thead>  
                    <tr> 
                        <th>Proveedor</th>
                        <th>Fact. Nro</th>
                        <th>Fecha</th>
                        <th>Total Iva</th>
                        <th>Total Factura</th>
                    </tr>
                </thead>
            @foreach($compras as $com)
                <tbody>    
                    <tr>       
                        <td>{{$com->nombre}}</td>                             
                        <td>{{$com->fact_compra}}</td>
                        <td>{{ date('d-m-Y', strtotime($com->fecha)) }}</td>                             
                        <td>Gs. {{number_format(($com->iva), 0, ",", ".")}}</td>
                        <td>Gs. {{number_format(($com->total), 0, ",", ".")}}</td>                                                                     
                    </tr>
                @php
                    $total_iva=$total_iva + $com->iva;
                    $total_compra=$total_compra + $com->total;
                @endphp
                </tbody>
            @endforeach       
            <tr id="totales">       
                <td >TOTALES</td>                             
                <td></td>
                <td></td>                             
                <td>Gs. {{number_format(($total_iva), 0, ",", ".")}}</td>
                <td>Gs. {{number_format(($total_compra), 0, ",", ".")}}</td>                                                                     
            </tr>   
            </table>
           
        </div>
    </section>  
    @endif 

    @if($gastos=="Vacio")
    <h4 >No posee gastos</h4>
    @else
    <h3 id="titulo" class="text-center">Gastos Varios</h3>
    ***************************************************************************
    <section id="marco">
        <div>
            <table id="letratabla" class="table table-bordered table-striped table-sm">  
            @php
                $total_iva_gasto=0;
                $total_gasto=0;
            @endphp
            
                <thead>  
                    <tr> 
                        <th>Proveedor</th>
                        <th>Fact. Nro</th>
                        <th>Fecha</th>
                        <th>Total Iva</th>
                        <th>Total Factura</th>
                    </tr>
                </thead>
            @foreach($gastos as $com)
                <tbody>    
                    <tr>       
                        <td>{{$com->nombre}}</td>                             
                        <td>{{$com->fact_compra}}</td>
                        <td>{{ date('d-m-Y', strtotime($com->fecha)) }}</td>                             
                        <td>Gs. {{number_format(($com->iva), 0, ",", ".")}}</td>
                        <td>Gs. {{number_format(($com->total), 0, ",", ".")}}</td>                                                                     
                    </tr>
                @php
                    $total_iva_gasto=$total_iva_gasto + $com->iva;
                    $total_gasto=$total_gasto + $com->total;
                @endphp
                </tbody>
            @endforeach       
            <tr id="totales">       
                <td >TOTALES</td>                             
                <td></td>
                <td></td>                             
                <td>Gs. {{number_format(($total_iva_gasto), 0, ",", ".")}}</td>
                <td>Gs. {{number_format(($total_gasto), 0, ",", ".")}}</td>                                                                     
            </tr>   
            </table>
           
        </div>
    </section>  
    @endif 

    <!-- //PAGO DE SALARIOS -->
     @if($salarios=="Vacio")
    {{-- <h4 >No posee salarios</h4> --}}
    @else
    <h3 id="titulo" class="text-center">Pago de Salarios</h3>
    ***************************************************************************
    <section id="marco">
        <div>
            <table id="letratabla" class="table table-bordered table-striped table-sm">  
            @php
                $total_iva_salario=0;
                $total_salario=0;
            @endphp
            
                <thead>  
                    <tr> 
                        <th>Funcionario</th>
                        <th>Recibo. Nro</th>
                        <th>Fecha</th>
                        <th>Total Iva</th>
                        <th>Total Pagado</th>
                    </tr>
                </thead>
            @foreach($salarios as $com)
                <tbody>    
                    <tr>       
                        <td>{{$com->nombre}}</td>                             
                        <td>{{$com->nro_recibo}}</td>
                        <td>{{ date('d-m-Y', strtotime($com->fecha_recibo)) }}</td>                             
                        <td>Gs. 0</td>
                        <td>Gs. {{number_format(($com->salario_cobrar), 0, ",", ".")}}</td>                                                                     
                    </tr>
                @php
                    $total_iva_salario=$total_iva_salario;
                    $total_salario=$total_salario + $com->salario_cobrar;
                @endphp
                </tbody>
            @endforeach       
            <tr id="totales">       
                <td >TOTALES</td>                             
                <td></td>
                <td></td>                             
                <td>Gs. {{number_format(($total_iva_salario), 0, ",", ".")}}</td>
                <td>Gs. {{number_format(($total_salario), 0, ",", ".")}}</td>                                                                     
            </tr>   
            </table>
           
        </div>
    </section>  
    @endif 

    @if($gastos=="Vacio")
            @php
                $total_iva_gasto=0;
                $total_gasto=0;
            @endphp
    @endif
    @if($compras=="Vacio")
            @php
                $total_iva=0;
                $total_compra=0;
            @endphp
    @endif
    @if($salarios=="Vacio")
            @php
                $total_iva_salario=0;
                $total_salario=0;
            @endphp
    @endif
    <h3 id="titulo" class="text-center">TOTAL IVA Y TOTAL GENERAL</h3>
     <section id="marco">
        <div>
            <table id="letratabla" class="table table-bordered table-striped table-sm">  
            @php
                $total_iva_gasto_g=0;
                $total_gasto_g=0;
            @endphp
            <thead>  
                    <tr> 
                        <th>*********</th>
                        <th>*********</th>
                        <th>*********</th>
                        <th>Total Iva</th>
                        <th>Total Factura</th>
                    </tr>
                </thead>
                <tbody>    
                @php
                    $total_iva_gasto_g=$total_iva_gasto + $total_iva +$total_iva_salario;
                    $total_gasto_g=$total_gasto + $total_compra + $total_salario;
                @endphp
                </tbody>    
            <tr id="totales">       
                <td >TOTAL GENERAL</td>                             
                <td></td>
                <td></td>                             
                <td>Gs. {{number_format(($total_iva_gasto_g), 0, ",", ".")}}</td>
                <td>Gs. {{number_format(($total_gasto_g), 0, ",", ".")}}</td>                                                                     
            </tr>   
            </table>
           
        </div>
    </section>  
  <footer>
    <hr>
    <p><b>LABPROF GROUP</b> <b>Usuario:</b> {{auth()->user()->name}}</p>
    <p><b>{{date('d-m-Y H:i:s')}}</b></p>
  </footer>
</html>