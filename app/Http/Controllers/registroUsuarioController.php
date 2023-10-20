<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class registroUsuarioController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registroUsuarioVista(){
        $tipoUsuario = [
            '' => '[Seleccione tipo]',
            'Administrador' => 'Administrador',
            'Empleado' => 'Empleado'
        ];

        $estado = [
            '' => '[Seleccione estado]',
            'Activo' => 'Activo',
            'Inactivo' => 'Inactivo'
        ];

        $data['tipoUsuario'] = $tipoUsuario;
        $data['estado'] = $estado;
        return view('registroUsuarios.registroUsuarios', compact('data'));
    }

    public function tablaUsuario()
    {
        $users = User::get();
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('nombre', function ($row) {
                $nombreCompleto = $row->name . ' ' . $row->apellidosP . ' ' . $row->apellidosM;
                return '<span class="text-left text-uppercase">' . $nombreCompleto . ' </span>';
            })
            ->addColumn('nroDoc', function ($row) {
                $nroDocumento = "-";
                if ($row->dni){
                    $nroDocumento = $row->dni;
                }
                return '<span class="text-left text-uppercase">' . $nroDocumento . ' </span>';
            })
            ->addColumn('rol', function ($row) {
                $rol = $row->tipo_usuario;
                return '<span class="text-left text-uppercase">' . $rol . ' </span>';
            })
            ->addColumn('email', function ($row) {
                $email = $row->email;
                return '<span class="text-left">' . $email . ' </span>';
            })
            ->addColumn('estado', function ($row) {
                $estado = "-";
                if ($row->estado){
                    $estado = $row->estado;
                }

                if ($estado == "Activo") {
                    return '<span class="badge text-uppercase badge-outline-success">' . $estado . ' </span>';
                } elseif ($estado == "Inactivo") {
                    return '<span class="badge text-uppercase badge-outline-danger">' . $estado . ' </span>';
                } else {
                    return '<span class="text-left text-uppercase">' . $estado . ' </span>';
                }
            })
            ->addColumn('fechaCrea', function ($row) {
                $fechaCancelacion = '-';
                $fecha = $row->created_at;
                $fechaCancelacion = Carbon::parse($fecha)->format('d/m/Y');
                return '<span class="badge bg-light text-dark text-wrap text-left "> <i class="bx bx-calendar text-success"></i><strong>' . $fechaCancelacion . '</strong></span></td>';
            })
            ->addColumn('options', function ($row) {
                return '<button data-toggle="tooltip" data-placement="auto" title="Editar" onclick="editarUsuario(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-info">
                <i class="las la-edit"></i>
                </button>
                <button data-toggle="tooltip" data-placement="auto" title="Eliminar" onclick="eliminarUsuario(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-danger ">
                <i class="las la-trash-alt"></i>
                </button>';
            })
            ->rawColumns(['nombre', 'nroDoc', 'rol', 'email', 'fechaCrea', 'estado', 'options'])
            ->toJson();
    }

    public function agregarUsuario(Request $request){
        try {

            $verificarUsuario = User::where('dni', $request->dni)->orwhere('email', $request->email)->first();
            if ($verificarUsuario) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡El Usuario ya existe!',
                    'message' => 'El Usuario ya existe: Ingrese otro email o DNI!'
                ];
                return $return;
            }

            if (empty($request->password)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'No se están enviando campos obligatorios: Contraseña'
                ];
                return $return;
            }

            if ($request->password != $request->password_rep) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'No se están enviando campos obligatorios: Las contraseñas no coinciden'
                ];
                return $return;
            }

            $user = new User();
            $user->name = $request->name;
            $user->apellidosP = $request->apellidoP;
            $user->apellidosM = $request->apellidoM;
            $user->dni = $request->dni;
            $user->email = $request->email;
            $user->telefono = $request->telefono;
            $user->fecha_nacimiento = date_format(date_create_from_format('d/m/Y', substr($request->fechaNacimiento, 0, 10)), 'Y-m-d');

            $user->tipo_usuario = $request->tipoUser;
            $user->estado = $request->estado;
            $user->password = Hash::make($request->password);
            $user->save();

            $return = [
                'status' => 'ok',
                'titulo' => '¡Registro Exitoso!',
                'message' => 'Se registró correctamente el usuario!'
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


    public function eliminarUsuario(Request $request){
        try {
            $usuarioEliminar = User::find($request->usuarioEliminarId);
            $usuarioEliminar->delete();

            $return = [
                'status' => 'ok',
                'titulo' => '¡Eliminación Exitosa!',
                'message' => 'Se eliminó correctamente el usuario!'
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

    public function getUsuario($id)
    {
        $usuario = User::find($id);
        $data['usuario'] = $usuario;
        return response()->json($data);
    }

    public function editarUsuario(Request $request) {
        try {
            $user = User::find($request->getUsuarioId);

            if (($request->checkPass) == true) {
                if (empty($request->password)) {
                    $return = [
                        'status' => 'error',
                        'titulo' => '¡Registro no completado!',
                        'message' => 'No se están enviando campos obligatorios: Contraseña'
                    ];
                    return $return;
                }

                if ($request->password != $request->password_rep) {
                    $return = [
                        'status' => 'error',
                        'titulo' => '¡Registro no completado!',
                        'message' => 'No se están enviando campos obligatorios: Las contraseñas no coinciden'
                    ];
                    return $return;
                }
            }

            $user->name = $request->name;
            $user->apellidosP = $request->apellidoP;
            $user->apellidosM = $request->apellidoM;
            $user->dni = $request->dni;
            $user->email = $request->email;
            $user->telefono = $request->telefono;
            $user->fecha_nacimiento = date_format(date_create_from_format('d/m/Y', substr($request->fechaNacimiento, 0, 10)), 'Y-m-d');
            $user->tipo_usuario = $request->tipoUser;
            $user->estado = $request->estado;

            if (($request->checkPass) == true) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            $return = [
                'status' => 'ok',
                'titulo' => '¡Registro Exitoso!',
                'message' => 'Se registró correctamente el usuario!'
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
