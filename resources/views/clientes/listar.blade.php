@extends('adminlte::page')
@section('title', 'Listado de Cliente')

@section('content_header')
    <h1 class="m-0 text-dark">Listado de Clientes</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Clientes Registrados</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="clientes" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nrodocumento</th>
                        <th>Tipodocumento</th>
                        <th>Link</th>
                        <th>Razonnombre</th>
                        <th>Diascredito</th>
                        <th>Limitecredito</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Contacto</th>
                        <th>Claveweb</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->NRODOCUMENTO }}</td>
                            <td>{{ $cliente->TIPODOCUMENTO }}</td>
                            <td>{{ $cliente->LINK }}</td>
                            <td>{{ $cliente->RAZONNOMBRE }}</td>
                            <td>{{ $cliente->DIASCREDITO }}</td>
                            <td>{{ $cliente->LIMITECREDITO }}</td>
                            <td>{{ $cliente->EMAIL }}</td>
                            <td>{{ $cliente->TELEFONO }}</td>
                            <td>{{ $cliente->CONTACTO }}</td>
                            <td>{{ $cliente->CLAVEWEB }}</td>
                            <td>
                                <a href="{{ route('clientes.edit', ['cliente' => $cliente->NRODOCUMENTO]) }}"
                                    class="btn btn-xs btn-primary">Editar</a>

                                <form action="{{ route('clientes.destroy', ['cliente' => $cliente->NRODOCUMENTO]) }}"
                                    method="POST" style="display: inline-block;">

                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <div>
        {{ $clientes->links() }}
    </div>
@stop
