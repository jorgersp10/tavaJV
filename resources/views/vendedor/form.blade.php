     
   
    <div class="row mb-4">
                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-9">
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el Nombre">
                    
                </div>
    </div>

    <div class="row mb-4">
                <label class="col-md-3 form-control-label" for="email">Correo</label>
                <div class="col-sm-9">                 
                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el correo">      
                </div>
    </div>

    <div class="row mb-4">
            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Número documento</label>
            <div class="col-sm-9">  
                    <input type="text" id="num_documento" name="num_documento" class="form-control" placeholder="Ingrese el número documento">
             </div> 
    </div> 
    
    <div class="row mb-4">
            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Dirección</label>
            <div class="col-sm-9">   
                <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Ingrese la dirección">
            </div>
    </div>

    <div class="row mb-4">
            <label class="col-md-3 col-form-label" for="telefono">Telefono</label>
            <div class="col-md-6">
                
                <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Ingrese el telefono">
                    
            </div>
    </div>

    <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="fecha_nacimiento">Fecha Nacimiento</label>
                <div class="col-md-3">
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control">     
                </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label class="col-md-3 form-control-label" for="documento">Sucursal</label>
            <div class="mb-3">
            
            <select class="form-control" name="idsucursal" id="idsucursal">
                                                
                <option value="0" disabled>Seleccione</option>
                
                @foreach($sucursales as $suc)
                    
                    <option value="{{$suc->id}}">{{$suc->sucursal}}</option>
                        
                @endforeach

            </select>

            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>