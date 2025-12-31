<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resumen Inmuebles</title>
    
    <div class="card-body">
    <style> 
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
        pre{		
            page-break-inside: auto;
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;        
        }
        body {
            margin: 145px 1px 1px 0px;
        }
             
        .letra{
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            display: flex;
            align-items: flex-end;
        }
        #margenfecha{
            margin: 0px 0px -38px 96px;
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            display: flex;
            align-items: flex-end;
        }
        #cond{
            margin: 0px 0px 0px 480px;
        }
        #mes{
            margin: 0px 0px -12px 85px;
        }    
        #anho{
            margin: 0px 0px -25px 230px;
        }
        #nombrecliente{
            margin: 2px 0px 10px 97px
        }
        #doc{
            margin: 0px 0px 15px 590px
        }
        #cant{
            margin-left: 40px;
        }
        #desc{
            padding-left: 35px;
        }
        #preuni{
            padding-left: 95px;
            padding-right: 0px;
            padding-bottom: 0px;
        }
        #exe{
            padding-left: 40px;
            padding-right: 0px;
        }
        #cinco{
            padding-left: 100px;
            padding-right: 0px;
        }
        #diez{
            padding-left: 80px;
            padding-right: 30px;
        }
        #totexe{
            margin-left: 460px;
            margin-bottom: 55px;
        }
        #tot5{
            margin-left: 575px;
            margin-bottom: 33px;
        }
        #totexe1{
            margin-left: 470px;
            margin-bottom: 0px;
        }
        #tot51{
            margin-left: 582px;
            margin-bottom: -41px;
        }
        #tot52{
            margin-left: 582px;
            margin-bottom: -36px;
        }
        #espacio{
            margin-left: 0px;
            padding-top: 200px;
        }
        #totletra{
            margin-left: 140px;
            margin-bottom: -7px;
        }
        #total{
            margin-left: 655px;
            margin-bottom: -25px;
        }
        #total2{
            margin-left: 655px;
            margin-bottom: -22px;
        }
        #total5{
            margin-left: 270px;
        }
        #total10{
            margin-left: 400px;
        }
        #totaliva{
            margin-left: 610px;
        }
        #canti{
            padding-left: 37px;
        }
        #section2{
            padding-top: 117px;
        }
    </style>
        <section>
            <div>
                <div id="margenfecha">
                    <pre >{{date('d')}}</pre>
                    <pre id="mes">{{$mesLetra}}</pre>
                    <pre id="anho">21</pre>
                    <p id="cond">X</p>
                </div>   

                <div class="letra">
                    <p id="nombrecliente" class="">{{$fac[0]->doc_cli}}</p>
                    <p id="doc">{{$fac[0]->num_documento}}</p>
                </div>
                <table class="table">
                    <thead>
                        
                    </thead>
                    <tbody>
                        @foreach($fac as $f)
                            <tr>
                                <td id="canti">{{$f->cantidad}}</td>
                                @if($f->merca == 10)
                                    <td id="desc" style="width:230px">Recargo Moratorio {{$f->descripcion}}</td> 
                                    <td id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td>
                                    @else
                                    <td id="desc" style="width:230px">Recargo Punitorio {{$f->descripcion}}</td>
                                    <td id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td> 
                                @endif    
                                <td id="exe">{{number_format(($f->precio_exe), 0, ",", ".")}}</td>
                                <td id="cinco">{{number_format(($f->precio_iv5), 0, ",", ".")}}</td>
                                <td id="diez">{{number_format(($f->precio_iv10), 0, ",", ".")}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
            <div class="letra espacio">            
                    <p id="totexe">.</p>
                    <p id="tot5">.</p>
                </div>
                <div class="letra">           
                    <p id="totexe1">{{number_format(($f->precio_exe), 0, ",", ".")}}</p>
                    <p id="tot51">{{number_format(($f->precio_iv5), 0, ",", ".")}}</p>
                </div>
                <div class="letra">
                    <p id="totletra">{{$tot_pag_let}}</p>
                    <p id="total">{{number_format(($f->total_gral), 0, ",", ".")}}</p>
                </div>

                <div class="letra">
                    <p id="total5">{{number_format(($f->iv5), 0, ",", ".")}}</p>
                    <p id="total10">{{number_format(($f->iv10), 0, ",", ".")}}</p>
                    <p id="totaliva">{{number_format(($f->iv10), 0, ",", ".")}}</p>
                </div>
                
                </div> 
            </section>   

            <section id="section2">
            <div>
                <div id="margenfecha">
                    <pre >{{date('d')}}</pre>
                    <pre id="mes">{{$mesLetra}}</pre>
                    <pre id="anho">21</pre>
                    <p id="cond">X</p>
                </div>   

                <div class="letra">
                    <p id="nombrecliente" class="">{{$fac[0]->doc_cli}}</p>
                    <p id="doc">{{$fac[0]->num_documento}}</p>
                </div>
                <table class="table">
                    <thead>
                        
                    </thead>
                    <tbody>
                        @foreach($fac as $f)
                            <tr>
                                <td id="canti">{{$f->cantidad}}</td>
                                @if($f->merca == 10)
                                    <td id="desc" style="width:230px">Recargo Moratorio {{$f->descripcion}}</td> 
                                    <td id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td>
                                    @else
                                    <td id="desc" style="width:230px">Recargo Punitorio {{$f->descripcion}}</td>
                                    <td id="preuni">{{number_format(($f->precio_uni), 0, ",", ".")}}</td> 
                                @endif    
                                <td id="exe">{{number_format(($f->precio_exe), 0, ",", ".")}}</td>
                                <td id="cinco">{{number_format(($f->precio_iv5), 0, ",", ".")}}</td>
                                <td id="diez">{{number_format(($f->precio_iv10), 0, ",", ".")}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
            <div class="letra espacio">            
                    <p id="totexe">.</p>
                    <p id="tot5">.</p>
                </div>
                <div class="letra">           
                    <p id="totexe1">{{number_format(($f->precio_exe), 0, ",", ".")}}</p>
                    <p id="tot52">{{number_format(($f->precio_iv5), 0, ",", ".")}}</p>
                </div>
                <div class="letra">
                    <p id="totletra">{{$tot_pag_let}}</p>
                    <p id="total2">{{number_format(($f->total_gral), 0, ",", ".")}}</p>
                </div>

                <div class="letra">
                    <p id="total5">{{number_format(($f->iv5), 0, ",", ".")}}</p>
                    <p id="total10">{{number_format(($f->iv10), 0, ",", ".")}}</p>
                    <p id="totaliva">{{number_format(($f->iv10), 0, ",", ".")}}</p>
                </div>
                
                </div> 
            </section>   
    </div><!--fin del div card body-->


  <footer>
 
  </footer>
</html>