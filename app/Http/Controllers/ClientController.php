<?php

namespace App\Http\Controllers;

use App\Models\Client;
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

        return view('clients.show', compact('client'));
    }

    /**
     * Actualizar estado del cliente
     */
    public function updateStatus(Request $request, Client $client)
    {
        $request->validate([
            'status' => 'required|in:assigned,contacted,completed',
            'notes' => 'nullable|string',
        ]);

        $client->update([
            'status' => $request->status,
            'notes' => $request->notes ?? $client->notes,
        ]);

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }

    /**
     * Mostrar clientes completados
     */
    public function completed()
    {
        $clients = Client::where('status', 'completed')
            ->with('assignedTo')
            ->latest('updated_at')
            ->paginate(20);

        return view('clients.completed', compact('clients'));
    }
}

