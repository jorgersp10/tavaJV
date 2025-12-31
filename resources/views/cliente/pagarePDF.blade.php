<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pagaré a la Orden</title>
    <div id="body" class="body">

    <style>
        #encabezado{
        font-size: 11px;
        }
        #timbrado{
        font-size: 8px;
        }
        #dir{
        font-size: 8px;
        }
        #direccion{
        font-size: 12px;
        }
        #cuerpo{
        font-size: 12.5px;
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
            width: 50px;
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
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }

        #marco{
		
            page-break-inside: auto;
	    }
        #margenTabla{
            margin: 35px;
        }
        #divcuadro {
            border-style: solid;
        font-size: 20px;
        }
    </style>

<section id="margenTabla">
        
        <div class="Row">
            <!-- <h4 class="float-end font-size-16">Order # 12345</h4> -->
            <div  class="Column" style="text-align:center;" id="timbrado">
            <img src="{{ public_path('assets/images/inox.png') }}" alt="logo" height="45px" width="200px" /><br>
            </div>
            <div class="Column" id="direccion">
                
                <strong style="text-align:center;" >Ruta 1 - Segunda Paralela al este</strong> <br>
                <strong style="text-align:center;" >Tel.: (071) 207615 - (0986) 755440</strong> <br>
                <strong style="text-align:center;">Encarnacion - Paraguay</strong> <br>
                
            </div>
            <div style="text-align:center;"class="Column" id="divcuadro">
                
                <strong></strong> <br>
                <strong>{{number_format(($total_pagar), 0, ",", ".")}} Gs.</strong><br>   
                
            </div>
        </div>
            @php 
                if(($cuotas[0]->fact_nro) == 0)
                    $factura = "___________";
                else
                    $factura=$cuotas[0]->fact_nro;
            @endphp

        <div id="cuerpo">
            <p>
            PAGAREMOS A LA ORDEN DE LABPROF GROUP DE ARMANDO GABRIEL GÓMEZ CON C.I. Nº 0000000 La suma de guaraníes,
            <strong>{{$total_pag_let}}</strong>--------------------------<br>
            En <strong>{{$cantCuotas}}</strong> cuotas iguales de Gs. <strong>{{number_format(($montoCuota), 0, ",", ".")}}</strong> todas ellas 
            con vencimiento mensual y consecutivas el {{$diafecha}} de cada mes, las cuales serán abonadas en 
            <!-- domicilio del acreedor sito en Ruta 1 - Segunda Paralela al Este. La Primera el <strong>{{ date('d-m-Y', strtotime($fecha_ini))}}</strong>, 
            y la Ultima el <strong>{{ date('d-m-Y', strtotime($fecha_fin))}}</strong>, por igual valor recibo en mercadería (s) a mi entera  -->
            satisfacción consistente en <strong>{{number_format(($total_pagar), 0, ",", ".")}} Gs.</strong> según 
            Numero de factura Nº <strong>{{$factura}}</strong>.<br> 
            Queda expresamente convenido que la falta de pago de cualquiera de las cuotas en los plazos establecidos, 
            hará incurrir automáticamente en mora al (los) deudor (es) sin necesidad de requerimiento alguno, cuyo caso 
            decaerán de pleno derecho y caducarán todos los plazos de las cuotas no vencidas, y el acreedor podrá exigir 
            el pago total adeudado como obligación vencida. A partir de la fecha de vencimiento las cuotas devengarán 3% 
            mensual de interés moratorio por simple retardo, más 1% mensual de interés punitorio. Además el (los) comprador 
            (es) abonará (n) una comisión del 5% en concepto de gestión de cobranza para hacer efectiva las cuotas a causa 
            de la falta de pago en las fechas convenidas y/o en el domicilio del mismo.--------------------------------<br>
            Mientras no haya abonado la totalidad del precio, el comprador se constituye en depositario regular de lo 
            vencido y queda obligado a su conservación, no pudiendo ni transferirlo, ni grabarlo, ni trasladarlo de su 
            domicilio constituido. Los deudores co-deudores y/o endosantes facultan al acreedor para que desde el momento de producida la mora, 
            pueda solicitar el secuestro de la (s) mercadería (s) objeto del presente crédito , asi como solicitar medidas precautorias contra 
            otros bienes de su propiedad. Conforme por ley Nº 1682/00, autorizo suficientemente a la acreedora para que en caso de atraso 
            superior a los noventa y un días en el pago de mi crédito, incluya mi nombre y razón social en el Registro General de Morosos de informconf
            u otros empresas de plaza constituidas para el efecto, asi como también proporcionar dicha información a terceros interesados. Las partes 
            se someten expresamente a la competencia de los tribunales de Encarnación para todos los efectos pertinentes.------------------

            </p>
        </div>
</section> 
<section id="margenTabla">
    <div>
        <table class="table table-bordered table-striped table-sm">                               
                <thead>                            
                    <tr>                                  
                        <th >Nombre: {{$cuotas[0]->nombre}}</th>
                    </tr>
                    <tr>                                  
                        <th>C.I.N°: {{$cuotas[0]->num_documento}}</th>
                    </tr>
                    <tr>                                  
                        <th>Firma:</th>
                    </tr>
                    <tr>                                  
                        <th>N° Celular: {{$cuotas[0]->telefono}}</th>
                    </tr>
                </thead>
                
            </table>
    </div>
    <p style="text-align:center;">DEUDOR</p>
    <div>
        <table class="table table-bordered table-striped table-sm">                               
                <thead style="width:50px">                            
                    <tr >                                  
                        <th >Nombre:</th>
                    </tr>
                    <tr>                                  
                        <th>C.I.N°:</th>
                    </tr>
                    <tr>                                  
                        <th>Firma:</th>
                    </tr>
                    <tr>                                  
                        <th>N° Celular:</th>
                    </tr>
                </thead>
                
            </table>
    </div>
    <p style="text-align:center;">CODEUDOR</p>
</section>
<!-- *********************************************DUPLICADO DE RECIBO**************************** -->
</html>
