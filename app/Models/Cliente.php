<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    protected $primaryKey = 'NRODOCUMENTO'; // Especifica la clave primaria personalizada

    protected $fillable = [
        'NRODOCUMENTO', 'TIPODOCUMENTO', 'LINK', 'RAZONNOMBRE', 'DIASCREDITO',
        'LIMITECREDITO', 'EMAIL', 'TELEFONO', 'CONTACTO', 'CLAVEWEB',
        'TIPOCLIENTE', 'TIPOORIGEN', 'FECHANACIMIENTO', 'OCUPACION',
        'DIRECCION', 'REFERENCIA', 'DNIFAMILIAR', 'TELEFONOCONTACTO',
        'FECULTIMACOMPRA', 'DOCULTIMACOMPRA', 'PORCENTAJE_DESCUENTO', 'PORCENTAJE_MORA',
    ];

    // Si tu clave primaria no es autoincremental, también debes indicarlo
    public $incrementing = false;

    // Además, si tu clave primaria no es un entero, debes especificar el tipo de clave
    protected $keyType = 'string';
}
