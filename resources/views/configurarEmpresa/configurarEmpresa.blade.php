@extends('layouts.main')
@section('title', 'Configurar Empresa |')
@section('styles')
    @include('encabezados.css.datatable')
    @include('encabezados.css.sweetalert')
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="mdi mdi-tools text-warning"></i> CONFIGURACIÓN DE EMPRESA</h4>
            <div class="page-title-right">
                <ol class="breadcrumb my-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">SWGRVB</a>
                    </li>
                    <li class="breadcrumb-item active">Configuracón de Empresa</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-xxl-9">
        <div class="card">
            <div class="card-header">
                <h5 class="header-title">Modificar Datos de la Empresa</h4>
            </div>
            {!! Form::open(['route' => ['configuracionEmpresa.actualizarEmpresa'], 'id' => 'formActualizarEmpresaId']) !!}
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="razonSocial_id" class="form-label">Razón Social</label>
                        {!! Form::text('razonSocial', isset($empresa->razon_social) ? $empresa->razon_social : '', ['class' => 'form-control', 'placeholder' => 'Razón Social', 'id' => 'razonSocial_id']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="nombreCorto_id" class="form-label">Nombre Corto</label>
                        {!! Form::text('nombreCorto', isset($empresa->nombre_corto) ? $empresa->nombre_corto : '', ['class' => 'form-control', 'placeholder' => 'Nombre Corto', 'id' => 'nombreCorto_id']) !!}
                    </div>
                    <div class="col-md-12">
                        <label for="direccion_id" class="form-label">Dirección</label>
                        {!! Form::text('direccion', isset($empresa->direccion) ? $empresa->direccion : '', ['class' => 'form-control', 'placeholder' => 'Dirección', 'id' => 'direccion_id']) !!}
                    </div>
                    <div class="col-md-4">
                        <label for="ruc_id" class="form-label">RUC</label>
                        {!! Form::text('ruc', isset($empresa->ruc) ? $empresa->ruc : '', ['class' => 'form-control', 'placeholder' => 'RUC', 'id' => 'ruc_id']) !!}
                    </div>
                    <div class="col-md-4">
                        <label for="telefono_id" class="form-label">Telefono</label>
                        {!! Form::text('telefono', isset($empresa->telefono) ? $empresa->telefono : '', ['class' => 'form-control', 'placeholder' => 'Teléfono', 'id' => 'telefono_id']) !!}
                    </div>
                    <div class="col-md-4">
                        <label for="correo_id" class="form-label">Correo Electrónico</label>
                        {!! Form::text('correo', isset($empresa->correo_electronico) ? $empresa->correo_electronico : '', ['class' => 'form-control', 'placeholder' => 'Correo Electrónico', 'id' => 'correo_id']) !!}
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" name="departamento_ayuda" id="departamento_ayuda" value="{{ isset($empresa->UBIG_DEPA) ? $empresa->UBIG_DEPA : '' }}">
                        <label for="depa_id" class="form-label">Departamento</label>
                        {!! Form::select('departamento', $data['grupo_select'], isset($empresa->UBIG_DEPA) ? $empresa->UBIG_DEPA : '', ['class' => 'form-select select2Agregar', 'style' => 'width:100%', 'id' => 'depa_id']) !!}
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" name="provincia_ayuda" id="provincia_ayuda" value="{{ isset($empresa->UBIG_PROVI) ? $empresa->UBIG_PROVI : '' }}">
                        <label for="provincia_id" class="form-label">Provincia</label>
                        <select name="provincia" class="form-select select2Agregar" style="width: 100%;" id="provincia_id">
                            <option value="" selected>[ SELECCIONE PROVINCIA]</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" name="distrito_ayuda" id="distrito_ayuda" value="{{ isset($empresa->UBIG_DISTR) ? $empresa->UBIG_DISTR : '' }}">
                        <label for="distrito_id" class="form-label">Distrito</label>
                        <select name="distrito" class="form-select select2Agregar" style="width: 100%;" id="distrito_id">
                            <option value="" selected>[ SELECCIONE DISTRITO]</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('home')}}" type="button" class="btn btn-danger waves-effect">Cancelar</a>
                <button type="submit" class="btn btn-success waves-effect waves-light" id="btn_generar_factura">Modificar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


{{-- PRVINCIA Y DISTRITOS --}}
{!! Form::open(['route' => ['configuracionEmpresa.get_provincias'], 'id' => 'form-getProvincias']) !!}
    <input type="hidden" name="get_provincias_name" id="get_provincia_id" />
{!! Form::close() !!}

{!! Form::open(['route' => ['configuracionEmpresa.get_distritos'], 'id' => 'form-getDistritos']) !!}
    <input type="hidden" name="get_distritos_name" id="get_distrito_id" />
{!! Form::close() !!}
@endsection
@section('scripts')
    @include('encabezados.js.datatable')
    @include('encabezados.js.sweetalert')
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/locale/es.js') }}"></script>
    <script src="{{ asset('dist/js/configurarEmpresa/configurarEmpresa.js') . '?version=1' }}"></script>
@endsection
