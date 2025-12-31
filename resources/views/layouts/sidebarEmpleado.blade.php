<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.Menu')</li>

                <li>
                    <a class="waves-effect" href="{{url('cliente')}}" onclick="event.preventDefault(); document.getElementById('cliente-form').submit();">
                    <i class="bx bxs-user-detail"></i>
                    <span>Clientes</span></a>
                    <form id="cliente-form" action="{{url('cliente')}}" method="GET" style="display: none;">
                        {{csrf_field()}} 
                        </form>
                </li> 

                <!-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-cash-register"></i>
                        <span key="t-invoices">Cuenta Corriente</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a class="waves-effect"  href="{{url('cuenta_corriente')}}" onclick="event.preventDefault(); document.getElementById('cuenta_corriente-form').submit();">
                            <span>Lista de cuentas corrientes</span></a>
                            <form id="cuenta_corriente-form" action="{{url('cuenta_corriente')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                        <li>
                            <a class="waves-effect"  href="{{url('cheque')}}" onclick="event.preventDefault(); document.getElementById('cheque-form').submit();">
                            <span>Cheques recibidos</span></a>
                            <form id="cheque-form" action="{{url('cheque')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                        <li>
                            <a class="waves-effect"  href="{{url('cheque_emitido')}}" onclick="event.preventDefault(); document.getElementById('cheque_emitido-form').submit();">
                            <span>Cheques emitidos</span></a>
                            <form id="cheque_emitido-form" action="{{url('cheque_emitido')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                    </ul>
                </li> -->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-cash-register"></i>
                        <span key="t-invoices">Caja</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a class="waves-effect"  href="{{url('caja')}}" onclick="event.preventDefault(); document.getElementById('caja-form').submit();">
                            <span>Cobrar</span></a>
                            <form id="caja-form" action="{{url('caja')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                        <li>
                            <a class="waves-effect"  href="{{url('arqueo')}}" onclick="event.preventDefault(); document.getElementById('arqueo-form').submit();">
                            <span>Arqueo del día</span></a>
                            <form id="arqueo-form" action="{{url('arqueo')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="waves-effect" href="{{url('producto')}}" onclick="event.preventDefault(); document.getElementById('producto-form').submit();">
                    <i class="fas fa-blender"></i>
                    <span>Productos</span></a>
                    <form id="producto-form" action="{{url('producto')}}" method="GET" style="display: none;">
                        {{csrf_field()}} 
                        </form>
                </li> 

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="dripicons-cart"></i> 
                        <span key="t-invoices">Ventas</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a class="waves-effect"  href="{{url('factura')}}" onclick="event.preventDefault(); document.getElementById('factura-form').submit();">
                            <span>Factura Venta</span></a>
                            <form id="factura-form" action="{{url('factura')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                                </form> 
                        </li>
                        <!-- <li><a class="waves-effect"  href="{{url('comprobante')}}" onclick="event.preventDefault(); document.getElementById('comprobante-form').submit();">    
                            <span>Recibos de cobro</span></a>
                            <form id="comprobante-form" action="{{url('comprobante')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li> -->
                        <li><a class="waves-effect"  href="{{url('pago')}}" onclick="event.preventDefault(); document.getElementById('pago-form').submit();">    
                            <span>Cobros</span></a>
                            <form id="pago-form" action="{{url('pago')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                    </ul>
                     
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="fas fa-shopping-basket"></i> 
                        <span key="t-invoices">Compras</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a class="waves-effect"  href="{{url('compra')}}" onclick="event.preventDefault(); document.getElementById('compra-form').submit();">
                            <span>Factura Compra</span></a>
                            <form id="compra-form" action="{{url('compra')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                                </form> 
                        </li>
                        <li><a class="waves-effect"  href="{{url('proveedor')}}" onclick="event.preventDefault(); document.getElementById('proveedor-form').submit();">    
                            <span>Proveedores</span></a>
                            <form id="proveedor-form" action="{{url('proveedor')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                        <li><a class="waves-effect"  href="{{url('gasto')}}" onclick="event.preventDefault(); document.getElementById('gasto-form').submit();">    
                            <span>Gastos</span></a>
                            <form id="gasto-form" action="{{url('gasto')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                        <li><a class="waves-effect"  href="{{url('concepto')}}" onclick="event.preventDefault(); document.getElementById('concepto-form').submit();">    
                            <span>Conceptos para gastos</span></a>
                            <form id="concepto-form" action="{{url('concepto')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                    </ul>
                     
                </li>

                <!-- <li class="nav-item">
                    <a class="waves-effect"  href="{{url('presupuesto')}}" onclick="event.preventDefault(); document.getElementById('presupuesto-form').submit();">
                    <i class="fas fa-file-invoice-dollar"></i> 
                    <span>Presupuestos</span></a>
                    <form id="presupuesto-form" action="{{url('presupuesto')}}" method="GET" style="display: none;">
                        {{csrf_field()}} 
                        </form> 
                </li> -->

                <!-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="fas fa-file-invoice-dollar"></i> 
                        <span key="t-invoices">Empleados</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a class="waves-effect"  href="{{url('funcionario')}}" onclick="event.preventDefault(); document.getElementById('funcionario-form').submit();">
                            <span>Empleados</span></a>
                            <form id="funcionario-form" action="{{url('funcionario')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                                </form> 
                        </li>
                        <li><a class="waves-effect"  href="{{url('recibo_funcionario')}}" onclick="event.preventDefault(); document.getElementById('recibo_funcionario-form').submit();">    
                            <span>Liquidación de salarios</span></a>
                            <form id="recibo_funcionario-form" action="{{url('recibo_funcionario')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                        <li><a class="waves-effect"  href="{{url('comision')}}" onclick="event.preventDefault(); document.getElementById('comision-form').submit();">    
                            <span>Comisiones</span></a>
                            <form id="comision-form" action="{{url('comision')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                        <li><a class="waves-effect"  href="{{url('adelanto')}}" onclick="event.preventDefault(); document.getElementById('adelanto-form').submit();">    
                            <span>Adelanto de salario</span></a>
                            <form id="adelanto-form" action="{{url('adelanto')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                    </ul>
                     
                </li> -->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-file-export"></i>
                        <span key="t-invoices">Reportes</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <!-- <li><a class="waves-effect"  href="{{url('informe')}}" onclick="event.preventDefault(); document.getElementById('informe-form').submit();">
                            <span>Resumen Total</span></a>
                            <form id="informe-form" action="{{url('informe')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                                </form> 
                        </li> -->
                        <li><a class="waves-effect"  href="{{url('reporteDetalle')}}" onclick="event.preventDefault(); document.getElementById('reporteDetalle-form').submit();">    
                            <span>Reporte por Detalle</span></a>
                            <form id="reporteDetalle-form" action="{{url('reporteDetalle')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                        <!-- <li><a class="waves-effect"  href="{{url('calculoMensual')}}" onclick="event.preventDefault(); document.getElementById('calculoMensual-form').submit();">    
                            <span>Calculo mensual</span></a>
                            <form id="calculoMensual-form" action="{{url('calculoMensual')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li> -->
                        <!-- <li><a class="waves-effect"  href="{{url('controlStock')}}" onclick="event.preventDefault(); document.getElementById('controlStock-form').submit();">    
                            <span>Control de Stock</span></a>
                            <form id="controlStock-form" action="{{url('controlStock')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li> -->
                        <li><a class="waves-effect"  href="{{url('iva')}}" onclick="event.preventDefault(); document.getElementById('iva-form').submit();">
                            <span>Fecha IVA</span></a>
                            <form id="iva-form" action="{{url('iva')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                                </form> 
                        </li>
                    </ul>
                     
                </li>

                 <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-cog"></i>
                        <span key="t-invoices">Admin. de Sistema</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a class="waves-effect"  href="{{url('timbrado')}}" onclick="event.preventDefault(); document.getElementById('timbrado-form').submit();">
                            <span>Timbrado Factura</span></a>
                            <form id="timbrado-form" action="{{url('timbrado')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>
                        <li><a class="waves-effect"  href="{{url('cajero')}}" onclick="event.preventDefault(); document.getElementById('cajero-form').submit();">
                            <span>Cajero</span></a>
                            <form id="cajero-form" action="{{url('cajero')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>     
                        <li class="nav-item">
                            <a class="waves-effect" href="{{url('user')}}" onclick="event.preventDefault(); document.getElementById('user-form').submit();">
                            <span>Usuarios</span></a>
                            <form id="user-form" action="{{url('user')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                                </form> 
                        </li> 
                        
                        <li class="nav-item">
                            <a class="waves-effect" href="{{url('empresa')}}" onclick="event.preventDefault(); document.getElementById('empresa-form').submit();">
                            <span>Empresas</span></a>
                            <form id="empresa-form" action="{{url('empresa')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                                </form> 
                        </li> 

                         <li>
                            <a class="waves-effect"  href="{{url('cuenta_corriente')}}" onclick="event.preventDefault(); document.getElementById('cuenta_corriente-form').submit();">
                            <span>Lista de cuentas corrientes</span></a>
                            <form id="cuenta_corriente-form" action="{{url('cuenta_corriente')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                            </form> 
                        </li>

                        <!-- <li class="nav-item">
                            <a class="waves-effect" href="{{url('sucursal')}}" onclick="event.preventDefault(); document.getElementById('sucursal-form').submit();">
                            <span>Sucursales</span></a>
                            <form id="sucursal-form" action="{{url('sucursal')}}" method="GET" style="display: none;">
                                {{csrf_field()}} 
                                </form> 
                        </li>  -->
                                        
                    </ul>
                </li>          

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-exit"></i>
                        <span key="t-invoices">{{Auth::user()->name}}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target=".change-password">
                            <i class="bx bx-wrench font-size-16 align-middle me-1 text-danger"></i> 
                            <span key="t-settings">@lang('Cambiar contraseña')</span></a>
                        </li>

                        <li>
                            <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> 
                            <span key="t-logout">@lang('Cerrar Sesion')</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
