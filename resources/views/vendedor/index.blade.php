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
                <h2>Lista de Vendedores</h2><br/>
                @if(session()->has('msj'))
                    <div class="alert alert-danger" role="alert">{{session('msj')}}</div>
                @endif
                @if(session()->has('msj2'))
                    <div class="alert alert-success" role="alert">{{session('msj2')}}</div>
                @endif
                <a href="vendedor/create">
                    <button type="button" class="btn btn-primary waves-effect waves-light">Agregar Vendedor</button>
                </a>
            </div>

            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                    {!!Form::open(array('url'=>'vendedor','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
                        <div class="input-group">
                            <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar vendedor, documento o usuario" value="{{$buscarTexto}}">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    {{Form::close()}}
                    </div>
                </div><br>

                <div class="table-rep-plugin">
                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th data-priority="1">Borrar</th>
                                    <th data-priority="1">Editar</th>
                                    <th data-priority="1">Nombre</th>
                                    <th data-priority="1">Documento</th>
                                    <th data-priority="1">Telefono</th>
                                    <th data-priority="1">Email</th>
                                    <th data-priority="1">Usuario</th>
                                    <th data-priority="1">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendedores as $v)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistro-{{$v->id}}">
                                                <i class="fa fa-times fa-1x"></i> Borrar
                                            </button>
                                        </td>
                                        <td>
                                            <a href="{{URL::action('App\Http\Controllers\VendedorController@show', $v->id)}}">
                                                <button type="button" class="btn btn-success btn-sm">
                                                    <i class="fa fa-edit fa-1x"></i> Editar
                                                </button>
                                            </a>
                                        </td>
                                        <td>{{$v->nombre}}</td>
                                        <td>{{$v->num_documento}}</td>
                                        <td>{{$v->telefono}}</td>
                                        <td>{{$v->email}}</td>
                                        <td>{{$v->usuario}} @if($v->usuario_email) - {{$v->usuario_email}} @endif</td>
                                        <td>
                                            @if($v->estado == 1)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-secondary">Inactivo</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @include('vendedor.delete')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{$vendedores->render()}}
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
