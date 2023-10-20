<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class registroClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registroClienteVista(){

        return view('registroCliente.registroCliente');
    }

    public function tablaCliente()
    {
        $cliente = Cliente::get();
        return DataTables::of($cliente)
            ->addIndexColumn()
            ->addColumn('nombre', function ($row) {
                $nombreCompleto = $row->nombres . ' ' . $row->apellidoP . ' ' . $row->apellidoM;
                return '<span class="text-left text-uppercase">' . $nombreCompleto . ' </span>';
            })
            ->addColumn('nroDoc', function ($row) {
                $nroDocumento = "-";
                if ($row->dni){
                    $nroDocumento = $row->dni;
                }
                return '<span class="text-left text-uppercase">' . $nroDocumento . ' </span>';
            })
            ->addColumn('email', function ($row) {
                $email = $row->correo_electronico;
                return '<span class="text-left">' . $email . ' </span>';
            })
            ->addColumn('telefono', function ($row) {
                $telefono = "-";
                if ($row->telefono){
                    $telefono = $row->telefono;
                }
                return '<span class="text-left text-uppercase">' . $telefono . ' </span>';
            })
            ->addColumn('fechaCrea', function ($row) {
                $fechaCreacion = '-';
                $fecha = $row->fecha_creacion;
                $fechaCreacion = Carbon::parse($fecha)->format('d/m/Y');
                return '<span class="badge bg-light text-dark text-wrap text-left "> <i class="bx bx-calendar text-success"></i><strong>' . $fechaCreacion . '</strong></span></td>';
            })
            ->addColumn('options', function ($row) {
                return '<button data-toggle="tooltip" data-placement="auto" title="Editar" onclick="editarCliente(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-info">
                <i class="las la-edit"></i>
                </button>
                <button data-toggle="tooltip" data-placement="auto" title="Eliminar" onclick="eliminarCliente(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-danger ">
                <i class="las la-trash-alt"></i>
                </button>';
            })
            ->rawColumns(['nombre', 'nroDoc', 'email', 'telefono', 'fechaCrea', 'options'])
            ->toJson();
    }

    public function agregarCliente(Request $request){
        try {
            $verificarCliente = Cliente::where('dni', $request->dni)->orwhere('correo_electronico', $request->email)->first();
            if ($verificarCliente) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡El Cliente ya existe!',
                    'message' => 'El Cliente ya existe: Ingrese otro email o DNI!'
                ];
                return $return;
            }

            $cliente = new Cliente();
            $cliente->nombres = $request->nombres;
            $cliente->apellidoP = $request->apellidoP;
            $cliente->apellidoM = $request->apellidoM;
            $cliente->dni = $request->dni;
            $cliente->telefono = $request->telefono;
            $cliente->correo_electronico = $request->email;

            if (!$cliente->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($cliente->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Guaradar Cliente. </br>\n";
                }
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Obtenemos el siguiente error: ' . $msg . '<br /><strong>NO se ha realizado ningún cambio en la base de datos!</strong>'
                ];
                return $return;
            }

            $return = [
                'status' => 'ok',
                'titulo' => '¡Registro Exitoso!',
                'message' => 'Se registró correctamente el Cliente!'
            ];
            return $return;
        } catch (Exception $ex) {
            $return = [
                'status' => 'error',
                'titulo' => '¡Registro no completado!',
                'message' => $ex->getMessage()
            ];
            return $return;
        }
    }

    public function getCliente($id)
    {
        $cliente = Cliente::find($id);
        $data['cliente'] = $cliente;
        return response()->json($data);
    }

    public function editarCliente(Request $request){
        try {
            $cliente = Cliente::find($request->getClienteId);

            $cliente->nombres = $request->nombres;
            $cliente->apellidoP = $request->apellidoP;
            $cliente->apellidoM = $request->apellidoM;
            $cliente->dni = $request->dni;
            $cliente->telefono = $request->telefono;
            $cliente->correo_electronico = $request->email;

            if (!$cliente->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($cliente->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Actualizar el Cliente. </br>\n";
                }
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Obtenemos el siguiente error: ' . $msg . '<br /><strong>NO se ha realizado ningún cambio en la base de datos!</strong>'
                ];
                return $return;
            }

            $return = [
                'status' => 'ok',
                'titulo' => '¡Registro Exitoso!',
                'message' => 'Se registró correctamente el Cliente!'
            ];
            return $return;
        } catch (Exception $ex) {
            $return = [
                'status' => 'error',
                'titulo' => '¡Registro no completado!',
                'message' => $ex->getMessage()
            ];
            return $return;
        }
    }

    public function eliminarCliente(Request $request){
        try {
            $cliente = Cliente::find($request->clienteEliminarId);
            $cliente->delete();

            $return = [
                'status' => 'ok',
                'titulo' => '¡Eliminación Exitosa!',
                'message' => 'Se eliminó correctamente el Cliente!'
            ];
            return $return;
        } catch (Exception $ex) {
            $return = [
                'status' => 'error',
                'titulo' => '¡Registro no completado!',
                'message' => $ex->getMessage()
            ];
            return $return;
        }
    }
}
