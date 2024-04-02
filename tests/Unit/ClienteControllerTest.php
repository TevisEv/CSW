<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\ClienteController;
use App\Models\Cliente;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

//use Illuminate\Foundation\Http\FormRequest;

class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Resto de tu código...
    }
    /*** A basic unit test example.*/
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /*public function test_store_client_invalid_NRODOCUMENTO_return_500(): void
    {
        // preparion 
        $requestData = [
            'NRODOCUMENTO' => '', // Este campo debe ser requerido
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];
        $request = Request::create('/clientes', 'POST', [
            'NRODOCUMENTO' => '', // Este campo debe ser requerido
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ]);

        $clienteMock = Mockery::mock(new \App\Models\Cliente);
        app()->instance('\App\Models\Cliente', $clienteMock);
        $clienteMock->shouldReceive('create')
            ->once()
            ->with($requestData)
            ->andReturn(true);

        //ejecucion
        $clientController = new ClienteController();
        $response = $clientController->store($request);
        
        // verificacion
        $this->assertEquals(404, $response->getStatusCode());
 
    }*/

    public function test_store_client_invalid_NRODOCUMENTO_return_404(): void
    {
        // Preparación
        $requestData = [
            'NRODOCUMENTO' => '', // Este campo debe ser requerido
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_store_client_missing_NRODOCUMENTO_return_422(): void
    {
        // Preparación: datos sin el campo NRODOCUMENTO
        $requestData = [
            // 'NRODOCUMENTO' está ausente
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_store_client_missing_TIPODOCUMENTO_return_422(): void
    {
        // Preparación: datos sin el campo TIPODOCUMENTO
        $requestData = [
            'NRODOCUMENTO' => '1234567890', // NRODOCUMENTO es válido
            // 'TIPODOCUMENTO' está ausente
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_store_client_missing_RAZONNOMBRE_return_422(): void
    {
        // Preparación: datos sin el campo RAZONNOMBRE
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            // 'RAZONNOMBRE' está ausente
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);
        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);
        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_store_client_empty_RAZONNOMBRE_return_422(): void
    {
        // Preparación: datos con el campo RAZONNOMBRE vacío
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => '', // RAZONNOMBRE vacío
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_store_client_missing_DIASCREDITO_return_422(): void
    {
        // Preparación: datos sin el campo DIASCREDITO
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            // 'DIASCREDITO' está ausente
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_store_client_missing_TIPOCLIENTE_return_422(): void
    {
        // Preparación: datos sin el campo TIPOCLIENTE
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            // 'TIPOCLIENTE' está ausente
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_store_client_empty_TIPOCLIENTE_return_422(): void
    {
        // Preparación: datos con el campo TIPOCLIENTE vacío
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => '', // TIPOCLIENTE vacío
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_store_client_empty_CLAVEWEB_return_422(): void
    {
        // Preparación: datos con el campo CLAVEWEB vacío
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => '', // CLAVEWEB vacío
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_store_client_missing_CLAVEWEB_return_422(): void
    {
        // Preparación: datos sin el campo CLAVEWEB
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            // 'CLAVEWEB' no está presente
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_store_client_valid_FECHANACIMIENTO_return_302(): void
    {
        // Preparación: datos con una fecha de nacimiento válida
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01', // Fecha de nacimiento válida
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera una redirección (código de estado 302)
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_store_client_missing_FECHANACIMIENTO_return_422(): void
    {
        // Preparación: datos sin el campo FECHANACIMIENTO
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            // 'FECHANACIMIENTO' no está presente
            'OCUPACION' => 'Ocupación del cliente',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_store_client_valid_OCUPACION_return_302(): void
    {
        // Preparación: datos con una ocupación válida
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ingeniero', // Ocupación válida
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera una redirección (código de estado 302)
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_store_client_missing_OCUPACION_return_422(): void
    {
        // Preparación: datos sin el campo OCUPACION
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            // 'OCUPACION' no está presente
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_store_client_all_fields_filled_return_redirect(): void
    {
        // Preparación: datos con todos los campos llenados correctamente
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ingeniero',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera una redirección (código de estado 302)
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_store_client_all_fields_filled_return_ok(): void
    {
        // Preparación: datos con todos los campos llenados correctamente
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ingeniero',
        ];

        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecución
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificación: se espera un código de estado 200 (OK)
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_store_client_valid_data(): void
    {
        // Datos válidos para la creación del cliente
        $requestData = [
            'NRODOCUMENTO' => '1234567890',
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://example.com',
            'RAZONNOMBRE' => 'Nombre del cliente',
            'DIASCREDITO' => 30,
            'LIMITECREDITO' => 1000.50,
            'EMAIL' => 'cliente@example.com',
            'TELEFONO' => '123456789',
            'CONTACTO' => 'Contacto del cliente',
            'CLAVEWEB' => 'clave_secreta',
            'TIPOCLIENTE' => 'Tipo del cliente',
            'TIPOORIGEN' => 1,
            'FECHANACIMIENTO' => '1990-01-01',
            'OCUPACION' => 'Ocupación del cliente',
        ];

        // Crear una instancia de Request con los datos de cliente válidos
        $request = Request::create('/clientes', 'POST', $requestData);

        // Ejecutar el método store del controlador
        $clientController = new ClienteController();
        $response = $clientController->store($request);

        // Verificar que la respuesta sea una redirección exitosa
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);

        // Verificar que se redirige a la ruta correcta
        $this->assertEquals(route('clientes.create'), $response->getTargetUrl());

        // Opcional: Verificar que se establece un mensaje de éxito en la sesión
        $this->assertNotNull(session('success'));
    }

    public function test_update_client_invalid_data(): void
    {
        $cliente = Cliente::factory()->create();

        $updatedData = [
            'NRODOCUMENTO' => '', // Este campo debe ser requerido
            'TIPODOCUMENTO' => 'DNI',
            'LINK' => 'http://updated-example.com',
            'RAZONNOMBRE' => 'Nombre del cliente actualizado',
            'DIASCREDITO' => 15,
            'LIMITECREDITO' => 2000.75,
            'EMAIL' => 'cliente@updated-example.com',
            'TELEFONO' => '987654321',
            'CONTACTO' => 'Contacto del cliente actualizado',
            'CLAVEWEB' => 'nueva_clave_secreta',
            'TIPOCLIENTE' => 'Nuevo tipo de cliente',
            'TIPOORIGEN' => 2,
            'FECHANACIMIENTO' => '1980-01-01',
            'OCUPACION' => 'Nueva ocupación del cliente',
        ];

        $request = Request::create("/clientes/{$cliente->id}", 'PUT', $updatedData);

        $clientController = new ClienteController();

        $response = $clientController->update($request, $cliente);

        $this->assertEquals(500, $response->getStatusCode());
    }


    // Prueba unitaria para actualizar un cliente omitiendo el campo NRODOCUMENTO
    public function test_update_client_missing_NRODOCUMENTO_return_error(): void
    {
        // Preparación: datos con el campo NRODOCUMENTO omitido
        $cliente = new Cliente();
        // Completa los demás campos del cliente según sea necesario
        $cliente->save();
        $requestData = $cliente->toArray();
        unset($requestData['NRODOCUMENTO']); // Omitir el campo NRODOCUMENTO
        $request = $this->put("/clientes/{$cliente->id}", $requestData);
        // Ejecución
        $response = $this->call('PUT', "/clientes/{$cliente->id}", $requestData);
        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    // Prueba unitaria para actualizar un cliente con un valor vacío en el campo RAZONNOMBRE
    public function test_update_client_empty_RAZONNOMBRE_return_error(): void
    {
        // Preparación: datos con el campo RAZONNOMBRE vacío
        $cliente = new Cliente();
        // Completa los demás campos del cliente según sea necesario
        $cliente->RAZONNOMBRE = ''; // Campo RAZONNOMBRE vacío
        $cliente->save();
        $requestData = $cliente->toArray();
        $request = $this->put("/clientes/{$cliente->id}", $requestData);
        // Ejecución
        $response = $this->call('PUT', "/clientes/{$cliente->id}", $requestData);
        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_update_client_all_fields_filled_return_200(): void
    {
        // Preparación: datos con todos los campos llenados correctamente para la actualización
        $cliente = new Cliente();
        $cliente->NRODOCUMENTO = '1234567890';
        $cliente->TIPODOCUMENTO = 'DNI';
        $cliente->LINK = 'http://example.com';
        $cliente->RAZONNOMBRE = 'Nuevo nombre del cliente';
        $cliente->DIASCREDITO = 30;
        $cliente->LIMITECREDITO = 1000.50;
        $cliente->EMAIL = 'nuevo_cliente@example.com';
        $cliente->TELEFONO = '987654321';
        $cliente->CONTACTO = 'Nuevo contacto del cliente';
        $cliente->CLAVEWEB = 'nueva_clave_secreta';
        $cliente->TIPOCLIENTE = 'Nuevo tipo del cliente';
        $cliente->TIPOORIGEN = 2;
        $cliente->FECHANACIMIENTO = '1985-05-15';
        $cliente->OCUPACION = 'Arquitecto';
        $cliente->DIRECCION = 'Nueva dirección del cliente';
        $cliente->REFERENCIA = 'Nueva referencia del cliente';
        $cliente->DNIFAMILIAR = '123456789012';
        $cliente->TELEFONOCONTACTO = '9876543210';
        $cliente->FECULTIMACOMPRA = '2023-04-01';
        $cliente->DOCULTIMACOMPRA = 'ABC123';
        $cliente->PORCENTAJE_DESCUENTO = 15.5;
        $cliente->PORCENTAJE_MORA = 5.25;
        $cliente->save();

        $requestData = $cliente->toArray();

        $response = $this->put("/clientes/{$cliente->id}", $requestData);

        // Verificación: se espera una redirección (código de estado 302) ya que el controlador redirige después de la actualización
        $response->assertStatus(Response::HTTP_FOUND);
    }

    // Prueba unitaria para actualizar un cliente omitiendo el campo NRODOCUMENTO
    public function test_update_client_missing_NRODOCUMENTO_return_500(): void
    {
        // Preparación: crear un cliente sin el campo NRODOCUMENTO
        $cliente = new Cliente();
        // Configurar otros campos del cliente según sea necesario
        $cliente->save();
        $requestData = $cliente->toArray();
        unset($requestData['NRODOCUMENTO']); // Omitir el campo NRODOCUMENTO
        $response = $this->put("/clientes/{$cliente->id}", $requestData);
        // Verificación: se espera un código de estado 422 (Unprocessable Entity)
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
