@extends('layouts.master')

@section('title') @lang('translation.Chartjs_Charts') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Informes de Credipar @endslot
        @slot('title') Graficos @endslot
    @endcomponent

    {{-- Inmuebles  --}}
    @php
        $saldo_cuo_inm_gs=0;
        $saldo_ven_inm_gs=0;
        $pagos_ven_inm_gs=0;
        $saldo_cuo_inm_us=0;
        $saldo_ven_inm_us=0;
        $pagos_ven_inm_us=0;
    @endphp
    @foreach($cuotas_inm_gs as $cag)       
        @php
            if ($cag->saldo_cuo!=null){
                $saldo_cuo_inm_gs=$saldo_cuo_inm_gs+$cag->saldo_cuo;
            }
            if ($cag->saldo_ven!=null){
                $saldo_ven_inm_gs=$saldo_ven_inm_gs+$cag->saldo_ven;
            }
            if ($cag->pagos_ven!=null){
                $pagos_ven_inm_gs=$pagos_ven_inm_gs+$cag->pagos_ven;
            }
        @endphp
        
    @endforeach
    @foreach($cuotas_inm_us as $cau)       
        @php
            if ($cau->saldo_cuo!=null){
                $saldo_cuo_inm_us=$saldo_cuo_inm_us+$cau->saldo_cuo;
            }
            if ($cau->saldo_ven!=null){
                $saldo_ven_inm_us=$saldo_ven_inm_us+$cau->saldo_ven;
            }
            if ($cau->pagos_ven!=null){
                $pagos_ven_inm_us=$pagos_ven_inm_us+$cau->pagos_ven;
            }
        @endphp
    @endforeach
    @php
        $saldo_ven_inm_gs=$saldo_ven_inm_gs-$pagos_ven_inm_gs;
        $saldo_ven_inm_us=$saldo_ven_inm_us-$pagos_ven_inm_us;
    @endphp
    <input type="hidden" id="saldo_cuo_inm_gs" name="saldo_cuo_inm_gs" class="form-control" value={{$saldo_cuo_inm_gs}}>
    <input type="hidden" id="saldo_ven_inm_gs" name="saldo_ven_inm_gs" class="form-control" value={{$saldo_ven_inm_gs}}>
    <input type="hidden" id="saldo_cuo_inm_us" name="saldo_cuo_inm_us" class="form-control" value={{$saldo_cuo_inm_us}}>
    <input type="hidden" id="saldo_ven_inm_us" name="saldo_ven_inm_us" class="form-control" value={{$saldo_ven_inm_us}}>

    <div class="row">


        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Inmuebles Gss</h4>

                    <div class="row text-center">
                        <div class="col-5">
                            <h5 class="mb-0">Gs. {{number_format(($saldo_cuo_inm_gs), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Al dia</p>
                        </div>
                        <div class="col-5">
                            <h5 class="mb-0">Gs. {{number_format(($saldo_ven_inm_gs), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Mora</p>
                        </div>

      
                    </div>

                    <canvas id="pie_inm_gs" height="260"></canvas>

                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Inmuebles US</h4>

                    <div class="row text-center">
                        <div class="col-5">
                            <h5 class="mb-0">U$. {{number_format(($saldo_cuo_inm_us), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Al dia</p>
                        </div>
                        <div class="col-5">
                            <h5 class="mb-0">U$. {{number_format(($saldo_ven_inm_us), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Mora</p>
                        </div>

      
                    </div>

                    <canvas id="pie_inm_us" height="260"></canvas>

                </div>
            </div>
        </div> <!-- end col -->

    </div> <!-- end row -->

        {{-- Vehiculos  --}}
        @php
        $saldo_cuo_mue_gs=0;
        $saldo_ven_mue_gs=0;
        $pagos_ven_mue_gs=0;
        $saldo_cuo_mue_us=0;
        $saldo_ven_mue_us=0;
        $pagos_ven_mue_us=0;
    @endphp
    @foreach($cuotas_mue_gs as $cag)       
        @php
            if ($cag->saldo_cuo!=null){
                $saldo_cuo_mue_gs=$saldo_cuo_mue_gs+$cag->saldo_cuo;
            }
            if ($cag->saldo_ven!=null){
                $saldo_ven_mue_gs=$saldo_ven_mue_gs+$cag->saldo_ven;
            }
            if ($cag->pagos_ven!=null){
                $pagos_ven_mue_gs=$pagos_ven_mue_gs+$cag->pagos_ven;
            }
        @endphp
        
    @endforeach
    @foreach($cuotas_mue_us as $cau)       
        @php
            if ($cau->saldo_cuo!=null){
                $saldo_cuo_mue_us=$saldo_cuo_mue_us+$cau->saldo_cuo;
            }
            if ($cau->saldo_ven!=null){
                $saldo_ven_mue_us=$saldo_ven_mue_us+$cau->saldo_ven;
            }
            if ($cau->pagos_ven!=null){
                $pagos_ven_mue_us=$pagos_ven_mue_us+$cau->pagos_ven;
            }
        @endphp
    @endforeach
    @php
        $saldo_ven_mue_gs=$saldo_ven_mue_gs-$pagos_ven_mue_gs;
        $saldo_ven_mue_us=$saldo_ven_mue_us-$pagos_ven_mue_us;
    @endphp
    <input type="hidden" id="saldo_cuo_mue_gs" name="saldo_cuo_mue_gs" class="form-control" value={{$saldo_cuo_mue_gs}}>
    <input type="hidden" id="saldo_ven_mue_gs" name="saldo_ven_mue_gs" class="form-control" value={{$saldo_ven_mue_gs}}>
    <input type="hidden" id="saldo_cuo_mue_us" name="saldo_cuo_mue_us" class="form-control" value={{$saldo_cuo_mue_us}}>
    <input type="hidden" id="saldo_ven_mue_us" name="saldo_ven_mue_us" class="form-control" value={{$saldo_ven_mue_us}}>

    <div class="row">


        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Vehiculos Gs</h4>

                    <div class="row text-center">
                        <div class="col-5">
                            <h5 class="mb-0">Gs. {{number_format(($saldo_cuo_mue_gs), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Al dia</p>
                        </div>
                        <div class="col-5">
                            <h5 class="mb-0">Gs. {{number_format(($saldo_ven_mue_gs), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Mora</p>
                        </div>

      
                    </div>

                    <canvas id="pie_mue_gs" height="260"></canvas>

                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Vehiculos US</h4>

                    <div class="row text-center">
                        <div class="col-5">
                            <h5 class="mb-0">U$. {{number_format(($saldo_cuo_mue_us), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Al dia</p>
                        </div>
                        <div class="col-5">
                            <h5 class="mb-0">U$. {{number_format(($saldo_ven_mue_us), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Mora</p>
                        </div>

      
                    </div>

                    <canvas id="pie_mue_us" height="260"></canvas>

                </div>
            </div>
        </div> <!-- end col -->

    </div> <!-- end row -->


    {{-- Acuerdos --}}
    @php
        $saldo_cuo_acu_gs=0;
        $saldo_ven_acu_gs=0;
        $pagos_ven_acu_gs=0;
        $saldo_cuo_acu_us=0;
        $saldo_ven_acu_us=0;
        $pagos_ven_acu_us=0;
    @endphp
    @foreach($cuotas_acu_gs as $cag)       
        @php
            if ($cag->saldo_cuo!=null){
                $saldo_cuo_acu_gs=$saldo_cuo_acu_gs+$cag->saldo_cuo;
            }
            if ($cag->saldo_ven!=null){
                $saldo_ven_acu_gs=$saldo_ven_acu_gs+$cag->saldo_ven;
            }
            if ($cag->pagos_ven!=null){
                $pagos_ven_acu_gs=$pagos_ven_acu_gs+$cag->pagos_ven;
            }
        @endphp
        
    @endforeach
    @foreach($cuotas_acu_us as $cau)       
        @php
            if ($cau->saldo_cuo!=null){
                $saldo_cuo_acu_us=$saldo_cuo_acu_us+$cau->saldo_cuo;
            }
            if ($cau->saldo_ven!=null){
                $saldo_ven_acu_us=$saldo_ven_acu_us+$cau->saldo_ven;
            }
            if ($cau->pagos_ven!=null){
                $pagos_ven_acu_us=$pagos_ven_acu_us+$cau->pagos_ven;
            }
        @endphp
    @endforeach
    @php
        $saldo_ven_acu_gs=$saldo_ven_acu_gs-$pagos_ven_acu_gs;
        $saldo_ven_acu_us=$saldo_ven_acu_us-$pagos_ven_acu_us;
    @endphp
    <input type="hidden" id="saldo_cuo_acu_gs" name="saldo_cuo_acu_gs" class="form-control" value={{$saldo_cuo_acu_gs}}>
    <input type="hidden" id="saldo_ven_acu_gs" name="saldo_ven_acu_gs" class="form-control" value={{$saldo_ven_acu_gs}}>
    <input type="hidden" id="saldo_cuo_acu_us" name="saldo_cuo_acu_us" class="form-control" value={{$saldo_cuo_acu_us}}>
    <input type="hidden" id="saldo_ven_acu_us" name="saldo_ven_acu_us" class="form-control" value={{$saldo_ven_acu_us}}>

    <div class="row">


        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Acuerdos Gs</h4>

                    <div class="row text-center">
                        <div class="col-5">
                            <h5 class="mb-0">Gs. {{number_format(($saldo_cuo_acu_gs), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Al dia</p>
                        </div>
                        <div class="col-5">
                            <h5 class="mb-0">Gs. {{number_format(($saldo_ven_acu_gs), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Mora</p>
                        </div>

      
                    </div>

                    <canvas id="pie_acu_gs" height="260"></canvas>

                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Acuerdos US</h4>

                    <div class="row text-center">
                        <div class="col-5">
                            <h5 class="mb-0">U$. {{number_format(($saldo_cuo_acu_us), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Al dia</p>
                        </div>
                        <div class="col-5">
                            <h5 class="mb-0">U$. {{number_format(($saldo_ven_acu_us), 0, ",", ".")}}</h5>
                            <p class="text-muted text-truncate">Mora</p>
                        </div>

      
                    </div>

                    <canvas id="pie_acu_us" height="260"></canvas>

                </div>
            </div>
        </div> <!-- end col -->

    </div> <!-- end row -->

 


@endsection
@section('script')
    <!-- Chart JS -->
    <script src="{{ URL::asset('/assets/libs/chart-js/chart-js.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/informe/grafico.js') }}"></script>


    <script>



    </script>
@endsection
