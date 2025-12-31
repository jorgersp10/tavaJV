@extends('layouts.master')

@section('title') Clientes @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
@endsection

@section('content')
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">A&M INOX - HIERROS</a></li>
                <!-- <li align ="center" class="breadcrumb-item active"><a href="{{url('home')}}">VOLVER A SELECTOR DE SISTEMA</a></li> -->
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Listado de Roles</h2><br/>
                      
                       
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'rol','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div><br>
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                            
                                        <tr>
                                        
                                            <th data-priority="1">Rol</th>
                                            <th data-priority="2">Descripción</th>
                                            <th data-priority="3">Estado</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($roles as $rol)
                                    
                                        <tr>
                                            
                                            <td>{{$rol->nombre}}</td>
                                            <td>{{$rol->descripcion}}</td>
                                            <td>

                                            @if($rol->condicion=="1")

                                                <button type="button" class="btn btn-success btn-md">
                                            
                                                <i class="fa fa-check fa-1x"></i> Activo
                                                </button>

                                            @else
                                                <button type="button" class="btn btn-danger btn-md">
                                            
                                                <i class="fa fa-check fa-1x"></i> Desactivado
                                                </button>

                                            @endif
                                                
                                            
                                            </td>

                                        
                                        </tr>

                                        @endforeach
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            {{$roles->render()}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>  
        </main>

@endsection
@section('script')
        
        <!-- Plugins js -->
        <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script> 
@endsection