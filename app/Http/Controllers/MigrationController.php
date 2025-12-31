<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Producto;

use DB;



class MigrationController extends Controller
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

     public function migra_codigo()
    {

        $productos = DB::table('productos')->orderBy('descripcion','asc')->get();

            for($i = 0 ; $i < sizeof($productos); $i++)
            {
                
               //$art=Producto::where('ArtCode', $productos[$i]->id)->first();
                $art = Producto::findOrFail($productos[$i]->id);
                        
                if ( $art != null)
                {
                    if ($i<9 ){
                        $art->ArtCode = '000000'.strval($i+1) ;
                    }elseif ($i<99 ){
                        $art->ArtCode = '00000'.strval($i+1) ;
                    }elseif ($i<999 ){
                        $art->ArtCode = '0000'.strval($i+1) ;
                    }elseif ($i<9999 ){
                        $art->ArtCode = '000'.strval($i+1) ;
                    }elseif ($i<99999 ){
                        $art->ArtCode = '00'.strval($i+1) ;
                    }
                    

                    $art->update();
                }
            }


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
        //
    }
}
