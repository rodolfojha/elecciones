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
        'user_id',
    ];

    protected $casts = [
        'consulta_completed_at' => 'datetime',
    ];

    /**
     * Get the user that created the voter.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
