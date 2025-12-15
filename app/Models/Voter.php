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
        'consulta_status',
        'consulta_error',
        'consulta_completed_at',
    ];

    protected $casts = [
        'consulta_completed_at' => 'datetime',
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
