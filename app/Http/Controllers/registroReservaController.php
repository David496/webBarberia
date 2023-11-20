<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Reserva;
use App\Models\Users;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class registroReservaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registroReservaVista(){
        $empresa = Empresa::first();
        $clienteSelect = Cliente::all()->pluck('fullname', 'clienteID');
        $clienteSelect->prepend('[ SELECCIONE CLIENTE ]', '');

        $empleadoSelect = User::where('tipo_usuario', 'Empleado')->where('estado', 'Activo')
            ->selectRaw("concat(name,' ',apellidosP,' ',apellidosM) as name, id")
            ->pluck('name', 'id');
        $empleadoSelect->prepend('[ SELECCIONE EMPLEADO ]', '');

        $estadoReserva = [
            'PENDIENTE' => 'PENDIENTE',
            'EN CURSO' => 'EN CURSO',
            'TERMINADO' => 'TERMINADO',
            'CANCELADO' => 'CANCELADO'
        ];

        $estado = [
            '' => '[SELECCIONE ESTADO]',
            'PENDIENTE' => 'PENDIENTE',
            'EN CURSO' => 'EN CURSO',
            'TERMINADO' => 'TERMINADO',
            'CANCELADO' => 'CANCELADO'
        ];

        $data['clienteSelect'] = $clienteSelect;
        $data['empleadoSelect'] = $empleadoSelect;
        $data['estadoReserva'] = $estadoReserva;
        $data['estado'] = $estado;
        return view('gestionarReservas.getionarReservas', compact('data', 'empresa'));
    }

    public function tablaReservas()
    {
        // $reserva = Reserva::get();
        $fechaActual = Carbon::now();
        $reserva = Reserva::orderByRaw('fecha_reserva = ? desc, fecha_reserva asc', [$fechaActual])
            ->get();

        return DataTables::of($reserva)
            ->addIndexColumn()
            ->addColumn('titulo', function ($row) {
                $reserva = $row->titulo_reserva;
                return '<span class="text-left text-uppercase">' . $reserva . ' </span>';
            })
            ->addColumn('empleado', function ($row) {
                $reserva = $row->usuario->name.' '.$row->usuario->apellidosP.' '.$row->usuario->apellidosM;
                return '<span class="text-left text-uppercase">' . $reserva . ' </span>';
            })
            ->addColumn('cliente', function ($row) {
                $reserva = $row->cliente->full_name;
                return '<span class="text-left text-uppercase">' . $reserva . ' </span>';
            })
            ->addColumn('fecha', function ($row) {
                $fechaReserva = '-';
                $fecha = $row->fecha_reserva;
                $fechaReserva = Carbon::parse($fecha)->format('d/m/Y');
                return '<span class="badge bg-light text-dark text-wrap text-left "> <i class="bx bx-calendar text-success"></i><strong>' . $fechaReserva . '</strong></span></td>';
            })
            ->addColumn('hora_inicio', function ($row) {
                $horaReserva = '-';
                $hora = $row->hora_reserva;
                $horaReserva = Carbon::parse($hora)->format('h:i A');
                return '<span class="badge bg-light text-dark text-wrap text-left "><i class="bx bx-time text-success"></i><strong>' . $horaReserva . '</strong></span></td>';
            })
            ->addColumn('hora_fin', function ($row) {
                $horaReservaFin = '-';
                $hora = $row->hora_fin_reserva;
                $horaReservaFin = Carbon::parse($hora)->format('h:i A');
                return '<span class="badge bg-light text-dark text-wrap text-left "><i class="bx bx-time text-success"></i><strong>' . $horaReservaFin . '</strong></span></td>';
            })
            ->addColumn('estado', function ($row) {
                $reserva = $row->estado;
                $estadosColores = [
                    'PENDIENTE' => 'warning',
                    'EN CURSO' => 'success',
                    'TERMINADO' => 'dark',
                    'CANCELADO' => 'danger',
                ];
                $color = $estadosColores[$reserva] ?? 'light';

                return '<span class="badge bg-'.$color.'">' . $reserva . '</span>';
            })
            ->addColumn('options', function ($row) {
                return '<button data-toggle="tooltip" data-placement="auto" title="Actualizar Estado" onclick="cambioEstado(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-primary">
                <i class="las la-stream"></i>
                </button>
                <button data-toggle="tooltip" data-placement="auto" title="Editar" onclick="editarReserva(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-info">
                <i class="las la-edit"></i>
                </button>
                <button data-toggle="tooltip" data-placement="auto" title="Eliminar" onclick="eliminarReserva(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-danger ">
                <i class="las la-trash-alt"></i>
                </button>';
            })
            ->rawColumns(['titulo', 'empleado', 'cliente', 'fecha', 'hora_inicio','hora_fin','estado','options'])
            ->toJson();
    }

    public function agregarReserva(Request $request){
        try {

            $reserva = new Reserva();
            $reserva->titulo_reserva = $request->titulo;
            $reserva->descripcion = $request->descripcion;
            $reserva->fecha_reserva = date_format(date_create_from_format('d/m/Y', substr($request->fecha, 0, 10)), 'Y-m-d');
            $reserva->hora_reserva = Carbon::createFromFormat('H:i', $request->horaInicio)->toTimeString();
            $reserva->hora_fin_reserva = Carbon::createFromFormat('H:i', $request->horaFin)->toTimeString();
            $reserva->clienteID = $request->cliente;
            $reserva->userID = $request->empleado;
            $reserva->estado = 'PENDIENTE';

            if (!$reserva->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($reserva->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Guardar la reserva. </br>\n";
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
                'message' => 'Se registró correctamente la Reserva!'
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


    public function getReserva($id)
    {
        $reserva = Reserva::find($id);

        $estados = [
            ['id' => 'PENDIENTE', 'name' => 'PENDIENTE', 'color' => 'warning'],
            ['id' => 'EN CURSO', 'name' => 'EN CURSO', 'color' => 'success'],
            ['id' => 'TERMINADO', 'name' => 'TERMINADO', 'color' => 'dark'],
            ['id' => 'CANCELADO', 'name' => 'CANCELADO', 'color' => 'danger']
        ];

        $data['estados'] = $estados;
        $data['reserva'] = $reserva;
        return response()->json($data);
    }

    public function editarReserva(Request $request){
        try {
            $reserva = Reserva::find($request->getReservaId);
            $reserva->titulo_reserva = $request->titulo;
            $reserva->descripcion = $request->descripcion;
            $reserva->fecha_reserva = date_format(date_create_from_format('d/m/Y', substr($request->fecha, 0, 10)), 'Y-m-d');
            $reserva->hora_reserva = Carbon::createFromFormat('H:i', $request->horaInicio)->toTimeString();
            $reserva->hora_fin_reserva = Carbon::createFromFormat('H:i', $request->horaFin)->toTimeString();
            $reserva->clienteID = $request->cliente;
            $reserva->userID = $request->empleado;

            if (!$reserva->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($reserva->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Actualizar la reserva. </br>\n";
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
                'message' => 'Se registró correctamente la reserva!'
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

    public function eliminarReserva(Request $request){
        try {
            $reserva = Reserva::find($request->reservaEliminarId);
            $reserva->delete();

            $return = [
                'status' => 'ok',
                'titulo' => '¡Eliminación Exitosa!',
                'message' => 'Se eliminó correctamente la reserva!'
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

    public function actualizaEstado(Request $request){
        try {
            $reserva = Reserva::find($request->idReserva);
            $reserva->estado = $request->valoEstado;

            if (!$reserva->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($reserva->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Actualizar el estado. </br>\n";
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
                'message' => 'Se registró correctamente el estado!'
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
