
<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Factura LABPROF GROUP</title>
    <div id="body" class="body">
        <style>
            #seccion1 {
                /* margin: 145px 1px 1px 0px; */
                padding-top: 154px;
                font-weight: bold;
            }
            #seccion2 {
                /* margin: 145px 1px 1px 0px; */
                padding-top: 112px;
                font-weight: bold;
            }
            .letra{
                font-size: 11px;
                display: flex;
                align-items: flex-end;
            }
            #margenfecha{
                margin: 0px 0px -38px 96px;
                font-size: 12px;
                display: flex;
                align-items: flex-end;
            }
            #margenfecha2{
                margin: 0px 0px -38px 96px;
                font-size: 12px;
                display: flex;
                align-items: flex-end;
            }
            #encabezado{
            font-size: 11px;
            }
            
            th.cantidad { 
                width: 70px !important;  
            }
            td.desc { 
                width: 310px !important;  
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
            #cond{
                margin: 0px 0px 0px 466px;
            }
            #cond2{
                margin: 0px 0px 0px 586px;
            }
            #mes{
                margin: 0px 0px -12px 85px;
            }    
            #anho{
                margin: 0px 0px -25px 230px;
            }
            #nombrecliente{
                margin: 5px 0px -100px 97px
            }
            #doc{
                margin: 0px 0px -3px 590px
            }
            #nombrecliente2{
                margin: 2px 0px -300px 97px
            }
            #doc2{
                margin: 0px 0px -95px 590px
            }
            #direccion{
                margin: 23px 0px 0px 97px
            }
           
            td.valorParcial { 
                width: 110 !important; 
            }
            #canti { 
                margin: 0px 0px 10px 0px; 
            }
            table td, table td * {
            vertical-align: top;
}
            .alturatabla { 
                height: 200px !important; 
                margin: 0px 0px -50px 0px
            }
            .alturatabla2 { 
                height: 1000px !important; 
                margin: 0px 0px -540px 0px;
                
            }
            /*SECTOR DE MARGENES PARA CONTENIDO DE LA DESCRICION */
            #cant{
                margin-left: 0px;
                padding-top: 15px;
                padding-bottom: 0px;
                width:50px;
            }
            #desc{
                padding-left: 30px;
                padding-top: 15px;
            }
            #preuni{
                padding-left: 65px;
                padding-right: 0px;
                padding-top: 15px;
            }
            #exe{
                padding-left: 8px;
                padding-top: 15px;
            }
            #cinco{
                padding-left: 18px;
                padding-top: 15px;
            }
            #diez{
                padding-left: 18px;
                padding-right: 30px;
                padding-top: 15px;
            }
            /*SECTOR DE TOTALES*/
            #exenta{
                padding-left: 449px;
                padding-top: 16px;
            }
            #tot5{
                padding-left: 18px;
                padding-top: 16px;
            }
            #tot10{
                padding-left: 15px;
                padding-top: 16px;
            }
            #totalgral{
                padding-right: 0px;
            }
            #totalletra{
                padding-left: 145px; 
                               
            }
            
            /*TOTALES DE LOS IVA*/

            #total5{
                margin-left: 250px;
                padding-top: 7px;
            }
            #total10{
                margin-left: 410px;
                padding-top: 7px;
            }
            #totaliva{
                margin-left: 610px;
                padding-top: 7px;
            }
        </style>
        <section id="seccion1">
        <div id="encabezado" class="row">
        <!-- <img src="{{ public_path('assets/images/logoFactura.png') }}" style="width: 200px; height: 200px"> -->
                        <div class="table-responsive">
                            @if($fac[0]->tipo_factura == "CO")
                                <div id="margenfecha">
                                    <p >{{date('d')}}</p>
                                    <p id="mes">{{$mesLetra}}</p>
                                    <p id="anho">21</p>
                                    <p id="cond">XXX</p>
                                </div> 
                            @else
                                <div id="margenfecha2">
                                    <p >{{date('d')}}</p>
                                    <p id="mes">{{$mesLetra}}</p>
                                    <p id="anho">21</p>
                                    <p id="cond2">XXX</p>
                                </div>
                            @endif


                            <div class="letra">
                                <p id="nombrecliente" class="">{{$fac[0]->doc_cli}}</p>
                                <p id="doc">{{$fac[0]->num_documento}}</p>
                            </div>
                            <div class="letra">
                                @if($fac[0]->direccion!=null)
                                    <p id="direccion" class="">{{$fac[0]->direccion}}</p>
                                    @else
                                    <p id="direccion" class="">--------------------</p>
                                @endif
                            </div>
                        </div>
                        @php
                            $total_exenta=0;
                            $total_iv5=0;
                            $total_iv10=0;
                        @endphp
                    </div>
                    <table id="encabezado" class="table-borderless alturatabla">
                    <thead class = "table-light">
                    </thead>
                            <tbody>
                            @foreach($fac as $f)
                            @if($f->moneda == "GS")
                            <tr>
                                <td style="text-align:center;" id="cant">{{$f->cantidad}}</td>
                                @if($f->merca == 10)
                                    <td id="desc" style="width:230px">Recargo {{$f->descripcion}}</td> 
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td>
                                @endif
                                @if($f->merca == 20)
                                    <td id="desc" style="width:230px">Recargo {{$f->descripcion}}</td>
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td> 
                                @endif 
                                @if($f->merca == 30)
                                    <td id="desc" style="width:230px">{{$f->descripcion}}</td>
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td> 
                                @endif 
                                @if($f->merca == 40)
                                    <td id="desc" style="width:230px">{{$f->descripcion}}</td>
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td> 
                                @endif 
                                <td id="exe" style="width:50">{{number_format(($f->precio_exe), 0, ",", ".")}}</td>
                                <td id="cinco" style="width:50">{{number_format(($f->precio_iv5), 0, ",", ".")}}</td>
                                <td id="diez" style="width:50">{{number_format(($f->precio_iv10), 0, ",", ".")}}</td>
                            </tr>
                            @else
                            <tr>
                                <td style="text-align:center;" id="cant">{{$f->cantidad}}</td>
                                @if($f->merca == 10)
                                    <td id="desc" style="width:230px">Recargo {{$f->descripcion}}</td> 
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 2, ",", ".")}}</td>
                                @endif
                                @if($f->merca == 20)
                                    <td id="desc" style="width:230px">Recargo {{$f->descripcion}}</td>
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 2, ",", ".")}}</td> 
                                @endif 
                                @if($f->merca == 30)
                                    <td id="desc" style="width:230px">{{$f->descripcion}}</td>
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 2, ",", ".")}}</td> 
                                @endif  
                                <td id="exe" style="width:50">{{number_format(($f->precio_exe), 2, ",", ".")}}</td>
                                <td id="cinco" style="width:50">{{number_format(($f->precio_iv5), 2, ",", ".")}}</td>
                                <td id="diez" style="width:50">{{number_format(($f->precio_iv10), 2, ",", ".")}}</td>
                            </tr>
                            @endif
                                @php
                                    $total_exenta=$total_exenta + $f->precio_exe;
                                    $total_iv5=$total_iv5 + $f->precio_iv5;
                                    $total_iv10= $total_iv10 + $f->precio_iv10;
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                              
                        <table class="table-borderless">
                            <tbody>
                            @if($fac[0]->moneda == "GS")
                                <tr id="encabezado">
                                    <td><strong></strong></td>
                                    <td></td>
                                    <td></td>
                                    <td style="width:50" id="exenta">{{number_format(($total_exenta), 0, ",", ".")}}---</td>
                                    <td style="width:50" id="tot5">{{number_format(($total_iv5), 0, ",", ".")}}---</td>
                                    <td style="width:50" id="tot10">{{number_format(($total_iv10), 0, ",", ".")}}---</td>
                                </tr>
                                <tr id="encabezado">
                                    <td ><strong></strong></td>
                                    <td colspan="3" id="totalletra">{{$tot_pag_let}}-</td>
                                    <td ></td>
                                    <td colspan="2" id="totalgral">{{number_format(($f->total_gral), 0, ",", ".")}}---</td>
                                    <td ></td>                                    
                                    <td ></td>
                                    <td ></td>
                                </tr> 
                            @else    
                            
                            <tr id="encabezado">
                                    <td><strong></strong></td>
                                    <td></td>
                                    <td></td>
                                    <td style="width:50" id="exenta">{{number_format(($total_exenta), 2, ",", ".")}}---</td>
                                    <td style="width:50" id="tot5">{{number_format(($total_iv5), 2, ",", ".")}}---</td>
                                    <td style="width:50" id="tot10">{{number_format(($total_iv10), 2, ",", ".")}}---</td>
                                </tr>
                                <tr id="encabezado">
                                    <td ><strong></strong></td>
                                    <td colspan="3" id="totalletra">{{$tot_pag_let}}-</td>
                                    <td ></td>
                                    <td colspan="2" id="totalgral">{{number_format(($f->total_gral), 2, ",", ".")}}---</td>
                                    <td ></td>                                    
                                    <td ></td>
                                    <td ></td>
                                </tr> 
                            @endif
                            </tbody>
                        </table>
                        @php
                            $tota_iva= $total_iv10 + $total_iv5;
                        @endphp
                        <div class="letra">
                        @if($fac[0]->moneda == "GS")
                            <p id="total5">{{number_format(($fac[0]->iv5), 0, ",", ".")}}---</p>
                            <p id="total10">{{number_format(($fac[0]->iv10), 0, ",", ".")}}---</p>
                            <p id="totaliva">{{number_format(($fac[0]->iv5+$fac[0]->iv10), 0, ",", ".")}}---</p>
                        @else
                            <p id="total5">{{number_format(($fac[0]->iv5), 2, ",", ".")}}---</p>
                            <p id="total10">{{number_format(($fac[0]->iv10), 2, ",", ".")}}---</p>
                            <p id="totaliva">{{number_format(($fac[0]->iv5+$fac[0]->iv10), 2, ",", ".")}}---</p>
                        @endif
                        </div>
                    </div>
                </div>
        </section> 
<!-- DUPLICADO -->
        <section id="seccion2">
        <div id="encabezado" class="row">
                        <div class="table-responsive">
                            @if($fac[0]->tipo_factura == "CO")
                                <div id="margenfecha">
                                    <p >{{date('d')}}</p>
                                    <p id="mes">{{$mesLetra}}</p>
                                    <p id="anho">21</p>
                                    <p id="cond">XXX</p>
                                </div> 
                            @else
                                <div id="margenfecha2">
                                    <p >{{date('d')}}</p>
                                    <p id="mes">{{$mesLetra}}</p>
                                    <p id="anho">21</p>
                                    <p id="cond2">XXX</p>
                                </div>
                            @endif

                            <div class="letra">
                                <p id="nombrecliente" class="">{{$fac[0]->doc_cli}}</p>
                                <p id="doc">{{$fac[0]->num_documento}}</p>
                            </div>
                            <div class="letra">
                                @if($fac[0]->direccion!=null)
                                    <p id="direccion" class="">{{$fac[0]->direccion}}</p>
                                    @else
                                    <p id="direccion" class="">--------------------</p>
                                @endif
                            </div>
                        </div>
                        @php
                            $total_exenta=0;
                            $total_iv5=0;
                            $total_iv10=0;
                        @endphp
                    </div>
                    <table id="encabezado" class="table-borderless alturatabla tabladirec">
                    <thead class = "table-light">
                    </thead>
                            <tbody>
                            @foreach($fac as $f)
                            @if($f->moneda == "GS")
                            <tr>
                                <td style="text-align:center;" id="cant">{{$f->cantidad}}</td>
                                @if($f->merca == 10)
                                    <td id="desc" style="width:230px">Recargo {{$f->descripcion}}</td> 
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td>
                                @endif
                                @if($f->merca == 20)
                                    <td id="desc" style="width:230px">Recargo {{$f->descripcion}}</td>
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td> 
                                @endif 
                                @if($f->merca == 30)
                                    <td id="desc" style="width:230px">{{$f->descripcion}}</td>
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td> 
                                @endif 
                                @if($f->merca == 40)
                                    <td id="desc" style="width:230px">{{$f->descripcion}}</td>
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td> 
                                @endif 
                                <td id="exe" style="width:50">{{number_format(($f->precio_exe), 0, ",", ".")}}---</td>
                                <td id="cinco" style="width:50">{{number_format(($f->precio_iv5), 0, ",", ".")}}---</td>
                                <td id="diez" style="width:50">{{number_format(($f->precio_iv10), 0, ",", ".")}}---</td>
                            </tr>
                            @else
                            <tr>
                                <td style="text-align:center;" id="cant">{{$f->cantidad}}</td>
                                @if($f->merca == 10)
                                    <td id="desc" style="width:230px">Recargo {{$f->descripcion}}</td> 
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 2, ",", ".")}}</td>
                                @endif
                                @if($f->merca == 20)
                                    <td id="desc" style="width:230px">Recargo {{$f->descripcion}}</td>
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 2, ",", ".")}}</td> 
                                @endif 
                                @if($f->merca == 30)
                                    <td id="desc" style="width:230px">{{$f->descripcion}}</td>
                                    <td style="width:50" id="preuni">{{number_format(($f->precio_uni), 2, ",", ".")}}</td> 
                                @endif  
                                <td id="exe" style="width:50">{{number_format(($f->precio_exe), 2, ",", ".")}}---</td>
                                <td id="cinco" style="width:50">{{number_format(($f->precio_iv5), 2, ",", ".")}}---</td>
                                <td id="diez" style="width:50">{{number_format(($f->precio_iv10), 2, ",", ".")}}---</td>
                            </tr>
                            @endif
                            @php
                                $total_exenta=$total_exenta + $f->precio_exe;
                                $total_iv5=$total_iv5 + $f->precio_iv5;
                                $total_iv10= $total_iv10 + $f->precio_iv10;
                            @endphp
                            @endforeach
                            </tbody>
                        </table>
                              
                        <table class="table-borderless">
                            <tbody>
                            @if($fac[0]->moneda == "GS")  
                                <tr id="encabezado">
                                    <td><strong></strong></td>
                                    <td></td>
                                    <td></td>
                                    <td style="width:50" id="exenta">{{number_format(($total_exenta), 0, ",", ".")}}---</td>
                                    <td style="width:50" id="tot5">{{number_format(($total_iv5), 0, ",", ".")}}---</td>
                                    <td style="width:50" id="tot10">{{number_format(($total_iv10), 0, ",", ".")}}---</td>
                                </tr>
                                <tr id="encabezado">
                                    <td ><strong></strong></td>
                                    <td colspan="3" id="totalletra">{{$tot_pag_let}}-</td>
                                    <td ></td>
                                    <td colspan="2" id="totalgral">{{number_format(($f->total_gral), 0, ",", ".")}}---</td>
                                    <td ></td>                                    
                                    <td ></td>
                                    <td ></td>
                                </tr>         
                                @else
                                <tr id="encabezado">
                                    <td><strong></strong></td>
                                    <td></td>
                                    <td></td>
                                    <td style="width:50" id="exenta">{{number_format(($total_exenta), 2, ",", ".")}}---</td>
                                    <td style="width:50" id="tot5">{{number_format(($total_iv5), 2, ",", ".")}}---</td>
                                    <td style="width:50" id="tot10">{{number_format(($total_iv10), 2, ",", ".")}}---</td>
                                </tr>
                                <tr id="encabezado">
                                    <td ><strong></strong></td>
                                    <td colspan="3" id="totalletra">{{$tot_pag_let}}-</td>
                                    <td ></td>
                                    <td colspan="2" id="totalgral">{{number_format(($f->total_gral), 2, ",", ".")}}---</td>
                                    <td ></td>                                    
                                    <td ></td>
                                    <td ></td>
                                </tr>     
                                @endif                          
                            </tbody>
                        </table>
                        @php
                            $tota_iva= $total_iv10 + $total_iv5;
                        @endphp
                        <div class="letra">
                        @if($fac[0]->moneda == "GS")
                            <p id="total5">{{number_format(($fac[0]->iv5), 0, ",", ".")}}---</p>
                            <p id="total10">{{number_format(($fac[0]->iv10), 0, ",", ".")}}---</p>
                            <p id="totaliva">{{number_format(($fac[0]->iv5+$fac[0]->iv10), 0, ",", ".")}}---</p>
                        @else
                            <p id="total5">{{number_format(($fac[0]->iv5), 2, ",", ".")}}---</p>
                            <p id="total10">{{number_format(($fac[0]->iv10), 2, ",", ".")}}---</p>
                            <p id="totaliva">{{number_format(($fac[0]->iv5+$fac[0]->iv10), 2, ",", ".")}}---</p>
                        @endif
                        </div>
                    </div>
                </div>
        </section> 
    </div>  
</html>