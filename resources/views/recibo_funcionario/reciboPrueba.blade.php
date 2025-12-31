<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liquidación de Salario</title>
    <div id="body" class="body">

    <style>
        #seccion2 {
            /* margin: 145px 1px 1px 0px; */
            padding-top: 112px;
        }
        #encabezado{
        font-size: 11px;
        }
        #alturaDiv{
        font-size: 11px;
        height: 180px;
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
            width: 70px !important;  
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

        #totalAl{
            padding-left: 555px;
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

<section id="seccion1">
        
        <div class="Row">
            <!-- <h4 class="float-end font-size-16">Order # 12345</h4> -->
            <div  class="Column" style="text-align:center;" id="timbrado">
            <img src="{{ public_path('assets/images/inox.png') }}" alt="logo" height="45px" width="200px" /><br>
                <strong style="text-align:center;" >Ruta 1 - Segunda Paralela al este</strong> <br>
                <strong style="text-align:center;" >Tel.: (071) 207615 - (0986) 755440</strong> <br>
                <strong style="text-align:center;">Encarnacion - Paraguay</strong> <br>
            </div>
            <div class="Column" id="ruc">
                
                    <strong>RUC:</strong> 6698924-8<br>
                    <strong>LIQUIDACIÓN DE SALARIO</strong><br>
                    <strong>NRO:</strong> {{$recibos->nro_recibo}}<br>
                
            </div>
            <div class="Column" id="ruc">
                
                    <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                    <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                
            </div>
        </div></br>
        
        <div class="Row">
            <div class="Column" id="encabezado">
                <p class="font-size-12 font-weight-bold">Empleador: A&M INOX - HIERROS </p>
                <p class="font-size-12 font-weight-bold">Empleado: {{$recibos->nombre}} </p>
                <p class="font-size-12 font-weight-bold">C.I.N°: {{number_format(($recibos->num_documento), 0, ",", ".")}}</p>
            </div>
            <div class="Column" id="encabezado">
                
                <p class="font-size-12 font-weight-bold">  MINISTERIO DE TRABAJO, EMPLEO Y SEGURIDAD SOCIAL</p>
                <p class="font-size-12 font-weight-bold">N° PATRONAL: {{$recibos->nro_patronal}} </p>
                <p class="font-size-12 font-weight-bold">MES DE PAGO: {{$mesLetra}} </p>
            </div>
        </div>
        <div id="alturaDiv" >
            <table>
                <thead class = "table-light">
                    <tr>
                        <!-- <th class="titulo">TRANS.</th> -->
                        <th class="titulo">Salario básico</th>
                        <th class="titulo">Horas Extras</th>
                        <th class="titulo">Comisiones</th>
                        <th class="titulo">Otros Ingresos</th>
                        <th class="titulo">Total Salario</th>
                        <th class="titulo">IPS</th>
                        <th class="titulo">Otros Descuentos</th>
                        <th class="titulo">Total Descuentos</th>
                        <th class="titulo">Saldo a cobrar</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td align="center">{{number_format(($recibos->salario_basico), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->horas_extra), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->comisiones), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->otros_ingre), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->salario_basico + $recibos->horas_extra + $recibos->comisiones + $recibos->otros_ingre), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->ips), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->otros_desc), 0, ",", ".")}}</td>                                    
                        <td align="center">{{number_format(($recibos->otros_desc + $recibos->ips), 0, ",", ".")}}</td> 
                        <td align="center">{{number_format(($recibos->salario_cobrar), 0, ",", ".")}}</td>
                    </tr>                              
                    
                </tbody>
            </table>
            
        </div>
        <div class="Row">
            <div id="encabezado" class="Column firma">
                <address class="mt-2 mt-sm-0">
                    <strong style="text-align:right;">__________________________</strong><br> 
                    <strong style="text-align:right;">Firma del encargado</strong><br>                          
                </address>
            </div>
            <div id="encabezado" class="Column firma">
                <address class="mt-2 mt-sm-0">
                    <strong style="text-align:right;">Fecha: {{$recibos->fecha_recibo}}</strong>                        
                </address>
            </div>
            <div id="encabezado" class="Column firma">
                <address class="mt-2 mt-sm-0">
                    <strong style="text-align:right;">__________________________</strong><br> 
                    <strong style="text-align:right;">Firma del empleado</strong><br>                          
                </address>
            </div>
        </div>
    </div>
</section> 
<!-- *********************************************DUPLICADO DE RECIBO**************************** -->
<section id="seccion2">

        <div class="Row">
            <!-- <h4 class="float-end font-size-16">Order # 12345</h4> -->
            <div  class="Column" style="text-align:center;" id="timbrado">
            <img src="{{ public_path('assets/images/inox.png') }}" alt="logo" height="45px" width="200px" /><br>
                <strong style="text-align:center;" >Ruta 1 - Segunda Paralela al este</strong> <br>
                <strong style="text-align:center;" >Tel.: (071) 207615 - (0986) 755440</strong> <br>
                <strong style="text-align:center;">Encarnacion - Paraguay</strong> <br>
            </div>
            <div class="Column" id="ruc">
                
                    <strong>RUC:</strong> 6698924-8<br>
                    <strong>LIQUIDACIÓN DE SALARIO</strong><br>
                    <strong>NRO:</strong> {{$recibos->nro_recibo}}<br>
                
            </div>
            <div class="Column" id="ruc">
                
                    <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                    <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                
            </div>
        </div></br>
        
        <div class="Row">
            <div class="Column" id="encabezado">
                <p class="font-size-12 font-weight-bold">Empleador: A&M INOX - HIERROS </p>
                <p class="font-size-12 font-weight-bold">Empleado: {{$recibos->nombre}} </p>
                <p class="font-size-12 font-weight-bold">C.I.N°: {{number_format(($recibos->num_documento), 0, ",", ".")}}</p>
            </div>
            <div class="Column" id="encabezado">
                
                <p class="font-size-12 font-weight-bold">  MINISTERIO DE TRABAJO, EMPLEO Y SEGURIDAD SOCIAL</p>
                <p class="font-size-12 font-weight-bold">N° PATRONAL: {{$recibos->nro_patronal}} </p>
                <p class="font-size-12 font-weight-bold">MES DE PAGO: {{$mesLetra}} </p>
            </div>
        </div>
        <div id="alturaDiv">
            <table >
                <thead class = "table-light">
                    <tr>
                        <!-- <th class="titulo">TRANS.</th> -->
                        <th class="titulo">Salario básico</th>
                        <th class="titulo">Horas Extras</th>
                        <th class="titulo">Comisiones</th>
                        <th class="titulo">Otros Ingresos</th>
                        <th class="titulo">Total Salario</th>
                        <th class="titulo">IPS</th>
                        <th class="titulo">Otros Descuentos</th>
                        <th class="titulo">Total Descuentos</th>
                        <th class="titulo">Saldo a cobrar</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td align="center">{{number_format(($recibos->salario_basico), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->horas_extra), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->comisiones), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->otros_ingre), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->salario_basico + $recibos->horas_extra + $recibos->comisiones + $recibos->otros_ingre), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->ips), 0, ",", ".")}}</td>
                        <td align="center">{{number_format(($recibos->otros_desc), 0, ",", ".")}}</td>                                    
                        <td align="center">{{number_format(($recibos->otros_desc + $recibos->ips), 0, ",", ".")}}</td> 
                        <td align="center">{{number_format(($recibos->salario_cobrar), 0, ",", ".")}}</td>
                    </tr>                              
                    
                </tbody>
            </table>
            
        </div>
        <div class="Row">
            <div id="encabezado" class="Column firma">
                <address class="mt-2 mt-sm-0">
                    <strong style="text-align:right;">__________________________</strong><br> 
                    <strong style="text-align:right;">Firma del encargado</strong><br>                          
                </address>
            </div>
            <div id="encabezado" class="Column firma">
                <address class="mt-2 mt-sm-0">
                    <strong style="text-align:right;">Fecha: {{$recibos->fecha_recibo}}</strong>                        
                </address>
            </div>
            <div id="encabezado" class="Column firma">
                <address class="mt-2 mt-sm-0">
                    <strong style="text-align:right;">__________________________</strong><br> 
                    <strong style="text-align:right;">Firma del empleado</strong><br>                          
                </address>
            </div>
        </div>
    </div>
    </section>
</html>
