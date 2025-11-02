<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            // Estadísticas para administrador
            $stats = [
                'total_users' => User::count(),
                'total_operators' => User::where('role', 'operator')->count(),
                'calls_today' => Client::whereDate('assigned_at', today())->count(),
                'total_clients' => Client::count(),
                'available_clients' => Client::where('status', 'waiting')->whereNull('assigned_to')->count(),
                'completed_today' => Client::where('status', 'completed')
                    ->whereDate('updated_at', today())
                    ->count(),
            ];
        } else {
            // Estadísticas para operador
            $stats = [
                'my_calls_today' => Client::where('assigned_to', $user->id)
                    ->whereDate('assigned_at', today())
                    ->count(),
                'average_time' => 0, // Puedes implementar esto más adelante
                'completed_calls' => Client::where('assigned_to', $user->id)
                    ->where('status', 'completed')
                    ->count(),
                'my_clients' => Client::where('assigned_to', $user->id)
                    ->whereIn('status', ['assigned', 'contacted'])
                    ->count(),
                'total_assigned' => Client::where('assigned_to', $user->id)->count(),
            ];
        }

        return view('dashboard', compact('stats'));
    }
}

