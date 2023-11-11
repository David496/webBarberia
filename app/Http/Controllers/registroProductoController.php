<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class registroProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registroProductoVista(){
        $empresa = Empresa::first();
        return view('gestionarProducto.gestionarProducto', compact('empresa'));
    }

    public function tablaProducto()
    {
        $producto = Producto::get();
        return DataTables::of($producto)
            ->addIndexColumn()
            ->addColumn('producto', function ($row) {
                $producto = $row->nombre_producto;
                return '<span class="text-left text-uppercase">' . $producto . ' </span>';
            })
            ->addColumn('precio', function ($row) {
                $precio = $row->precio_venta;
                return '<span class="text-left text-uppercase">' . $precio . ' </span>';
            })
            ->addColumn('descripcion', function ($row) {
                $descripcion = $row->descripcion;
                return '<span class="badge badge-outline-primary text-wrap" style="width: 20rem;"><strong>' . $descripcion . ' </strong></span>';
            })
            ->addColumn('unidad', function ($row) {
                $unidad = $row->unidad;
                return '<span class="text-left text-uppercase">' . $unidad . ' </span>';
            })
            ->addColumn('stock', function ($row) {
                $stock = $row->stock;
                return '<span class="text-left text-uppercase">' . $stock . ' </span>';
            })
            ->addColumn('imagen', function ($row) {
                if ($row->producto_imagen){
                    $nombre = $row->producto_imagen;
                    $rutaCompleta = 'images/productos/'.$nombre;
                    return '<img src="' . asset($rutaCompleta) . '" alt="'.$row->nombre_producto.'" class="img-fluid img-thumbnail" width="60px" id="img_id">';
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
                return '<button data-toggle="tooltip" data-placement="auto" title="Editar" onclick="editarProducto(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-info">
                <i class="las la-edit"></i>
                </button>
                <button data-toggle="tooltip" data-placement="auto" title="Eliminar" onclick="eliminarProducto(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-danger ">
                <i class="las la-trash-alt"></i>
                </button>';
            })
            ->rawColumns(['producto', 'precio', 'descripcion', 'unidad', 'stock', 'fechaCrea', 'options','imagen'])
            ->toJson();
    }

    public function agregarProducto(Request $request){
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

            $producto = new Producto();
            $producto->nombre_producto = $request->nombreProducto;
            $producto->descripcion = $request->descripcion;
            $producto->precio_venta = $request->precio;
            $producto->unidad = $request->unidad;
            $producto->stock = $request->stock;

            if (!$producto->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($producto->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Guaradar producto. </br>\n";
                }
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Obtenemos el siguiente error: ' . $msg . '<br /><strong>NO se ha realizado ningún cambio en la base de datos!</strong>'
                ];
                return $return;
            }

            if ($request->file('imagen') != null && $request->file('imagen')->isValid()) {
                $productId = $producto->id;
                $extension = strtolower($request->imagen->getClientOriginalExtension());
                $imageName = 'productImg_' . $productId . '.' . $extension;
                $request->imagen->move(public_path('images/productos'), $imageName);
                $producto->producto_imagen = $imageName;
                $producto->save();
            }


            $return = [
                'status' => 'ok',
                'titulo' => '¡Registro Exitoso!',
                'message' => 'Se registró correctamente el producto!'
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

    public function getProducto($id)
    {
        $producto = Producto::find($id);
        $data['producto'] = $producto;
        return response()->json($data);
    }

    public function editarProducto(Request $request){
        try {
            $producto = Producto::find($request->getProductoId);

            if ($request->file('imagen') != null && $request->file('imagen')->isValid()) {
                $extension = $request->imagen->getClientOriginalExtension();
                $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
                if (in_array(strtolower($extension), $extensionesPermitidas)) {
                    $productId = $producto->id;
                    // Eliminar la imagen antigua si existe
                    if ($producto->producto_imagen) {
                        unlink(public_path('images/productos/' . $producto->producto_imagen));
                    }
                    $extension = strtolower($request->imagen->getClientOriginalExtension());
                    $imageName = 'productImg_' . $productId . '.' . $extension;
                    $request->imagen->move(public_path('images/productos'), $imageName);
                    $producto->producto_imagen = $imageName;
                } else {
                    $return = [
                        'status' => 'error',
                        'titulo' => '¡Extensión inválida!',
                        'message' => '<strong>Solo se permiten imágenes con extensiones .jpg, .jpeg o .png</strong>'
                    ];
                    return $return;
                }
            }

            $producto->nombre_producto = $request->nombreProducto;
            $producto->descripcion = $request->descripcion;
            $producto->precio_venta = $request->precio;
            $producto->unidad = $request->unidad;
            $producto->stock = $request->stock;

            if (!$producto->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($producto->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Actualizar el producto. </br>\n";
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
                'message' => 'Se registró correctamente el producto!'
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

    public function eliminarProducto(Request $request){
        try {
            $producto = Producto::find($request->productoEliminarId);
            // Eliminar la imagen antigua si existe
            if ($producto->producto_imagen) {
                unlink(public_path('images/productos/' . $producto->producto_imagen));
            }
            $producto->delete();

            $return = [
                'status' => 'ok',
                'titulo' => '¡Eliminación Exitosa!',
                'message' => 'Se eliminó correctamente el producto!'
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
