@extends('layouts.master')

@section('title') Adelanto de Salario @endsection

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

                    <h2>Adelantos de salarios</h2><br/>                     
                    
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                    
                        </div>
                    </div><br>
                    <form action="{{route('adelanto.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">                               
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="rol">Empleado</label>
                                
                                <div class="mb-3">
                                
                                    <select class="form-control" name="funcionario_id" id="funcionario_id" style= "width:330px" onchange="obtenerDatos()">
                                                                        
                                        <option value="0" disabled>Seleccionar empleado</option>

                                    </select>
                                
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Adelanto</label>
                            <div class="col-sm-6">
                                <input type="text" id="adelanto" name="adelanto" class="form-control number1">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Mes Pago</label>
                            <div class="col-sm-6">
                                <input type="date" id="mes_pago" name="mes_pago" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Comentario</label>
                            <div class="col-sm-6">
                                <input type="text" id="comentario" name="comentario" class="form-control">
                            </div>
                        </div>

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

    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#funcionario_id').select2({
                ajax:{
                    url:"{{route('getFuncionarios') }}",
                    type: 'post',
                    dataType: 'json',
                    delay: 100,
                    data: function(params){
                        return{
                            _token: CSRF_TOKEN,
                            search:params.term
                        }
                    },
                    processResults: function(response){
                        return{
                            results: response
                        }
                    },
                    cache: true
                }
            });
        });
    
    </script>

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
</script>s
        
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