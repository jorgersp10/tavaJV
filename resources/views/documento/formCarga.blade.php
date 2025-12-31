<form action="{{route('documento.store','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">                               
                        
    @csrf
    <div class="col-sm-6">
        <input type="hidden" id="idcliente" name="idcliente" value={{$client->id}} class="form-control">
    </div>

    <div class="row mb-4">
      

        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"> Tipo de Documento   </label>
        <div class="col-sm-6">
            <input readonly type="hidden" id="tipo_doc_id" name="tipo_doc_id" class="form-control"  required>
            <input readonly type="text" id="td_descripcion" name="td_descripcion" class="form-control"  required>
        </div>

    </div>

    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Vencimiento</label>
        <div class="col-sm-3">
            <input  type="date" id="fecha_ven" name="fecha_ven" class="form-control" placeholder="Ingrese la fecha" required>
        </div>
    </div>

    <div class="row mb-4">
        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Documento PDF</label>
        <div class="col-sm-6">
            <input type="file" id="pdf_agregar" name="pdf_agregar" class="form-control">
        </div>
        <span style="color: red">@error('pdf_agregar')
            "Debe selecionar un archivo"
        @enderror</span>
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
    

</form>