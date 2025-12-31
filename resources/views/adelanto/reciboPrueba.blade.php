<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adelanto de Salario</title>
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
                    <strong>ADELANTO DE SALARIO</strong><br>
                
            </div>
            <div class="Column" id="ruc">
                
                    <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                    <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                
            </div>
        </div></br>
        
        <div class="Row">
            <div class="Column" id="encabezado">
                <p class="font-size-12 font-weight-bold">Empleador: A&M INOX - HIERROS </p>
                <p class="font-size-12 font-weight-bold">Empleado: {{$adelantos->nombre}} </p>
                <p class="font-size-12 font-weight-bold">C.I.N°: {{number_format(($adelantos->num_documento), 0, ",", ".")}}</p>
            </div>
            <div class="Column" id="encabezado">
                
                <p class="font-size-12 font-weight-bold">N° PATRONAL: {{$adelantos->nro_patronal}} </p>
                <p class="font-size-12 font-weight-bold">MES DE ADELANTO: {{$mesLetra}} </p>
            </div>
        </div>
        <div id="alturaDiv" >
            <table>
                <thead class = "table-light">
                    <tr>
                        <!-- <th class="titulo">TRANS.</th> -->
                        <th class="titulo">Adelanto</th>
                        <th class="titulo">Fecha de adelanto</th>
                        <th class="titulo">Mes al que corresponde</th>
                        <th class="titulo">Comentario</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td align="center">{{number_format(($adelantos->adelanto), 0, ",", ".")}}</td>
                        <td align="center">{{ date('d-m-Y', strtotime($adelantos->fecha_adelanto)) }}</td>
                        <td align="center">{{$mesLetra}}</td>
                        <td align="center">{{$adelantos->comentario}}</td>
                       
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
                    <strong style="text-align:right;">Fecha: {{$adelantos->fecha_adelanto}}</strong>                        
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
                    <strong>ADELANTO DE SALARIO</strong><br>
                
            </div>
            <div class="Column" id="ruc">
                
                    <strong>Fecha:</strong> {{date('d-m-Y')}}<br>
                    <strong>Usuario:</strong> {{auth()->user()->name}}<br> 
                
            </div>
        </div></br>
        
        <div class="Row">
            <div class="Column" id="encabezado">
                <p class="font-size-12 font-weight-bold">Empleador: A&M INOX - HIERROS </p>
                <p class="font-size-12 font-weight-bold">Empleado: {{$adelantos->nombre}} </p>
                <p class="font-size-12 font-weight-bold">C.I.N°: {{number_format(($adelantos->num_documento), 0, ",", ".")}}</p>
            </div>
            <div class="Column" id="encabezado">
                

                <p class="font-size-12 font-weight-bold">N° PATRONAL: {{$adelantos->nro_patronal}} </p>
                <p class="font-size-12 font-weight-bold">MES DE ADELANTO: {{$mesLetra}} </p>
            </div>
        </div>
        <div id="alturaDiv" >
            <table>
                <thead class = "table-light">
                    <tr>
                        <!-- <th class="titulo">TRANS.</th> -->
                        <th class="titulo">Adelanto</th>
                        <th class="titulo">Fecha de adelanto</th>
                        <th class="titulo">Mes al que corresponde</th>
                        <th class="titulo">Comentario</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td align="center">{{number_format(($adelantos->adelanto), 0, ",", ".")}}</td>
                        <td align="center">{{ date('d-m-Y', strtotime($adelantos->fecha_adelanto)) }}</td>
                        <td align="center">{{$mesLetra}}</td>
                        <td align="center">{{$adelantos->comentario}}</td>
                       
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
                    <strong style="text-align:right;">Fecha: {{$adelantos->fecha_adelanto}}</strong>                        
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
