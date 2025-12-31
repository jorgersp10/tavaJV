 <!--BORRAR REGISGTRO -->
 <div class="modal fade" id="borrarRegistroFac-{{$ven->id}}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Borrar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('factura.destroy',$ven->id)}}" method="POST">
                    {{method_field('delete')}}
                    {{csrf_field()}}

                    <p>¿Desea borrar el Factura N° <b>{{$ven->fact_nro}} de {{$ven->nombre}}</b>?</p>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>

                </form>
            </div>                                    
        </div>
    </div>
</div>