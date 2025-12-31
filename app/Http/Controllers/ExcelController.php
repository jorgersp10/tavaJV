<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use Carbon\Carbon;


class ExcelController extends Controller
{
    public function ProductoExportNew()
    {       
        $carbon = Carbon::now('America/Asuncion');
        //dd("llega aca");
        return Excel::download(new ProductExport, 'product-'.$carbon.'.xlsx');
    
    }
}
