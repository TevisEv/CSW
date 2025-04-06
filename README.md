
# INTEGRANTES

- `ALARCON GOMEZ BILY ALEXIS`
- `ESPIRITU VILLAR TEVIS`
- `HORNA CERNA DAYANA ESTEFANY`
- `HURTADO MILIAN JEAN HARLEY`
- `DURAND PALACIOS ABIGAIL`
     

# Documentación del Generador de CRUD para Laravel

Esta aplicación en Python está diseñada para automatizar la generación de operaciones CRUD (Crear, Leer, Actualizar, Eliminar) en proyectos Laravel. Permite a los usuarios introducir definiciones de esquemas SQL y genera archivos correspondientes de modelo, migración, controlador y vistas en Laravel, así como definiciones de rutas. Adicionalmente, ofrece una interfaz gráfica de usuario (GUI) para una interacción más sencilla.

## Características

- Análisis de sentencias SQL `CREATE TABLE` para extraer la estructura de la tabla.
- Generación de archivos de modelo Laravel basados en el esquema SQL.
- Creación de archivos de migración Laravel con definiciones de esquema.
- Generación de archivos de controlador Laravel con operaciones CRUD.
- Creación de archivos de vista Blade Laravel para operaciones de registro, listado y edición.
- Generación automática de rutas web para las operaciones CRUD.
- GUI para una interacción fácil y operativa.

## Requisitos

- Python 3.x
- Biblioteca Tkinter para la GUI.
- Conocimientos básicos de SQL y el framework Laravel.

## Descripción de la Interfaz Gráfica

La interfaz de la aplicación incluye:

- **Área de Sentencia SQL**: Un área de texto donde puedes pegar tu sentencia SQL `CREATE TABLE`.
- **Botón Procesar SQL**: Procesa la entrada SQL para extraer detalles de la tabla.
- **Visualización de Campos**: Muestra los campos extraídos de la sentencia SQL, permitiendo alternar propiedades como clave primaria, nullable y obligatorio haciendo clic.
- **Botones de Operaciones CRUD**: Botones para generar archivos CRUD, modelo, controlador, migración y rutas para la aplicación Laravel.

## Uso

1. **Inicio de la Aplicación**: Inicia la aplicación. Debería aparecer la GUI.
2. **Introducir Esquema SQL**: Pega tu sentencia SQL `CREATE TABLE` en el área designada.
**Ejemplo de tablas**: 

`TABLA CLIENTE`

CREATE TABLE CLIENTE
(
  NRODOCUMENTO Varchar(12) NOT NULL,
  TIPODOCUMENTO Varchar(2),
  LINK Varchar(36),
  RAZONNOMBRE Varchar(255),
  DIASCREDITO Smallint,
  LIMITECREDITO Numeric(16,6),
  EMAIL Varchar(64),
  TELEFONO Varchar(48),
  CONTACTO Varchar(64),
  CLAVEWEB Varchar(16),
  TIPOCLIENTE Varchar(64),
  TIPOORIGEN Smallint,
  FECHANACIMIENTO Date,
  OCUPACION Varchar(128),
  DIRECCION Varchar(250),
  REFERENCIA Varchar(250),
  DNIFAMILIAR Varchar(12),
  TELEFONOCONTACTO Varchar(16),
  FECULTIMACOMPRA Date,
  DOCULTIMACOMPRA Varchar(18),
  PORCENTAJE_DESCUENTO Numeric(16,2),
  PORCENTAJE_MORA Numeric(16,2),
  PRIMARY KEY (NRODOCUMENTO)
);

`TABLA PROVEEDOR`

CREATE TABLE PROVEEDOR
(
  RUC Varchar(12) NOT NULL,
  RAZONSOCIAL Varchar(256),
  DIASCREDITO Integer,
  CODCUENTA Varchar(18),
  LIMITECREDITO Numeric(16,6),
  CUENTABANCARIA Varchar(64),
  SERIE Varchar(6),
  DIRECCION Varchar(128),
  EMAIL Varchar(36),
  TELEFONO Varchar(16),
  CONTACTO Varchar(64),
  FECHA Date,
  PRIMARY KEY (RUC)
);


3. **Procesar SQL**: Haz clic en "Procesar SQL" para extraer los detalles de la tabla. Los campos y sus propiedades se mostrarán.
4. **Revisar y Editar Campos**: Haz clic en las propiedades de los campos para alternarlas. Haz doble clic en tipo o tamaño para editar los valores.
5. **Generar Archivos**:
   - **Vistas Blade de Laravel (archivos de vista)**: En la generación de las vistas Blade de Laravel para operaciones CRUD, particularmente en el archivo `listar.blade.php`, se utiliza el atributo `mandatory` para determinar qué campos deben mostrarse en la vista de listado. Solo los campos marcados como `mandatory` son incluidos en la tabla de listado, lo que significa que estos campos son considerados esenciales o importantes para ser mostrados a los usuarios cuando visualizan la lista de registros de la base de datos.
    - **Controlador de Laravel**: Aunque el código para la generación del controlador en sí no se muestra en el fragmento proporcionado, el atributo `mandatory` puede influir en la validación dentro de los métodos del controlador. Por ejemplo, al crear o actualizar registros en la base de datos, los campos marcados como `mandatory` podrían requerirse en la validación, asegurando que los datos esenciales sean proporcionados antes de que la operación CRUD se realice efectivamente.
    - **Modelo de Laravel**:  Crea un modelo Laravel con atributos basados en el esquema SQL.
    - **Migración de Laravel**:  Crea un archivo de migración Laravel para el esquema de la base de datos.
    - **Rutas web de Laravel**: Genera rutas web para las operaciones CRUD.

## Funciones Adicionales

- **Excepciones Personalizadas**: Define `SQLParsingError` para manejar excepciones de análisis SQL.
- **Pluralización y Conversión de Tipo de Entrada HTML**: Funciones para manejar la pluralización de sustantivos en español y la conversión de tipos de datos SQL a tipos de entrada HTML.
- **Generación y Guardado de Archivos**: Funciones para generar el contenido de archivos de modelo, controlador, migración y vistas y guardarlos en el directorio seleccionado por el usuario.


