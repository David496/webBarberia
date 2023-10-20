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
