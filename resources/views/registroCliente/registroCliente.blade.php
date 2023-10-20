@extends('layouts.main')
@section('title', 'Clientes |')
@section('styles')
    @include('encabezados.css.datatable')
    @include('encabezados.css.sweetalert')
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="las la-person-booth text-warning"></i> REGISTRO CLIENTES</h4>

            <div class="page-title-right">
                <ol class="breadcrumb my-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">SWGRVB</a>
                    </li>
                    <li class="breadcrumb-item active">Registro Clientes</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <div class="float-end">
            <button type="button" class="btn btn-success waves-effect " data-bs-toggle="modal" data-bs-target="#modalAgregarClienteId">
                <i class="ri-add-circle-line align-middle "></i>
                Agregar Cliente
            </button>
        </div>
    </div>
</div>

{{-- Ruta Tabla Clientes --}}
{!! Form::open(['route' => ['registroClientes.tablaCliente'], 'id' => 'formTablaCliente']) !!}
{!! Form::close() !!}

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="header-title">Clientes Registrados</h4>
            </div>
            <div class="card-body">
                <table id="tablaClienteId" class="table dt-responsive table-bordered table-sm table-hover align-middle">
                    <thead class="font-weight-bold bg-light">
                        <tr>
                            <th class="all align-middle text-center">#</th>
                            <th class="all align-middle text-center">Nombre</th>
                            <th class="align-middle text-center">N° Doc.</th>
                            <th class="align-middle text-center">Email</th>
                            <th class="align-middle text-center">Telefono</th>
                            <th class="align-middle text-center">Fec. Crea.</th>
                            <th class="align-middle">Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!--  Modal Agregar Cliente -->
<div class="modal fade fadeInUp" id="modalAgregarClienteId" tabindex="-1" role="dialog" aria-labelledby="modalLabelAgregar" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {!! Form::open(['route' => ['registroClientes.agregarCliente'], 'id' => 'formAgregarClienteId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Agregar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="nombres_id" class="form-label">Nombres <span class="text-danger">(*)</span></label>
                        {!! Form::text('nombres', '', ['class' => 'form-control', 'placeholder' => 'Nombres', 'id' => 'nombres_id', 'required']) !!}
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
                        <label for="telefono_id" class="form-label">Telefono <span class="text-danger">(*)</span></label>
                        {!! Form::text('telefono', '', ['class' => 'form-control', 'placeholder' => 'Telefono', 'id' => 'telefono_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="email_id" class="form-label">Email <span class="text-danger">(*)</span></label>
                        {!! Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email_id', 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-light waves-effect fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Cerrar</a>
                <button type="submit" class="btn btn-success waves-effect">Agregar Cliente</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--  Modal Editar Cliente -->
<div class="modal fade fadeInUp" id="modalEditarClienteId" tabindex="-1" role="dialog" aria-labelledby="modalLabelEditar" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {!! Form::open(['route' => ['registroClientes.editarCliente'], 'id' => 'formEditarClienteId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <input type="hidden" name="getClienteId" id="getClienteId" />
                    <div class="col-md-4">
                        <label for="nombres_edit_id" class="form-label">Nombres <span class="text-danger">(*)</span></label>
                        {!! Form::text('nombres', '', ['class' => 'form-control', 'placeholder' => 'Nombres', 'id' => 'nombres_edit_id', 'required']) !!}
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
                        <label for="telefono_edit_id" class="form-label">Telefono <span class="text-danger">(*)</span></label>
                        {!! Form::text('telefono', '', ['class' => 'form-control', 'placeholder' => 'Telefono', 'id' => 'telefono_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="email_edit_id" class="form-label">Email <span class="text-danger">(*)</span></label>
                        {!! Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email_edit_id', 'required']) !!}
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

{{-- Obtener Cliente --}}
{!! Form::open(['route' => ['registroClientes.getCliente', 0], 'id' => 'formGetClienteId']) !!}
{!! Form::close() !!}

{{-- Eliminar Cliente --}}
{!! Form::open(['route' => ['registroClientes.eliminarCliente'], 'id' => 'formEliminarClienteId']) !!}
<input type="hidden" name="clienteEliminarId" id="clienteEliminarId" />
{!! Form::close() !!}
@endsection
@section('scripts')
    @include('encabezados.js.datatable')
    @include('encabezados.js.sweetalert')
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/locale/es.js') }}"></script>
    <script src="{{ asset('dist/js/registroCliente/registroCliente.js') . '?version=1' }}"></script>
@endsection
