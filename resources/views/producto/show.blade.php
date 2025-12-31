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

@section('title') Productos @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('/assets/css/inm-show.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb') 
        @slot('li_1') INICIO @endslot
        @slot('title') {{$tit_desde}} @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
             <!-- Nav -->
             @include('producto.tab_show')
    
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
    <script src="{{ URL::asset('/assets/js/producto/show.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/moment.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="{{ URL::asset('/assets/js/producto/show_tab.js') }}" defer></script>
    <!-- Table Editable plugin -->
    <script src="{{ URL::asset('/assets/libs/table-edits/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/table-editable.int.js') }}"></script>
@endsection