<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use DB;

class ImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $imagenes=DB::table('inmo_img')
        ->select('id','imagen')
        ->where('inmueble_id','=',$id)->get();

        return response()->json($imagenes, 200, $headers);
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
        //
        $imagen= new Imagen();
        $imagen->inmueble_id = $request->id_inmueble;
        ///////////////////////////////////////////////////////////
        //Handle File Upload
        if($request->hasFile('imagen')){
            //Get filename with the extension
            $filenamewithExt = $request->file('imagen')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('imagen')->guessClientExtension();
            //FileName to store
            $fileNameToStore = time().'.'.$extension;
            //Upload Image
            $path = $request->file('imagen')->storeAs('public/img/inmuebles',$fileNameToStore);
            $imagen->imagen=$fileNameToStore;
            $imagen->save();
        } 
        //return Redirect::to("inmueble");
        ///////////////////////////////////////////////////////////
        return response()->json($imagen, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $imagenes=DB::table('inmo_img')
        ->select('id','imagen')
        ->where('inmueble_id','=',$id)->get();

        return response()->json($imagenes, 200);
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
    public function destroy($id)
    {
        $item = Imagen::findOrFail($id);
       
        Storage::delete('public/img/inmuebles/'.$item->imagen);
        $item->delete();
        return response()->json(200);
      
    }
}
