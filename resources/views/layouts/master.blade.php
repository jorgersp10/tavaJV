<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | LABPROF GROUP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="SISTEMA DE GESTIÓN - LABPROF GROUP" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    
    <!-- Bootstrap Css @include('layouts.head-css')
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css-->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css -->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    
</head>

@section('body')
    <body data-sidebar="dark">
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @if(Auth::check())
                @if (Auth::user()->idrol == 1)
                @include('layouts.sidebarAdministrador')
                    @elseif (Auth::user()->idrol == 2)
                        @include('layouts.sidebarEmpleado')                        
                @endif
        @endif
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('layouts.right-sidebar')
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')

    @yield('scripts')



    <!-- SECTOR PARA EDICION DE FORMULARIO -->
    <script>
       
         /*EDITAR USUARIO EN VENTANA MODAL*/
         $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        
            /*el button.data es lo que está en el button de editar*/
            var button = $(event.relatedTarget)
            
            var nombre_modal_editar = button.data('name')
            var email_modal_editar = button.data('email')
            var num_documento_modal_editar = button.data('num_documento')
            var direccion_modal_editar = button.data('direccion')
            var telefono_modal_editar = button.data('telefono')
            var fecha_nacimiento_modal_editar = button.data('fecha_nacimiento')
            var id_rol_modal_editar = button.data('idrol')
            var sucursal_modal_editar = button.data('idsucursal')
            var id_usuario = button.data('id_usuario')
            var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            /*los # son los id que se encuentran en el formulario*/
            modal.find('.modal-body #nombre').val(nombre_modal_editar);
            modal.find('.modal-body #email').val(email_modal_editar);
            modal.find('.modal-body #num_documento').val(num_documento_modal_editar);
            modal.find('.modal-body #direccion').val(direccion_modal_editar);
            modal.find('.modal-body #telefono').val(telefono_modal_editar);
            modal.find('.modal-body #fecha_nacimiento').val(fecha_nacimiento_modal_editar);
            modal.find('.modal-body #idrol').val(id_rol_modal_editar);
            modal.find('.modal-body #idsucursal').val(sucursal_modal_editar);
            modal.find('.modal-body #id_usuario').val(id_usuario);
        })

        /*EDITAR SUCURSAL EN VENTANA MODAL*/
        $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        
            /*el button.data es lo que está en el button de editar*/
            var button = $(event.relatedTarget)
            
            var sucursal_modal_editar = button.data('sucursal')
            var id_sucursal = button.data('id_sucursal')
            var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            /*los # son los id que se encuentran en el formulario*/
            modal.find('.modal-body #sucursal').val(sucursal_modal_editar);
            modal.find('.modal-body #id_sucursal').val(id_sucursal);
        })

        //SECTOR PARA CAMBIAR LOS ESTADOS

        /*INICIO ventana modal para cambiar el estado del usuario*/
        
         $('#cambiarEstado').on('show.bs.modal', function (event) {       
        
            var button = $(event.relatedTarget) 
            var id_usuario = button.data('id_usuario')
            var modal = $(this)        
            modal.find('.modal-body #id_usuario').val(id_usuario);
            })
         
        /*FIN ventana modal para cambiar estado del usuario*/
        
    </script>

</body>

</html>
