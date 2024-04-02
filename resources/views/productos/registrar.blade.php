@extends('adminlte::page')

@section('title', 'Registrar Producto')

@section('content_header')
    <h1 class="m-0 text-dark">Registrar Producto</h1>
@stop

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Error</strong> Hubo problemas con los datos ingresados<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{
$error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success mt-2">
        <strong>{{ Session::get('success') }}</strong>
    </div>
@endif

<form action="{{ route('productos.store') }}" method="POST" autocomplete="off">
    @csrf
    <div class="row">
        <x-adminlte-input name="nombre" label="Nombre" placeholder="Nombre" fgroup-class="col-md-6" disable-feedback type="text"/>
        <x-adminlte-input name="precio" label="Precio" placeholder="Precio" fgroup-class="col-md-6" disable-feedback type="text"/>
    </div>


    <x-adminlte-button class="btn-flat" type="submit" label="Registrar" theme="success" icon="fas fa-lg fa-save"/>
</form>
@stop
