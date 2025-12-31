<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Documento;
use App\Models\Tipo_documento;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use DateTime;


class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
  
        $request->validate([
            'tipo_doc_id' => 'required',
            'pdf_agregar' => 'required'
        ]);


        $file = $request->file('pdf_agregar');

        if($file)
        {
            $filename = $request->file('pdf_agregar')->getClientOriginalName();
            $foo = \File::extension($filename);
            $foo = strtolower($foo);
            //dd($foo);
            if($foo == 'pdf' || $foo == 'PDF')
            {
                // Buscamos nro de documento del cliente
                $id_cli=DB::select('select num_documento from clientes where id= ?',[$request->idcliente]);
                // Buscamos nro de documento del cliente

                $id_doc=DB::select('select id from documentos where cliente_id= ? and tipo_doc_id= ?',
                [$request->idcliente,$request->tipo_doc_id]);
                $nuevo=0;
 
                if(!empty($id_doc))
                {
                    $documento = Documento::findOrFail($id_doc[0]->id);
                    if(!empty($documento)) 
                    {
                        $nuevo=1;
                    }
                }

                $fileNameToStore = time().'.'.$foo;
                $archivo_ruta = 'documentos'.DIRECTORY_SEPARATOR.'DOC-'.$id_cli[0]->num_documento.DIRECTORY_SEPARATOR.$fileNameToStore;

                if($nuevo==1) 
                {
                    Storage::disk('public')->delete($documento->url_doc);
                    Storage::disk('public')->put($archivo_ruta,\File::get($file));
                    $documento->url_doc= $archivo_ruta;
                    $documento->fec_vto=$request->fecha_ven;
                    $documento->fec_carga=Carbon::now();
                    $documento->user_id=auth()->user()->id;
                    $documento->update();
                }
                else
                {
                    $newdoc=new Documento();
                    Storage::disk('public')->put($archivo_ruta,\File::get($file));

                    $newdoc->tipo_doc_id=$request->tipo_doc_id;
                    $newdoc->fec_vto=$request->fecha_ven;
                    $newdoc->fec_carga=Carbon::now();
                    $newdoc->user_id=auth()->user()->id;
                    $newdoc->url_doc = $archivo_ruta;
                    $newdoc->operacion_id=0;
                    $newdoc->cliente_id =$request->idcliente;
                    $newdoc->save();
                } 

                
            }
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {


      //Traemos los datos del cliente
      $client=DB::table('clientes')
      ->select('id','edad','estado_civil','sexo','direccion','idciudad as ciudad','telefono','nombre as cliente','num_documento as documento','user')
      ->where('id','=',$id)->first();

      $tipo_docs=DB::table('tipo_documentos')
      ->select('id','descripcion','vence')
      ->where('id','>','1')
      ->get();

      $dinamicos=DB::table('grupo_doc')
      ->select('id','descripcion')
      ->where('id','>','2')
      ->get();

    //   $documentos=DB::table('tipo_documentos as td')
    //   ->leftJoin('documentos as doc', 'td.id', '=', 'doc.tipo_doc_id')
    //   ->join('grupo_doc as gd','gd.id','=', 'td.doc_grupo')
    //   ->leftJoin('users as u','doc.user_id','=','u.id')
    //   ->select('td.id','td.descripcion as des_doc','td.vence',
    //            'doc.id','td.id as tipo_doc_id','td.descripcion as des_tipo','doc.fec_vto','doc.fec_carga',
    //            'doc.url_doc as url','u.name as user',
    //            'doc.cliente_id','gd.id as grupo_id','gd.descripcion as grupo')
    //   //->where('doc.cliente_id','=',$id)
    //   //->orWhere('doc.cliente_id','=',null)
    //   ->orderBy('gd.id')
    //   ->get();

      $documentos=DB::table('tipo_documentos as td')
      ->leftJoin('documentos as doc', function ($join) use($id){
        $join->on('td.id', '=', 'doc.tipo_doc_id')
             ->where('doc.cliente_id', '=',$id);})
      ->join('grupo_doc as gd','gd.id','=', 'td.doc_grupo')
      ->leftJoin('users as u','doc.user_id','=','u.id')
      ->select('td.id','td.id as tipo_doc_id','td.descripcion as des_doc','td.vence',
               'td.descripcion as des_tipo',
               'gd.id as grupo_id','gd.descripcion as grupo',
               'doc.id','doc.fec_vto','doc.fec_carga',
               'doc.url_doc as url','doc.cliente_id','u.name as user'
               )
      ->orderBy('gd.id')
      ->orderBy('td.descripcion')
      ->get();

      //dd($documentos);

      return view('documento.show',["client"=>$client, "documentos"=>$documentos, "dinamicos"=>$dinamicos, 
      "tipo_docs"=>$tipo_docs]);
     

  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function urlfile($id){
        $file = Documento::where('id',$id)->first();
        return response()->json(['response' => [
            'url' => $file->url_doc,
            ]
        ], 201);
    }

    public function descargar($id){
        $file = Documento::where('id',$id)->first();
        $nombre= $file->url_doc;
       
        
        $public_path = public_path();
        $url = $public_path.'/storage/'.$nombre;// depende de root en el archivo filesystems.php.
        $exists = Storage::disk('public')->exists($nombre);

        //verificamos si el archivo existe y lo retornamos
        
        if ($exists)
        {

            return response()->download(storage_path('app/public/' . $nombre));
        }
        //si no se encuentra lanzamos un error 404.
        abort(404);
    }

    public function destroy($id)
    {   
        //$id_doc = $id;
        $documento = Documento::findOrFail($id);

        Storage::disk('public')->delete($documento->url_doc);
        $documento->delete();
        return back();
         
    }
    
}
