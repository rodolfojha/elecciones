<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'departamento',
        'municipio',
        'puesto_votacion',
        'direccion_puesto',
        'mesa',
        'telefono',
        'notas',
        'estado',
    ];

    /**
     * Obtener el nombre completo del votante
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    /**
     * Scope para votantes activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
}
