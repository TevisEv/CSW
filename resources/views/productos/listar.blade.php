
@extends('adminlte::page')
@section('title', 'Listado de Producto')

@section('content_header')
    <h1 class="m-0 text-dark">Listado de Productos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Productos Registrados</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="productos" class="table table-bordered table-striped">
                <thead>
                    <tr>
                <th>Nombre</th>
                <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->precio }}</td>
                            <td>
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-xs btn-primary">Editar</a>
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display: inline-block;">
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
       {{ $productos->links() }}
    </div>
@stop
