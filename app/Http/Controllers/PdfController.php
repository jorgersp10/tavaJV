<?php

namespace App\Http\Controllers;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Models\Cuota;
use App\Models\Cuota_det;
use App\Models\Informe;
use App\Models\Cliente;
use Illuminate\Support\Facades\Redirect;
use DB;

class PdfController extends Controller
{
    protected $fpdf;
 
    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function index() 
    {
        //DB::select("CALL sp_update_pagos()");
        $cuotas=DB::table('cuotas as c')
        ->join('clientes as cli','c.cliente_id','=','cli.id')
        ->join('ventas as v','c.factura_id','=','v.id')
        ->select('c.id as cuota_id','cli.nombre as cliente','v.fact_nro as descripcion'
        ,'c.total_cuo as deuda','pagos_cuo as pagos','c.cuotas_atr',
        'saldo_cuo','saldo_ven','pagos_ven')
        ->where('c.saldo_cuo','>',0)
        ->orderby('cli.nombre')
        ->get();

        //Seteamos el tiupo de letra y creamos el titulo de la pagina. No es un encabezado no se repetira
        

        //dd($cuotas);
    	
        $this->fpdf->AddPage("L", "A4");
        
        $this->fpdf->SetFont('Arial','B',12);
        $this->fpdf->Cell(90,6,'',0,0,'C');
        $this->fpdf->Cell(100,6,'Resumen de Clientes - Saldos y Atrasos',1,0,'C');
        $this->fpdf->Ln();

        $this->fpdf->SetLineWidth(.3);
        $this->fpdf->SetFont('Arial', 'B', 6);

        $w = array(60, 60, 30, 30, 30, 30, 30);
        $this->fpdf->Cell($w[0],10,"Cliente",1,0,'L',0);
        $this->fpdf->Cell($w[1],10,"Producto",1,0,'L',0);
        $this->fpdf->Cell($w[2],10,"Precio",1,0,'L',0);
        $this->fpdf->Cell($w[3],10,"Pagado",1,0,'L',0);
        $this->fpdf->Cell($w[4],10,"Saldo",1,0,'L',0);
        $this->fpdf->Cell($w[5],10,"Cuotas Atrasadas",1,0,'L',0);
        $this->fpdf->Ln();

            $total_deuda=0;
            $total_pagos=0;
            $total_vencido=0;

        foreach($cuotas as $row)
        {
           // dd($row);
            $this->fpdf->Cell($w[0],6,$row->cliente,1,0,'L',0);
            $this->fpdf->Cell($w[1],6,$row->descripcion,1,0,'L',0);
            $this->fpdf->Cell($w[2],6,"Gs ".number_format(($row->deuda), 0, ",", "."),1,0,'L',0);
            $this->fpdf->Cell($w[3],6,"Gs ".number_format(($row->pagos), 0, ",", "."),1,0,'L',0);
            $this->fpdf->Cell($w[4],6,"Gs ".number_format(($row->saldo_cuo), 0, ",", "."),1,0,'L',0);
            $this->fpdf->Cell($w[6],6,($row->cuotas_atr),1,0,'L',0);
            $this->fpdf->Ln();

            $total_deuda=$total_deuda+$row->deuda;
            $total_pagos=$total_pagos+$row->pagos;
            $total_vencido=$total_vencido+$row->saldo_cuo;
            
        }        

        // TOTALES DE COLUMNAS
        $this->fpdf->Cell($w[0],6,"",1,0,'L',0);
        $this->fpdf->Cell($w[1],6,"Totales",1,0,'L',0);
        $this->fpdf->Cell($w[2],6,"Gs ".number_format(($total_deuda), 0, ",", "."),1,0,'L',0);
        $this->fpdf->Cell($w[3],6,"Gs ".number_format(($total_pagos), 0, ",", "."),1,0,'L',0);
        $this->fpdf->Cell($w[4],6,"Gs ".number_format(($total_vencido), 0, ",", "."),1,0,'L',0);
        $this->fpdf->Cell($w[5],6,"",1,0,'L',0);
        $this->fpdf->Ln();

            //$this->fpdf->Cell(0,10,'Printing line number '.$i,0,1);
        $this->fpdf->Output();

        exit;
    }
}
