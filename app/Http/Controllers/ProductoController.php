<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return 'estoy en el index';
        //$productos = Producto::all(); // Recupera todos los productos
        $productos = Producto::orderBy('nombre', 'asc')->paginate(6);
        return view('productos.listar', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // esto muestra la vista de creacion
        return view('productos.registrar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // con la vista y sus datos se crea el producto
        //dd($request->all());
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|decimal:2|gt:0'
        ]);

        Producto::create($request->all());
        return redirect()->route('productos.create')->with('success','Producto creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        return view('productos.editar', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0',
        ]);
    
        $producto->update($request->all());
    
        // Cambia 'productos.update' por 'productos.index'
        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //prueba si se elimina
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
    }
}
