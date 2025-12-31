

<div class="row">
    <div class="col-xl-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="product-img position-relative">
                    <div class="avatar-sm product-ribbon">
                        <span class="avatar-title rounded-circle  bg-primary">
                            - 25 %
                        </span>
                    </div>
                    <img src="{{asset('storage/img/inmuebles/'.$img->imagen) }}" alt="" class="img-fluid mx-auto d-block">
                </div>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistro-{{$img->id}}">
                    <i class="fa fa-times fa-1x"></i> Borrar
                </button>
            </div>
        </div>
        @include('inmueble.deleteImagen')
    </div>

