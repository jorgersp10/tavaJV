     
   
    <div class="row mb-4">
                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-9">
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el Nombre">
                    
                </div>
    </div>
    
    <div class="row mb-4">
                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Dirección</label>
                <div class="col-sm-9">
                    <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Ingrese la dirección">
                </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label class="col-md-3 form-control-label" for="documento">Tipo de Documento</label>
            
            <div class="mb-3">
            
                <select class="form-control" name="tipo_documento" id="tipo_documento">
                                                
                    <option value="0" disabled>Seleccione</option>
                    <option value="DNI">DNI</option>
                    <option value="CEDULA">C.I.</option>
                    <option value="RUC">RUC</option>

                </select>
            
            </div>
        </div>
        <div class="col-md-6">
            <label class="col-md-3 form-control-label" for="num_documento">Número documento</label>
                <div class="mb-3">
                    <input type="text" id="num_documento" name="num_documento" class="form-control" placeholder="Ingrese el número documento">
                </div> 
        </div>
    </div>     

    <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="fecha_nacimiento">Fecha Nacimiento</label>
                    <div class="col-md-3">
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control">     
                    </div>
    </div>
    

    <div class="row mb-2">
                <label class="col-md-3 col-form-label" for="telefono">Telefono</label>
                <div class="col-md-6">
                  
                    <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Ingrese el telefono">
                       
                </div>
    </div>

    <div class="row mb-2">
                <label class="col-md-3 form-control-label" for="telefono">Correo</label>
                <div class="col-md-6">
                  
                <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el correo">
                       
                </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label class="col-md-3 form-control-label" for="documento">Sexo</label>
            
            <div class="mb-3">
            
                <select class="form-control" name="sexo" id="sexo">
                                                    
                    <option value="0" disabled>Seleccione</option>
                    <option value="M">M</option>
                    <option value="F">F</option>
                    <option value="OTRO">OTRO</option>

                </select>
            
            </div>
        </div>
        <div class="col-md-6">
            <label class="col-md-3 form-control-label" for="documento">Estado Civil</label>
            <div class="mb-3">
            
                <select class="form-control" name="estado_civil" id="estado_civil">
                                                
                    <option value="0" disabled>Seleccione</option>
                    <option value="CASADO">CASADO/A</option>
                    <option value="SOLTERO">SOLTERO/A</option>
                    <option value="VIUDO">VIUDO/A</option>
                    <option value="SEPARADO">SEPARADO/A</option>

                </select>
        
            </div>
        </div>
    </div>     

    <div class="modal-footer">
        <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>