@extends('layouts.master')

@section('title') Vendedores @endsection

@section('css')
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') LABPROF GROUP @endslot
    @endcomponent
<main class="main">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2>Agregar Vendedor</h2><br/>
                @if(session()->has('msj'))
                    <div class="alert alert-danger" role="alert">{{session('msj')}}</div>
                @endif
                @if(session()->has('msj2'))
                    <div class="alert alert-success" role="alert">{{session('msj2')}}</div>
                @endif
            </div>

            <div class="card-body">
                <form action="{{route('vendedor.store')}}" method="POST">
                    {{csrf_field()}}
                    @include('vendedor.form')

                    <div class="modal-footer">
                        <a href="{{url('vendedor')}}" class="btn btn-light">Cerrar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script>
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
