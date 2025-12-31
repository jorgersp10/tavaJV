
    <div class="row mb-6">
                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Usuario</label>

                <select style= "width:350px" class="js-example-basic-single js-states form-control" name="user_id" id="user_id"">
                                                    
                    <option></option>
                    
                    @foreach($usuarios as $u)
                    
                    <option value="{{$u->id}}">{{$u->name}} - {{$u->num_documento}}</option>
                        
                    @endforeach

                </select>
    </div><br>

    <div class="row mb-4">
                <label class="col-md-3 form-control-label" for="caja_nro">Número de caja</label>
                <div class="col-sm-5">                 
                    <input type="text" class="form-control" id="caja_nro" name="caja_nro" placeholder="Ingrese el número de caja">      
                </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
   @section('scripts')

   <script type="text/javascript">
        
        $(document).ready(function() {
             $("#user_id").select2({
                 placeholder:'Escribe y Seleciona Usuario',
                 allowClear: true
             });
        });
    </script>  

     <script>
     /*EDITAR CAJERO EN VENTANA MODAL*/
     $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        
        /*el button.data es lo que está en el button de editar*/
        var button = $(event.relatedTarget)
        
        var user_id_modal_editar = button.data('user_id')
        var caja_nro_modal_editar = button.data('caja_nro')
        var id_cajero = button.data('id_cajero')
        var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        /*los # son los id que se encuentran en el formulario*/
        modal.find('.modal-body #user_id').val(user_id_modal_editar);
        modal.find('.modal-body #caja_nro').val(caja_nro_modal_editar);
        modal.find('.modal-body #id_cajero').val(id_cajero);
    })
    </script> 
   @endsection 