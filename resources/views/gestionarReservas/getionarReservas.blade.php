@extends('layouts.main')
@section('title', 'Reservas |')
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
            <h4 class="mb-sm-0"><i class="las la-book text-warning"></i> REGISTRO DE RESERVAS</h4>

            <div class="page-title-right">
                <ol class="breadcrumb my-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">SWGRVB</a>
                    </li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Registro Reservas</a>
                    </li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <div class="float-end">
            <button type="button" class="btn btn-success waves-effect " data-bs-toggle="modal" data-bs-target="#modalAgregarReservaId">
                <i class="ri-add-circle-line align-middle "></i>
                REGISTRAR RESERVA
            </button>
        </div>
    </div>
</div>

{{-- Ruta Tabla Reservas --}}
{!! Form::open(['route' => ['reservas.tablaReservas'], 'id' => 'formTablaReservas']) !!}
{!! Form::close() !!}

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="header-title">Reservas Registradas</h4>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-3 mb-2">
                        <span class="h6 text-dark mb-1">Seleccionar Estado</span>
                        {!! Form::select('filterEstado', $data['estado'], null, ['class' => 'selectFilter', 'style' => 'width:100%', 'id' => 'filterEstadoId']) !!}
                    </div>
                </div>
                <table id="tablaReservaId" class="table dt-responsive table-bordered table-sm table-hover align-middle">
                    <thead class="font-weight-bold bg-light">
                        <tr>
                            <th class="all align-middle text-center">#</th>
                            <th class="all align-middle text-center">Titulo Reserva</th>
                            <th class="align-middle text-center">Empleado</th>
                            <th class="align-middle text-center">Cliente</th>
                            <th class="align-middle text-center">Fecha Reserva</th>
                            <th class="align-middle text-center">Hora Inicio</th>
                            <th class="align-middle text-center">Hora Fin</th>
                            <th class="align-middle text-center">Estado</th>
                            <th class="align-middle">Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!--  Modal Agregar Reserva -->
<div class="modal fade fadeInUp" id="modalAgregarReservaId" tabindex="-1" role="dialog" aria-labelledby="modalLabelAgregar" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {!! Form::open(['route' => ['reservas.agregarReserva'], 'id' => 'formAgregarReservaId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Agregar Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="titulo_id" class="form-label">Titulo Reserva <span class="text-danger">(*)</span></label>
                        {!! Form::text('titulo', '', ['class' => 'form-control', 'placeholder' => 'Tituloo', 'id' => 'titulo_id', 'required']) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="descripcion_id" class="form-label">Descripción Reserva</label>
                        {!! Form::textarea('descripcion', '', ['class' => 'form-control', 'placeholder' => 'Descripcion', 'id' => 'descripcion_id', 'rows' => 5]) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="fecha_id" class="form-label">Fecha Reserva<span class="text-danger">(*)</span></label>
                        {!! Form::text('fecha', '', [
                            'class' => 'form-control ',
                            'data-provider' => 'flatpickr',
                            'data-date-format' => 'd/m/Y',
                            'data-locale' => 'es',
                            'placeholder' => 'dd/mm/aaaa',
                            'id' => 'fecha_id',
                            'required',
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="hora_inicio_id" class="form-label">Hora Inicio<span class="text-danger">(*)</span></label>
                        {!! Form::text('horaInicio', '', [
                            'class' => 'form-control flatpickr-input',
                            'data-provider' => 'timepickr',
                            'data-time-basic' => 'true',
                            'id' => 'hora_inicio_id',
                            'required',
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="hora_fin_id" class="form-label">Hora Fin<span class="text-danger">(*)</span></label>
                        {!! Form::text('horaFin', '', [
                            'class' => 'form-control flatpickr-input',
                            'data-provider' => 'timepickr',
                            'data-time-basic' => 'true',
                            'id' => 'hora_fin_id',
                            'required',
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="cliente_id" class="form-label">Cliente <span class="text-danger">(*)</span></label>
                        {!! Form::select('cliente', $data['clienteSelect'], null, ['class' => 'form-select select2', 'style' => 'width:100%', 'id' => 'cliente_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="empleado_id" class="form-label">Empleado <span class="text-danger">(*)</span></label>
                        {!! Form::select('empleado', $data['empleadoSelect'], null, ['class' => 'form-select select2', 'style' => 'width:100%', 'id' => 'empleado_id', 'required']) !!}
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

<!--  Modal Editar Reserva -->
<div class="modal fade fadeInUp" id="modalEditarrReservaId" tabindex="-1" role="dialog" aria-labelledby="modalLabelAgregar" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {!! Form::open(['route' => ['reservas.editarReserva'], 'id' => 'formEditarReservaId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Modificar Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <input type="hidden" name="getReservaId" id="getReservaId" />
                    <div class="col-md-12">
                        <label for="titulo_edit_id" class="form-label">Titulo Reserva <span class="text-danger">(*)</span></label>
                        {!! Form::text('titulo', '', ['class' => 'form-control', 'placeholder' => 'Tituloo', 'id' => 'titulo_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="descripcion_edit_id" class="form-label">Descripción Reserva</label>
                        {!! Form::textarea('descripcion', '', ['class' => 'form-control', 'placeholder' => 'Descripcion', 'id' => 'descripcion_edit_id', 'rows' => 5]) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="fecha_edit_id" class="form-label">Fecha Reserva<span class="text-danger">(*)</span></label>
                        {!! Form::text('fecha', '', [
                            'class' => 'form-control ',
                            'data-provider' => 'flatpickr',
                            'data-date-format' => 'd/m/Y',
                            'data-locale' => 'es',
                            'placeholder' => 'dd/mm/aaaa',
                            'id' => 'fecha_edit_id',
                            'required',
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="hora_inicio_edit_id" class="form-label">Hora Inicio<span class="text-danger">(*)</span></label>
                        {!! Form::text('horaInicio', '', [
                            'class' => 'form-control flatpickr-input',
                            'data-provider' => 'timepickr',
                            'data-time-basic' => 'true',
                            'id' => 'hora_inicio_edit_id',
                            'required',
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="hora_fin_edit_id" class="form-label">Hora Fin<span class="text-danger">(*)</span></label>
                        {!! Form::text('horaFin', '', [
                            'class' => 'form-control flatpickr-input',
                            'data-provider' => 'timepickr',
                            'data-time-basic' => 'true',
                            'id' => 'hora_fin_edit_id',
                            'required',
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="cliente_edit_id" class="form-label">Cliente <span class="text-danger">(*)</span></label>
                        {!! Form::select('cliente', $data['clienteSelect'], null, ['class' => 'form-select select3', 'style' => 'width:100%', 'id' => 'cliente_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="empleado_edit_id" class="form-label">Empleado <span class="text-danger">(*)</span></label>
                        {!! Form::select('empleado', $data['empleadoSelect'], null, ['class' => 'form-select select3', 'style' => 'width:100%', 'id' => 'empleado_edit_id', 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-light waves-effect fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Cerrar</a>
                <button type="submit" class="btn btn-success waves-effect">Modificar</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--  Actualizar Estado -->
<div class="modal fade fadeInUp" id="modalActualizarEstadoId" tabindex="-1" role="dialog" aria-labelledby="modalLabelAgregar" aria-hidden="true">
    <div class="modal-dialog modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Actualizar Estado de Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div id="estadosContainer">
                    </div>
                </div>
                <br>
                <div id="mensajeGuardadoId">
                </div>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


{{-- Obtener Reserva --}}
{!! Form::open(['route' => ['reservas.getReserva', 0], 'id' => 'formGetReservaId']) !!}
{!! Form::close() !!}

{{-- Eliminar Reserva --}}
{!! Form::open(['route' => ['reservas.eliminarReserva'], 'id' => 'formEliminarReservaId']) !!}
<input type="hidden" name="reservaEliminarId" id="reservaEliminarId" />
{!! Form::close() !!}

{{-- Guardar estado --}}
{!! Form::open(['route' => ['reservas.actualizaEstado'], 'id' => 'formActualizarEstadoId']) !!}
<input type="hidden" name="idReserva" id="idReserva">
<input type="hidden" name="valoEstado" id="valoEstado">
{!! Form::close() !!}


@endsection
@section('scripts')
    @include('encabezados.js.datatable')
    @include('encabezados.js.sweetalert')
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/locale/es.js') }}"></script>
    <script src="{{ asset('dist/js/gestionarReserva/gestionarReserva.js') . '?version=2' }}"></script>
@endsection
