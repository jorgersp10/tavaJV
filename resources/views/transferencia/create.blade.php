@extends('layouts.master')

@section('title') Cuentas Corrientes @endsection

@section('css')
        <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <meta name='csrf-token' content="{{ csrf_token() }}">
        <style>
            .btn-toolbar {
                display: none !important;
            }
        </style>
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') LABPROF GROUP @endslot
    @endcomponent
<main class="main">
            <!-- Breadcrumb -->
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Agregar Transferencia</h2><br/>
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>
                        @endif

                    </div>

                    <div class="card-body">
                        <form id="form_mora" action="{{route('transfer.store')}}" method="POST">
                             {{csrf_field()}}
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label class="col-md-4 form-control-label" for="precio">Cuenta Origen</label>
                                <select class="form-control" name="cuenta_id1" id="cuenta_id1">                                     
                                        <option disabled>Seleccione</option>                                        
                                        @foreach($cuentas as $cc)
                                        <option value="{{$cc->id}}">{{$cc->nro_cuenta}} - {{$cc->banco}} - {{$cc->tipo}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-md-4 form-control-label" for="precio">Cuenta Destino</label>
                                <select class="form-control" name="cuenta_id2" id="cuenta_id2">                                     
                                        <option disabled>Seleccione</option>                                        
                                        @foreach($cuentas as $cc)
                                        <option value="{{$cc->id}}">{{$cc->nro_cuenta}} - {{$cc->banco}} - {{$cc->tipo}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="col-md-3 form-control-label" for="precio">Fecha</label>
                                <div class="mb-3">
                                    <input type="date" id="fecha" name="fecha" class="form-control" required>
                                </div>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="precio">Monto</label>
                                <div class="mb-3">
                                    <input type="text" id="monto" name="monto" class="form-control number" placeholder="Ingrese monto" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="col-md-5 form-control-label" for="precio">Comentario</label>
                                <div class="mb-3">
                                    <textarea class="form-control" id="comentario" name="comentario"></textarea>
                                </div>
                            </div>                            
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
             <div class="card">
                    <div class="card-header">
                        <h3>Lista de Transferencias</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            
                        </div>
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="datatable" class="display table table-bordered dt-responsive  nowrap w-100">                               
                                    <thead>                            
                                            <tr>  
                                            <th  data-priority="1">Borrar</th>                                
                                            <th  data-priority="1">Origen</th>
                                            <th  data-priority="1">Destino</th>
                                            <th  data-priority="1">Monto</th>
                                            <th  data-priority="1">Fecha</th>
                                            <th  data-priority="1">Comentario</th>
                                            <!-- <th  data-priority="1">Saldo</th>  -->
                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @foreach($transfers as $t)
                                            <!-- El if realiza el filtro de datos de acuerdo a la empresa del usuario logueado
                                            Asi cada usuario solo puede ver datos de su empresa -->
                                        
                                            <tr>      
                                                <td>
                                    
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistro-{{$t->id}}">
                                                        <i class="fa fa-times fa-1x"></i> Borrar
                                                    </button>
                                    
                                                </td>                                                                         
                                                                            
                                                <td>{{$t->cuenta1}} - {{$t->banco1}}</td>
                                                <td>{{$t->cuenta2}} - {{$t->banco1}}</td>
                                                <td>Gs. {{number_format(($t->monto), 0, ",", ".")}}</td>  
                                                <td>{{ date('d-m-Y', strtotime($t->fecha)) }}</td>
                                                <td>{{$t->comentario}}</td>                                                              
                                            </tr>  
                                            @include('transferencia.delete')
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                                
                            </div> 
                        </div> 
                        
                    </div>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>

</main>

@endsection

@section('script')
    <script>
        const number = document.querySelector('.number');
        function formatNumber(n) {
            n = String(n).replace(/\D/g, "");
            return n === '' ? n : Number(n).toLocaleString();
        }
        number.addEventListener('keyup', (e) => {
            const element = e.target;
            const value = element.value;
            element.value = formatNumber(value);
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script>
        <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

@endsection
