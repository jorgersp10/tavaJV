<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iva_param;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use DB;

class IvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $ivas=DB::table('iva_param as i')
        ->select('i.id','i.fecha_ini','i.fecha_fin')           
        ->get();

        return view('iva.index',["ivas"=>$ivas]);
    }
    

    public function update(Request $request)
    {
        $ivas= Iva_param::findOrFail($request->id_iva);
        $ivas->fecha_ini = $request->fecha_ini;
        $ivas->fecha_fin = $request->fecha_fin;

        $ivas->save();
        return Redirect::to("iva");
    }
}
