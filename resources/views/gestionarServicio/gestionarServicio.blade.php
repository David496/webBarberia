@extends('layouts.main')
@section('title', 'Servicios |')
@section('styles')
    @include('encabezados.css.datatable')
    @include('encabezados.css.sweetalert')
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="bx bx-store-alt text-warning"></i> SERVICIOS REGISTRADOS</h4>

            <div class="page-title-right">
                <ol class="breadcrumb my-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">SWGRVB</a>
                    </li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Producto/servicios</a>
                    </li>
                    <li class="breadcrumb-item active">Servicios</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <div class="float-end">
            <button type="button" class="btn btn-success waves-effect " data-bs-toggle="modal" data-bs-target="#modalAgregarServicioId">
                <i class="ri-add-circle-line align-middle "></i>
                Agregar Servicio
            </button>
        </div>
    </div>
</div>

{{-- Ruta Tabla Servicio --}}
{!! Form::open(['route' => ['servicios.tablaServicio'], 'id' => 'formTablaServicio']) !!}
{!! Form::close() !!}

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="header-title">Servicios Registrados</h4>
            </div>
            <div class="card-body">
                <table id="tablaServicioId" class="table dt-responsive table-bordered table-sm table-hover align-middle">
                    <thead class="font-weight-bold bg-light">
                        <tr>
                            <th class="all align-middle text-center">#</th>
                            <th class="all align-middle text-center">Servicio</th>
                            <th class="align-middle text-center">Precio</th>
                            <th class="align-middle text-center">Descripción</th>
                            <th class="align-middle text-center">Fec. Crea.</th>
                            <th class="align-middle">Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!--  Modal Agregar Servicio -->
<div class="modal fade fadeInUp" id="modalAgregarServicioId" tabindex="-1" role="dialog" aria-labelledby="modalLabelAgregar" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {!! Form::open(['route' => ['servicios.agregarServicio'], 'id' => 'formAgregarServicioId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Agregar Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="nombreServicio_id" class="form-label">Nombre Servicio <span class="text-danger">(*)</span></label>
                        {!! Form::text('nombreServicio', '', ['class' => 'form-control', 'placeholder' => 'Nombres Servicio', 'id' => 'nombreServicio_id', 'required']) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="descripcion_id" class="form-label">Descripción <span class="text-danger">(*)</span></label>
                        {!! Form::textarea('descripcion', '', ['class' => 'form-control', 'placeholder' => 'Descripcion', 'id' => 'descripcion_id', 'required']) !!}
                    </div>
                    <div class="col-md-4">
                        <label for="precio_id" class="form-label">Precio de Venta</label>
                        {!! Form::number('precio', '', [
                            'class' => 'form-control ',
                            'placeholder' => 'S/ 0.00',
                            'step' => 'any',
                            'id' => 'precio_id',
                            'required'
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="imagen_id" class="form-label">Subir imagen</label>
                        <input class="form-control" type="file" id="imagen_id" accept="application/xml" name="imagen" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-light waves-effect fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Cerrar</a>
                <button type="submit" class="btn btn-success waves-effect">Agregar Servicio</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--  Modal Editar Servicio -->
<div class="modal fade fadeInUp" id="modalEditarServicioId" tabindex="-1" role="dialog" aria-labelledby="modalLabelEditar" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {!! Form::open(['route' => ['servicios.editarServicio'], 'id' => 'formEditarServicioId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Editar Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <input type="hidden" name="getServicioId" id="getServicioId" />
                    <div class="col-md-12">
                        <label for="nombreServicio_edit_id" class="form-label">Nombre Servicio <span class="text-danger">(*)</span></label>
                        {!! Form::text('nombreServicio', '', ['class' => 'form-control', 'placeholder' => 'Nombres Servicio', 'id' => 'nombreServicio_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="descripcion_edit_id" class="form-label">Descripción <span class="text-danger">(*)</span></label>
                        {!! Form::textarea('descripcion', '', ['class' => 'form-control', 'placeholder' => 'Descripcion', 'id' => 'descripcion_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-4">
                        <label for="precio_edit_id" class="form-label">Precio de Venta</label>
                        {!! Form::number('precio', '', [
                            'class' => 'form-control ',
                            'placeholder' => 'S/ 0.00',
                            'step' => 'any',
                            'id' => 'precio_edit_id',
                            'required'
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="imagen_id" class="form-label">Subir imagen</label>
                        <input class="form-control" type="file" id="imagen_id" accept="application/xml" name="imagen" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-light waves-effect fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Cerrar</a>
                <button type="submit" class="btn btn-success waves-effect">Editar Usuario</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- Obtener Servicio --}}
{!! Form::open(['route' => ['servicios.getServicio', 0], 'id' => 'formGetServicioId']) !!}
{!! Form::close() !!}

{{-- Eliminar Servicio --}}
{!! Form::open(['route' => ['servicios.eliminarServicio'], 'id' => 'formEliminarServicioId']) !!}
<input type="hidden" name="servicioEliminarId" id="servicioEliminarId" />
{!! Form::close() !!}
@endsection
@section('scripts')
    @include('encabezados.js.datatable')
    @include('encabezados.js.sweetalert')
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/locale/es.js') }}"></script>
    <script src="{{ asset('dist/js/gestionarServicio/gestionarServicio.js') . '?version=1' }}"></script>
@endsection
