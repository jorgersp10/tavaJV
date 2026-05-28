<div class="form-group row">
    <div class="col-md-4">
        <label class="col-md-3 form-control-label" for="nombre">Nombre</label>
        <div class="mb-3">
            <input type="text" id="nombre" name="nombre" value="{{old('nombre', $vendedor->name ?? '')}}" class="form-control" placeholder="Ingrese nombre" required>
        </div>
    </div>
    <div class="col-md-4">
        <label class="col-md-3 form-control-label" for="num_documento">Documento</label>
        <div class="mb-3">
            <input type="text" id="num_documento" name="num_documento" value="{{old('num_documento', $vendedor->num_documento ?? '')}}" class="form-control" placeholder="Ingrese documento">
        </div>
    </div>
    <div class="col-md-4">
        <label class="col-md-3 form-control-label" for="telefono">Telefono</label>
        <div class="mb-3">
            <input type="text" id="telefono" name="telefono" value="{{old('telefono', $vendedor->telefono ?? '')}}" class="form-control" placeholder="Ingrese telefono">
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4">
        <label class="col-md-3 form-control-label" for="email">Email</label>
        <div class="mb-3">
            <input type="email" id="email" name="email" value="{{old('email', $vendedor->email ?? '')}}" class="form-control" placeholder="Ingrese email">
        </div>
    </div>
    <div class="col-md-4">
        <label class="col-md-3 form-control-label" for="direccion">Direccion</label>
        <div class="mb-3">
            <input type="text" id="direccion" name="direccion" value="{{old('direccion', $vendedor->direccion ?? '')}}" class="form-control" placeholder="Ingrese direccion">
        </div>
    </div>
    <div class="col-md-4">
        <label class="col-md-3 form-control-label" for="estado">Estado</label>
        <div class="mb-3">
            <select class="form-control" name="estado" id="estado">
                <option value="1" @if(old('estado', $vendedor->condicion ?? 1) == 1) selected @endif>Activo</option>
                <option value="0" @if(old('estado', $vendedor->condicion ?? 1) == 0) selected @endif>Inactivo</option>
            </select>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-6">
        <label class="col-md-3 form-control-label" for="user_id">Usuario vinculado</label>
        <div class="mb-3">
            <select class="form-control" name="user_id" id="user_id">
                <option value="0">Sin usuario</option>
                @foreach($usuarios as $u)
                    <option value="{{$u->id}}" @if(old('user_id', $vendedor->user_id ?? 0) == $u->id) selected @endif>{{$u->name}} - {{$u->email}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
