<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Course;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Mostrar lista de clientes
     */
    public function index()
    {
        return view('clients.index');
    }

    /**
     * Mostrar detalle del cliente
     */
    public function show(Client $client)
    {
        // Verificar que el cliente esté asignado al operador actual o sea admin
        if (!auth()->user()->isAdmin() && $client->assigned_to !== auth()->id()) {
            abort(403, 'No tienes permiso para ver este cliente.');
        }

        // Cargar relación course si existe
        $client->load('course');

        // Obtener cursos disponibles (publicados)
        $courses = Course::where('status', 'published')
            ->orderBy('title')
            ->get();

        return view('clients.show', compact('client', 'courses'));
    }

    /**
     * Actualizar estado del cliente
     */
    public function updateStatus(Request $request, Client $client)
    {
        $request->validate([
            'status' => 'required|in:assigned,contacted,completed',
            'notes' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $client->update([
            'status' => $request->status,
            'notes' => $request->notes ?? $client->notes,
            'course_id' => $request->course_id,
        ]);

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }

    /**
     * Mostrar clientes completados
     */
    public function completed()
    {
        $query = Client::where('status', 'completed');
        
        // Si es operador, solo ver sus propios clientes
        if (!auth()->user()->isAdmin()) {
            $query->where('assigned_to', auth()->id());
        }
        
        $clients = $query->with(['assignedTo', 'course'])
            ->latest('updated_at')
            ->paginate(20);
        
        // Calcular estadísticas - usar la misma condición base
        $baseCondition = [['status', '=', 'completed']];
        if (!auth()->user()->isAdmin()) {
            $baseCondition[] = ['assigned_to', '=', auth()->id()];
        }
        
        $stats = [
            'total' => Client::where($baseCondition)->count(),
            'today' => Client::where($baseCondition)->whereDate('updated_at', today())->count(),
            'this_week' => Client::where($baseCondition)->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        return view('clients.completed', compact('clients', 'stats'));
    }
}

