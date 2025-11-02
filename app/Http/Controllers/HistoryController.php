<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Mostrar historial del operador
     */
    public function index()
    {
        // Obtener todos los clientes que el operador ha atendido
        $clients = Client::where('assigned_to', auth()->id())
            ->orderBy('assigned_at', 'desc')
            ->paginate(20);

        // Estadísticas
        $stats = [
            'total' => Client::where('assigned_to', auth()->id())->count(),
            'completed' => Client::where('assigned_to', auth()->id())
                ->where('status', 'completed')
                ->count(),
            'contacted' => Client::where('assigned_to', auth()->id())
                ->where('status', 'contacted')
                ->count(),
            'assigned' => Client::where('assigned_to', auth()->id())
                ->where('status', 'assigned')
                ->count(),
        ];

        return view('history.index', compact('clients', 'stats'));
    }
}

