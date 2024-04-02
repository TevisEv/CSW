@extends('adminlte::page')

@section('title', 'Editar el Producto')

@section('content_header')
    <h1 class="m-0 text-dark">Editar Producto</h1>
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

@if(session('success'))
    <div class="alert alert-success mt-2">
        <strong>{{ session('success') }}</strong>
    </div>
@endif

<form action="{{ route('productos.update', $producto->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT') <!-- IMPORTANTE: Simular método PUT -->
    <div class="row">
        <x-adminlte-input name="nombre" label="Nombre" placeholder="Nombre del Producto"
            fgroup-class="col-md-6" disable-feedback value="{{ $producto->nombre }}"/>
    </div>

    <div class="row">
        <x-adminlte-input name="precio" label="Precio" placeholder="Precio del Producto"
            fgroup-class="col-md-6" disable-feedback value="{{ $producto->precio }}"/>
    </div>

    <x-adminlte-button class="btn-flat" type="submit" label="Actualizar" theme="success" icon="fas fa-lg fa-save"/>
</form>
@stop
