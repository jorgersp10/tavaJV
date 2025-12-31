<div class="form-group row">
    <label class="col-md-2 form-control-label" for="myCheck">Próxima Llamada</label>
            
            <div class="col-md-3">
            
                <select class="form-control" name="myCheck" id="myCheck" onChange="mostrar(this.value);">
                                                
                    <option value="0">Seleccione</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>

                </select>
            
            </div> 
</div> 

<div id="text" style="display:none" class="form-group row">
            <label class="col-md-2 form-control-label" for="recordatorio">Próxima llamada</label>
            <div class="col-md-4">
                <input type="date" id="recordatorio" name="recordatorio" value="{{ date('Y-m-d') }}" class="form-control">     
            </div>
</div>
<script>
    function mostrar(id) {
        if (id == "Si") {
            $("#text").show();
        }

        if (id == "No") {
            $("#text").hide();
        }
    }
</script>