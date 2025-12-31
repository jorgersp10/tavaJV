@extends('layouts.master')

@section('title') Funcionarios @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') A&M INOX - HIERROS @endslot
    @endcomponent
<main class="main">
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <form action="{{route('funcionario.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">                               
                {{method_field('patch')}}
                @csrf
                <div class="card-header">

                    <h2>Actualizar Funcionario</h2><br/>                     
                    
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                    
                        </div>
                    </div><br>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-6">
                                <input type="text" id="nombre" value="{{$funcionarios->nombre}}"
                                name="nombre" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Documento</label>
                            <div class="col-sm-6">
                                <input type="text" id="num_documento" value="{{$funcionarios->num_documento}}"
                                name="num_documento" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Patronal</label>
                            <div class="col-sm-6">
                                <input type="text" id="nro_patronal" value="{{$funcionarios->nro_patronal}}"
                                name="nro_patronal" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Telefono</label>
                            <div class="col-sm-6">
                                <input type="text" id="telefono" value="{{$funcionarios->telefono}}"
                                name="telefono" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Salario básico</label>
                            <div class="col-sm-6">
                                <input type="text" id="salario_basico" value=" {{number_format(($funcionarios->salario_basico), 0, ",", ".")}}"
                                name="salario_basico" class="form-control">
                            </div>
                        </div>

                        <input type="hidden" id="id_funcionario" name="id_funcionario" 
                        value={{$funcionarios->id_funcionario}} class="form-control" >
                        
                        <div class="modal-footer">
                            <a href="{{ url()->previous() }}">
                                <button type="button" class="btn btn-primary">Salir</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</main>

    @endsection

@section('script')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
       
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
    <script src="{{ URL::asset('/assets/js/moment.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/funcionario/funcionario.js') }}"></script>
    
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection