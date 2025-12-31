@extends('layouts.master')

@section('title') Sucursales @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') INICIO @endslot
        @slot('title') A&M INOX - HIERROS @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                       <h2>Reporte por Urbanizacion</h2><br/>
                        
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            <form id="urba_pdf" action="{{route('reporteUrbaPDF')}}" method="POST"target="_blank"> 
                            {{csrf_field()}}                            
                            <label class="col-md-3 form-control-label" for="loteamiento">Urbanizacion</label>
                            <div class="col-md-6">
                                <!-- Aquí selecciona el usuario del cual quiere sacar el reporte -->
                                
                                <select style= "width:330px" class="form-control" name="urba" id="urba">
                                                                        
                                    <option readonly>Seleccione Urbanizacion</option>
                                    
                                    @foreach($loteamientos as $l)
                                    
                                    <option value="{{$l->id}}">{{$l->descripcion}}</option>
                                        
                                    @endforeach

                                </select>
                                
                                </div>
                                <br> <br>
                                <div>
                                    <button type="submit" class="btn btn-danger float-left"><i class="fa fa-file fa-1x"></i> Generar PDF</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
               
        </div><br>   
                     
    </main>

@endsection
@section('script')
        
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