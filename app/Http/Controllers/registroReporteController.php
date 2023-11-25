<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Item;
use App\Models\Reporte;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class registroReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registroReporteVista(){
        $empresa = Empresa::first();
        return view('reportes.registrarReportes', compact('empresa'));
    }

    public function tablaReportes()
    {
        $reportes = Reporte::get();

        return DataTables::of($reportes)
            ->addIndexColumn()
            ->addColumn('titulo', function ($row) {
                $titulo = $row->titulo;
                return '<span class="text-left text-uppercase fw-bold">' . $titulo . ' </span>';
            })
            ->addColumn('fechaInicio', function ($row) {
                $fechaInicio = '-';
                $fecha = $row->fecha_inicio;
                $fechaInicio = Carbon::parse($fecha)->format('d/m/Y');
                return '<span class="badge bg-light text-dark text-wrap text-left "> <i class="bx bx-calendar text-success"></i><strong>' . $fechaInicio . '</strong></span></td>';
            })
            ->addColumn('fechaFin', function ($row) {
                $fechaFin = '-';
                $fecha = $row->fecha_fin;
                $fechaFin = Carbon::parse($fecha)->format('d/m/Y');
                return '<span class="badge bg-light text-dark text-wrap text-left "> <i class="bx bx-calendar text-success"></i><strong>' . $fechaFin . '</strong></span></td>';
            })
            ->addColumn('fechaCreacion', function ($row) {
                $fechaCreacion = '-';
                $fecha = $row->fecha_creacion;
                $fechaCreacion = Carbon::parse($fecha)->format('d/m/Y');
                return '<span class="badge bg-light text-dark text-wrap text-left "> <i class="bx bx-calendar text-success"></i><strong>' . $fechaCreacion . '</strong></span></td>';
            })
            ->addColumn('options', function ($row) {
                return '<a href="' . route('reportes.generarReporte', $row->id) . '" data-toggle="tooltip" data-placement="auto" title="Generar Reporte" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-primary" target="_blank">
                <i class="bx bxs-file-pdf"></i></a>
                <button data-toggle="tooltip" data-placement="auto" title="Eliminar" onclick="eliminarReporte(' . $row->id . ')" class="btn px-2 py-0 btn-lg waves-effect waves-light btn-danger ">
                <i class="las la-trash-alt"></i>
                </button>';
            })
            ->rawColumns(['titulo', 'fechaInicio', 'fechaFin', 'fechaCreacion', 'options'])
            ->toJson();
    }

    public function CrearReporte(Request $request){
        try {
            if (empty($request->fechaIni)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Complete la fecha de inicio'
                ];
                return $return;
            }
            if (empty($request->fechaFin)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Complete la fecha de Fin'
                ];
                return $return;
            }
            if (empty($request->titulo)) {
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Ingrese el titulo'
                ];
                return $return;
            }

            $reporte = new Reporte();
            $reporte->titulo = $request->titulo;
            $reporte->fecha_inicio = date_format(date_create_from_format('d/m/Y', substr($request->fechaIni, 0, 10)), 'Y-m-d');
            $reporte->fecha_fin = date_format(date_create_from_format('d/m/Y', substr($request->fechaFin, 0, 10)), 'Y-m-d');

            if (!$reporte->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($reporte->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Guardar el Reporte. </br>\n";
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
                'message' => 'Se registró correctamente el Reporte!'
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

    public function eliminarReporte(Request $request){
        try {

            $reporte = Reporte::find($request->reporteEliminarId);
            $reporte->delete();

            $return = [
                'status' => 'ok',
                'titulo' => '¡Eliminación Exitosa!',
                'message' => 'Se eliminó correctamente el Reporte!'
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

    public function generarReporte($id)
    {
        $empresa = Empresa::first();
        $reporte = Reporte::find($id);
        $ventas = [];
        if ($reporte) {
            $ventas = Venta::whereBetween('fecha_emision', [$reporte->fecha_inicio, $reporte->fecha_fin])->get();
        }
        $totalRecaudado = 0;
        foreach ($ventas as $venta) {
            $totalRecaudado += $venta->total;
        }
        $data['totalRecaudado'] = $totalRecaudado;

        $fechaInicio = Carbon::parse($reporte->fecha_inicio)->format('d/m/Y');
        $data['fechaInicio'] = $fechaInicio;
        $fechaFin = Carbon::parse($reporte->fecha_fin)->format('d/m/Y');
        $data['fechaFin'] = $fechaFin;

        // Generar el PDF
        $pdf = \PDF::loadView('reportes.reporteVenta',compact('data','empresa','reporte','ventas'));
        // Descargar o mostrar el PDF según sea necesario
        $tituloFormateado = str_replace(' ', '_', $reporte->titulo);
        $nombreArchivo = 'reporte_' . $tituloFormateado . '_' . $reporte->rporteID . '.pdf';
        return $pdf->stream($nombreArchivo);
    }

}
