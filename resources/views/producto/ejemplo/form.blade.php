    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="titulo">Cliente</label>
            
            <div class="col-md-5">
            <!-- obtenerDatos y obtenerDatos2 activan el javascript para completar los campos de cliente y empresa -->
            <select style= "width:330px" class="form-control" name="idcliente" id="idcliente">
                                                
                <option></option>
                
                @foreach($clientes as $cli)
                
                <option value="{{$cli->id}}">{{$cli->num_documento}} - {{$cli->nombre}} - {{$cli->telefono}}</option>
                    
                @endforeach

            </select>
            
            </div>

            <div class="col-md-4">
            
            <a class="nav-link" href="{{url('clienteseguimiento')}}" onclick="event.preventDefault(); document.getElementById('clienteseguimiento-form').submit();"><i class="fa fa-plus fa-1x"></i> Agregar Cliente Seg.</a>

            
            </div>

            
                                    
    </div> 

    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="documento">Tipo de Cliente</label>
            
            <div class="col-md-4">
            
                <select class="form-control" name="tipo_cliente" id="tipo_cliente">
                                                
                    <option value="0" disabled>Seleccione</option>
                    <option value="Asalariado">Asalariado</option>
                    <option value="Profesional Independiente">Profesional Independiente</option>
                    <option value="Cuenta Propia">Cuenta Propia</option>

                </select>
            
            </div>
            <label class="col-md-2 form-control-label" for="tipo_operacion">Tipo de Operación</label>
            
            <div class="col-md-3">
            
                <select class="form-control" name="tipo_operacion" id="tipo_operacion">
                                                
                    <option value="0" disabled>Seleccione</option>
                    <option value="Prestamos">Préstamos</option>
                    <option value="Electrodomesticos">Electrodomésticos</option>
                    <option value="Inmbiliaria">Inmobiliaria</option>

                </select>
            
            </div>                       
    </div>
    
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="consulta">Consulta al cliente</label>
                <div class="col-md-9">
                    <input type="text" id="consulta" name="consulta" class="form-control" placeholder="Ingrese el ofrecimiento al cliente">
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="respuesta">Respuesta del cliente</label>
                <div class="col-md-9">
                    <input type="text" id="respuesta" name="respuesta" class="form-control" placeholder="Ingrese la respuesta del cliente">
                </div>
    </div>
    
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="observacion">Observacion</label>
                <div class="col-md-9">
                    <input type="text" id="observacion" name="observacion" class="form-control" placeholder="Ingrese alguna observacion de ser necesario">
                </div>
    </div>

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

    <!-- <div class="form-group row">
                <label class="col-md-2 form-control-label" for="llamada">Próxima llamada</label>
                <div class="col-md-5">
                    <select class="form-control" name="myCheck" id="myCheck" onChange="mostrar(this.value);">
                    <option value = "0" >Seleccione</option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                </div>            
    </div> -->

    

    <div id="text" style="display:none" class="form-group row">
                <label class="col-md-2 form-control-label" for="recordatorio">Próxima llamada</label>
                <div class="col-md-4">
                    <input type="date" id="recordatorio" name="recordatorio" value="{{ date('Y-m-d') }}" class="form-control">     
                </div>
    </div>

     <div class="form-group row">
            <label class="col-md-2 form-control-label" for="estado">Estado</label>
            
            <div class="col-md-2">
            
                <select class="form-control" name="estado" id="estado">
                                                
                    <option value="0" disabled>Seleccione</option>
                    <option value="ABIERTO">ABIERTO</option>
                    <option value="CERRADO">CERRADO</option>
                </select>
            
            </div>                      
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
        
    </div>
    @section('scripts')


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
    <script type="text/javascript">
        
        $(document).ready(function() {
            $("#idcliente").select2({
                placeholder:'Busca por Nombre, CI o Telefono'
            });
        });
    </script>   
    @endsection 