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
