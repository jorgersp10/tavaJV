     
   
    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Descripcion</label>
        <div class="col-sm-9">
            <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ingrese el Nombre">
            
        </div>
    </div>

    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Código</label>
        <div class="col-sm-5">
            <input type="text" id="ArtCode" name="ArtCode" class="form-control" placeholder="Ingrese su código">
        </div>
    </div>

    
    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Precio Venta</label>
        <div class="col-sm-5">
            <input type="text" id="precio_venta" name="precio_venta" class="form-control" placeholder="Ingrese el Importe de Venta">
        </div>
    </div>

    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Tipo Producto</label>
        <div class="col-sm-5">
            <select class="form-control" name="tipo_producto" id="tipo_producto">                                                    
                <option disabled>Seleccione</option>
                <option value="0">Producto</option>
                <option value="1">Servicio</option>
            </select>
        </div>
    </div>

    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">IVA</label>
        <div class="col-sm-5">
        <select class="form-control" name="tipo_iva" id="tipo_iva">                                     
            <option value="0" disabled>Seleccione</option>            
            @foreach($tipos_iva as $i)
                <option value="{{$i->id}}">{{$i->descripcion}}</option>
            @endforeach
        </select>
        </div>
    </div>

    <input type="hidden" id="estado" name="estado" value="1" class="form-control" placeholder="Estado">

    <div class="modal-footer">
        <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>