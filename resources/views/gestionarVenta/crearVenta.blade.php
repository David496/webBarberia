@extends('layouts.main')
@section('title', 'Crear Venta |')
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
            <h4 class="mb-sm-0"><i class="las la-book text-warning"></i> REGISTRAR VENTA</h4>
            <div class="page-title-right">
                <ol class="breadcrumb my-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">SWGRVB</a>
                    </li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Registro de Ventas</a>
                    </li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Registrar Venta</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Ruta Tabla Items --}}
{!! Form::open(['route' => ['reservas.CrearVenta.tablaItems'], 'id' => 'formTablaItems']) !!}
{!! Form::close() !!}
<div class="row">
    <div class="col-lg-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border card-border-primary">
                    <div class="card-header bg-primary ">
                        <h6 class="card-title mb-0 text-white">Datos de Producto</h6>
                    </div>
                    {!! Form::open(['route' => ['reservas.CrearVenta.guardarProducto'], 'id' => 'formGuardarProductoId']) !!}
                    <div class="card-body">
                        <div class="row g-1">
                            <div class="col-md-12">
                                <label for="productoId" class="form-label">Producto</label>
                                {!! Form::select('productoSelect', $data['productoSelect'], null, ['class' => 'form-select select2', 'style' => 'width:100%', 'id' => 'productoId']) !!}
                            </div>
                            <div class="col-md-10">
                                <label for="nombreProductoId" class="form-label">Nombre Producto</label>
                                {!! Form::text('nombreProducto', '', ['class' => 'form-control', 'placeholder' => 'Nombres Producto', 'id' => 'nombreProductoId','readonly']) !!}
                            </div>
                            <div class="col-md-2">
                                <label for="stockProductoId" class="form-label">stock</label>
                                {!! Form::number('stockProducto', '', [
                                    'class' => 'form-control ',
                                    'placeholder' => 'stock',
                                    'step' => 'any',
                                    'id' => 'stockProductoId',
                                    'readonly'
                                ]) !!}
                            </div>
                            <div class="col-md-6">
                                <label for="precioProductoId" class="form-label">Precio de Venta</label>
                                {!! Form::number('precioProducto', '', [
                                    'class' => 'form-control ',
                                    'placeholder' => 'S/ 0.00',
                                    'step' => 'any',
                                    'id' => 'precioProductoId'
                                ]) !!}
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h5 class="fs-14 fw-medium mt-1">Cantidad</h5>
                                    <div class="input-step step-primary full-width">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" name="cantidadProducto" id="cantidadProductoId" class="product-quantity" value="1" min="0" max="50">
                                        <button type="button" class="plus">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="btnAgregarProducto" class="btn btn-primary btn-label"><i class="las la-shopping-cart label-icon align-middle fs-16 me-2"></i>Agregar Producto</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card border card-border-secondary">
                    <div class="card-header bg-secondary">
                        <h6 class="card-title mb-0 text-white">Datos de Servicio</h6>
                    </div>
                    {!! Form::open(['route' => ['reservas.CrearVenta.guardarServicio'], 'id' => 'formGuardarServicioId']) !!}
                    <div class="card-body">
                        <div class="row g-1">
                            <div class="col-md-12">
                                <label for="servicioId" class="form-label">Servicio</label>
                                {!! Form::select('servicioSelect', $data['servicioSelect'], null, ['class' => 'form-select select2', 'style' => 'width:100%', 'id' => 'servicioId']) !!}
                            </div>
                            <div class="col-md-12">
                                <label for="nombreServicioId" class="form-label">Nombre Servicio</label>
                                {!! Form::text('nombreServicio', '', ['class' => 'form-control', 'placeholder' => 'Nombres Servicio', 'id' => 'nombreServicioId','readonly']) !!}
                            </div>
                            <div class="col-md-6">
                                <label for="precioServicioId" class="form-label">Precio de Venta</label>
                                {!! Form::number('precioServicio', '', [
                                    'class' => 'form-control ',
                                    'placeholder' => 'S/ 0.00',
                                    'step' => 'any',
                                    'id' => 'precioServicioId'
                                ]) !!}
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h5 class="fs-14 fw-medium mt-1">Cantidad</h5>
                                    <div class="input-step step-secondary full-width">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" name="cantidadServicio" id="cantidadServicioId" class="product-quantity" value="1" min="0" max="50">
                                        <button type="button" class="plus">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="btnAgregarServicio"  class="btn btn-secondary btn-label"><i class="las la-shopping-cart label-icon align-middle fs-16 me-2"></i>Agregar Servicio</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="row" >
            <div class="col-12">
                <div class="card border card-border-danger">
                    <div class="card-header bg-danger">
                        <h6 class="card-title mb-0 text-white">Datos de la Venta</h6>
                    </div>
                    {!! Form::open(['route' => ['reservas.CrearVenta.registrarVenta'], 'id' => 'formRegistrarVentaId']) !!}
                    <div class="card-body">
                        <div class="row g-1">
                            <div class="col-md-5">
                                <label for="clienteId" class="form-label">Cliente</label>
                                {!! Form::select('clienteSelect', $data['clienteSelect'], null, ['class' => 'form-select select2', 'style' => 'width:100%', 'id' => 'clienteId']) !!}
                            </div>
                            <div class="col-md-4">
                                <label for="fechaEmisionId" class="form-label">Fecha Emisión</label>
                                {!! Form::text('fechaEmision', '', [
                                    'class' => 'form-control ',
                                    'data-provider' => 'flatpickr',
                                    'data-date-format' => 'd/m/Y',
                                    'data-locale' => 'es',
                                    'placeholder' => 'dd/mm/aaaa',
                                    'id' => 'fechaEmisionId',
                                ]) !!}
                            </div>
                            <div class="col-md-3">
                                <label for="nroBoletaId" class="form-label">Nro. Boleta</label>
                                {!! Form::text('nroBoleta', '', ['class' => 'form-control', 'placeholder' => 'nroBoleta', 'id' => 'nroBoletaId']) !!}
                            </div>
                        </div>
                        <br>
                        <div class="row g-1">
                            <table id="tablaItemsId" class="table dt-responsive table-bordered table-sm table-hover align-middle">
                                <thead class="font-weight-bold bg-light">
                                    <tr>
                                        <th class="all align-middle text-center">#</th>
                                        <th class="all align-middle text-center">Nombre</th>
                                        <th class="align-middle text-center">Tipo</th>
                                        <th class="align-middle text-center">Cantidad</th>
                                        <th class="align-middle text-center">Precio</th>
                                        <th class="align-middle text-center">Total</th>
                                        <th class="align-middle">Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <br>
                        <div class="row g-1">
                            <div class="col-md-8">
                                <!-- Contenido de las otras columnas -->
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">Total a pagar: S/.</span>
                                    {!! Form::number('totalPagar', '', [
                                    'class' => 'form-control ',
                                    'placeholder' => '0.00',
                                    'step' => 'any',
                                    'id' => 'totalPagarId',
                                    'readonly'
                                ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="registrarVentaId" class="btn btn-success btn-label"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>Registrar venta</button>
                        <button type="button" class="btn btn-danger btn-label" onclick="cancelarVenta()"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i>Cancelar</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Obtener Servicio --}}
{!! Form::open(['route' => ['reservas.CrearVenta.getServicio', 0], 'id' => 'formGetServicioId']) !!}
{!! Form::close() !!}

{{-- Obtener Producto --}}
{!! Form::open(['route' => ['reservas.CrearVenta.getProducto', 0], 'id' => 'formGetProductoId']) !!}
{!! Form::close() !!}

{{-- Obtener total --}}
{!! Form::open(['route' => ['reservas.CrearVenta.getTotalItems', 0], 'id' => 'formGetTotalItemsId']) !!}
{!! Form::close() !!}

{{-- Eliminar Reserva --}}
{!! Form::open(['route' => ['reservas.CrearVenta.eliminarItem'], 'id' => 'formEliminarItemId']) !!}
<input type="hidden" name="itemEliminarId" id="itemEliminarId" />
{!! Form::close() !!}

<!-- Redireccionar a ventas -->
{!! Form::open(['route' => ['ventas.registroVentaVista'], 'id' => 'formRedireccionarVentas']) !!}
<input type="hidden" name="" id="" />
{!! Form::close() !!}

@endsection
@section('scripts')
    @include('encabezados.js.datatable')
    @include('encabezados.js.sweetalert')
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/locale/es.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-input-spin.init.js') }}"></script>
    <script src="{{ asset('dist/js/gestionarVenta/crearVenta.js') . '?version=1' }}"></script>
@endsection
