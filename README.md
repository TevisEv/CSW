# INTEGRANTES

- `ALARCON GOMEZ BILY ALEXIS`
- `ESPIRITU VILLAR TEVIS`
- `HORNA CERNA DAYANA ESTEFANY`
- ``
- ``


# Documentación del Script de Generación de CRUD para Laravel

Este documento ofrece una visión detallada de un script de Python diseñado para automatizar la generación de componentes CRUD (Crear, Leer, Actualizar, Eliminar) para aplicaciones Laravel. El script analiza la estructura de una tabla SQL y genera el código necesario para modelos, vistas, controladores, migraciones y rutas.

## Dependencias

El script requiere las siguientes bibliotecas de Python:

- `tkinter` para la interfaz gráfica de usuario (GUI).
- `re` para la manipulación de expresiones regulares.
- `os` y `datetime` para operaciones relacionadas con el sistema de archivos.
- `random` para la generación de números aleatorios necesarios en los nombres de archivos de migración.

## Constantes

El script define dos constantes para el manejo de casillas de verificación en la GUI:

- `CHECKBOX_TICKED`: Representa una casilla marcada.
- `CHECKBOX_UNTICKED`: Representa una casilla desmarcada.

## Funcionalidades Principales

### Pluralización y Análisis de SQL

- **pluralizar(palabra)**: Función que pluraliza sustantivos en español siguiendo reglas básicas.
- **parse_sql_table(sql)**: Analiza un comando `CREATE TABLE` SQL para extraer información relevante como el nombre de la tabla y detalles de campos.

### Generación de Código

- **sql_to_html_input_type(sql_type)**: Mapea tipos de datos SQL a sus equivalentes en tipos de entrada HTML.
- **generar_fields_html(fields, valores_actuales=None)**: Genera fragmentos de código HTML para los campos de formulario.
- **generar_vista_registrar(fields, table_name)**, **generar_vista_listar(fields, table_name, mandatory_fields)**, **generar_vista_editar(fields, table_name)**: Generan vistas Blade para registrar, listar y editar, respectivamente.
- **guardar_vista(table_name, contenido, nombre_archivo)**: Guarda el contenido generado en un archivo.
- **generar_y_guardar_vistas(table_name, fields)**: Coordina la generación y el guardado de todas las vistas Blade necesarias para el CRUD.

### Migración y Rutas

- **generate_controller(table_name, save_path)**: Crea un controlador de Laravel.
- **generate_model(table_name, fields)**: Genera un modelo de Laravel basado en los campos de la tabla.
- **generate_migration_from_sql(sql_schema, save_path=None)**: Convierte una definición de tabla SQL en una migración de Laravel.
- **generate_migration_filename(table_name)**: Genera un nombre de archivo para la migración basado en las convenciones de Laravel.
- **generate_routes()**, **generate_routes_content(table_name, save_path)**: Generan y almacenan las rutas de Laravel necesarias para el CRUD.

### Interacción con la GUI

El script incluye funcionalidades para interactuar con la GUI, permitiendo al usuario modificar y actualizar detalles de los campos a través de la interfaz.

## Configuración de la GUI

Se configura una ventana principal utilizando `tkinter`, donde se alojan varios widgets para la interacción del usuario:

- Área de texto para el comando SQL.
- Botones para procesar el SQL y generar los archivos necesarios.
- Una tabla para mostrar y editar la información de los campos detectados.

Esta herramienta está diseñada para mejorar la eficiencia y precisión en el desarrollo de aplicaciones Laravel, automatizando la creación de componentes básicos basados en la estructura de tablas SQL.

