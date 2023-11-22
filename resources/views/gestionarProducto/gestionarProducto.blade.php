@extends('layouts.main')
@section('title', 'Productos |')
@section('styles')
    @include('encabezados.css.datatable')
    @include('encabezados.css.sweetalert')
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="bx bx-store-alt text-warning"></i> PRODUCTOS REGISTRADOS</h4>

            <div class="page-title-right">
                <ol class="breadcrumb my-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">SWGRVB</a>
                    </li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Producto/servicios</a>
                    </li>
                    <li class="breadcrumb-item active">Productos</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <div class="float-end">
            <button type="button" class="btn btn-success waves-effect " data-bs-toggle="modal" data-bs-target="#modalAgregarProductoId">
                <i class="ri-add-circle-line align-middle "></i>
                Agregar Producto
            </button>
        </div>
    </div>
</div>

{{-- Ruta Tabla Producto --}}
{!! Form::open(['route' => ['productos.tablaProducto'], 'id' => 'formTablaProducto']) !!}
{!! Form::close() !!}

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="header-title">Productos Registrados</h4>
            </div>
            <div class="card-body">
                <table id="tablaProductosId" class="table dt-responsive table-bordered table-sm table-hover align-middle">
                    <thead class="font-weight-bold bg-light">
                        <tr>
                            <th class="all align-middle text-center">#</th>
                            <th class="all align-middle text-center">Producto</th>
                            <th class="align-middle text-center">Precio</th>
                            <th class="align-middle text-center">Descripción</th>
                            <th class="align-middle text-center">Unidad</th>
                            <th class="align-middle text-center">Stock</th>
                            <th class="align-middle text-center">Imagen</th>
                            <th class="align-middle text-center">Fec. Crea.</th>
                            <th class="align-middle">Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!--  Modal Agregar Producto -->
<div class="modal fade fadeInUp" id="modalAgregarProductoId" tabindex="-1" role="dialog" aria-labelledby="modalLabelAgregar" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {!! Form::open(['route' => ['productos.agregarProducto'], 'id' => 'formAgregarProductoId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="nombreProducto_id" class="form-label">Nombre Producto <span class="text-danger">(*)</span></label>
                        {!! Form::text('nombreProducto', '', ['class' => 'form-control', 'placeholder' => 'Nombres Producto', 'id' => 'nombreProducto_id', 'required']) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="descripcion_id" class="form-label">Descripción <span class="text-danger">(*)</span></label>
                        {!! Form::textarea('descripcion', '', ['class' => 'form-control', 'placeholder' => 'Descripcion', 'id' => 'descripcion_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="unidad_id" class="form-label">Unidad <span class="text-danger">(*)</span></label>
                        {!! Form::text('unidad', '', ['class' => 'form-control', 'placeholder' => 'Unidad', 'id' => 'unidad_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="precio_id" class="form-label">Precio de Venta</label>
                        {!! Form::number('precio', '', [
                            'class' => 'form-control ',
                            'placeholder' => 'S/ 0.00',
                            'step' => 'any',
                            'id' => 'precio_id',
                            'required'
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="stock_id" class="form-label">stock</label>
                        {!! Form::number('stock', '', [
                            'class' => 'form-control ',
                            'placeholder' => 'stock',
                            'step' => 'any',
                            'id' => 'stock_id',
                            'required'
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="imagen_id" class="form-label">Subir imagen</label>
                        <input class="form-control" type="file" id="imagen_id" accept="image/*" name="imagen">
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


<!--  Modal Editar Producto -->
<div class="modal fade fadeInUp" id="modalEditarServicioId" tabindex="-1" role="dialog" aria-labelledby="modalLabelEditar" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {!! Form::open(['route' => ['productos.editarProducto'], 'id' => 'formEditarProductoId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <input type="hidden" name="getProductoId" id="getProductoId" />
                    <div class="col-md-12">
                        <label for="nombreProducto_edit_id" class="form-label">Nombre Producto <span class="text-danger">(*)</span></label>
                        {!! Form::text('nombreProducto', '', ['class' => 'form-control', 'placeholder' => 'Nombres Producto', 'id' => 'nombreProducto_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="descripcion_edit_id" class="form-label">Descripción <span class="text-danger">(*)</span></label>
                        {!! Form::textarea('descripcion', '', ['class' => 'form-control', 'placeholder' => 'Descripcion', 'id' => 'descripcion_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="unidad_edit_id" class="form-label">Unidad <span class="text-danger">(*)</span></label>
                        {!! Form::text('unidad', '', ['class' => 'form-control', 'placeholder' => 'Unidad', 'id' => 'unidad_edit_id', 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="precio_edit_id" class="form-label">Precio de Venta</label>
                        {!! Form::number('precio', '', [
                            'class' => 'form-control ',
                            'placeholder' => 'S/ 0.00',
                            'step' => 'any',
                            'id' => 'precio_edit_id',
                            'required'
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="stock_edit_id" class="form-label">stock</label>
                        {!! Form::number('stock', '', [
                            'class' => 'form-control ',
                            'placeholder' => 'stock',
                            'step' => 'any',
                            'id' => 'stock_edit_id',
                            'required'
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="imagen_edit_id" class="form-label">Subir imagen</label>
                        <input class="form-control" type="file" id="imagen_edit_id" accept="image/*" name="imagen">
                        <span id="imagenSubida">No se encontró imagen</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-light waves-effect fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Cerrar</a>
                <button type="submit" class="btn btn-success waves-effect">Editar Servicio</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--  Modal aumentar stock-->
<div class="modal fade fadeInUp" id="modalAumentarStockId" tabindex="-1" role="dialog" aria-labelledby="modalLabelEditar" aria-hidden="true">
    <div class="modal-dialog modal-sm ">
        <div class="modal-content">
            {!! Form::open(['route' => ['productos.aumentarStock'], 'id' => 'formAumentarStockId']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregar">Aumentar Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <input type="hidden" name="getProductId" id="getProductId" />
                    <div class="col-md-12">
                        <label for="nombreProducto_info_id" class="form-label">Nombre Producto</label>
                        {!! Form::text('nombreProducto', '', ['class' => 'form-control', 'placeholder' => 'Nombres Producto', 'id' => 'nombreProducto_info_id', 'readonly',]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="stock_actual_id" class="form-label">Stock Actual</label>
                        {!! Form::number('stockActual', '', [
                            'class' => 'form-control ',
                            'placeholder' => 'stock',
                            'step' => 'any',
                            'id' => 'stock_actual_id',
                            'readonly',
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="stock_edit_id" class="form-label">Stock a Agregar</label>
                        {!! Form::number('stockMas', '', [
                            'class' => 'form-control ',
                            'placeholder' => 'stock',
                            'step' => 'any',
                            'id' => 'stock_mas_id'
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-light waves-effect fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Cerrar</a>
                <button type="submit" class="btn btn-success waves-effect">Guardar</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- Obtener Producto --}}
{!! Form::open(['route' => ['productos.getProducto', 0], 'id' => 'formGetProductoId']) !!}
{!! Form::close() !!}

{{-- Eliminar Producto --}}
{!! Form::open(['route' => ['productos.eliminarProducto'], 'id' => 'formEliminarProductoId']) !!}
<input type="hidden" name="productoEliminarId" id="productoEliminarId" />
{!! Form::close() !!}
@endsection
@section('scripts')
    @include('encabezados.js.datatable')
    @include('encabezados.js.sweetalert')
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/locale/es.js') }}"></script>
    <script src="{{ asset('dist/js/gestionarProducto/gestionarProducto.js') . '?version=3' }}"></script>
@endsection
