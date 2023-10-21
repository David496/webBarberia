<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class registroServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registroServicioVista(){

        return view('gestionarServicio.gestionarServicio');
    }

    public function tablaServicio()
    {
        $servicio = Servicio::get();
        return DataTables::of($servicio)
            ->addIndexColumn()
            ->addColumn('servicio', function ($row) {
                $servicio = $row->nombre_servicio;
                return '<span class="text-left text-uppercase">' . $servicio . ' </span>';
            })
            ->addColumn('precio', function ($row) {
                $precio = $row->precio_venta;
                return '<span class="text-left text-uppercase">' . $precio . ' </span>';
            })
            ->addColumn('descripcion', function ($row) {
                $descripcion = $row->descripcion;
                return '<span class="badge badge-outline-primary text-wrap" style="width: 20rem;"><strong>' . $descripcion . ' </strong></span>';
            })
            ->addColumn('fechaCrea', function ($row) {
                $fechaCreacion = '-';
                $fecha = $row->fecha_creacion;
                $fechaCreacion = Carbon::parse($fecha)->format('d/m/Y');
                return '<span class="badge bg-light text-dark text-wrap text-left "> <i class="bx bx-calendar text-success"></i><strong>' . $fechaCreacion . '</strong></span></td>';
            })
            ->addColumn('options', function ($row) {
                return '<button data-toggle="tooltip" data-placement="auto" title="Editar" onclick="editarServicio(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-info">
                <i class="las la-edit"></i>
                </button>
                <button data-toggle="tooltip" data-placement="auto" title="Eliminar" onclick="eliminarServicio(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-danger ">
                <i class="las la-trash-alt"></i>
                </button>';
            })
            ->rawColumns(['servicio', 'precio', 'descripcion', 'fechaCrea', 'options'])
            ->toJson();
    }

    public function agregarServicio(Request $request){
        try {
            $servicio = new Servicio();
            $servicio->nombre_servicio = $request->nombreServicio;
            $servicio->descripcion = $request->descripcion;
            $servicio->precio_venta = $request->precio;

            if (!$servicio->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($servicio->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Guaradar servicio. </br>\n";
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
                'message' => 'Se registró correctamente el servicio!'
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

    public function getServicio($id)
    {
        $servicio = Servicio::find($id);
        $data['servicio'] = $servicio;
        return response()->json($data);
    }

    public function editarServicio(Request $request){
        try {
            $servicio = Servicio::find($request->getServicioId);
            $servicio->nombre_servicio = $request->nombreServicio;
            $servicio->descripcion = $request->descripcion;
            $servicio->precio_venta = $request->precio;

            if (!$servicio->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($servicio->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Actualizar el servicio. </br>\n";
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
                'message' => 'Se registró correctamente el servicio!'
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

    public function eliminarServicio(Request $request){
        try {
            $servicio = Servicio::find($request->servicioEliminarId);
            $servicio->delete();

            $return = [
                'status' => 'ok',
                'titulo' => '¡Eliminación Exitosa!',
                'message' => 'Se eliminó correctamente el servicio!'
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
