@extends('adminlte::page')

@section('title', 'Registrar Cliente')

@section('content_header')
    <h1 class="m-0 text-dark">Registrar Cliente</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error</strong> Hubo problemas con los datos ingresados<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mt-2">
            <strong>{{ Session::get('success') }}</strong>
        </div>
    @endif

    <form action="{{ route('clientes.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="row">
            <x-adminlte-input name="NRODOCUMENTO" label="Nrodocumento" placeholder="Nrodocumento" fgroup-class="col-md-6"
                disable-feedback type="text" />
            <x-adminlte-input name="TIPODOCUMENTO" label="Tipodocumento" placeholder="Tipodocumento" fgroup-class="col-md-6"
                disable-feedback type="text" />
        </div>
        <div class="row">
            <x-adminlte-input name="LINK" label="Link" placeholder="Link" fgroup-class="col-md-6" disable-feedback
                type="text" />
            <x-adminlte-input name="RAZONNOMBRE" label="Razonnombre" placeholder="Razonnombre" fgroup-class="col-md-6"
                disable-feedback type="text" />
        </div>
        <div class="row">
            <x-adminlte-input name="DIASCREDITO" label="Dias credito" placeholder="Diascredito" fgroup-class="col-md-6"
                disable-feedback type="text" />
            <x-adminlte-input name="LIMITECREDITO" label="Limitecredito" placeholder="Limitecredito" fgroup-class="col-md-6"
                disable-feedback type="text" />
        </div>
        <div class="row">
            <x-adminlte-input name="EMAIL" label="Email" placeholder="Email" fgroup-class="col-md-6" disable-feedback
                type="text" />
            <x-adminlte-input name="TELEFONO" label="Telefono" placeholder="Telefono" fgroup-class="col-md-6"
                disable-feedback type="text" />
        </div>
        <div class="row">
            <x-adminlte-input name="CONTACTO" label="Contacto" placeholder="Contacto" fgroup-class="col-md-6"
                disable-feedback type="text" />
            <x-adminlte-input name="CLAVEWEB" label="Claveweb" placeholder="Claveweb" fgroup-class="col-md-6"
                disable-feedback type="text" />
        </div>
        <div class="row">
            <x-adminlte-input name="TIPOCLIENTE" label="Tipocliente" placeholder="Tipocliente" fgroup-class="col-md-6"
                disable-feedback type="text" />
            <x-adminlte-input name="TIPOORIGEN" label="Tipoorigen" placeholder="Tipoorigen" fgroup-class="col-md-6"
                disable-feedback type="text" />
        </div>
        <div class="row">
            <x-adminlte-input name="FECHANACIMIENTO" label="Fechanacimiento" placeholder="Fechanacimiento"
                fgroup-class="col-md-6" disable-feedback type="date" />
            <x-adminlte-input name="OCUPACION" label="Ocupacion" placeholder="Ocupacion" fgroup-class="col-md-6"
                disable-feedback type="text" />
        </div>
        <div class="row">
            <x-adminlte-input name="DIRECCION" label="Direccion" placeholder="Direccion" fgroup-class="col-md-6"
                disable-feedback type="text" />
            <x-adminlte-input name="REFERENCIA" label="Referencia" placeholder="Referencia" fgroup-class="col-md-6"
                disable-feedback type="text" />
        </div>
        <div class="row">
            <x-adminlte-input name="DNIFAMILIAR" label="Dnifamiliar" placeholder="Dnifamiliar" fgroup-class="col-md-6"
                disable-feedback type="text" />
            <x-adminlte-input name="TELEFONOCONTACTO" label="Telefonocontacto" placeholder="Telefonocontacto"
                fgroup-class="col-md-6" disable-feedback type="text" />
        </div>
        <div class="row">
            <x-adminlte-input name="FECULTIMACOMPRA" label="Fecultimacompra" placeholder="Fecultimacompra"
                fgroup-class="col-md-6" disable-feedback type="date" />
            <x-adminlte-input name="DOCULTIMACOMPRA" label="Docultimacompra" placeholder="Docultimacompra"
                fgroup-class="col-md-6" disable-feedback type="text" />
        </div>
        <div class="row">
            <x-adminlte-input name="PORCENTAJE_DESCUENTO" label="Porcentaje_descuento" placeholder="Porcentaje_descuento"
                fgroup-class="col-md-6" disable-feedback type="text" />
            <x-adminlte-input name="PORCENTAJE_MORA" label="Porcentaje_mora" placeholder="Porcentaje_mora"
                fgroup-class="col-md-6" disable-feedback type="text" />
        </div>


        <x-adminlte-button class="btn-flat" type="submit" label="Registrar" theme="success"
            icon="fas fa-lg fa-save" />
    </form>
@stop

