<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\Attributes\On;

class ClientsList extends Component
{
    public $showMyClients = false;

    /**
     * Asignar cliente al operador actual
     */
    public function assignClient($clientId)
    {
        $client = Client::findOrFail($clientId);
        
        // Verificar que el cliente aún esté disponible
        if (!$client->isAvailable()) {
            session()->flash('error', 'Este cliente ya ha sido asignado a otro operador.');
            return redirect()->route('clients.index');
        }

        // Asignar el cliente
        $client->assignTo(auth()->user());

        // Notificar a otros operadores que actualicen su lista
        $this->dispatch('client-assigned');

        // Redirigir al detalle del cliente
        return redirect()->route('clients.show', $client->id);
    }

    /**
     * Escuchar cuando un cliente es asignado
     */
    #[On('client-assigned')]
    public function refreshList()
    {
        // Livewire automáticamente re-renderizará el componente
    }

    /**
     * Cambiar entre ver todos los clientes o solo los míos
     */
    public function toggleView()
    {
        $this->showMyClients = !$this->showMyClients;
    }

    public function render()
    {
        if ($this->showMyClients) {
            // Mostrar clientes asignados al operador actual
            $clients = Client::where('assigned_to', auth()->id())
                ->whereIn('status', ['assigned', 'contacted'])
                ->orderBy('assigned_at', 'desc')
                ->get();
        } else {
            // Mostrar solo clientes disponibles (esperando)
            $clients = Client::where('status', 'waiting')
                ->whereNull('assigned_to')
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.clients-list', [
            'clients' => $clients,
        ]);
    }
}

