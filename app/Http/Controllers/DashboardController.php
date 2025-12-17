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
            // Estadísticas para administrador
            $stats = [
                'total_voters' => \App\Models\Voter::count(),
                'voters_today' => \App\Models\Voter::whereDate('created_at', today())->count(),
            ];
        } else {
            // Estadísticas para operador
            // Estadísticas para trabajador/operador
            $stats = [
                'my_total_voters' => \App\Models\Voter::where('user_id', $user->id)->count(),
                'my_voters_today' => \App\Models\Voter::where('user_id', $user->id)
                    ->whereDate('created_at', today())
                    ->count(),
            ];
        }

        return view('dashboard', compact('stats'));
    }
}

