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
            ->rawColumns(['producto', 'precio', 'descripcion', 'unidad', 'stock', 'fechaCrea', 'options'])
            ->toJson();
    }

    public function agregarProducto(Request $request){
        try {
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
