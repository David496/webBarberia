<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
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
        $empresa = Empresa::first();
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
        return view('registroUsuarios.registroUsuarios', compact('data', 'empresa'));
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
            ->addColumn('foto', function ($row) {
                if ($row->foto_archivo){
                    $nombre = $row->foto_archivo;
                    $rutaCompleta = 'images/usuarios/'.$nombre;
                    return '<img src="' . asset($rutaCompleta) . '" alt="'.$row->name.'" class="img-fluid img-thumbnail" width="60px" id="img_id">';
                } else {
                    return '<span class="badge bg-light text-dark text-wrap text-left " id="img_id"> <i class="bx bx-x-circle text-danger"></i><strong>No Registra</strong></span>';
                }
            })
            ->addColumn('fechaCrea', function ($row) {
                $fechaCancelacion = '-';
                $fecha = $row->created_at;
                $fechaCancelacion = Carbon::parse($fecha)->format('d/m/Y');
                return '<span class="badge bg-light text-dark text-wrap text-left "> <i class="bx bx-calendar text-success"></i><strong>' . $fechaCancelacion . '</strong></span></td>';
            })
            ->addColumn('options', function ($row) {
                $disabled = '';
                if ($row->id === 1) {
                    $disabled =  'disabled';
                }
                return '<button data-toggle="tooltip" data-placement="auto" title="Editar" onclick="editarUsuario(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-info">
                <i class="las la-edit"></i>
                </button>
                <button data-toggle="tooltip" data-placement="auto" title="Eliminar" onclick="eliminarUsuario(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-danger" '.$disabled.'>
                <i class="las la-trash-alt"></i>
                </button>';
            })
            ->rawColumns(['nombre', 'nroDoc', 'rol', 'email', 'fechaCrea', 'estado', 'options', 'foto'])
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

            if ($request->file('imagen') != null && $request->file('imagen')->isValid()) {
                $extension = $request->imagen->getClientOriginalExtension();
                $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
                if (in_array(strtolower($extension), $extensionesPermitidas)) {
                    // La extensión es válida, puedes continuar con el código para procesar el archivo.
                } else {
                    $return = [
                        'status' => 'error',
                        'titulo' => '¡Extensión inválida!',
                        'message' => '<strong>Solo se permiten imágenes con extensiones .jpg, .jpeg o .png</strong>'
                    ];
                    return $return;
                }
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

            if ($request->file('imagen') != null && $request->file('imagen')->isValid()) {
                $userId = $user->id;
                $extension = strtolower($request->imagen->getClientOriginalExtension());
                $imageName = 'userImg_' . $userId . '.' . $extension;
                $request->imagen->move(public_path('images/usuarios'), $imageName);
                $user->foto_archivo = $imageName;
                $user->save();
            }

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
            // Eliminar la imagen antigua si existe
            if ($usuarioEliminar->foto_archivo) {
                unlink(public_path('images/usuarios/' . $usuarioEliminar->foto_archivo));
            }
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

            if ($request->file('imagen') != null && $request->file('imagen')->isValid()) {
                $extension = $request->imagen->getClientOriginalExtension();
                $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
                if (in_array(strtolower($extension), $extensionesPermitidas)) {
                    $userId = $user->id;
                    // Eliminar la imagen antigua si existe
                    if ($user->foto_archivo) {
                        unlink(public_path('images/usuarios/' . $user->foto_archivo));
                    }
                    $extension = strtolower($request->imagen->getClientOriginalExtension());
                    $imageName = 'userImg_' . $userId . '.' . $extension;
                    $request->imagen->move(public_path('images/usuarios'), $imageName);
                    $user->foto_archivo = $imageName;
                } else {
                    $return = [
                        'status' => 'error',
                        'titulo' => '¡Extensión inválida!',
                        'message' => '<strong>Solo se permiten imágenes con extensiones .jpg, .jpeg o .png</strong>'
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
