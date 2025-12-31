@section('title') Ventas @endsection

@section('css') 
        <!-- DataTables -->       
        <script src="{{ URL::asset('/assets/libs/table-edits/table-edits.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/pages/table-editable.int.js') }}"></script>
@endsection

@if(session()->has('msj2'))
<div class="alert alert-success" role="alert">{{session('msj2')}}</div>    
@endif
@if(session()->has('msj3'))
<div class="alert alert-danger" role="alert">{{session('msj3')}}</div>    
@endif
<h2>Detalle de Inmuebles</h2><br/>
<div class="menu card-header">
    <button style="margin: 10px" type="button" class="btn btn-primary waves-effect waves-light" data-target="#men_ven">Ventas</button>
</div>

<div class="card-body">

    <div class="active card-body" data-content id="men_ven">
        <form action="{{route('proforma.calcularCuota')}}" method="post" class="form-horizontal">
                                
            {{csrf_field()}}
            <input type="hidden" class="form-control" name="desde" id="desde" value="tab_show">

            <div class="container-fluid">
               
                <input type="hidden" id="precio_mue" name="precio_mue"  value=0>

                <div class="row mt-3">
                    <div class="card-header">
                        <h2>Venta de Inmueble</h2>
                        {{--Precio plazo Entrega y Vto Entrega --}}
                    </div>
                    <div class="row mb-4">
                        <label class="col-md-2 form-control-label" for="titulo">Cliente</label>
                        <div class="form-group  col-xs-5 col-md-3">
                            <select id='idcliente' name='idcliente' style= "width:400px">
                                <option value="0">--Seleccionar Cliente </option>    
                            </select>
                        </div></br>
                    </div></br>
                    <div class="row mb-4">
                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Producto/os</label>
                        <div class="col-sm-6">
                            <textarea type="text" id="producto" name="producto" class="form-control" placeholder="Ingrese el producto"></textarea>
                            
                        </div>
                    </div>
                         <div class="row mb-4">
                            <div class="form-group  col-xs-5 col-md-3">
                                <label for="precio">Precio del producto</label>                                
                                <input type="text" class="form-control" name="precio_inm" id="precio_inm">
                            </div>
                            <div class="form-group  col-xs-5 col-md-3">
                                <label for="tiempo">Tiempo en Meses</label>
                                <input type="text" class="form-control" id="tiempo" name="tiempo" placeholder="Cantidad Meses" required>
                            </div>
                            <div class="form-group  col-xs-5 col-md-3">
                                <label for="primer_vto">Primer Vto</label>
                                <input type="date" class="form-control" id="primer_vto" name="primer_vto" value="{{ date('d-m-Y') }}" >
                            </div>
                            <div class="form-group  col-xs-5 col-md-3">
                                <label for="interes">Tasa de Interes</label>
                                <input type="text" class="form-control" id="interes" name="interes" placeholder="Tasa Interes" required>
                            </div>
                        </div>
                        <br/>
                        
                        {{--Entrega y Vto Entrega --}}
                        <div class="row mb-4">
                            <div class="form-group  col-xs-5 col-md-3">
                                <label for="entrega">Entrega</label>
                                <input type="text" class="form-control number" id="entrega" name="entrega" placeholder="Monto Entrega">
                            </div>
                            <div class="form-group  col-xs-5 col-md-3">
                                <label for="entrega_vto">Vto Entrega</label>
                                <input type="date" class="form-control" id="entrega_vto" name="entrega_vto" value="{{ date('d-m-Y') }}">
                            </div>
                            <br/>
                            {{--Refuerzo Cantidad Periodo y Vto Primer Refuerzo --}}
                            <div class="form-group  col-xs-5 col-md-3">
                                <label for="refuerzo">Importe de Refuerzos</label>
                                <input type="text" class="form-control number2" name="refuerzo" id="refuerzo" >
                            </div>
                            <div class="form-group  col-xs-5 col-md-3">
                                <label for="can_ref">Cantidad de Refuerzos</label>
                                <input type="text" class="form-control" name="can_ref"  id="can_ref" placeholder="Cantidad Refuerzo">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group  col-xs-5 col-md-3">
                                <label for="per_ref">Periodo Ref.</label>
                                <input type="text" class="form-control" name="per_ref" id="per_ref" placeholder="Cantidad Meses">
                            </div>

                            <div class="form-group  col-xs-5 col-md-3">
                                <label for="refuerzo_vto">Vto 1er Ref.</label>
                                <input type="date" class="form-control" name="refuerzo_vto" id="refuerzo_vto" value="{{ date('d-m-Y') }}"
                                >
                            </div>
          
                        </div></br>
                        <div class="row mb-4">
                            <div class="form-group  col-xs-5 col-md-3 mt-3">
                                <div class="form-check form-switch ">
                                    <input class="form-check-input" type="checkbox" id="con_iva" name="con_iva">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Con Iva</label>
                                </div>
                            </div>
                        </div>


                        <br/>
                        
                        <div class="modal-footer">
                                <button type="submitt" class="btn btn-primary" name="btnCalcular" id="btnCalcular">Calcular Cuotas </button>
                        </div>                        
                        <br/>

                </div>
            </div>
        </form>
    </div>  
</div>

@section('scripts')

<script>
    const number = document.querySelector('.number');
    function formatNumber (n) {
        n = String(n).replace(/\D/g, "");
    return n === '' ? n : Number(n).toLocaleString();
    }
    number.addEventListener('keyup', (e) => {
        const element = e.target;
        const value = element.value;
    element.value = formatNumber(value);
    });
</script>

<script>
    const number2 = document.querySelector('.number2');
    function formatNumber (n) {
        n = String(n).replace(/\D/g, "");
    return n === '' ? n : Number(n).toLocaleString();
    }
    number2.addEventListener('keyup', (e) => {
        const element = e.target;
        const value = element.value;
    element.value = formatNumber(value);
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

