

@section('title') @lang('translation.Form_Wizard') @endsection

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!--<h4 class="card-title mb-4">Documentos del Cliente</h4> -->

                    <div id="basic-example">

                        <h3>Documentación</h3>
                        <section>
                                <div class="table-rep-plugin">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="tech-companies-1" class="table table-striped">                               
                                            <thead>                            
                                                <tr>      
                                                    <th  data-priority="1">Ver Documento</th>
                                                    <th  data-priority="1">Tipo Documento</th>
                                                    <th  data-priority="1">Fecha Carga</th>
                                                    <th  data-priority="1">Fecha Vto</th>
                                                    {{-- <th  data-priority="1">URL</th> --}}
                                                    <th  data-priority="1">Cargado Por</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($documentos as $doc)
                                                @if ($doc->grupo_id==2)
                                                    <tr>                  
                                                        <td>                                     
                                                        <div class="col-sm-6">
 
                                                            @if ($doc->id==null)

                                                                <button type="button" class="btn btn-danger btn-sm" 
                                                                data-tipo_doc_id="{{ $doc->tipo_doc_id}}"
                                                                data-des_tipo="{{ $doc->des_tipo}}"
                                                                data-vence="{{ $doc->vence}}"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#abrirmodalDoc"><i class="fa fa-danger fa-1x"></i> Cargar Documento</button>
                                                            
                                                            @else
                                                                <button type="button" class="btn btn-success btn-sm" 
                                                                    data-tipo_doc_id="{{ $doc->tipo_doc_id}}"
                                                                    data-des_tipo="{{ $doc->des_tipo}}"
                                                                    data-vence="{{ $doc->vence}}"
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#abrirmodalDoc"><i class="fa fa-success fa-1x"></i> 
                                                                Editar</button>
                                                                <a href="{{URL::action('App\Http\Controllers\DocumentoController@descargar', $doc->id)}}">
                                                                    <button type="button" class="btn btn-success btn-sm" >
                                                                            <i class="fa fa-success fa-1x"></i> Descargar
                                                                    </button>
                                                                </a> 
                                                                <button type="button" class="btn btn-success btn-sm" onclick="showFile('{{ $doc->id }}')">
                                                                    <i class="fa fa-success fa-1x"></i>Ver
                                                                </button>
                                                                @if(auth()->user()->idrol == 1)
                                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#borrarRegistro-{{$doc->id}}">
                                                                        <i class="fa fa-times fa-1x"></i> Borrar
                                                                    </button>
                                                                    @include('documento.delete')
                                                                @endif

                                                            @endif
                                                            
                                                        </div>  
                                                        
                                                        <td>{{$doc->des_doc}}</td>
                                                        @if ($doc->fec_carga==null)
                                                            <td>   </td>
                                                        @else
                                                            <td>{{ date('d-m-Y', strtotime($doc->fec_carga)) }}</td>
                                                        @endif

                                                        @if ($doc->fec_vto==null)
                                                            <td>   </td>
                                                        @else
                                                            <td>{{ date('d-m-Y', strtotime($doc->fec_vto)) }}</td>    
                                                        @endif
                                                        
                                                        {{-- <td>{{$doc->url}}</td> --}}
                                                        <td>{{$doc->user}}</td>      
                                                    </tr>  
                                                @endif
                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>                         
                        </section>

                    </div>

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

  


@section('script')
    <script>
        /*cargar documento EN VENTANA MODAL*/
    $('#abrirmodalDoc').on('show.bs.modal', function (event) {

    /*el button.data es lo que est�� en el button de editar*/
    var button = $(event.relatedTarget)        
    var td_id_modal = button.data('tipo_doc_id')
    var td_descripcion_modal = button.data('des_tipo')

    var modal = $(this)
    // modal.find('.modal-title').text('New message to ' + recipient)
    /*los # son los id que se encuentran en el formulario*/
    modal.find('.modal-body #tipo_doc_id').val(td_id_modal);
    modal.find('.modal-body #td_descripcion').val(td_descripcion_modal);


    })
    </script>
    <!-- jquery step -->
    <script src="{{ URL::asset('/assets/libs/jquery-steps/jquery-steps.min.js') }}"></script>

    <!-- form wizard init -->
    <script src="{{ URL::asset('/assets/js/pages/form-wizard.init.js') }}"></script>
@endsection
