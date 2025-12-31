@extends('layouts.master')

@section('title') Cuentas Corrientes @endsection

@section('css')
        <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <meta name='csrf-token' content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') A&M INOX - HIERROS @endslot
    @endcomponent
<main class="main">
            <!-- Breadcrumb -->
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Agregar Cuenta Corriente</h2><br/>
                       @if(session()->has('msj'))
                            <div class="alert alert-danger" role="alert">{{session('msj')}}</div>
                        @endif
                        @if(session()->has('msj2'))
                            <div class="alert alert-success" role="alert">{{session('msj2')}}</div>
                        @endif

                    </div>

                    <div class="card-body">
                        <form action="{{route('cuenta_corriente.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">                             
                             {{method_field('patch')}}
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="precio">N° Cuenta</label>
                                <div class="mb-3">
                                    <input type="text" id="nro_cuenta" name="nro_cuenta" value="{{$cuentas_corriente->nro_cuenta}}" class="form-control" placeholder="Ingrese nro de cuenta" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label class="col-md-3 form-control-label" for="precio">Tipo cuenta</label>
                                <select class="form-control" name="tipo_cuenta" id="tipo_cuenta">                                     
                                    <option value="0" disabled>Seleccione</option>
                                    
                                    @foreach($tipo_cuenta as $tp)
                                        <option value="{{$tp->id}}" 
                                    <?php echo("{{$cuentas_corriente->tipo_cuenta}}"=="{{$tp->id}}")?"selected":"";?> >{{$tp->tipo}}
                                </option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label class="col-md-3 form-control-label" for="precio">Banco</label>
                                <select class="form-control" name="banco_id" id="banco_id">                                     
                                    <option value="0" disabled>Seleccione</option>
                                    
                                    @foreach($bancos as $ban)
                                        <option value="{{$ban->id}}" <?php echo("{{$cuentas_corriente->banco_id}}"=="{{$ban->id}}")?"selected":"";?> >{{$ban->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="id_cuenta" name="id_cuenta" value="{{$cuentas_corriente->id}}" class="form-control" placeholder="Ingrese nro de cuenta" required>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>

</main>

@endsection

@section('script')
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
