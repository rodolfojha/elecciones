<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Mostrar historial del operador
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $isActiveFilter = ($filter === 'active');
        
        $query = Client::where('assigned_to', auth()->id());
        
        // Filtrar por clientes activos si se solicita
        if ($isActiveFilter) {
            $query->whereIn('status', ['assigned', 'contacted']);
        }
        
        $clients = $query->orderBy('assigned_at', 'desc')->paginate(20);

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

        return view('history.index', compact('clients', 'stats', 'isActiveFilter'));
    }
}

