@section('title') Productos @endsection

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
<h2>Detalle de Producto</h2><br/>
<div class="menu card-header">
    
    <button style="margin: 10px" type="button" class="btn btn-primary waves-effect waves-light" data-target="#men_det">Producto</button><br>
    <!-- <button style="margin: 10px" type="button" class="btn btn-primary waves-effect waves-light" data-target="#men_img">Imagenes</button><br> -->


</div>

<div class="card-body">

    <div class="card-body" data-content id="men_img">
        <form id="addImagen">                     
            @csrf
            <div class="col-sm-9">
                <input type="file" id="imagen_agregar" name="imagen_agregar" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" onclick="history.back()" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                @if((auth()->user()->idrol) != "11")
                <button type="submit" class="btn btn-primary">Guardar</button>
                @endif
            </div>
        </form>  
        <br>    
        <div class="contenedor-galeria" id="contenedor"></div>
    </div>

    <div data-content id="men_det" class="active card-body">


        <form action="{{route('producto.update','test')}}" method="post" class="form-horizontal">                               
            {{method_field('patch')}}
            @csrf
    
            <input type="hidden" id="id_producto" name="id_producto"  value={{$producto->id}}>
            {{--<div class="container-fluid">--}}

            <div class="row mb-4">
                <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Codigo</label>
                <div class="col-sm-3">
                    <input type="text" id="ArtCode" value="{{$producto->ArtCode}}" name="ArtCode" class="form-control" placeholder="Ingrese el codigo">
                </div>
            </div>
    
        <div class="row mb-4">
            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Descripcion</label>
            <div class="col-sm-7">
                <input type="text" id="descripcion" value="{{$producto->descripcion}}" name="descripcion" class="form-control" placeholder="Ingrese el Nombre">
            </div>
        </div>
        @if($producto->tipo_producto == 0)
            <div class="row mb-4">
                <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Tipo Producto</label>
                <div class="col-sm-2">
                    <select class="form-control" name="tipo_producto" id="tipo_producto">                                                    
                        <option disabled>Seleccione</option>
                        <option value="0">Producto</option>
                        <option value="1">Servicio</option>
                    </select>
                </div>
            </div>
        @else
            <div class="row mb-4">
                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Tipo Producto</label>
                <div class="col-sm-2">
                    <select class="form-control" name="tipo_producto" id="tipo_producto">                                                    
                        <option disabled>Seleccione</option>
                        <option value="1">Servicio</option>
                        <option value="0">Producto</option>                        
                    </select>
                </div>
            </div>
        @endif

        @if($producto->veri_stock == 0)
        <div class="row mb-4">
            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Verifica Stock</label>
            <div class="col-sm-1">
                <select class="form-control" name="veri_stock" id="veri_stock">                                                    
                    <option disabled>Seleccione</option>
                    <option value="0">SI</option>
                    <option value="1">NO</option>
                </select>
            </div>
        </div>
        @else
        <div class="row mb-4">
            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Verifica Stock</label>
            <div class="col-sm-1">
                <select class="form-control" name="veri_stock" id="veri_stock">                                                    
                    <option disabled>Seleccione</option>
                    <option value="1">NO</option>
                    <option value="0">SI</option>                        
                </select>
            </div>
        </div>
    @endif

        <!-- <div class="row mb-4">
            <label class="col-sm-2 form-control-label" for="documento">Categoria</label>
            <div class="col-sm-9">
                <select class="form-control" name="categoria_id" id="categoria_id">                                     
                    <option value="0" disabled>Seleccione</option>
                    
                    @foreach($categorias as $cat)
                        <option value="{{$cat->id}}">{{$cat->codigo}}-{{$cat->descripcion}}</option>
    
                    @endforeach
                </select>
            </div>
        </div> -->
    
        <!-- <div class="row mb-4">
            <label class="col-sm-2 form-control-label" for="documento">Marcas</label>
            <div class="col-sm-9">
                <select class="form-control" name="categoria_id" id="categoria_id">                                     
                    <option value="0" disabled>Seleccione</option>
                    
                    @foreach($categorias as $cat)
                        <option value="{{$cat->id}}">{{$cat->codigo}}-{{$cat->descripcion}}</option>
    
                    @endforeach
                </select>
            </div>
        </div> -->
    
        <!-- <div class="row mb-4">
            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Moneda</label>
            <div class="col-sm-3">
                <select class="form-control" name="moneda" id="moneda">                                     
                    <option value="0" disabled>Seleccione Moneda</option>
                    <option value="GS">Guaranies</option>
                    <option value="US">Dolares</option>
                </select>
            </div>
        </div> -->
        <div class="form-group row">
            <div class="col-md-4">
                <label class="col-md-2 form-control-label">Stock</label>
                <div class="col-sm-4">
                    <input type="text" id="stock" value="{{$producto->stock}}" name="stock" class="form-control" placeholder="Ingrese la cantidad">
                </div>
            </div>

            <input type="hidden" id="tipo_iva_hidden" name="tipo_iva_hidden"  value="{{$producto->iva_id}}">

           <div class="col-md-4">
                 <label class="col-md-2 form-control-label">IVA</label>
                <div class="col-sm-4">
                <select class="form-control" name="tipo_iva" id="tipo_iva">                                     
                    <option value="0" disabled>Seleccione</option>            
                    @foreach($tipos_iva as $i)
                        <option value="{{$i->id}}">{{$i->descripcion}}</option>
                    @endforeach
                </select>
                </div>
            </div>
        </div><br>
        <div class="form-group row">
            <div class="col-md-4">
               <label class="col-md-4 form-control-label">Precio Compra</label>
                <div class="col-sm-4">
                    <input type="text" id="precio_compra" value="{{number_format(($producto->precio_compra), 0, ",", ".")}}" name="precio_compra" class="form-control number" placeholder="Ingrese el precio compra">
                </div>
            </div>

            <div class="col-md-4">
               <label class="col-md-4 form-control-label">Precio Venta</label>
                <div class="col-sm-4">
                    <input type="text" id="precio_venta" value="{{number_format(($producto->precio_venta), 0, ",", ".")}}" name="precio_venta" class="form-control number2" placeholder="Ingrese el precio venta">
                </div>
            </div>
        </div><br>
        <div class="form-group row">
            <div class="col-md-4">
               <label class="col-md-4 form-control-label">Precio Mínimo</label>
                <div class="col-sm-4">
                    <input type="text" id="precio_min" value="{{number_format(($producto->precio_min), 0, ",", ".")}}" name="precio_min" class="form-control number3" placeholder="Ingrese el precio minimo">
                </div>
            </div>

            <div class="col-md-4">
               <label class="col-md-4 form-control-label">Precio Máximo</label>
                <div class="col-sm-4">
                    <input type="text" id="precio_max" value="{{number_format(($producto->precio_max), 0, ",", ".")}}" name="precio_max" class="form-control number4" placeholder="Ingrese el precio maximo">
                </div>
            </div>
        </div><br>

        <div class="row mb-4">
            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Comentario</label>
            <div class="col-sm-9">
                <textarea id="comentarios" value="{{$producto->comentarios}}" name="comentarios" class="form-control" placeholder="Ingrese comentarios del producto ..." >{{$producto->comentarios}}</textarea>    
            </div>
        </div>

        <div class="modal-footer">
                <button type="button" onclick="history.back()" class="btn btn-light">Cerrar</button>
                @if((auth()->user()->idrol) != "11")
                    <button type="submit" class="btn btn-primary">Guardar</button>
                @endif
        </div>
    </form>
        <br/>
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

<script>
    const number3 = document.querySelector('.number3');
    function formatNumber (n) {
        n = String(n).replace(/\D/g, "");
    return n === '' ? n : Number(n).toLocaleString();
    }
    number3.addEventListener('keyup', (e) => {
        const element = e.target;
        const value = element.value;
    element.value = formatNumber(value);
    });
</script>

<script>
    const number4 = document.querySelector('.number4');
    function formatNumber (n) {
        n = String(n).replace(/\D/g, "");
    return n === '' ? n : Number(n).toLocaleString();
    }
    number4.addEventListener('keyup', (e) => {
        const element = e.target;
        const value = element.value;
    element.value = formatNumber(value);
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

