# Documentación del Proyecto

Esta documentación provee una guía detallada para configurar y correr el proyecto, incluyendo cómo ejecutar las pruebas unitarias específicas utilizando `phpunit`.

## Pre-requisitos

Antes de correr el proyecto, asegúrate de tener instalado [Composer](https://getcomposer.org/) y [Node.js](https://nodejs.org/), los cuales son necesarios para instalar las dependencias del proyecto.

## Configuración Inicial

Sigue los siguientes pasos para configurar el entorno del proyecto:

1. **Instalar Dependencias de PHP**:
   Ejecuta `composer install` para instalar las dependencias de PHP necesarias para el proyecto.

2. **Instalar Dependencias de JavaScript**:
   Usa `npm install` para instalar las dependencias necesarias de Node.js.

3. **Configurar Archivo .env**:
   - Renombra el archivo `.env.example` a `.env`.
   - Crea una base de datos en tu sistema de gestión de bases de datos preferido.
   - Edita el archivo `.env` y establece el nombre de tu base de datos en la variable `DB_DATABASE=`.
   - Verifica el puerto en `DB_PORT=3306`. Si no funciona, intenta cambiarlo a `DB_PORT=8889`.
   - Para la seguridad del sitio web, puedes generar un `APP_KEY=` automáticamente con el comando `php artisan key:generate`. Si prefieres establecer uno manualmente, asegúrate de que sea seguro y único.

4. **Migraciones**:
   Ejecuta `php artisan migrate` para realizar las migraciones a la base de datos. Esto estructurará la base de datos según lo definido en tus archivos de migración.

## Pruebas Unitarias

### Ejecutar Todas las Pruebas Unitarias

Para correr todas las pruebas unitarias definidas en tu proyecto, utiliza el siguiente comando:

```
.\vendor\bin\phpunit.bat
```

Esto ejecutará todos los archivos de test disponibles. Es importante tener en cuenta que no se puede controlar específicamente cuáles pruebas se ejecutan con este comando.

### Ejecutar una Prueba Unitaria Específica

Si necesitas ejecutar una prueba específica, por ejemplo, para verificar la funcionalidad de agregar un nuevo cliente, puedes filtrar la ejecución de las pruebas unitarias de la siguiente manera:

```
.\vendor\bin\phpunit.bat --filter test_store_client_invalid_NRODOCUMENTO_return_404
```

Este comando ejecutará solo la prueba unitaria `test_store_client_invalid_NRODOCUMENTO_return_404`, lo cual es útil para enfocarse en una funcionalidad específica.

## Errores y Éxitos Esperados

Durante las pruebas, los siguientes códigos de estado indican resultados esperados:

- **ERRORES**: Se espera recibir un código de estado `422` o `404` en algunos casos. Un código de estado `302` puede aparecer pero generalmente indica manejo de excepciones.
- **ÉXITO**: Un resultado exitoso se indica con un "OK" o un código de estado `200`.