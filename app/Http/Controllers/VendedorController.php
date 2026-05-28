<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendedor;
use Illuminate\Support\Facades\Redirect;
use DB;

class VendedorController extends Controller
{
    public function index(Request $request)
    {
        $sql = trim($request->get('buscarTexto'));
        $sql = str_replace(" ", "%", $sql);

        $vendedores = DB::table('vendedores as v')
        ->leftJoin('users as u', 'u.id', '=', 'v.user_id')
        ->select('v.id','v.name as nombre','v.num_documento','v.telefono','v.email','v.condicion as estado',
        'u.name as usuario','u.email as usuario_email')
        ->where('v.name','LIKE','%'.$sql.'%')
        ->orWhere('v.num_documento','LIKE','%'.$sql.'%')
        ->orWhere('u.name','LIKE','%'.$sql.'%')
        ->orderBy('v.id','desc')
        ->paginate(10);

        return view('vendedor.index',["vendedores"=>$vendedores,"buscarTexto"=>$sql]);
    }

    public function create()
    {
        $usuarios = $this->usuariosDisponibles();

        return view('vendedor.create',["usuarios"=>$usuarios]);
    }

    public function store(Request $request)
    {
        $docu = str_replace(".", "", $request->num_documento);

        if ($docu != null) {
            $yaexistedocumento = DB::select('select name,num_documento from vendedores where num_documento = ?',[$docu]);
            if ($yaexistedocumento != null) {
                return back()->with('msj', 'Vendedor: '.$yaexistedocumento[0]->name.' - '.$yaexistedocumento[0]->num_documento.' ya existe');
            }
        }

        if ($request->user_id != 0) {
            $usuarioAsignado = Vendedor::where('user_id', $request->user_id)->first();
            if ($usuarioAsignado != null) {
                return back()->with('msj', 'El usuario seleccionado ya esta vinculado a otro vendedor');
            }
        }

        $vendedor = new Vendedor();
        $vendedor->name = strtoupper($request->nombre);
        $vendedor->num_documento = $docu;
        $vendedor->telefono = $request->telefono;
        $vendedor->email = $request->email;
        $vendedor->direccion = strtoupper($request->direccion);
        $vendedor->user_id = $request->user_id == 0 ? null : $request->user_id;
        $vendedor->condicion = $request->estado ?? 1;
        $vendedor->save();

        return Redirect::to("vendedor")->with('msj2', 'VENDEDOR REGISTRADO');
    }

    public function show($id)
    {
        $vendedor = Vendedor::findOrFail($id);
        $usuarios = $this->usuariosDisponibles($vendedor->user_id);

        return view('vendedor.show',["vendedor"=>$vendedor,"usuarios"=>$usuarios]);
    }

    public function update(Request $request)
    {
        $vendedor = Vendedor::findOrFail($request->id_vendedor);
        $docu = str_replace(".", "", $request->num_documento);

        if ($request->user_id != 0) {
            $usuarioAsignado = Vendedor::where('user_id', $request->user_id)
            ->where('id', '<>', $vendedor->id)
            ->first();

            if ($usuarioAsignado != null) {
                return back()->with('msj', 'El usuario seleccionado ya esta vinculado a otro vendedor');
            }
        }

        $vendedor->name = strtoupper($request->nombre);
        $vendedor->num_documento = $docu;
        $vendedor->telefono = $request->telefono;
        $vendedor->email = $request->email;
        $vendedor->direccion = strtoupper($request->direccion);
        $vendedor->user_id = $request->user_id == 0 ? null : $request->user_id;
        $vendedor->condicion = $request->estado ?? 1;
        $vendedor->save();

        return Redirect::to("vendedor")->with('msj2', 'VENDEDOR ACTUALIZADO');
    }

    public function destroy($id)
    {
        Vendedor::destroy($id);

        return Redirect::to("vendedor")->with('msj2', 'VENDEDOR ELIMINADO');
    }

    private function usuariosDisponibles($usuarioActual = null)
    {
        return DB::table('users as u')
        ->leftJoin('vendedores as v', 'v.user_id', '=', 'u.id')
        ->select('u.id','u.name','u.email')
        ->where(function ($query) use ($usuarioActual) {
            $query->whereNull('v.id');

            if ($usuarioActual != null) {
                $query->orWhere('u.id', '=', $usuarioActual);
            }
        })
        ->orderBy('u.name','asc')
        ->get();
    }
}
