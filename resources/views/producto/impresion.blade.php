@php
    $sis_desde="";
    $extension='layouts.master';
    $tit_desde='LABPROF GROUP';
    $sis_desde=session()->get('sis_desde');
    if ($sis_desde == "electro")
    {
        $extension='layouts.masterElectro';
        $tit_desde='ELECTRODOMESTICOS';
    }
@endphp

@extends($extension)

@section('title') Calculos para Venta de Inmuebles @endsection

@section('css')        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <meta name='csrf-token' content="{{ csrf_token() }}">
@endsection

<style>
        .table-bordered {
            border: 1px solid #c2cfd6 ;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
</style>

@section('content')

{{-- @component('components.breadcrumb')
        @slot('li_1') INICIO @endslot
        @slot('title') INMOBILIARIA @endslot
@endcomponent --}}
    

<main class="main">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div style="text-align:center;">
                    <img src="{{ URL::asset('/assets/images/logo completo-1500.png') }}"height="120px" width="500px" /><br> 
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="mb-6">
                                @php
                                    if ($desde=="calculos")
                                    $nombre=$cliente_nom;
                                    else
                                    $nombre=$cliente->nombre;
                                @endphp
                                <h2>Cliente : {{$nombre}}</h2>
                                <h4>Tasa : {{$interes}}%</h4>    

                            </div><br>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3">
                                <div class="d-print-none mb-3">
                                    <div class="float-end">
                                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i
                                                class="fa fa-print"></i> Imprimir</a>
                                                
                                    </div>
                                    <form action="{{route('proforma.store')}}" method="post" class="form-horizontal">
                                
                                        {{csrf_field()}}

                                            <input type="hidden" id="id_inmuebleven" name="id_inmuebleven"  value={{$inmueble_ven}}>
                                            @foreach ($cuotas_arr as $cuota_arr)
                                                <input type="hidden" name="cfec_vto[]"  value={{$cuota_arr['fec_vto']}}>
                                                <input type="hidden" name="ccap[]"  value={{$cuota_arr['cap']}}>
                                                <input type="hidden" name="cint[]"  value={{$cuota_arr['int']}}>
                                                <input type="hidden" name="civa[]"  value={{$cuota_arr['iva']}}>
                                            @endforeach
                                        
                                            <input type="hidden" id="desde" name="desde"  value={{$desde}}>
                                            <input type="hidden" id="idcliente" name="idcliente"  value={{$idcliente}}>
                                            <input type="hidden" id="precio_mue" name="precio_mue"  value=0>
                                            <input type="hidden" id="precio_inm" name="precio_inm"  value={{$precio_inm}}>
                                            <input type="hidden" class="form-control" id="tiempo" name="tiempo" value={{$tiempo}}>
                                            <input type="hidden" class="form-control" id="primer_vto" name="primer_vto" value={{$primer_vto}} >
                                            <input type="hidden" class="form-control" id="interes" name="interes" value={{$interes}}>
                                            <input type="hidden" class="form-control number" id="entrega" name="entrega" value={{$entrega}}>
                                            <input type="hidden" class="form-control" id="entrega_vto" name="entrega_vto" value={{$entrega_vto}}>
                                            <input type="hidden" class="form-control number2" name="refuerzo" id="refuerzo" value={{$refuerzo}}>
                                            <input type="hidden" class="form-control" name="can_ref"  id="can_ref" value={{$can_ref}}>
                                            <input type="hidden" class="form-control" name="per_ref" id="per_ref" value={{$per_ref}}>
                                            <input type="hidden" class="form-control" name="refuerzo_vto" id="refuerzo_vto" value={{$refuerzo_vto}}>
                                            <input type="hidden" class="form-control" name="cuo_imp" id="cuo_imp" value={{$cuo_imp}}>
                                            <?php if($desde=="tab_show") { ?>
                                                <button type="submitt" class="btn btn-danger" name="btnCalcular" id="btnCalcular">Grabar </button>
                                            <?php } ?>
      
                                    </form>
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
                <div >
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Nro Cuota</th>
                                <th scope="col">Vto</th>
                                <th scope="col">Capital</th>
                                <th scope="col">Interes</th>

                                <th scope="col">Monto Cuota</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                
                                $precio_inm=0;
                            @endphp
                            @foreach($cuotas_arr as $cuota)
                                    @php
                                        //$cuota->cap= str_replace('.', "", $cuota->cap);
                                        $precio_inm=$precio_inm+$cuota['cap'];
                                    @endphp
                             
                            @endforeach

                            @php
                                $cuota_nro=0;$total_cap=0;$total_int=0;
                                $total_iva=0;$saldo=$precio_inm;$total_cuo=0;
                                
                            @endphp
                            @foreach($cuotas_arr as $cuota)
                             
                                    <tr>
                                        @php
                                            $cuota_nro++;
           
                                            $cuo=$cuota['cap']+$cuota['int'];
                                            $saldo=$saldo-$cuota['cap'];
                                            $total_cap=$total_cap+$cuota['cap'];
                                            $total_int=$total_int+$cuota['int'];
                                            $total_iva=$total_iva+$cuota['iva'];
                                            $total_cuo=$total_cuo+$cuota['cap']+$cuota['int']+$cuota['iva'];
                                        @endphp
                                        <th scope="row">{{$cuota_nro}}</th>
                                        <td>{{ date('d-m-Y', strtotime($cuota['fec_vto'])) }}</td>
                                        <td>{{number_format(($cuota['cap']), 0, ",", ".")}}</td>
                                        <td>{{number_format(($cuota['int']), 0, ",", ".")}}</td>
 
                                        <td>{{number_format(($cuo), 0, ",", ".")}}</td>

                                    </tr>
                           
                            @endforeach
                            <tr>
                                <th scope="row"></th>
                                <th scope="row"></th>
                                <th>{{number_format(($total_cap), 0, ",", ".")}}</th>
                                <th>{{number_format(($total_int), 0, ",", ".")}}</th>
                                <th>{{number_format(($total_cuo), 0, ",", ".")}}</th>

                                {{-- <th scope="row"></th> --}}
                            </tr>
                            <tr>
                                <th scope="row">Desembolso</th>
                                <th scope="row"></th>
                                <th>{{number_format(($total_cap-$total_iva), 0, ",", ".")}}</th>
                                <th scope="row"></th>
                                <th scope="row"></th>
                                <th scope="row"></th>
                                <th scope="row"></th>
                                <th scope="row"></th>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>   
        </div>  
    </div>              
</main>

@endsection
@section('script')



    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
 

    <script src="{{ URL::asset('/assets/js/inmueble/cuotas.js') }}"></script>

    <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/moment.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

    <script src="{{ URL::asset('/assets/libs/table-edits/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/table-editable.int.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            $('#idCliente').select2({
                ajax:{
                    url:"{{route('getClientesVen') }}",
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
        /*EDITAR CLIENTE EN VENTANA MODAL*/
        $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        
            /*el button.data es lo que está en el button de editar*/
            var button = $(event.relatedTarget)
            
            var nombre_descripcion = button.data('descripcion')
            console.log(nombre_descripcion)

            var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            /*los # son los id que se encuentran en el formulario*/
            modal.find('.modal-body #descripcion').val(nombre_descripcion);
        })
    

    </script>


@endsection


