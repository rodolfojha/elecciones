<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'frequency',
        'user_id',
    ];

    /**
     * Relación con el usuario que creó el mensaje
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación muchos a muchos con clientes completados
     */
    public function completedClients()
    {
        return $this->belongsToMany(Client::class, 'message_completed_clients')
                    ->withTimestamps();
    }
}
