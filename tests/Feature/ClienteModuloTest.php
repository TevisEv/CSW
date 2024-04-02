<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteModuloTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba la visualización de la lista de clientes.
     */
    public function testVerListaClientes()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/clientes');
        $response->assertStatus(200);
        $response->assertViewIs('clientes.listar');
    }

    /**
     * Prueba la creación de un cliente.
     */
    public function testCrearCliente()
    {
        $user = User::factory()->create();

        $datosCliente = [
            'nombre' => 'Cliente de Prueba',
            // Agrega más datos necesarios para tu prueba
        ];

        $response = $this->actingAs($user)->post('/clientes', $datosCliente);

        $this->assertDatabaseHas('clientes', [
            'nombre' => 'Cliente de Prueba',
            // Verifica los mismos datos aquí
        ]);

        $response->assertRedirect('/clientes');
        $response->assertSessionHas('success', 'Cliente creado exitosamente');
    }

    /**
     * Prueba la actualización de un cliente.
     */
    public function testActualizarCliente()
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create([
            'nombre' => 'Cliente Original',
            // Configura el estado inicial del cliente
        ]);

        $response = $this->actingAs($user)->put("/clientes/{$cliente->id}", [
            'nombre' => 'Cliente Actualizado',
            // Actualiza los datos aquí
        ]);

        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'nombre' => 'Cliente Actualizado',
            // Verifica los datos actualizados
        ]);

        $response->assertRedirect('/clientes');
        $response->assertSessionHas('success', 'Cliente actualizado exitosamente');
    }

    /**
     * Prueba la eliminación de un cliente.
     */
    public function testEliminarCliente()
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create();

        $response = $this->actingAs($user)->delete("/clientes/{$cliente->id}");

        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);

        $response->assertRedirect('/clientes');
        $response->assertSessionHas('success', 'Cliente eliminado exitosamente');
    }
}
