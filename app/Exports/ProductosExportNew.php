<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ProductosExportNew implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return Ciclista::all();
        $productos=DB::table('productos')
        //$productos=Producto::join('categorias','productos.categoria_id','=','categorias.id')
        ->select('productos.descripcion','productos.ArtCode','productos.stock'
        ,'productos.precio_compra','productos.precio_venta')
        ->orderBy('productos.descripcion','asc')
        ->get();

        return $productos;
    }

    public function headings(): array
    {
        return [
            'Producto',
            'Codigo',            
            'Stock',
            'Precio Compra',
            'Precio Venta',
        ];
    }
}
