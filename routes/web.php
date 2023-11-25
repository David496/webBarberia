<?php

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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// REGISTRO DE USUARIOS
Route::get('/registroUsuarios/usuarios', 'registroUsuarioController@registroUsuarioVista')->name('registroUsuarios');
Route::get('/registroUsuarios/tablaUser', 'registroUsuarioController@tablaUsuario')->name('registroUsuarios.tablaUser');
Route::post('/registroUsuarios/agregarUsuario', 'registroUsuarioController@agregarUsuario')->name('registroUsuarios.agregarUsuario');
Route::get('/registroUsuarios/getUsuario/{id}', 'registroUsuarioController@getUsuario')->name('registroUsuarios.getUsuario');
Route::post('/registroUsuarios/editarUsuario', 'registroUsuarioController@editarUsuario')->name('registroUsuarios.editarUsuario');
Route::post('/registroUsuarios/eliminarUsuario', 'registroUsuarioController@eliminarUsuario')->name('registroUsuarios.eliminarUsuario');
Route::post('/registroUsuarios/actualizarEstadoUsuario', 'registroUsuarioController@actualizarEstadoUsuario')->name('registroUsuarios.actualizarEstadoUsuario');

//GESTIONAR EMPRESA
Route::get('/ConfigurarEmpresa', 'configurarEmpresaController@configurarEmpresaVista')->name('configuracionEmpresa.configurarEmpresaVista');
Route::post('/ConfigurarEmpresa/get_provincias', 'configurarEmpresaController@get_provincias')->name('configuracionEmpresa.get_provincias');
Route::post('/ConfigurarEmpresa/get_distritos', 'configurarEmpresaController@get_distritos')->name('configuracionEmpresa.get_distritos');
Route::post('/ConfigurarEmpresa/actualizarEmpresa', 'configurarEmpresaController@actualizarEmpresa')->name('configuracionEmpresa.actualizarEmpresa');

//GESTIONAR CLIENTES
Route::get('/registroClientes/clientes', 'registroClienteController@registroClienteVista')->name('registroClientes');
Route::get('/registroClientes/tablaCliente', 'registroClienteController@tablaCliente')->name('registroClientes.tablaCliente');
Route::post('/registroClientes/agregarCliente', 'registroClienteController@agregarCliente')->name('registroClientes.agregarCliente');
Route::get('/registroClientes/getCliente/{id}', 'registroClienteController@getCliente')->name('registroClientes.getCliente');
Route::post('/registroClientes/editarCliente', 'registroClienteController@editarCliente')->name('registroClientes.editarCliente');
Route::post('/registroClientes/eliminarCliente', 'registroClienteController@eliminarCliente')->name('registroClientes.eliminarCliente');

//GESTIONAR SERVICIOS
Route::get('/registroServicios/productoServicios/servicios', 'registroServicioController@registroServicioVista')->name('servicios.registroServicioVista');
Route::get('/registroServicios/productoServicios/tablaServicio', 'registroServicioController@tablaServicio')->name('servicios.tablaServicio');
Route::post('/registroServicios/productoServicios/agregarServicio', 'registroServicioController@agregarServicio')->name('servicios.agregarServicio');
Route::get('/registroServicios/productoServicios/getServicio/{id}', 'registroServicioController@getServicio')->name('servicios.getServicio');
Route::post('/registroServicios/productoServicios/editarServicio', 'registroServicioController@editarServicio')->name('servicios.editarServicio');
Route::post('/registroServicios/productoServicios/eliminarServicio', 'registroServicioController@eliminarServicio')->name('servicios.eliminarServicio');

//GESTIONAR PRODUCTOS
Route::get('/registroProductos/productoServicios/productos', 'registroProductoController@registroProductoVista')->name('productos.registroProductoVista');
Route::get('/registroProductos/productoServicios/tablaProducto', 'registroProductoController@tablaProducto')->name('productos.tablaProducto');
Route::post('/registroProductos/productoServicios/agregarProducto', 'registroProductoController@agregarProducto')->name('productos.agregarProducto');
Route::get('/registroProductos/productoServicios/getProducto/{id}', 'registroProductoController@getProducto')->name('productos.getProducto');
Route::post('/registroProductos/productoServicios/editarProducto', 'registroProductoController@editarProducto')->name('productos.editarProducto');
Route::post('/registroProductos/productoServicios/eliminarProducto', 'registroProductoController@eliminarProducto')->name('productos.eliminarProducto');
Route::post('/registroProductos/productoServicios/aumentarStock', 'registroProductoController@aumentarStock')->name('productos.aumentarStock');

//GESTIONAR RESERVAS
Route::get('/registroReservas/reservas', 'registroReservaController@registroReservaVista')->name('reservas.registroReservaVista');
Route::get('/registroReservas/tablaProducto', 'registroReservaController@tablaReservas')->name('reservas.tablaReservas');
Route::post('/registroReservas/agregarReserva', 'registroReservaController@agregarReserva')->name('reservas.agregarReserva');
Route::get('/registroReservas/getReserva/{id}', 'registroReservaController@getReserva')->name('reservas.getReserva');
Route::post('/registroReservas/editarReserva', 'registroReservaController@editarReserva')->name('reservas.editarReserva');
Route::post('/registroReservas/eliminarReserva', 'registroReservaController@eliminarReserva')->name('reservas.eliminarReserva');
Route::post('/registroReservas/actualizaEstado', 'registroReservaController@actualizaEstado')->name('reservas.actualizaEstado');

//GESTIONAR VENTAS
Route::get('/registroVentas/ventas', 'registroVentaController@registroventaVista')->name('ventas.registroVentaVista');
Route::get('/registroVentas/tablaVentas', 'registroVentaController@tablaVentas')->name('ventas.tablaVentas');
Route::get('/registroVentas/generarComprobante/{id}', 'registroVentaController@generarComprobante')->name('ventas.generarComprobante');
Route::post('/registroVentas/eliminarVenta', 'registroVentaController@eliminarVenta')->name('ventas.eliminarVenta');


/*crear venta*/
Route::get('/registroVentas/CrearVenta', 'registroVentaController@CrearVentaVista')->name('ventas.CrearVenta');
Route::get('/registroVentas/CrearVenta/getProducto/{id}', 'registroVentaController@getProducto')->name('reservas.CrearVenta.getProducto');
Route::get('/registroVentas/CrearVenta/getServicio/{id}', 'registroVentaController@getServicio')->name('reservas.CrearVenta.getServicio');
Route::post('/registroVentas/CrearVenta/guardarProducto', 'registroVentaController@guardarProducto')->name('reservas.CrearVenta.guardarProducto');
Route::post('/registroVentas/CrearVenta/guardarServicio', 'registroVentaController@guardarServicio')->name('reservas.CrearVenta.guardarServicio');
Route::get('/registroVentas/CrearVenta/tablaItems', 'registroVentaController@tablaItems')->name('reservas.CrearVenta.tablaItems');
Route::get('/registroVentas/CrearVenta/getTotalItems/{id}', 'registroVentaController@getTotalItems')->name('reservas.CrearVenta.getTotalItems');
Route::post('/registroVentas/CrearVenta/eliminarItem', 'registroVentaController@eliminarItem')->name('reservas.CrearVenta.eliminarItem');
Route::post('/registroVentas/CrearVenta/registrarVenta', 'registroVentaController@registrarVenta')->name('reservas.CrearVenta.registrarVenta');


//REPORTES DE VENTA
Route::get('/registroReportes/reportes', 'registroReporteController@registroReporteVista')->name('reportes.registroReporteVista');
Route::get('/registroReportes/tablaReportes', 'registroReporteController@tablaReportes')->name('reportes.tablaReportes');
Route::post('/registroReportes/CrearReporte', 'registroReporteController@CrearReporte')->name('reportes.CrearReporte');
Route::post('/registroReportes/eliminarReporte', 'registroReporteController@eliminarReporte')->name('reportes.eliminarReporte');
Route::get('/registroReportes/generarReporte/{id}', 'registroReporteController@generarReporte')->name('reportes.generarReporte');



