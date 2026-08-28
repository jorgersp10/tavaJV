<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ventas por Vendedor y Sucursal</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 11px; margin: 1cm; }
        h2, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #c2cfd6; padding: 5px; text-align: left; }
        th, .totales { font-weight: bold; background-color: #ffff00; }
    </style>
</head>
<body>
    <h2>Ventas por Vendedor y/o Sucursal</h2>
    @if($date1 && $date2)
        <h3>Rango de fecha: {{ date('d-m-Y', strtotime($date1)) }} al {{ date('d-m-Y', strtotime($date2)) }}</h3>
    @else
        <h3>Rango de fecha: Todas las fechas</h3>
    @endif
    <h3>Vendedor: {{ $vendedorSeleccionado }} | Sucursal: {{ $sucursalSeleccionada }}</h3>

    @if($ventas === 'Vacio')
        <h3>No se encontraron ventas</h3>
    @else
        @php
            $totalIva = 0;
            $totalVenta = 0;
        @endphp
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Factura</th>
                    <th>Cliente</th>
                    <th>Vendedor</th>
                    <th>Sucursal</th>
                    <th>IVA</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    @php
                        $iva = $venta->estado == 1 ? 0 : $venta->ivaTotal;
                        $total = $venta->estado == 1 ? 0 : $venta->total;
                        $totalIva += $iva;
                        $totalVenta += $total;
                    @endphp
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($venta->fecha)) }}</td>
                        <td>{{ $venta->fact_nro }}</td>
                        <td>{{ $venta->cliente }}</td>
                        <td>{{ $venta->vendedor ?: '-' }}</td>
                        <td>{{ $venta->sucursal ?: '-' }}</td>
                        <td>Gs. {{ number_format($iva, 0, ',', '.') }}</td>
                        <td>Gs. {{ number_format($total, 0, ',', '.') }}</td>
                        <td>{{ $venta->estado == 1 ? 'Anulado' : ($venta->estado_pago == 'C' ? 'Cobrado' : 'Pendiente') }}</td>
                    </tr>
                @endforeach
                <tr class="totales">
                    <td colspan="5">TOTALES</td>
                    <td>Gs. {{ number_format($totalIva, 0, ',', '.') }}</td>
                    <td>Gs. {{ number_format($totalVenta, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif
</body>
</html>