
import tkinter as tk
from tkinter import ttk, filedialog, messagebox, simpledialog
import re
import os
import datetime
import inflect
import random

# Definición de las constantes para las casillas de verificación
CHECKBOX_TICKED = "☑"
CHECKBOX_UNTICKED = "☐"


def pluralizar(palabra):
    if palabra.endswith(('a', 'e', 'i', 'o', 'u')):
        return palabra + 's'
    elif palabra.endswith('z'):
        return palabra[:-1] + 'ces'
    elif palabra.endswith('ión'):
        return palabra[:-3] + 'iones'
    elif palabra.endswith(('r', 'l', 'n', 'd')):
        return palabra + 'es'
    else:
        return palabra + 'es'


def parse_sql_table(sql):
    table_pattern = re.compile(r"CREATE TABLE (\w+)", re.IGNORECASE)
    table_match = table_pattern.search(sql)
    table_name = table_match.group(1) if table_match else 'unknown'
    field_pattern = re.compile(
        r"(\w+)\s+(\w+)(\(\d+(,\d+)?\))?\s*(NOT NULL)?", re.IGNORECASE)
    pk_pattern = re.compile(r"PRIMARY KEY\s*\((.*?)\)", re.IGNORECASE)

    fields = []
    for match in field_pattern.finditer(sql):
        if match.group(2).upper() in ["TABLE", "KEY"]:
            continue
        fields.append({
            "name": match.group(1),
            "type": match.group(2),
            "size": match.group(3).strip("()") if match.group(3) else "",
            "nullable": not bool(match.group(5)),
            "primary_key": False,
            "mandatory": True  # Inicialmente, todos los campos son obligatorios
        })

    pk_match = pk_pattern.search(sql)
    if pk_match:
        pk_fields = {pk_field.strip()
                     for pk_field in pk_match.group(1).split(",")}
        for field in fields:
            if field["name"] in pk_fields:
                field["primary_key"] = True

    return table_name, fields

def sql_to_html_input_type(sql_type):

    mapping = {
        'varchar': 'text',
        'int': 'number',
        'bigint': 'number',
        'float': 'number',
        'double': 'number',
        'decimal': 'number',
        'date': 'date',
        'datetime': 'datetime-local',
        'timestamp': 'datetime-local',
        'boolean': 'checkbox',  # Este requerirá lógica especial si se usa
    }
    return mapping.get(sql_type.lower(), 'text')

def generar_fields_html(fields, valores_actuales=None):
    html = ""
    for i in range(0, len(fields), 2):  # Dividir los campos en pasos de dos
        html += '    <div class="row">\n'  # Abrir un nuevo div row
        # Iterar a través del par actual de campos (o solo uno si es el último y es impar)
        for field in fields[i:i+2]:
            field_label = field.get("label", field['name'].capitalize())
            field_placeholder = field.get(
                "placeholder", field['name'].capitalize())
            html_input_type = sql_to_html_input_type(field["type"])

            # Manejar valores pre-populados si se proporcionan
            current_value = valores_actuales.get(
                field["name"], "") if valores_actuales else ""

            # Agregar el atributo 'value' a la etiqueta de entrada si se proporciona current_value
            if current_value:
                html += f'        <x-adminlte-input name="{field["name"]}" label="{field_label}" placeholder="{field_placeholder}" value="{current_value}" fgroup-class="col-md-6" disable-feedback type="{html_input_type}"/>\n'
            else:
                html += f'        <x-adminlte-input name="{field["name"]}" label="{field_label}" placeholder="{field_placeholder}" fgroup-class="col-md-6" disable-feedback type="{html_input_type}"/>\n'
        html += '    </div>\n'  # Cerrar el div row

    return html

def generar_vista_registrar(fields, table_name):
    fields_html = generar_fields_html(fields)
    return f"""@extends('adminlte::page')

@section('title', 'Registrar {table_name.capitalize()}')

@section('content_header')
    <h1 class="m-0 text-dark">Registrar {table_name.capitalize()}</h1>
@stop

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Error</strong> Hubo problemas con los datos ingresados<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{{{
{'$error'} }}}}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success mt-2">
        <strong>{{{{ Session::get('success') }}}}</strong>
    </div>
@endif

<form action="{{{{ route('{pluralizar(table_name)}.store') }}}}" method="POST" autocomplete="off">
    @csrf
{fields_html}

    <x-adminlte-button class="btn-flat" type="submit" label="Registrar" theme="success" icon="fas fa-lg fa-save"/>
</form>
@stop
"""

def generar_vista_listar(fields, table_name, mandatory_fields):
    columnas = ''.join(
        [f"                <th>{field.get('label', field['name'].capitalize())}</th>\n" for field in fields if field['name'] in mandatory_fields])
    fields_data = ''.join(
        [f"                <td>{{{{ ${table_name}->{field['name']} }}}}</td>\n" for field in fields if field['name'] in mandatory_fields])
    # Asegúrate de que pluralizar maneje tus reglas de pluralización específicas correctamente.
    table_name_plural = pluralizar(table_name)
    return f"""
@extends('adminlte::page')
@section('title', 'Listado de {table_name.capitalize()}')

@section('content_header')
    <h1 class="m-0 text-dark">Listado de {table_name_plural.capitalize()}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{table_name_plural.capitalize()} Registrados</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="{table_name_plural}" class="table table-bordered table-striped">
                <thead>
                    <tr>
{columnas}                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (${table_name_plural} as ${table_name})
                        <tr>
{fields_data}                            <td>
                                <a href="{{{{ route('{table_name_plural}.edit', ${table_name}->id) }}}}" class="btn btn-xs btn-primary">Editar</a>
                                <form action="{{{{ route('{table_name_plural}.destroy', ${table_name}->id) }}}}" method="POST" style="display: inline-block;">
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
       {{{{ ${table_name_plural}->links() }}}}
    </div>
@stop
"""

def generar_vista_editar(fields, table_name):
    # Simula valores actuales como un diccionario vacío por ahora
    # Este diccionario debería llenarse con los valores actuales de cada campo si están disponibles
    valores_actuales = {}
    fields_html = generar_fields_html(fields, valores_actuales)
    table_name_plural = pluralizar(table_name)
    return f"""@extends('adminlte::page')

@section('title', 'Editar {table_name.capitalize()}')

@section('content_header')
    <h1 class="m-0 text-dark">Editar {table_name.capitalize()}</h1>
@stop

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Error</strong> Hubo problemas con los datos ingresados<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{{{ $error }}}}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success mt-2">
        <strong>{{{{ session('success') }}}}</strong>
    </div>
@endif

<form action="{{{{ route('{table_name_plural}.update', ${table_name}->id) }}}}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
{fields_html}

    <x-adminlte-button class="btn-flat" type="submit" label="Actualizar" theme="success" icon="fas fa-lg fa-save"/>
</form>
@stop
"""

def guardar_vista(table_name, contenido, nombre_archivo):
    nombre_carpeta_plural = pluralizar(table_name)
    # Ajusta la ruta base según necesites
    ruta_carpeta = os.path.join(nombre_carpeta_plural)

    # Crear la carpeta si no existe
    if not os.path.exists(ruta_carpeta):
        os.makedirs(ruta_carpeta)

    ruta_archivo = os.path.join(ruta_carpeta, nombre_archivo)
    with open(ruta_archivo, 'w') as archivo:
        archivo.write(contenido)
    print(f"Archivo {nombre_archivo} guardado en {ruta_carpeta}/")

def generar_y_guardar_vistas(table_name, fields):
    # Identificar los campos marcados como obligatorios
    mandatory_fields = [field['name'] for field in fields if field.get('mandatory', False)]

    # Generar contenido de las vistas
    contenido_registrar = generar_vista_registrar(fields, table_name)
    contenido_listar = generar_vista_listar(fields, table_name, mandatory_fields)
    contenido_editar = generar_vista_editar(fields, table_name)

    # Guardar las vistas
    guardar_vista(table_name, contenido_registrar, "registrar.blade.php")
    guardar_vista(table_name, contenido_listar, "listar.blade.php")
    guardar_vista(table_name, contenido_editar, "editar.blade.php")

def request_directory_and_create_files(table_name, fields):
    # Solicitar al usuario que seleccione el directorio donde guardar los archivos
    root = tk.Tk()
    root.withdraw()  # No queremos una ventana de TK completa, solo el diálogo
    save_path = filedialog.askdirectory()  # Abre el diálogo para elegir carpeta
    if not save_path:  # Si el usuario cancela la selección
        messagebox.showerror("Error", "No folder selected.")
        return

    # Generar y guardar las vistas HTML para el CRUD
    generar_y_guardar_vistas(table_name, fields)

    messagebox.showinfo("Success", "CRUD files generated successfully.")

def generate_controller(table_name, save_path):
    controller_content = f"""<?php

namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use App\\Models\\{table_name.capitalize()};

class {table_name.capitalize()}Controller extends Controller
{{
    public function index()
    {{
        ${table_name.lower()}s = {table_name.capitalize()}::all();
        return view('{table_name.lower()}s.listar', compact('{table_name.lower()}s'));
    }}

    public function create()
    {{
        return view('{table_name.lower()}s.registrar');
    }}

    public function store(Request $request)
    {{
        ${table_name.lower()} = new {table_name.capitalize()}($request->all());
        ${table_name.lower()}->save();

        return redirect()->route('{table_name.lower()}s.create')->with('success', '{table_name.capitalize()} creado exitosamente');
    }}

    public function show($id)
    {{
        ${table_name.lower()} = {table_name.capitalize()}::findOrFail($id);
        return view('{table_name.lower()}s.show', compact('{table_name.lower()}'));
    }}

    public function edit($id)
    {{
        ${table_name.lower()} = {table_name.capitalize()}::findOrFail($id);
        return view('{table_name.lower()}s.editar', compact('{table_name.lower()}'));
    }}

    public function update(Request $request, $id)
    {{
        ${table_name.lower()} = {table_name.capitalize()}::findOrFail($id);
        ${table_name.lower()}->update($request->all());

        return redirect()->route('{table_name.lower()}s.index')->with('success', '{table_name.capitalize()} actualizado exitosamente');
    }}

    public function destroy($id)
    {{
        ${table_name.lower()} = {table_name.capitalize()}::findOrFail($id);
        ${table_name.lower()}->delete();

        return redirect()->route('{table_name.lower()}s.index')->with('success', '{table_name.capitalize()} eliminado exitosamente');
    }}
}}
"""
    if not save_path.endswith('/'):
        save_path += '/'
    file_path = f"{save_path}{table_name.capitalize()}Controller.php"
    with open(file_path, 'w') as f:
        f.write(controller_content)
    messagebox.showinfo("Controller Created",
                        f"Controller created at: '{file_path}'")

def create_controller(table_name):
    if table_name and table_name != 'unknown':
        root = tk.Tk()
        root.withdraw()  # No queremos una ventana de TK completa, solo el diálogo
        save_path = filedialog.askdirectory()  # Abre el diálogo para elegir carpeta
        if save_path:  # Asegurarse de que el usuario no canceló el diálogo
            generate_controller(table_name, save_path)
        else:
            messagebox.showerror("Error", "No folder selected.")
    else:
        messagebox.showerror(
            "Error", "No valid table name found. Please check your input.")

def generate_model(table_name, fields):
    # Solicita al usuario que seleccione la ruta de guardado
    root = tk.Tk()
    root.withdraw()  # No queremos una ventana de TK completa, solo el diálogo
    save_path = filedialog.askdirectory()  # Abre el diálogo para elegir carpeta

    if not save_path:  # Si el usuario canceló el diálogo
        messagebox.showerror("Error", "No folder selected.")
        return  # Sale de la función sin hacer nada más

    if not os.path.exists(save_path):
        os.makedirs(save_path)
    fillable = [f"'{field['name']}'" for field in fields if not field.get(
        'primary_key', False)]
    model_content = f"""<?php

namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Database\\Eloquent\\Model;

class {table_name.capitalize()} extends Model
{{
    use HasFactory;

    protected $table = '{table_name.lower()}';

    public $timestamps = false;

    protected $fillable = [
        {', '.join(fillable)}
    ];

    protected $guarded = [];
}}
"""
    # Escribe el contenido en el archivo en la ruta seleccionada
    file_path = os.path.join(save_path, f'{table_name.capitalize()}.php')
    with open(file_path, 'w') as file:
        file.write(model_content)
    messagebox.showinfo("Model Generated",
                        f"Model file generated at: '{file_path}'")

def sql_to_laravel_type(sql_type):
    type_mapping = {
        'varchar': 'string',
        'integer': 'integer',
        'smallint': 'smallInteger',
        'numeric': 'decimal',
        'date': 'date'
    }
    match = re.match(r"(\w+)(?:\((\d+)(?:,(\d+))?\))?",
                     sql_type, re.IGNORECASE)
    if match:
        sql_data_type, size, decimal_place = match.groups()
        laravel_type = type_mapping.get(sql_data_type.lower(), 'string')
        if laravel_type == 'decimal' and decimal_place:
            return laravel_type, size, decimal_place
        elif size:
            return laravel_type, size, None
        else:
            return laravel_type, None, None
    else:
        return 'string', None, None

def generate_migration_from_sql(sql_schema, save_path=None):
    lines = sql_schema.strip().split('\n')
    table_name_match = re.search(
        r"CREATE TABLE (\w+)", lines[0], re.IGNORECASE)
    if not table_name_match:
        print("No valid CREATE TABLE statement found.")
        return "", []
    table_name = table_name_match.group(1)

    fields = lines[1:-1]
    migration_fields = ""
    for field in fields:
        if not re.match(r"^\s*\w", field):
            continue

        field_parts = re.split(r"\s+", field.strip().strip(','), maxsplit=2)
        if len(field_parts) < 2:
            print(f"Skipping invalid field definition: {field}")
            continue

        field_name, field_type = field_parts[:2]
        laravel_type, size, decimal_place = sql_to_laravel_type(field_type)

        nullable = '->nullable()' if 'NOT NULL' not in field else ''
        primary = '->primary()' if 'PRIMARY KEY' in field else ''

        if size and decimal_place:  # Para tipos como decimal que tienen dos parámetros numéricos
            migration_fields += f"$table->{laravel_type}('{field_name}', {size}, {decimal_place}){nullable}{primary};\n            "
        elif size:  # Para tipos que tienen un parámetro numérico
            migration_fields += f"$table->{laravel_type}('{field_name}', {size}){nullable}{primary};\n            "
        else:  # Para tipos sin parámetro numérico
            migration_fields += f"$table->{laravel_type}('{field_name}'){nullable}{primary};\n            "

    migration_content = f"""<?php

use Illuminate\\Support\\Facades\\Schema;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Database\\Migrations\\Migration;

class Create{pluralizar(table_name.capitalize())}Table extends Migration
{{
    public function up()
    {{
        Schema::create('{pluralizar(table_name.lower())}', function (Blueprint $table) {{
            {migration_fields}
        }});
    }}

    public function down()
    {{
        Schema::dropIfExists('{pluralizar(table_name.lower())}');
    }}
}}
"""
    return migration_content

def generate_migration_filename(table_name):
    # Obtener la fecha y hora actuales con el formato de Laravel para nombres de archivos de migración
    timestamp = datetime.datetime.now().strftime('%Y_%m_%d_')
    # Generar un ID aleatorio de seis dígitos
    random_id = f"{random.randint(100000, 999999):06d}"

    # Usar la función de pluralización personalizada para español
    plural_table_name = pluralizar(table_name.lower())

    return f"{timestamp}{random_id}_create_{plural_table_name}_table.php"

def generate_migration_only():
    save_path = filedialog.askdirectory()
    if save_path:
        sql_schema = sql_input_text.get("1.0", tk.END)
        # Aquí se corrige el desempaquetado para esperar solo un valor
        migration_content = generate_migration_from_sql(sql_schema)
        table_name = re.search(r"CREATE TABLE (\w+)",
                               sql_schema, re.IGNORECASE).group(1)
        migration_filename = generate_migration_filename(table_name)
        file_path = os.path.join(save_path, migration_filename)
        with open(file_path, 'w') as f:
            f.write(migration_content)
        messagebox.showinfo(
            "Migration Generated", f"Migration file has been generated at: '{file_path}'")

def write_to_file(filename, content, save_path):
    file_path = os.path.join(save_path, filename)
    with open(file_path, 'w') as file:
        file.write(content)
    messagebox.showinfo(
        "File Generated", f"File {filename} has been generated at: '{file_path}'")

def generate_routes():
    global table_name
    save_path = filedialog.askdirectory()
    if save_path and table_name:
        generate_routes_content(table_name, save_path)

def generate_routes_content(table_name, save_path):
    routes_content = f"""<?php

use App\Http\Controllers\{table_name.capitalize()}Controller;
use Illuminate\\Support\\Facades\\Route;

// routes\web.php (ruta para colocar el codigo solo copias y pega en el archivo)

Route::get('/', function () {{
    return view('welcome');
}});

Auth::routes();

Route::get('/home', [App\\Http\\Controllers\\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {{
    return view('home');
}})->name('home')->middleware('auth');

Route::resource('/{pluralizar(table_name.lower())}', {table_name.capitalize()}Controller::class)->name('home','')->middleware('auth');
"""
    write_to_file('web.php', routes_content, save_path)

def toggle_value(item, index, values_list):
    item_list = list(item)
    current_value = item_list[index]
    item_list[index] = values_list[1] if current_value == values_list[0] else values_list[0]
    return item_list

def on_field_click(event):
    region = fields_table.identify_region(event.x, event.y)
    if region == 'cell':
        col = fields_table.identify_column(event.x)
        row_id = fields_table.identify_row(event.y)
        col_num = int(col.strip('#')) - 1
        if col_num in [3, 4, 5]:  # Permitir cambiar estas columnas
            item = fields_table.item(row_id, 'values')
            item_list = toggle_value(
                item, col_num, [CHECKBOX_TICKED, CHECKBOX_UNTICKED])
            fields_table.item(row_id, values=item_list)
            update_field_data(row_id, col_num, item_list[col_num])
    elif region == 'heading':
        return "break"

def update_field_data(row_id, col_index, value):
    field_name = fields_table.item(row_id, 'values')[0]
    field_info = next(
        (field for field in fields if field['name'] == field_name), None)
    if field_info:
        if col_index == 3:
            field_info['primary_key'] = (value == CHECKBOX_TICKED)
        elif col_index == 4:
            field_info['nullable'] = (value == CHECKBOX_TICKED)
        elif col_index == 5:
            field_info['mandatory'] = (value == CHECKBOX_TICKED)

def edit_field_details(event):
    region = fields_table.identify_region(event.x, event.y)
    if region != 'cell':
        return
    col = fields_table.identify_column(event.x)
    row_id = fields_table.identify_row(event.y)
    col_num = int(col.strip('#')) - 1
    if col_num == 1 or col_num == 2:  # Permite editar Type o Size
        item = fields_table.item(row_id, 'values')
        field_name = fields_table.item(row_id, 'values')[0]
        new_value = simpledialog.askstring(
            "Edit Value", f"Enter new value for {field_name}:", parent=app)
        if new_value is not None:
            item_list = list(item)
            item_list[col_num] = new_value
            fields_table.item(row_id, values=item_list)
            update_field_data_type_size(row_id, col_num, new_value)

def update_field_data_type_size(row_id, col_num, value):
    field_name = fields_table.item(row_id, 'values')[0]
    field_info = next(
        (field for field in fields if field['name'] == field_name), None)
    if field_info:
        if col_num == 1:  # Type
            field_info['type'] = value
        elif col_num == 2:  # Size
            field_info['size'] = value

def process_sql_and_update():
    sql = sql_input_text.get("1.0", tk.END)
    global table_name, fields
    table_name, fields = parse_sql_table(sql)
    load_fields_into_ui(fields)

def load_fields_into_ui(fields):
    for i in fields_table.get_children():
        fields_table.delete(i)
    for field in fields:
        fields_table.insert('', 'end', values=(
            field['name'],
            field['type'],
            field['size'],
            CHECKBOX_TICKED if field['primary_key'] else CHECKBOX_UNTICKED,
            CHECKBOX_TICKED if field['nullable'] else CHECKBOX_UNTICKED,
            CHECKBOX_TICKED if field['mandatory'] else CHECKBOX_UNTICKED
        ))



# GUI setup
app = tk.Tk()
app.title("CRUD Generator for Laravel")

# Definir los estilos para los botones con colores personalizados
style = ttk.Style()
style.configure('Pastel.TButton', borderwidth=0, width=20)

style.configure('Button1.TButton', background='#47E72E')  
style.configure('Button2.TButton', background='#87CEEB') 
style.configure('Button3.TButton', background='#87CEEB')  
style.configure('Button4.TButton', background='#FFD700')  

# SQL input area
sql_input_frame = tk.Frame(app)
sql_input_frame.pack(fill='x', padx=10, pady=10)
sql_input_label = tk.Label(sql_input_frame, text="SQL Statement:")
sql_input_label.pack(side='left')
sql_input_text = tk.Text(sql_input_frame, height=10)
sql_input_text.pack(side='left', fill='x', expand=True)

# Button to process SQL input
process_button = ttk.Button(app, text="Process SQL", command=process_sql_and_update, style='Button1.TButton')
process_button.pack(pady=5)

# Table to display detected fields
fields_frame = tk.LabelFrame(app, text="Fields")
fields_frame.pack(fill='both', expand=True, padx=10, pady=10)
fields_table = ttk.Treeview(fields_frame, columns=(
    'name', 'type', 'size', 'primary_key', 'nullable', 'mandatory'), show='headings')

for col in fields_table['columns']:
    fields_table.heading(col, text=col.capitalize())
    fields_table.column(col, anchor='center', width=120)
fields_table.pack(fill='both', expand=True)

# Nuevo frame para organizar los botones en una sola fila
buttons_frame = tk.Frame(app)
buttons_frame.pack(fill='x', padx=10, pady=5)

# Organiza los botones lado a lado dentro del frame buttons_frame
create_crud_files_button = ttk.Button(buttons_frame, text="Create CRUD Files", command=lambda: request_directory_and_create_files(table_name.lower()), style='Button2.TButton')
create_crud_files_button.pack(side='left', fill='x', expand=True, padx=2)

create_controller_button = ttk.Button(buttons_frame, text="Create Controller", command=lambda: create_controller(table_name), style='Button3.TButton')
create_controller_button.pack(side='left', fill='x', expand=True, padx=2)

generate_model_button = ttk.Button(buttons_frame, text="Generate Model", command=lambda: generate_model(table_name, fields), style='Button4.TButton')
generate_model_button.pack(side='left', fill='x', expand=True, padx=2)

generate_migration_button = ttk.Button(buttons_frame, text="Generate Migration", command=generate_migration_only, style='Button4.TButton')
generate_migration_button.pack(side='left', fill='x', expand=True, padx=2)

generate_routes_button = ttk.Button(buttons_frame, text="Generate Routes", command=generate_routes, style='Button4.TButton')
generate_routes_button.pack(side='left', fill='x', expand=True, padx=2)

# Add bindings for click to toggle and double-click to edit
fields_table.bind('<Button-1>', on_field_click)
fields_table.bind('<Double-Button-1>', edit_field_details)

app.mainloop()
