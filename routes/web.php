<?php

use App\Http\Controllers\AdelantoController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CajeroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ComisionController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CreaCuotasController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\InmuebleController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProformaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\Recibo_funcionarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\TimbradoController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\Cuenta_corrienteController;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\Cheque_emitidoController;
use App\Http\Controllers\IvaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\TransferenciaController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::resource('migration', MigrationController::class);
Route::get('/migra_codigo', [MigrationController::class, 'migra_codigo'])->name('migra_codigo');


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root')->middleware('auth');

Route::group(['middleware' => ['auth']], function () {

    Route::get('resumenClientes', [PdfController::class, 'index']);
    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
    Route::post('/getClientesVen', [VentaController::class, 'getClientesVen'])->name('getClientesVen');
    Route::post('/getClientes', [CajaController::class, 'getClientes'])->name('getClientecaja');
    Route::post('/getClienteInforme', [InformeController::class, 'getClienteInforme'])->name('getClienteInforme');
    Route::post('/getProInforme', [InformeController::class, 'getProInforme'])->name('getProInforme');

    Route::post('/getProveedores', [CompraController::class, 'getProveedores'])->name('getProveedores');
    Route::post('compraContable', [CompraController::class, 'compraContable'])->name('compraContable');
    Route::post('/getProductos', [FacturaController::class, 'getProductos'])->name('getProductos');
    Route::post('/getProductosCompra', [CompraController::class, 'getProductosCompra'])->name('getProductosCompra');
    Route::post('/getConceptos', [GastoController::class, 'getConceptos'])->name('getConceptos');
    Route::post('/getClientesVentas', [FacturaController::class, 'getClientesVentas'])->name('getClientesVentas');
    Route::post('/obtenerPrecio', [FacturaController::class, 'obtenerPrecio'])->name('obtenerPrecio'); //aca de prueba
    Route::get('factura_pdf/{id}', [FacturaController::class, 'factura_pdf'])->name('factura_pdf');
    Route::get('factura_pdf_orden/{id}', [FacturaController::class, 'factura_pdf_orden'])->name('factura_pdf_orden');

    Route::post('update_facNro', [FacturaController::class, 'update_facNro'])->name('update_facNro');
    Route::get('imprimirTicket/{id}', [FacturaController::class, 'imprimirTicket'])->name('imprimirTicket');

    Route::post('update_compra', [CompraController::class, 'update_compra'])->name('update_compra');

    Route::post('/getFuncionarios', [Recibo_funcionarioController::class, 'getFuncionarios'])->name('getFuncionarios');
    Route::post('/obtenerDatos', [Recibo_funcionarioController::class, 'obtenerDatos'])->name('obtenerDatos'); //aca de prueba
    Route::get('recibo_func/{id}', [Recibo_funcionarioController::class, 'recibo_func'])->name('recibo_func');
    Route::get('recibo_adelanto/{id}', [AdelantoController::class, 'recibo_adelanto'])->name('recibo_adelanto');
    Route::get('productoExport/{ruta}', [ExcelController::class, 'ProductoExportNew'])->name('ProductoExportNew');

    Route::resource('rol', RolController::class);
    Route::resource('cliente', ClienteController::class);
    Route::resource('user', UserController::class);
    Route::resource('sucursal', SucursalController::class);
    Route::resource('cargarventa', InmuebleController::class);
    Route::resource('venta', VentaController::class);
    Route::resource('informe', InformeController::class);
    Route::resource('tipo_operacion', Tipo_operacionController::class);
    Route::resource('documento', DocumentoController::class);
    Route::resource('compra', CompraController::class);
    Route::resource('proveedor', ProveedorController::class);
    Route::resource('factura', FacturaController::class);
    Route::resource('presupuesto', PresupuestoController::class);
    Route::resource('producto', ProductoController::class);
    Route::resource('funcionario', FuncionarioController::class);
    Route::resource('comision', ComisionController::class);
    Route::resource('adelanto', AdelantoController::class);
    Route::resource('recibo_funcionario', Recibo_funcionarioController::class);
    Route::resource('pago', PagoController::class);
    Route::resource('timbrado', TimbradoController::class);
    Route::resource('gasto', GastoController::class);
    Route::resource('concepto', ConceptoController::class);
    Route::resource('cuenta_corriente', Cuenta_corrienteController::class);
    Route::resource('cheque', ChequeController::class);
    Route::resource('cheque_emitido', Cheque_emitidoController::class);
    Route::resource('iva', IvaController::class);
    Route::resource('empresa', EmpresaController::class);
    Route::resource('transfer', TransferenciaController::class);

    Route::get('editar/{id}', [PresupuestoController::class, 'editar'])->name('editar'); 
    Route::get('obtenerPresupuesto/{id}', [PresupuestoController::class, 'obtenerPresupuesto'])->name('obtenerPresupuesto');   

    Route::post('/obtenerBanco', [Cheque_emitidoController::class, 'obtenerBanco'])->name('obtenerBanco'); //aca de prueba


    Route::post('/getClientesLib', [ChequeController::class, 'getClientesLib'])->name('getClientesLib');
    Route::post('/getClientesEnd', [ChequeController::class, 'getClientesEnd'])->name('getClientesEnd');

    Route::post('/getClienteEm', [Cheque_emitidoController::class, 'getClienteEm'])->name('getClienteEm');
    Route::post('/getProveedorEm', [Cheque_emitidoController::class, 'getProveedorEm'])->name('getProveedorEm');

    Route::get('/documentos/file/{id}', [DocumentoController::class, 'urlfile'])->name('documento_file');
    Route::get('getDocumento/{nombre}', [DocumentoController::class, 'descargar'])->name('getDoc');

    Route::post('/proformaPDF', [VentaController::class, 'proformaPDF'])->name('venta.imprime');
    Route::post('/proformamPDF', [MuebleController::class, 'proformaPDF'])->name('mueble.imprime');
    Route::post('/proformaiPDF', [InmuebleController::class, 'proformaPDF'])->name('inmueble.imprime');

    Route::get('/ventacalc', [VentaController::class, 'calculos'])->name('venta.calculos');

    Route::get('/proforma/{id}', [ProformaController::class, 'show'])->name('proforma.show');
    Route::post('/proformai', [ProformaController::class, 'calcularCuota'])->name('proforma.calcularCuota');
    Route::post('/proforma', [ProformaController::class, 'store'])->name('proforma.store');

    Route::resource('cajero', CajeroController::class);

    Route::resource('caja', CajaController::class);
    Route::post('pagar', [CajaController::class, 'pagar'])->name('caja.pagar');
    Route::get('pagarCompra/{id}', [CompraController::class, 'pagarCompra'])->name('pagarCompra');
    Route::post('pagarFactCompra', [CompraController::class, 'pagarFactCompra'])->name('pagarFactCompra');
    Route::get('pagarFactura', [CompraController::class, 'pagarFactura'])->name('pagarFactura');
    Route::get('reciboCompra/{id}', [CompraController::class, 'reciboCompra'])->name('reciboCompra');
    Route::get('pagos_compra', [CompraController::class, 'pagos_compra'])->name('pagos_compra');
    Route::post('destroy_pago', [CompraController::class, 'destroy_pago'])->name('destroy_pago');



    Route::post('cobrarCheque', [Cheque_emitidoController::class, 'cobrarCheque'])->name('cobrarCheque');
    Route::post('cobrarChequeR', [ChequeController::class, 'cobrarChequeR'])->name('cobrarChequeR');


    Route::get('pagarGasto/{id}', [GastoController::class, 'pagarGasto'])->name('pagarGasto');
    Route::post('pagarFactGasto', [GastoController::class, 'pagarFactGasto'])->name('pagarFactGasto');
    Route::get('pagarFacturaG', [GastoController::class, 'pagarFacturaG'])->name('pagarFacturaG');
    Route::post('gastoContable', [GastoController::class, 'gastoContable'])->name('gastoContable');

    Route::post('comprobante', [CajaController::class, 'comprobante'])->name('comprobante');
    Route::get('comprobante', [CajaController::class, 'comprobante'])->name('comprobante');
    Route::get('/comprobante_imp/{id}/{tc}', [CajaController::class, 'show'])->name('comprobante_imp');
    Route::get('obtenerCuotas/{id}', [CajaController::class, 'obtenerCuotas'])->name('obtenerCuotas');

    Route::get('obtenerInmuebles/{id}', [CajaController::class, 'obtenerInmuebles'])->name('obtenerInmuebles');
    Route::get('obtenerFacturas/{id}', [CompraController::class, 'obtenerFacturas'])->name('obtenerFacturas');

    Route::get('pdfResumen', [InformeController::class, 'pdfResumen'])->name('pdfResumen');

    Route::get('graficosResumen', [InformeController::class, 'graficosResumen'])->name('graficosResumen');

    Route::get('reporteUrba', [InformeController::class, 'reporteUrba'])->name('reporteUrba');
    Route::post('reporteUrbaPDF', [InformeController::class, 'reporteUrbaPDF'])->name('reporteUrbaPDF');
    Route::get('reporteDetalle', [InformeController::class, 'reporteDetalle'])->name('reporteDetalle');
    Route::post('reporteDetallePDF', [InformeController::class, 'reporteDetallePDF'])->name('reporteDetallePDF');
    Route::post('reporteVentaPDF', [InformeController::class, 'reporteVentaPDF'])->name('reporteVentaPDF');
    Route::post('reporteVentaPendientePDF', [InformeController::class, 'reporteVentaPendientePDF'])->name('reporteVentaPendientePDF');

    Route::post('reporteCompraPDF', [InformeController::class, 'reporteCompraPDF'])->name('reporteCompraPDF');
    Route::post('reporteCompraPendientePDF', [InformeController::class, 'reporteCompraPendientePDF'])->name('reporteCompraPendientePDF');
    Route::post('reporteCompraCobradaPDF', [InformeController::class, 'reporteCompraCobradaPDF'])->name('reporteCompraCobradaPDF');


    Route::post('reporteProductoPDF', [InformeController::class, 'reporteProductoPDF'])->name('reporteProductoPDF');
    Route::post('reporteProductoGSPDF', [InformeController::class, 'reporteProductoGSPDF'])->name('reporteProductoGSPDF');
    Route::post('reporteCreditoPDF', [InformeController::class, 'reporteCreditoPDF'])->name('reporteCreditoPDF');
    Route::get('calculoMensual', [InformeController::class, 'calculoMensual'])->name('calculoMensual');
    Route::get('controlStock', [InformeController::class, 'controlStock'])->name('controlStock');
    Route::post('reporteIvaPDF', [InformeController::class, 'reporteIvaPDF'])->name('reporteIvaPDF');
    Route::get('informeLibroVenta', [InformeController::class, 'informeLibroVenta'])->name('informeLibroVenta');
    Route::post('informeLibroVenta', [InformeController::class, 'informeLibroVenta'])->name('informeLibroVenta');
    Route::get('informeLibroCompra', [InformeController::class, 'informeLibroCompra'])->name('informeLibroCompra');
    Route::post('informeLibroCompra', [InformeController::class, 'informeLibroCompra'])->name('informeLibroCompra');


    Route::get('reporteCuotasVencer', [InformeController::class, 'reporteCuotasVencer'])->name('reporteCuotasVencer');
    Route::post('reporteCuotasVencerPDF', [InformeController::class, 'reporteCuotasVencerPDF'])->name('reporteCuotasVencerPDF');
    Route::get('facturapdf/{id}', [CajaController::class, 'facturapdf'])->name('facturapdf');
    Route::get('arqueo', [CajaController::class, 'arqueo'])->name('arqueo');
    Route::post('arqueo_dias', [CajaController::class, 'arqueo_dias'])->name('arqueo_dias');
    Route::post('/cliente-cuota', [App\Http\Controllers\ClienteController::class, 'detalleCuotasMora'])->name('cliente.mora');

    //Update User Details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

    Route::get('detalleCuotasInm/{id}', [InmuebleController::class, 'detalleCuotasInm'])->name('detalleCuotasInm');

    Route::get('detalleCuotas/{id}', [ClienteController::class, 'detalleCuotas'])->name('detalleCuotas');
    Route::get('pagare/{id}', [ClienteController::class, 'pagare'])->name('pagare');
    //Route::post('presuPDF', [PresupuestoController::class, 'presuPDF'])->name('presuPDF');
    Route::get('presuPDF/{id}', [PresupuestoController::class, 'presuPDF'])->name('presuPDF');

    Route::get('/facturas/validar-numero', [FacturaController::class, 'validarNumero'])
    ->name('facturas.validar');

    //Language Translation
    Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

    Route::get('cajeros/{id}', [InformeController::class, 'cajeros'])->name('cajeros');

    Route::get('clientes/{id}', [InformeController::class, 'clientes'])->name('clientes');

    Route::get('creacuotas', [CreaCuotasController::class, 'creacuotas'])->name('creacuotas');

    Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

});