@extends('layouts.master')

@section('title') Adelantos de salario @endsection

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
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
                                    

                <div class="card-header">

                    <h2>Actualizar adelanto de salarios</h2><br/>                     
                    
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                    
                        </div>
                    </div><br>
                    <form action="{{route('adelanto.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">                               
                    {{method_field('patch')}}
                    @csrf
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="rol">Empleado</label>
                                
                                <div class="mb-3">
                                
                                    <select class="form-control" name="funcionario_id" id="funcionario_id" value=" {{$adelantos->funcionario_id}}" style= "width:330px">
                                                                        
                                        @foreach($funcionarios as $f)
                                            <option value="{{$f->funcionario_id}}">{{$f->nombre}} - {{$f->num_documento}}</option>
                                        @endforeach 

                                    </select>
                                
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Adelanto</label>
                            <div class="col-sm-6">
                                <input type="text" id="adelanto" name="adelanto" value=" {{number_format(($adelantos->adelanto), 0, ",", ".")}}" class="form-control number1">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Mes Pago</label>
                            <div class="col-sm-6">
                                <input type="date" id="mes_pago" name="mes_pago" class="form-control" value={{$adelantos->mes_pago}}>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Comentario</label>
                            <div class="col-sm-6">
                                <input type="text" id="comentario" name="comentario" class="form-control" value="{{$adelantos->comentario}}">
                            </div>
                        </div>

                        <input type="hidden" id="funcionario_id_hidden" name="funcionario_id_hidden" 
                        value="{{$adelantos->funcionario_id}}" class="form-control" >

                        <input type="hidden" id="id_adelanto" name="id_adelanto" 
                        value="{{$adelantos->id_adelanto}}" class="form-control" >

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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    const number1 = document.querySelector('.number1');

    function formatNumber (n) {
        n = String(n).replace(/\D/g, "");
    return n === '' ? n : Number(n).toLocaleString();
    }
    number1.addEventListener('keyup', (e) => {
        const element = e.target;
        const value = element.value;
    element.value = formatNumber(value);
    });
</script>
        
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script> 
        <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/recibos_func/adelanto.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
  
@endsection