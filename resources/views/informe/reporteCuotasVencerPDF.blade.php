<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cuotas a Vencer</title>
    
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
        #totalesporfec{		
            background-color: rgb(198, 200, 221);
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
        <h2 id="titulo" class="text-center">Cuotas a Vencer - Guaranies -  {{ date('d/m/Y', strtotime($date1))}} -  {{ date('d/m/Y', strtotime($date2))}}</h2><br/>   

    </header>
    
    <section id="marco">
            <div>
            <table class="table table-bordered table-striped table-sm">                               
                    <thead>                            
                        <tr>                                  
                            <th>Cliente</th>
                            <th>Inmueble</th>
                            <th>Cuota Nro</th>
                            <th>Fec. Vto</th>
                            <th>Capital</th>
                            <th>Total Cuota</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Inicializamos las variables -->
                        @php    
                            $total_tot_cap=0;        
                            $total_tot_tot=0;  

                        @endphp

                        @foreach($cuotas as $cuota)
                            @if($loop->first){
                                @php
                                    $fec=$cuota->fec_vto;     
                                    $total_fec_cap=0;        
                                    $total_fec_tot=0;      
                                @endphp
                            }
                            @endif
                         
                            @if($fec!=$cuota->fec_vto)
                                <tr id="totalesporfec">   
                                    <td></td> 
                                    <td><strong>TOTALES POR FECHA</strong></td>     
                                    <td></td> 
                                    <td></td> 
                                    <td><strong>Gs. {{number_format(($total_fec_cap), 0, ",", ".")}}</strong></td> 
                                    <td><strong>Gs. {{number_format(($total_fec_tot), 0, ",", ".")}}</strong></td>                   
                                </tr>
                                @php
                                    $fec=$cuota->fec_vto;    
                                    $total_fec_cap=0;        
                                    $total_fec_tot=0;     
                                @endphp
                            @endif
                            @php   
                                $total_fec_cap+=$cuota->capital;        
                                $total_fec_tot+=$cuota->total_cuota;           
                                $total_tot_cap+=$cuota->capital;           
                                $total_tot_tot+=$cuota->total_cuota;         
                            @endphp
                            <tr>                                    
                                <td>{{$cuota->nombre}}</td>
                                <td>{{$cuota->nombreInm}}</td>
                                <td>{{$cuota->cuota_nro}}</td>
                                <td>{{ date('d-m-Y', strtotime($cuota->fec_vto))}}</td>
                                @if($cuota->moneda == "GS")
                                    <td>Gs. {{number_format(($cuota->capital), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($cuota->total_cuota), 0, ",", ".")}}</td>
                                    @else
                                    <td>U$s. {{number_format(($cuota->capital), 2, ",", ".")}}</td>
                                    <td>U$s. {{number_format(($cuota->total_cuota), 2, ",", ".")}}</td>
                                @endif
                            </tr>
                            @if($loop->last)
                            <tr id="totalesporfec">   
                                <td></td> 
                                <td><strong>TOTALES POR FECHA</strong></td>     
                                <td></td> 
                                <td></td> 
                                <td><strong>Gs. {{number_format(($total_fec_cap), 0, ",", ".")}}</strong></td> 
                                <td><strong>Gs. {{number_format(($total_fec_tot), 0, ",", ".")}}</strong></td>                   
                            </tr>
                            <tr id="totales">   
                                <td></td> 
                                <td><strong>TOTALES</strong></td>     
                                <td></td> 
                                <td></td> 
                                <td><strong>Gs. {{number_format(($total_tot_cap), 0, ",", ".")}}</strong></td> 
                                <td><strong>Gs. {{number_format(($total_tot_tot), 0, ",", ".")}}</strong></td>                   
                            </tr>
                             @endif
                        @endforeach                                  
                    </tbody>
                </table>
            </div>
        </section>
    <hr id="hr"> <!-- Salto de página -->

    <h2 id="titulo" class="text-center">Cuotas a Vencer - Dolares - {{ date('d/m/Y', strtotime($date1))}} - {{ date('d/m/Y', strtotime($date2))}} </h2><br/>   
    
    <section>
            <div>
            <table class="table table-bordered table-striped table-sm">                               
                    <thead>                            
                        <tr>                                  
                            <th>Cliente</th>
                            <th>Inmueble</th>
                            <th>Cuota Nro</th>
                            <th>Fec. Vto</th>
                            <th>Capital</th>
                            <th>Total Cuota</th> 
                        </tr>
                    </thead>
                    <tbody>
                            <!-- Inicializamos las variables -->
                            @php    
                                $total_tot_cap=0;        
                                $total_tot_tot=0;  

                            @endphp

                            @foreach($cuotas_us as $cuota)
                            <!-- Acumulamos -->
                                @if($loop->first){
                                    @php
                                        $fec=$cuota->fec_vto;     
                                        $total_fec_cap=0;        
                                        $total_fec_tot=0;      
                                    @endphp
                                }
                                @endif
                             
                                @if($fec!=$cuota->fec_vto)
                                    <tr id="totalesporfec">   
                                        <td></td> 
                                        <td><strong>TOTALES POR FECHA</strong></td>     
                                        <td></td> 
                                        <td></td> 
                                        <td><strong>U$s. {{number_format(($total_fec_cap), 2, ",", ".")}}</strong></td> 
                                        <td><strong>U$s. {{number_format(($total_fec_tot), 2, ",", ".")}}</strong></td>                   
                                    </tr>
                                    @php
                                        $fec=$cuota->fec_vto;    
                                        $total_fec_cap=0;        
                                        $total_fec_tot=0;     
                                    @endphp
                                @endif
                                @php   
                                    $total_fec_cap+=$cuota->capital;        
                                    $total_fec_tot+=$cuota->total_cuota;           
                                    $total_tot_cap+=$cuota->capital;           
                                    $total_tot_tot+=$cuota->total_cuota;         
                                @endphp

                            <tr>  
                                <td>{{$cuota->nombre}}</td>
                                <td>{{$cuota->nombreInm}}</td>
                                <td>{{$cuota->cuota_nro}}</td>
                                <td>{{ date('d-m-Y', strtotime($cuota->fec_vto))}}</td>
                                @if($cuota->moneda == "GS")
                                    <td>Gs. {{number_format(($cuota->capital), 0, ",", ".")}}</td>
                                    <td>Gs. {{number_format(($cuota->total_cuota), 0, ",", ".")}}</td>
                                    @else
                                    <td>U$s. {{number_format(($cuota->capital), 2, ",", ".")}}</td>
                                    <td>U$s. {{number_format(($cuota->total_cuota), 2, ",", ".")}}</td>
                                @endif
                                                        
                            </tr>

                            @if($loop->last)
                                <tr id="totalesporfec">   
                                    <td></td> 
                                    <td><strong>TOTALES POR FECHA</strong></td>     
                                    <td></td> 
                                    <td></td> 
                                    <td><strong>U$s. {{number_format(($total_fec_cap), 2, ",", ".")}}</strong></td> 
                                    <td><strong>U$s. {{number_format(($total_fec_tot), 2, ",", ".")}}</strong></td>                   
                                </tr>
                                <tr id="totales">   
                                    <td></td> 
                                    <td><strong>TOTALES</strong></td>     
                                    <td></td> 
                                    <td></td> 
                                    <td><strong>U$s. {{number_format(($total_tot_cap), 2, ",", ".")}}</strong></td> 
                                    <td><strong>U$s. {{number_format(($total_tot_tot), 2, ",", ".")}}</strong></td>                   
                                </tr>
                            @endif
                        @endforeach    
                        
                    </tbody>
                </table>
            </div>
        </section>
   
  </div><!--fin del div card body-->
  <footer>
  <hr>
    <p><b>LABPROF GROUP</b> <b>Usuario:</b> {{auth()->user()->name}}</p>
    <p><b>{{date('d-m-Y H:i:s')}}</b></p>
  </footer>
</html>