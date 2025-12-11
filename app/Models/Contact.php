<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'notes',
    ];

    /**
     * Relación muchos a muchos con mensajes
     */
    public function messages()
    {
        return $this->belongsToMany(Message::class, 'message_contact')
                    ->withPivot('status', 'error_message', 'sent_at')
                    ->withTimestamps();
    }
}
