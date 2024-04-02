<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ProductoTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanViewProductList()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/productos');
        $response->assertStatus(200);
    }

    public function testUsersCanAccessCreateProductForm()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/productos/create');
        $response->assertStatus(200);
    }

    public function testUsersCanCreateNewProduct()
    {
        $user = User::factory()->create();
        $productData = [
            'nombre' => 'Producto de Prueba',
            'precio' => 10.00,
        ];
        $response = $this->actingAs($user)->post('/productos', $productData);
        $this->assertDatabaseHas('productos', $productData);
        $response->assertRedirect('/productos');
    }

    public function testUsersCanAccessEditProductForm()
    {
        $user = User::factory()->create();
        $product = Producto::factory()->create();
        $response = $this->actingAs($user)->get("/productos/{$product->id}/edit");
        $response->assertStatus(200);
    }

    public function testUsersCanDeleteAProduct()
    {
        $user = User::factory()->create();
        $product = Producto::factory()->create();
        $response = $this->actingAs($user)->delete("/productos/{$product->id}");
        $this->assertDatabaseMissing('productos', ['id' => $product->id]);
        $response->assertRedirect('/productos');
    }
}