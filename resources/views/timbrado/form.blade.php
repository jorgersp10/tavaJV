     
   
    <div class="row mb-4">
            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Sucursal</label>
            <div class="col-sm-7">
            
            <select class="form-control" name="suc_timbrado" id="suc_timbrado">
                                                
                <option value="0" disabled>Seleccione</option>
                
                @foreach($sucursales as $suc)
                    
                    <option value="{{$suc->id}}">{{$suc->sucursal}}</option>
                        
                @endforeach

            </select>

            </div>
    </div>

    <div class="row mb-4">
                <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Inicio</label>
                <div class="col-sm-7">
                    <input type="date" id="ini_timbrado" name="ini_timbrado" class="form-control">
                    
                </div>
    </div>

    <div class="row mb-4">
                <label class="col-md-2 form-control-label" for="email">Fin</label>
                <div class="col-sm-7">                 
                    <input type="date" class="form-control" id="fin_timbrado" name="fin_timbrado">      
                </div>
    </div>

    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">N° Timbrado</label>
        <div class="col-sm-7">  
                <input type="text" id="nro_timbrado" name="nro_timbrado" class="form-control" placeholder="Ingrese el número de timbrado">
         </div> 
    </div> 

    <div class="row mb-4">
            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">N° de Local/Sucursal</label>
            <div class="col-sm-7">  
                    <input type="text" id="nrof_suc" name="nrof_suc" class="form-control" placeholder="Ingrese el número">
             </div> 
    </div> 

    <div class="row mb-4">
            <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">N° Expendio</label>
            <div class="col-sm-7">  
                    <input type="text" id="nrof_expendio" name="nrof_expendio" class="form-control" placeholder="Ingrese el número">
             </div> 
    </div> 

    <div class="modal-footer">
        <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
