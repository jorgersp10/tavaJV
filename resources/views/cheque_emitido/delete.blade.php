 <!--BORRAR REGISGTRO -->
 <div class="modal fade" id="borrarRegistro-{{$c->id}}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Borrar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('cheque_emitido.destroy',$c->id)}}" method="POST">
                    {{method_field('delete')}}
                    {{csrf_field()}}

                    <p>¿Desea borrar el Cheque N° <b>{{$c->nro_cheque}}</b>?</p>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>

                </form>
            </div>                                    
        </div>
    </div>
</div>