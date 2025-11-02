<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'notes',
        'assigned_to',
        'assigned_at',
        'status',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    /**
     * Relación con el operador asignado
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Obtener el nombre completo del cliente
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Verificar si el cliente está disponible (esperando)
     */
    public function isAvailable()
    {
        return $this->status === 'waiting' && is_null($this->assigned_to);
    }

    /**
     * Asignar cliente a un operador
     */
    public function assignTo(User $user)
    {
        $this->update([
            'assigned_to' => $user->id,
            'assigned_at' => now(),
            'status' => 'assigned',
        ]);
    }

    /**
     * Scope para clientes disponibles (esperando)
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'waiting')
                    ->whereNull('assigned_to');
    }

    /**
     * Scope para clientes asignados a un operador
     */
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }
}

