<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Item;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class registroVentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registroVentaVista(){
        $empresa = Empresa::first();
        return view('gestionarVenta.gestionarVenta', compact('empresa'));
    }

    public function tablaVentas()
    {
        $venta = Venta::get();

        return DataTables::of($venta)
            ->addIndexColumn()
            ->addColumn('nroVenta', function ($row) {
                $nroVenta = $row->id;
                return '<span class="text-left text-uppercase fw-bold">' . $nroVenta . ' </span>';
            })
            ->addColumn('cliente', function ($row) {
                $cliente = $row->cliente->full_name;
                return '<span class="text-left text-uppercase fw-bold">' . $cliente . ' </span>';
            })
            ->addColumn('nroDoc', function ($row) {
                $doc = $row->cliente->dni;
                return '<span class="badge bg-primary">' . $doc . ' </span>';
            })
            ->addColumn('fechaEmision', function ($row) {
                $fechaEmision = '-';
                $fecha = $row->fecha_emision;
                $fechaEmision = Carbon::parse($fecha)->format('d/m/Y');
                return '<span class="badge bg-light text-dark text-wrap text-left "> <i class="bx bx-calendar text-success"></i><strong>' . $fechaEmision . '</strong></span></td>';
            })
            ->addColumn('montoTotal', function ($row) {
                $total = $row->total ?? '-';
                return '<span class="text-left text-uppercase fw-bold">' . $total . ' </span>';
            })
            ->addColumn('nroBoleta', function ($row) {
                $nroBoleta = $row->nro_boleta ?? '-';
                return '<span class="text-left text-uppercase">' . $nroBoleta . ' </span>';
            })
            ->addColumn('options', function ($row) {
                return '<a href="' . route('ventas.generarComprobante', $row->id) . '" data-toggle="tooltip" data-placement="auto" title="Generar Comprobante" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-primary" target="_blank">
                <i class="bx bxs-file-pdf"></i></a>
                <button data-toggle="tooltip" data-placement="auto" style="display:none" title="Editar" onclick="editarVenta(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-info">
                <i class="las la-edit"></i>
                </button>
                <button data-toggle="tooltip" data-placement="auto" title="Eliminar" onclick="eliminarVenta(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-danger ">
                <i class="las la-trash-alt"></i>
                </button>';
            })
            ->rawColumns(['nroVenta', 'cliente', 'nroDoc', 'fechaEmision', 'montoTotal','nroBoleta','options'])
            ->toJson();
    }

    public function generarComprobante($id)
    {
        $empresa = Empresa::first();
        $venta = Venta::find($id);
        $items = Item::where('ventaID', $id)->get();

        $fechaEmision = Carbon::parse($venta->fecha_emision)->format('d/m/Y');
        $data['fechaEmision'] = $fechaEmision;

        $nroComprobante = $venta->ventaID;
        $data['nroComprobante'] = $nroComprobante;
        $nameEmpresa = $empresa->razon_social;
        $data['nameEmpresa'] = $nameEmpresa;
        $direccionEmpresa = $empresa->direccion;
        $data['direccionEmpresa'] = $direccionEmpresa;

        // Generar el PDF
        $pdf = \PDF::loadView('gestionarVenta.comprobanteVenta',compact('data','empresa','venta','items'));
        // Descargar o mostrar el PDF según sea necesario
        return $pdf->stream('comprobante_'.$venta->ventaID.'_'.$venta->clienteID.'_'.$venta->nro_boleta.'.pdf');
    }

    public function eliminarVenta(Request $request){
        try {
            $venta = Venta::find($request->ventaEliminarId);
            $items = Item::where('ventaID',$venta->id)->get();
            foreach ($items as $item) {
                if ($item->tipo_item == 'PRODUCTO') {
                    $producto = Producto::find($item->productoID);
                    $producto->stock += $item->cantidad;
                    $producto->save();
                }
                $item->delete();
            }
            $venta->delete();

            $return = [
                'status' => 'ok',
                'titulo' => '¡Eliminación Exitosa!',
                'message' => 'Se eliminó correctamente la Venta!'
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

    // crear venta
    public function CrearVentaVista(){
        $empresa = Empresa::first();

        $clienteSelect = Cliente::all()->pluck('fullname', 'clienteID');
        $clienteSelect->prepend('[ SELECCIONE CLIENTE ]', '');
        $data['clienteSelect'] = $clienteSelect;

        $productoSelect = Producto::selectRaw("concat(nombre_producto,'- Precio:',precio_venta,' soles') as product, productoID")
            ->pluck('product', 'productoID');
        $productoSelect->prepend('[ SELECCIONE PRODUCTO ]', '');
        $data['productoSelect'] = $productoSelect;

        $servicioSelect = Servicio::selectRaw("concat(nombre_servicio,'- Precio:',precio_venta,' soles') as service, servicioID")
            ->pluck('service', 'servicioID');
        $servicioSelect->prepend('[ SELECCIONE SERVICIO ]', '');
        $data['servicioSelect'] = $servicioSelect;

        return view('gestionarVenta.CrearVenta', compact('empresa','data'));
    }

    public function getProducto($id){
        $producto = Producto::find($id);
        $data['producto'] = $producto;
        return response()->json($data);
    }

    public function getServicio($id)
    {
        $servicio = Servicio::find($id);
        $data['servicio'] = $servicio;
        return response()->json($data);
    }


    public function guardarProducto(Request $request){
        try {
            if (empty($request->productoSelect)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Seleccione un producto'
                ];
                return $return;
            }
            $busquedaItem = Item::where('flag_venta_progreso', 0)->where('productoID',$request->productoSelect)->first();
            if ($busquedaItem) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Ya registró este producto en el detalle de la venta'
                ];
                return $return;
            }
            if (empty($request->precioProducto)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Ingrese el precio del producto'
                ];
                return $return;
            }
            if (empty($request->cantidadProducto)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Ingrese la cantidad del producto'
                ];
                return $return;
            }

            $producto = Producto::find($request->productoSelect);

            if ($request->cantidadProducto > $producto->stock) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Stock insuficiente del producto'
                ];
                return $return;
            }

            $producto->stock -= $request->cantidadProducto;
            $producto->save();

            $itemProducto = new Item();
            $itemProducto->productoID = $request->productoSelect;
            $itemProducto->ventaID = 0;
            $itemProducto->tipo_item = 'PRODUCTO';
            $itemProducto->cantidad = $request->cantidadProducto;
            $itemProducto->precio = $request->precioProducto;
            $itemProducto->total = $request->cantidadProducto * $request->precioProducto;
            $itemProducto->flag_venta_progreso = 0;

            if (!$itemProducto->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($itemProducto->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Guardar el item. </br>\n";
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
                'message' => 'Se registró correctamente el item!'
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

    public function guardarServicio(Request $request){
        try {
            if (empty($request->servicioSelect)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Seleccione un Servicio'
                ];
                return $return;
            }
            $busquedaItem = Item::where('flag_venta_progreso', 0)->where('servicioID',$request->servicioSelect)->first();
            if ($busquedaItem) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Ya registró este Servicio en el detalle de la venta'
                ];
                return $return;
            }
            if (empty($request->precioServicio)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Ingrese el precio del Servicio'
                ];
                return $return;
            }
            if (empty($request->cantidadServicio)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Ingrese la cantidad del Servicio'
                ];
                return $return;
            }

            $itemServicio= new Item();
            $itemServicio->servicioID = $request->servicioSelect;
            $itemServicio->ventaID = 0;
            $itemServicio->tipo_item = 'SERVICIO';
            $itemServicio->cantidad = $request->cantidadServicio;
            $itemServicio->precio = $request->precioServicio;
            $itemServicio->total = $request->cantidadServicio * $request->precioServicio;
            $itemServicio->flag_venta_progreso = 0;

            if (!$itemServicio->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($itemServicio->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Guardar el item. </br>\n";
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
                'message' => 'Se registró correctamente el item!'
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

    public function tablaItems()
    {
        $items = Item::where('flag_venta_progreso', 0)->get();

        return DataTables::of($items)
            ->addIndexColumn()
            ->addColumn('nombre', function ($row) {
                if ($row->tipo_item == 'PRODUCTO') {
                    $nombre = $row->producto->nombre_producto;
                } else {
                    $nombre = $row->servicio->nombre_servicio;
                }
                return '<span class="text-left text-uppercase">' . $nombre . ' </span>';
            })
            ->addColumn('tipo', function ($row) {
                $tipo = $row->tipo_item;
                if ($row->tipo_item == 'PRODUCTO') {
                    return '<span class="badge bg-primary">' . $tipo . ' </span>';
                } else {
                    return '<span class="badge bg-secondary">' . $tipo . ' </span>';
                }
            })
            ->addColumn('cantidad', function ($row) {
                $cantidad = $row->cantidad;
                return '<span class="text-left text-uppercase">' . $cantidad . ' </span>';
            })
            ->addColumn('precio', function ($row) {
                $precio = $row->precio;
                return '<span class="text-left text-uppercase">' . $precio . ' </span>';
            })
            ->addColumn('total', function ($row) {
                $total = $row->total;
                return '<span class="text-left text-uppercase">' . $total . ' </span>';
            })
            ->addColumn('options', function ($row) {
                return '<button data-toggle="tooltip" data-placement="auto" title="Eliminar" onclick="eliminarItem(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-danger ">
                <i class="las la-trash-alt"></i>
                </button>';
            })
            ->rawColumns(['nombre', 'tipo', 'cantidad', 'precio', 'total','options'])
            ->toJson();
    }

    public function getTotalItems($id)
    {
        $items = Item::where('flag_venta_progreso', $id)->where('ventaID', 0)->get();
        $totalPagar=0;
        if ($items->isEmpty()) {
            $data['totalPagar'] = $totalPagar;
        } else {
            foreach ($items as $item) {
                $totalPagar += $item->total;
            }
            $data['totalPagar'] = $totalPagar;
        }
        return response()->json($data);
    }

    public function eliminarItem(Request $request){
        try {

            $item = Item::find($request->itemEliminarId);

            if ($item->tipo_item == 'PRODUCTO') {
                $producto = Producto::find($item->productoID);
                $producto->stock += $item->cantidad;
                $producto->save();
            }

            $item->delete();

            $return = [
                'status' => 'ok',
                'titulo' => '¡Eliminación Exitosa!',
                'message' => 'Se eliminó correctamente el item!'
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

    public function registrarVenta(Request $request){
        try {
            if (empty($request->clienteSelect)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Seleccione un Cliente'
                ];
                return $return;
            }
            if (empty($request->fechaEmision)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Complete la fecha de emision'
                ];
                return $return;
            }
            if (empty($request->nroBoleta)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'complete el numero de la boleta'
                ];
                return $return;
            }

            $empresa = Empresa::first();

            $venta = new Venta();
            $venta->fecha_emision = date_format(date_create_from_format('d/m/Y', substr($request->fechaEmision, 0, 10)), 'Y-m-d');
            $venta->nro_boleta = $request->nroBoleta;
            $venta->clienteID = $request->clienteSelect;
            $venta->empresaID = $empresa->id;

            $totalPagar = Item::where('flag_venta_progreso', 0)->where('ventaID', 0)->sum('total');
            $venta->total = $totalPagar;
            $venta->save();

            if (!$venta->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($venta->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Guardar la Venta. </br>\n";
                }
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Obtenemos el siguiente error: ' . $msg . '<br /><strong>NO se ha realizado ningún cambio en la base de datos!</strong>'
                ];
                return $return;
            }

            $items = Item::where('flag_venta_progreso', 0)->where('ventaID', 0)->get();
            foreach ($items as $item) {
                $item->ventaID = $venta->id;
                $item->flag_venta_progreso = 1;
                $item->save();
            }

            $return = [
                'status' => 'ok',
                'titulo' => '¡Registro Exitoso!',
                'message' => 'Se registró correctamente la venta!'
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
