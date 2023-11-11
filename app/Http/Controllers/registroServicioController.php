<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
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
        $empresa = Empresa::first();
        return view('gestionarServicio.gestionarServicio', compact('empresa'));
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
            ->addColumn('imagen', function ($row) {
                if ($row->servicio_imagen){
                    $nombre = $row->servicio_imagen;
                    $rutaCompleta = 'images/servicios/'.$nombre;
                    return '<img src="' . asset($rutaCompleta) . '" alt="'.$row->nombre_servicio.'" class="img-fluid img-thumbnail" width="60px" id="img_id">';
                } else {
                    return '<span class="badge bg-light text-dark text-wrap text-left " id="img_id"> <i class="bx bx-x-circle text-danger"></i><strong>No Registra</strong></span>';
                }
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
            ->rawColumns(['servicio', 'precio', 'descripcion', 'fechaCrea', 'options','imagen'])
            ->toJson();
    }

    public function agregarServicio(Request $request){
        try {

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

            if ($request->file('imagen') != null && $request->file('imagen')->isValid()) {
                $servicioId = $servicio->id;
                $extension = strtolower($request->imagen->getClientOriginalExtension());
                $imageName = 'serviceImg_' . $servicioId . '.' . $extension;
                $request->imagen->move(public_path('images/servicios'), $imageName);
                $servicio->servicio_imagen = $imageName;
                $servicio->save();
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

            if ($request->file('imagen') != null && $request->file('imagen')->isValid()) {
                $extension = $request->imagen->getClientOriginalExtension();
                $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
                if (in_array(strtolower($extension), $extensionesPermitidas)) {
                    $productId = $servicio->id;
                    // Eliminar la imagen antigua si existe
                    if ($servicio->servicio_imagen) {
                        unlink(public_path('images/servicios/' . $servicio->servicio_imagen));
                    }
                    $extension = strtolower($request->imagen->getClientOriginalExtension());
                    $imageName = 'serviceImg_' . $productId . '.' . $extension;
                    $request->imagen->move(public_path('images/servicios'), $imageName);
                    $servicio->servicio_imagen = $imageName;
                } else {
                    $return = [
                        'status' => 'error',
                        'titulo' => '¡Extensión inválida!',
                        'message' => '<strong>Solo se permiten imágenes con extensiones .jpg, .jpeg o .png</strong>'
                    ];
                    return $return;
                }
            }

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
            // Eliminar la imagen antigua si existe
            if ($servicio->servicio_imagen) {
                unlink(public_path('images/servicios/' . $servicio->servicio_imagen));
            }
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
