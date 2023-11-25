@extends('layouts.main')
@section('title', 'Reporte Venta |')
@section('styles')
    @include('encabezados.css.datatable')
    @include('encabezados.css.sweetalert')

    <!-- icheck material -->
    <link href="{{ asset('assets/libs/icheck-material/icheck-material.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- icheck bootstrap -->
    <link href="{{ asset('assets/libs/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="las la-book text-warning"></i> REPORTES DE VENTA</h4>

            <div class="page-title-right">
                <ol class="breadcrumb my-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">SWGRVB</a>
                    </li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Registro Reportes</a>
                    </li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <div class="float-end">
            <button type="button" class="btn btn-success waves-effect " data-bs-toggle="modal" data-bs-target="#modalAgregarReporteId">
                <i class="ri-add-circle-line align-middle "></i>
                REGISTRAR REPORTE
            </button>
        </div>
    </div>
</div>

{{-- Ruta Tabla Reportes --}}
{!! Form::open(['route' => ['reportes.tablaReportes'], 'id' => 'formTablaReportes']) !!}
{!! Form::close() !!}

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="header-title">Reportes Registrados</h4>
            </div>
            <div class="card-body">
                <table id="tablaReportesId" class="table dt-responsive table-bordered table-sm table-hover align-middle">
                    <thead class="font-weight-bold bg-light">
                        <tr>
                            <th class="all align-middle text-center">#</th>
                            <th class="all align-middle text-center">Titulo</th>
                            <th class="align-middle text-center">Fecha Inicio</th>
                            <th class="align-middle text-center">Fecha Fin</th>
                            <th class="align-middle text-center">Fecha Emisión</th>
                            <th class="align-middle">Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!--  Modal Agregar Reporte -->
<div class="modal fade fadeInUp" id="modalAgregarReporteId" tabindex="-1" role="dialog" aria-labelledby="modalLabelAgregar" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {!! Form::open(['route' => ['reportes.CrearReporte'], 'id' => 'formAgregarReporteId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Crear Reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="titulo_id" class="form-label">Titulo Reporte <span class="text-danger">(*)</span></label>
                        {!! Form::text('titulo', '', ['class' => 'form-control', 'placeholder' => 'Tituloo', 'id' => 'titulo_id']) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="fecha_ini_id" class="form-label">Fecha Inicio<span class="text-danger">(*)</span></label>
                        {!! Form::text('fechaIni', '', [
                            'class' => 'form-control ',
                            'data-provider' => 'flatpickr',
                            'data-date-format' => 'd/m/Y',
                            'data-locale' => 'es',
                            'placeholder' => 'dd/mm/aaaa',
                            'id' => 'fecha_ini_id',
                            'required',
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="fecha_fin_id" class="form-label">Fecha Fin<span class="text-danger">(*)</span></label>
                        {!! Form::text('fechaFin', '', [
                            'class' => 'form-control ',
                            'data-provider' => 'flatpickr',
                            'data-date-format' => 'd/m/Y',
                            'data-locale' => 'es',
                            'placeholder' => 'dd/mm/aaaa',
                            'id' => 'fecha_fin_id',
                            'required',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-light waves-effect fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Cerrar</a>
                <button type="submit" class="btn btn-success waves-effect">Registrar</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


{{-- Eliminar Reporte --}}
{!! Form::open(['route' => ['reportes.eliminarReporte'], 'id' => 'formEliminarReporteId']) !!}
<input type="hidden" name="reporteEliminarId" id="reporteEliminarId" />
{!! Form::close() !!}


@endsection
@section('scripts')
    @include('encabezados.js.datatable')
    @include('encabezados.js.sweetalert')
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/locale/es.js') }}"></script>
    <script src="{{ asset('dist/js/registroReporte/registroReporte.js') . '?version=1' }}"></script>
@endsection
