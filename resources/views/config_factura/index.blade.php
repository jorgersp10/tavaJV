@extends('layouts.master')

@section('title') Configuración de Factura @endsection

@section('css')
        <meta name='csrf-token' content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Configuraciones @endslot
        @slot('title') Configuración de Factura @endslot
    @endcomponent
<main class="main">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">

                       <h2>Altura de Cabeceras (Factura PDF)</h2><br/>
                       @if(session()->has('msj'))
                            <div class="alert alert-success" role="alert">{{session('msj')}}</div>
                        @endif

                    </div>

                    <div class="card-body">
                        <form action="{{url('config_factura')}}" method="POST">
                             {{csrf_field()}}
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="cabecera">Cabecera 1 (px)</label>
                                <div class="mb-3">
                                    <input type="number" id="cabecera" name="cabecera" class="form-control" value="{{$config->cabecera}}" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="cabecera2">Cabecera 2 (px)</label>
                                <div class="mb-3">
                                    <input type="number" id="cabecera2" name="cabecera2" class="form-control" value="{{$config->cabecera2}}" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-3 form-control-label" for="cabecera3">Cabecera 3 (px)</label>
                                <div class="mb-3">
                                    <input type="number" id="cabecera3" name="cabecera3" class="form-control" value="{{$config->cabecera3}}" min="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</main>

@endsection
