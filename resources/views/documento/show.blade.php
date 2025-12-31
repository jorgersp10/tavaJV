@extends('layouts.master')

@section('title') Clientes @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') A&M INOX - HIERROS - DOCUMENTOS @endslot
    @endcomponent
<main class="main">
 <!-- Breadcrumb -->
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <h2>Documentos del Cliente</h2><br/>                     
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 form-control-label"><b>Nombre y Apellido:</b></label>
                    <div class="col-md-5">
                            <p>{{$client->cliente}}</p>     
                    </div>
                    <label class="col-md-2 form-control-label"><b>Documento N°:</b></label>
                    <div class="col-md-3">
                            <p>{{$client->documento}}</p>     
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label"><b>Dirección:</b></label>
                    <div class="col-md-5">
                            <p>{{$client->direccion}}</p>     
                    </div>
                    <label class="col-md-2 form-control-label"><b>Ciudad:</b></label>
                    <div class="col-md-3">
                            <p>{{$client->ciudad}}</p>     
                    </div>
                    
                </div>
                <div class="form-group row">
                <label class="col-md-2 form-control-label"><b>Teléfono:</b></label>
                    <div class="col-md-3">
                            <p>{{$client->telefono}}</p>     
                    </div>
                </div>
            </div>

            @include('documento.form')

        </div>  
    </div>
    <!-- Fin ejemplo de tabla Listado -->    

    <!--Inicio del modal agregar documento-->
    <div class="modal fade" id="abrirmodalDoc" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Ingreso Documento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                        @include('documento.formCarga')
                       
                </div>
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</main>

<script>

    function showFile(id){
        $.ajax({
            url: "{{ asset('/documentos/file/') }}/"+id,
            type: "get",
            dataType: "html",
            contentType: false,
            processData: false
        }).done(function(res){
            url = JSON.parse(res).response.url
            window.open('../storage/'+url,'_blank');
        }).fail(function(res){
            console.log(res)
        });
    }
    </script>


<script>
    function getval(sel)
    {
        console.log("vencimiento");
        var vencimiento= sel.selectedOptions[0].getAttribute("data-vence");
        console.log(vencimiento);
        var fecha_ven=document.getElementById('fecha_ven');
        if (vencimiento=="SI")
        {
            fecha_ven.required = true;
            fecha_ven.disabled = false;
        }
        else
        {
            fecha_ven.required = false;
            fecha_ven.disabled = true;

        }

    }
</script>



    <script src="{{ URL::asset('/assets/libs/jquery-steps/jquery-steps.min.js') }}"></script>

    <!-- form wizard init -->
    <script src="{{ URL::asset('/assets/js/pages/form-wizard.init.js') }}"></script>


@endsection