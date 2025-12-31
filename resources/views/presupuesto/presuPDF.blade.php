<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Presupuesto</title>
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
                <img src="{{ public_path('assets/images/inox.png') }}" alt="logo" height="55px" width="250px" /><br>  
            </div>
            <div class="Column" id="direccion">
                
                <strong style="text-align:center;" >Ruta 1 KM 2 1 Encarnación</strong> <br>
                <strong style="text-align:center;" >Tel.: (071) 207 615 - (0986) 755 440</strong> <br>
                <strong style="text-align:center;">Encarnación - Paraguay</strong> <br>
                
            </div>
            <div style="text-align:center;"class="Column">
                <strong><h2>PRESUPUESTO</h2></strong><br>                
            </div>
        </div>
            <div class="form-group row">
                <p class="col-md-2 form-control-label"><b>Fecha: </b>{{ date('d-m-Y', strtotime($ventas->fecha)) }}</p>

                <p class="col-md-2 form-control-label"><b>Cliente: </b>{{$ventas->nombre}}</p>
                    
                <p class="col-md-2 form-control-label"><b>Documento: </b>{{$ventas->num_documento}}</p>
                    
                </div>
        <div class="form-group row border">

                <h3>Detalle de presupuesto</h3>

                <div class="table-responsive col-md-12">
                <table id="detalles" class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio (Gs.)</th>                        
                        <th>SubTotal (Gs.)</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($detalles as $det)

                    <tr>
                        <td style="width:30px">{{$det->cantidad}}</td>
                        <td style="width:200px">{{$det->producto}}</td>
                        <td>Gs. {{number_format(($det->precio), 0, ",", ".")}}</td>
                        <td>Gs. {{number_format(($det->cantidad*$det->precio), 0, ",", ".")}}</td>
                    </tr> 

                    @endforeach
                    
                </tbody>
                <tfoot>

                    <tr>
                        <th  colspan="3"><p align="left">TOTAL PAGAR: {{$tot_pag_let}}</p></th>
                        <th><p align="left">Gs. {{number_format($ventas->total, 0, ",", ".")}}</p></th>
                    </tr> 

                </tfoot>

                

                </table>
            </div>
        </div>

<!-- *********************************************DUPLICADO DE RECIBO**************************** -->
</html>
