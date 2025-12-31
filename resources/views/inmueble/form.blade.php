     
   
    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Descripcion</label>
        <div class="col-sm-9">
            <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ingrese el Nombre">
            
        </div>
    </div>

    <div class="row mb-4">
        <label class="col-md-3 form-control-label" for="documento">Loteamiento</label>
        <div class="col-sm-9">
            <select class="form-control" name="loteamiento_id" id="loteamiento_id">                                     
                <option value="0" disabled>Seleccione</option>
                
                @foreach($loteamientos as $lot)
                    <option value="{{$lot->id}}">{{$lot->descripcion}}</option>

                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Importe</label>
        <div class="col-sm-9">
            <input type="text" id="precio" name="precio" class="form-control" placeholder="Ingrese el Importe de Venta">
        </div>
    </div>

    <input type="hidden" id="estado" name="estado" value="1" class="form-control" placeholder="Estado">

    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Moneda</label>
        <div class="col-sm-9">
    
            <select class="form-control" name="moneda" id="moneda">                                     
                <option value="0" disabled>Seleccione Moneda</option>
                <option value="GS">Guaranies</option>
                <option value="US">Dolares</option>
            </select>
        </div>
    </div>
    {{-- 
    // Frente y Contrafrente 
    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Frente</label>
        <div class="col-sm-2">
            <input type="text" id="frente" name="frente" class="form-control" placeholder="Frente">    
        </div>
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Mts2</label>

        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Contrafrente</label>
        <div class="col-sm-2">
            <input type="text" id="contrafrente" name="contrafrente" class="form-control" placeholder="Contra Frente">    
        </div>
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Mts2</label>
    </div>
    // Laterales 
    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Lateral 1</label>
        <div class="col-sm-2">
            <input type="text" id="lateral1" name="lateral1" class="form-control" placeholder="Lateral 1">    
        </div>
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Mts2</label>

        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Lateral 2</label>
        <div class="col-sm-2">
            <input type="text" id="lateral2" name="lateral2" class="form-control" placeholder="Lateral 2">    
        </div>
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Mts2</label>
    </div>
    // Total 
    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Total</label>
        <div class="col-sm-2">
            <input type="text" id="cantidad_mts" name="cantidad_mts" class="form-control" placeholder="Total">    
        </div>
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Mts2</label>
    </div>
    // Lote y Manzana
    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Lote</label>
        <div class="col-sm-2">
            <input type="text" id="lote" name="lote" class="form-control" placeholder="Lote">    
        </div>
        
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Manzana</label>
        <div class="col-sm-2">
            <input type="text" id="manzana" name="manzana" class="form-control" placeholder="Manzana">    
        </div>
    </div>
    // Piso y Nro 
    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Piso Nro</label>
        <div class="col-sm-2">
            <input type="text" id="piso_nro" name="piso_nro" class="form-control" placeholder="Piso">    
        </div>
        
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Dpto Nro</label>
        <div class="col-sm-2">
            <input type="text" id="dpto_nro" name="dpto_nro" class="form-control" placeholder="Dpto Nro">    
        </div>
    </div>
    // Latitud y Longitud 
    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Latitud</label>
        <div class="col-sm-2">
            <input type="text" id="geolat" name="geolat" class="form-control" placeholder="Latitud">    
        </div>
        
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Longitud</label>
        <div class="col-sm-2">
            <input type="text" id="geolng" name="geolng" class="form-control" placeholder="Longitud">    
        </div>
    </div>

    --}}
    <div class="modal-footer">
        <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>