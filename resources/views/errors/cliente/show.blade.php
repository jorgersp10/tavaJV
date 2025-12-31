@extends('principal')
@section('contenido')


<main class="main">
<ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">CREDIANALIS</a></li>
                <li align ="center" class="breadcrumb-item active"><a href="{{url('home')}}">VOLVER A SELECTOR DE SISTEMA</a></li>
            </ol>
 <div class="card-body">
  <h4 class="text-left">Datos Personales</h4><br/>
    
                <div class="form-group row">
                    <label class="col-md-2 form-control-label"><b>Nombre y Apellido:</b></label>
                    <div class="col-md-3">
                          <p>{{$client->cliente}}</p>     
                    </div>
                    <label class="col-md-2 form-control-label"><b>Documento N°:</b></label>
                    <div class="col-md-3">
                          <p>{{$client->documento}}</p>     
                    </div>
              </div>

              <div class="form-group row">
                    <label class="col-md-2 form-control-label"><b>Dirección:</b></label>
                    <div class="col-md-3">
                          <p>{{$client->direccion}}</p>     
                    </div>
                    <label class="col-md-2 form-control-label"><b>Teléfono:</b></label>
                    <div class="col-md-3">
                          <p>{{$client->telefono}}</p>     
                    </div>
              </div>

              <div class="form-group row">
                    <label class="col-md-2 form-control-label"><b>Estado Civil:</b></label>
                    <div class="col-md-3">
                          <p>{{$client->estado_civil}}</p>     
                    </div>
                    <label class="col-md-2 form-control-label"><b>Sexo:</b></label>
                    <div class="col-md-2">
                          <p>{{$client->sexo}}</p>     
                    </div>
                    <label class="col-md-1 form-control-label"><b>Edad:</b></label>
                    <div class="col-md-1">
                          <p>{{$edadcliente}}</p>     
                    </div>
              </div>
<h4 class="text-left">Lista de Informes</h4><br/>
  <table class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">
                                   
                                    <!-- <th>Documento</th>
                                    <th>Cliente</th> -->
                                    <th>Fecha</th>
                                    <th>Ant. Laboral</th>
                                    <th>Ingreso</th>
                                    <th>Egreso</th>
                                    <th>Monto Solic.</th>
                                    <th>Cuota</th>
                                    <th>Respuesta</th>
                                    <th>Ver Detalle</th>
                                    <!-- <th>Mapa</th> -->
                                    <th>Imprimir</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($clientes as $lec)
                              <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                               Asi cada usuario solo puede ver datos de su empresa -->                               
                                    
                                    @if($lec->respuesta == "Rechazar")
                                        <tr class="table-danger">
                                    @endif  
                                    @if($lec->respuesta == "Condicionar")
                                        <tr class="table-warning">
                                    @endif
                                    @if($lec->respuesta == "Aprobado")
                                        <tr class="table-success">
                                    @endif                                     
                                        <!-- <td>{{$lec->documento}}</td>
                                        <td>{{$lec->cliente}}</td>                                         -->
                                        <td>{{$lec->fecha_lectura}}</td>
                                        <td>{{$lec->a_laboral}} Meses</td>
                                        <td>Gs. {{number_format(($lec->ingreso), 0, ",", ".")}}</td>
                                        <td>Gs. {{number_format(($lec->egreso), 0, ",", ".")}}</td>
                                        <td>Gs. {{number_format(($lec->monto), 0, ",", ".")}}</td>
                                        <td>Gs. {{number_format(($lec->cuota), 0, ",", ".")}}</td>
                                        <td>{{$lec->respuesta}}</td>
                                        <td>                                     
                                            <a href="{{URL::action('LecturaController@show',$lec->id)}}">
                                                <button type="button" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-eye fa-1x"></i> Ver
                                                </button> &nbsp;
                                            </a>
                                        </td>
                                            
                                            <td>                                       
                                                <a href="{{url('pdfInforme',$lec->id)}}" target="_blank">                                         
                                                    <button type="button" class="btn btn-info btn-sm">                                           
                                                    <i class="fa fa-file fa-1x"></i> Imprimir
                                                    </button> &nbsp;
                                                </a> 
                                            </td>
                                            <td>
                                          <form method="post" action="{{ url('/lectura/'.$lec->id)}}">
                                                {{method_field('delete')}}
                                                {{csrf_field()}}
                                                @if(auth()->user()->idrol != 2) 
                                                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Borrar?')">
                                                      <i class="fa fa-trash fa-1x"></i> Borrar
                                                      </button> &nbsp;
                                                @endif
                                          </form>
                                          
                                          </td>
                                    </tr>
                                   
                              @endforeach                               
                            </tbody>
                        </table>                           
                                               
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
    
          
    </main>

@endsection