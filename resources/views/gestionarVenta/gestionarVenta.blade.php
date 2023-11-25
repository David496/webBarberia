@extends('layouts.main')
@section('title', 'Ventas |')
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
            <h4 class="mb-sm-0"><i class="las la-book text-warning"></i> REGISTRO DE VENTAS</h4>

            <div class="page-title-right">
                <ol class="breadcrumb my-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">SWGRVB</a>
                    </li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Registro de Ventas</a>
                    </li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <div class="float-end">
            <a href="{{route('ventas.CrearVenta')}}" class="btn btn-success waves-effect">
                <i class="ri-add-circle-line align-middle"></i>
                REGISTRAR VENTAS
            </a>
        </div>
    </div>
</div>

{{-- Ruta Tabla Ventas --}}
{!! Form::open(['route' => ['ventas.tablaVentas'], 'id' => 'formTablaVentas']) !!}
{!! Form::close() !!}

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="header-title">Reservas Registradas</h4>
            </div>
            <div class="card-body">
                <table id="tablaVentaId" class="table dt-responsive table-bordered table-sm table-hover align-middle">
                    <thead class="font-weight-bold bg-light">
                        <tr>
                            <th class="all align-middle text-center">#</th>
                            <th class="all align-middle text-center">nro Venta</th>
                            <th class="all align-middle text-center">Cliente</th>
                            <th class="align-middle text-center">Nro Doc</th>
                            <th class="align-middle text-center">Fecha Emision</th>
                            <th class="align-middle text-center">Monto Total</th>
                            <th class="align-middle text-center">Nro Boleta</th>
                            <th class="align-middle">Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Eliminar Venta --}}
{!! Form::open(['route' => ['ventas.eliminarVenta'], 'id' => 'formEliminarVentaId']) !!}
<input type="hidden" name="ventaEliminarId" id="ventaEliminarId" />
{!! Form::close() !!}

@endsection
@section('scripts')
    @include('encabezados.js.datatable')
    @include('encabezados.js.sweetalert')
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/locale/es.js') }}"></script>
    <script src="{{ asset('dist/js/gestionarVenta/gestionarVenta.js') . '?version=1' }}"></script>
@endsection
