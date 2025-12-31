@extends('layouts.master')

@section('title') Inmuebles @endsection

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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    
                        <h4 class="card-title">Proforma de Venta de Inmueble: {{$proforma[0]->descripcion}}</h4>
                          
                        <div class="table-responsive">
                            <table class="table table-editable table-nowrap align-middle table-edits">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Vto</th>
                                        <th>Capital</th>
                                        <th>Interes</th>
                                        <th>Total</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $entro=0;
                                        $lineap=0;
                                    @endphp 
                                
                                    @foreach($proforma as $linea)
                                    @if ($entro==0)
                                        @php
                                            $entro==1;
                                            $lineap=$linea->cuota_nro;
                                        @endphp 
                                            
                                        @else
                                        @php
                                            $lineap=$lineap+1;
                                        @endphp 
                            
                                    @endif
                                
                                    <tr data-id="{{$linea->cuota_nro}}">
                                        <td data-field="id" style="width: 80px">{{$lineap}}</td>
                                        <td data-field="fec_vto">{{$linea->fec_vto}}</td>
                                        <td data-field="capital">{{$linea->capital}}</td>
                                        <td data-field="interes">{{$linea->interes}}</td>
                                        <td data-field="total">{{$linea->total_cuota}}</td>
                                        <td style="width: 100px">
                                            <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    </tr> 
                                    @endforeach
                                    


                        
                                </tbody>
                            </table>
                        </div>
    
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->




    </main>

    @endsection
    @section('script')
    
        <!-- Required datatable js -->
        <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script>
        <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

        <script src="{{ URL::asset('/assets/js/moment.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
            <!-- Table Editable plugin -->
        <script src="{{ URL::asset('/assets/libs/table-edits/table-edits.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/pages/table-editable.int.js') }}"></script>

            
    
     
    
        <!-- Datatable init js -->
    
        <script>

        </script>
@endsection