
    <div class="row mb-6">
                <label class="col-md-3 form-control-label" for="caja_nro">Fecha Inicio</label>
                <div class="col-sm-5">                 
                    <input type="date" class="form-control" id="fecha_ini" name="fecha_ini" placeholder="Ingrese el número de caja">      
                </div>
    </div>

    <div class="row mb-4">
                <label class="col-md-3 form-control-label" for="caja_nro">Fecha Fin</label>
                <div class="col-sm-5">                 
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" placeholder="Ingrese el número de caja">      
                </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
   @section('scripts')


     <script>
     /*EDITAR CAJERO EN VENTANA MODAL*/
     $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        
        /*el button.data es lo que está en el button de editar*/
        var button = $(event.relatedTarget)
        
        var fecha_ini_modal_editar = button.data('fecha_ini')
        var fecha_fin_modal_editar = button.data('fecha_fin')
        var id_iva = button.data('id_iva')
        var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        /*los # son los id que se encuentran en el formulario*/
        modal.find('.modal-body #fecha_ini').val(fecha_ini_modal_editar);
        modal.find('.modal-body #fecha_fin').val(fecha_fin_modal_editar);
        modal.find('.modal-body #id_iva').val(id_iva);
    })
    </script> 
   @endsection 