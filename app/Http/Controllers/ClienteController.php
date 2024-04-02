<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class ClienteController extends Controller{
    /*Display a listing of the resource.*/
    public function index(){
        $clientes = Cliente::orderBy('RAZONNOMBRE', 'asc')->paginate(6);
        return view('clientes.listar', compact('clientes'));
    }

    /*Show the form for creating a new resource.*/
    public function create(){
        return view('clientes.registrar');
    }

    /*Store a newly created resource in storage.*/
    public function store(Request $request){
        $validated = Validator::make($request->all(),[
            'NRODOCUMENTO' => 'required|string|max:12',
            'TIPODOCUMENTO' => 'required|string|max:2',
            'LINK' => 'nullable|string|max:36',
            'RAZONNOMBRE' => 'required|string|max:255',
            'DIASCREDITO' => 'nullable|integer|min:0',
            'LIMITECREDITO' => 'nullable|numeric|min:0',
            'EMAIL' => 'nullable|email|max:64',
            'TELEFONO' => 'nullable|string|max:48',
            'CONTACTO' => 'nullable|string|max:64',
            'CLAVEWEB' => 'nullable|string|max:16',
            'TIPOCLIENTE' => 'nullable|string|max:64',
            'TIPOORIGEN' => 'nullable|integer',
            'FECHANACIMIENTO' => 'nullable|date',
            'OCUPACION' => 'nullable|string|max:128',
            'DIRECCION' => 'nullable|string|max:250',
            'REFERENCIA' => 'nullable|string|max:250',
            'DNIFAMILIAR' => 'nullable|string|max:12',
            'TELEFONOCONTACTO' => 'nullable|string|max:16',
            'FECULTIMACOMPRA' => 'nullable|date',
            'DOCULTIMACOMPRA' => 'nullable|string|max:18',
            'PORCENTAJE_DESCUENTO' => 'nullable|numeric|min:0|max:100',
            'PORCENTAJE_MORA' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validated->fails()) {
            return response()->json(['error' => $validated->errors()], Response::HTTP_NOT_FOUND);
        }
        Cliente::create($request->all());
        return redirect()->route('clientes.create')->with('success', 'Cliente creado con éxito.');
    }

    /*Display the specified resource.*/
    public function show(Cliente $cliente){
    }

    /*Show the form for editing the specified resource.*/
    public function edit(Cliente $cliente){
        return view('clientes.editar', compact('cliente'));
    }

    /*Update the specified resource in storage.*/
    public function update(Request $request, Cliente $cliente){
        $validated = Validator::make($request->all(),[
            'NRODOCUMENTO' => 'required|string|max:12',
            'TIPODOCUMENTO' => 'required|string|max:2',
            'LINK' => 'nullable|string|max:36',
            'RAZONNOMBRE' => 'required|string|max:255',
            'DIASCREDITO' => 'nullable|integer|min:0',
            'LIMITECREDITO' => 'nullable|numeric|min:0',
            'EMAIL' => 'nullable|email|max:64',
            'TELEFONO' => 'nullable|string|max:48',
            'CONTACTO' => 'nullable|string|max:64',
            'CLAVEWEB' => 'nullable|string|max:16',
            'TIPOCLIENTE' => 'nullable|string|max:64',
            'TIPOORIGEN' => 'nullable|integer',
            'FECHANACIMIENTO' => 'nullable|date',
            'OCUPACION' => 'nullable|string|max:128',
            'DIRECCION' => 'nullable|string|max:250',
            'REFERENCIA' => 'nullable|string|max:250',
            'DNIFAMILIAR' => 'nullable|string|max:12',
            'TELEFONOCONTACTO' => 'nullable|string|max:16',
            'FECULTIMACOMPRA' => 'nullable|date',
            'DOCULTIMACOMPRA' => 'nullable|string|max:18',
            'PORCENTAJE_DESCUENTO' => 'nullable|numeric|min:0|max:100',
            'PORCENTAJE_MORA' => 'nullable|numeric|min:0|max:100',
        ]);
        if ($validated->fails()) {
            return response()->json(['error' => $validated->errors()], Response::HTTP_NOT_FOUND);
        }
        $cliente->update($request->all());
        return redirect()->route('clientes.index')->with('success', 'Producto actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito.');
    }
}