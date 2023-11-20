@extends('layouts.main')
@section('title', 'Usuarios |')
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
            <h4 class="mb-sm-0"><i class="mdi mdi-account text-warning"></i> REGISTRO USUARIOS</h4>

            <div class="page-title-right">
                <ol class="breadcrumb my-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">SWGRVB</a>
                    </li>
                    <li class="breadcrumb-item active">Registro Usuarios</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <div class="float-end">
            <button type="button" class="btn btn-success waves-effect " data-bs-toggle="modal" data-bs-target="#modalAgregarUsuarioId">
                <i class="ri-add-circle-line align-middle "></i>
                Agregar Usuario
            </button>
        </div>
    </div>
</div>

{{-- Ruta Tabla Usuarios --}}
{!! Form::open(['route' => ['registroUsuarios.tablaUser'], 'id' => 'formTablaUsuarios']) !!}
{!! Form::close() !!}

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="header-title">Usuarios Registrados</h4>
            </div>
            <div class="card-body">
                <table id="tablaUsuariosId" class="table dt-responsive table-bordered table-sm table-hover align-middle">
                    <thead class="font-weight-bold bg-light">
                        <tr>
                            <th class="all align-middle text-center">#</th>
                            <th class="all align-middle text-center">Nombre</th>
                            <th class="align-middle text-center">N° Doc.</th>
                            <th class="align-middle text-center">Rol</th>
                            <th class="align-middle text-center">Email</th>
                            <th class="align-middle text-center">Foto</th>
                            <th class="align-middle text-center">Fec. Crea.</th>
                            <th class="align-middle text-center">Estado</th>
                            <th class="align-middle">Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!--  Modal Agregar Usuario -->
<div class="modal fade fadeInUp" id="modalAgregarUsuarioId" tabindex="-1" role="dialog" aria-labelledby="modalLabelAgregar" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {!! Form::open(['route' => ['registroUsuarios.agregarUsuario'], 'id' => 'formAgregarUsuarioId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="name_id" class="form-label">Nombres <span class="text-danger">(*)</span></label>
                        {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Nombres', 'id' => 'name_id', 'required']) !!}
                    </div>
                    <div class="col-md-4">
                        <label for="apellidoP_id" class="form-label">Apellido Paterno <span class="text-danger">(*)</span></label>
                        {!! Form::text('apellidoP', '', ['class' => 'form-control', 'placeholder' => 'Apellido Paterno', 'id' => 'apellidoP_id', 'required']) !!}
                    </div>
                    <div class="col-md-4">
                        <label for="apellidoM_id" class="form-label">Apellido Materno <span class="text-danger">(*)</span></label>
                        {!! Form::text('apellidoM', '', ['class' => 'form-control', 'placeholder' => 'Apellido Materno', 'id' => 'apellidoM_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="dni_id" class="form-label">DNI <span class="text-danger">(*)</span></label>
                        {!! Form::text('dni', '', ['class' => 'form-control', 'placeholder' => 'N° Doc', 'id' => 'dni_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="email_id" class="form-label">Email <span class="text-danger">(*)</span></label>
                        {!! Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="telefono_id" class="form-label">Telefono <span class="text-danger">(*)</span></label>
                        {!! Form::text('telefono', '', ['class' => 'form-control', 'placeholder' => 'Telefono', 'id' => 'telefono_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="fechaNacimiento_id" class="form-label">Fecha de Nacimiento <span class="text-danger">(*)</span></label>
                        {!! Form::text('fechaNacimiento', '', [
                            'class' => 'form-control ',
                            'data-provider' => 'flatpickr',
                            'data-date-format' => 'd/m/Y',
                            'data-locale' => 'es',
                            'placeholder' => 'dd/mm/aaaa',
                            'id' => 'fechaNacimiento_id',
                            'required',
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="tipoUser_id" class="form-label">Tipo Usuario <span class="text-danger">(*)</span></label>
                        {!! Form::select('tipoUser', $data['tipoUsuario'], null, ['class' => 'form-select select2Agregar', 'style' => 'width:100%', 'id' => 'tipoUser_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="estado_id" class="form-label">Estado <span class="text-danger">(*)</span></label>
                        {!! Form::select('estado', $data['estado'], null, ['class' => 'form-select select2Agregar', 'style' => 'width:100%', 'id' => 'estado_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="password_id" class="form-label">Contraseña <span class="text-danger">(*)</span></label>
                        {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'new-password', 'id' => 'password_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="password_rep_id" class="form-label">Repetir Contraseña <span class="text-danger">(*)</span></label>
                        {!! Form::password('password_rep', ['class' => 'form-control', 'autocomplete' => 'new-password', 'id' => 'password_rep_id', 'required']) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="imagen_id" class="form-label">Subir foto</label>
                        <input class="form-control" type="file" id="imagen_id" accept="image/*" name="imagen">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-light waves-effect fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Cerrar</a>
                <button type="submit" class="btn btn-success waves-effect">Agregar Usuario</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--  Modal Editar Usuario -->
<div class="modal fade fadeInUp" id="modalEditarUsuarioId" tabindex="-1" role="dialog" aria-labelledby="modalLabelEditar" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {!! Form::open(['route' => ['registroUsuarios.editarUsuario'], 'id' => 'formEditarUsuarioId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <input type="hidden" name="getUsuarioId" id="getUsuarioId" />
                    <div class="col-md-4">
                        <label for="name_edit_id" class="form-label">Nombres <span class="text-danger">(*)</span></label>
                        {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Nombres', 'id' => 'name_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-4">
                        <label for="apellidoP_edit_id" class="form-label">Apellido Paterno <span class="text-danger">(*)</span></label>
                        {!! Form::text('apellidoP', '', ['class' => 'form-control', 'placeholder' => 'Apellido Paterno', 'id' => 'apellidoP_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-4">
                        <label for="apellidoM_edit_id" class="form-label">Apellido Materno <span class="text-danger">(*)</span></label>
                        {!! Form::text('apellidoM', '', ['class' => 'form-control', 'placeholder' => 'Apellido Materno', 'id' => 'apellidoM_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="dni_edit_id" class="form-label">DNI <span class="text-danger">(*)</span></label>
                        {!! Form::text('dni', '', ['class' => 'form-control', 'placeholder' => 'N° Doc', 'id' => 'dni_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="email_edit_id" class="form-label">Email <span class="text-danger">(*)</span></label>
                        {!! Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="telefono_edit_id" class="form-label">Telefono <span class="text-danger">(*)</span></label>
                        {!! Form::text('telefono', '', ['class' => 'form-control', 'placeholder' => 'Telefono', 'id' => 'telefono_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="fechaNacimiento_edit_id" class="form-label">Fecha de Nacimiento <span class="text-danger">(*)</span></label>
                        {!! Form::text('fechaNacimiento', '', [
                            'class' => 'form-control ',
                            'data-provider' => 'flatpickr',
                            'data-date-format' => 'd/m/Y',
                            'data-locale' => 'es',
                            'placeholder' => 'dd/mm/aaaa',
                            'id' => 'fechaNacimiento_edit_id',
                            'required',
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="tipoUser_edit_id" class="form-label">Tipo Usuario <span class="text-danger">(*)</span></label>
                        {!! Form::select('tipoUser', $data['tipoUsuario'], null, ['class' => 'form-select select2Actualizar', 'style' => 'width:100%', 'id' => 'tipoUser_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="estado_edit_id" class="form-label">Estado <span class="text-danger">(*)</span></label>
                        {!! Form::select('estado', $data['estado'], null, ['class' => 'form-select select2Actualizar', 'style' => 'width:100%', 'id' => 'estado_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-12">
                        <div class="form-check form-switch form-switch-secondary">
                            {!! Form::checkbox('checkPass', true, false, ['id' => 'cambiarPassCheckId', 'class' => 'form-check-input']) !!}
                            <label class="form-check-label" for="cambiarPassCheckId">Cambiar Contraseña</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="password_edit_id" class="form-label">Contraseña <span class="text-danger">(*)</span></label>
                        {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'new-password', 'id' => 'password_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="password_rep_edit_id" class="form-label">Repetir Contraseña <span class="text-danger">(*)</span></label>
                        {!! Form::password('password_rep', ['class' => 'form-control', 'autocomplete' => 'new-password', 'id' => 'password_rep_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="imagen_edit_id" class="form-label">Subir foto</label>
                        <input class="form-control" type="file" id="imagen_edit_id" accept="image/*" name="imagen">
                        <span id="imagenSubida">No se encontró imagen</span>
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

<!--  Actualizar Estado -->
<div class="modal fade fadeInUp" id="modalActualizarEstadoId" tabindex="-1" role="dialog" aria-labelledby="modalLabelAgregar" aria-hidden="true">
    <div class="modal-dialog modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Actualizar Estado del Usuario</h5>
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

{{-- Obtener Usuario --}}
{!! Form::open(['route' => ['registroUsuarios.getUsuario', 0], 'id' => 'formGetUsuarioId']) !!}
{!! Form::close() !!}

{{-- Eliminar Usuario --}}
{!! Form::open(['route' => ['registroUsuarios.eliminarUsuario'], 'id' => 'formEliminarUsuarioId']) !!}
<input type="hidden" name="usuarioEliminarId" id="usuarioEliminarId" />
{!! Form::close() !!}

{{-- Guardar estado --}}
{!! Form::open(['route' => ['registroUsuarios.actualizarEstadoUsuario'], 'id' => 'formActualizarEstadoId']) !!}
<input type="hidden" name="idUser" id="idUser">
<input type="hidden" name="valoEstado" id="valoEstado">
{!! Form::close() !!}
@endsection
@section('scripts')
    @include('encabezados.js.datatable')
    @include('encabezados.js.sweetalert')
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/locale/es.js') }}"></script>
    <script src="{{ asset('dist/js/registroUsuarios/registroUsuario.js') . '?version=3' }}"></script>
@endsection
