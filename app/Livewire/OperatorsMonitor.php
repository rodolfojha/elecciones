<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Client;
use Livewire\Component;

class OperatorsMonitor extends Component
{
    public $searchTerm = '';
    public $filterStatus = '';

    // Refrescar cada 5 segundos
    protected $listeners = ['refreshMonitor' => '$refresh'];

    public function mount()
    {
        // Verificar que el usuario sea admin
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
    }

    public function render()
    {
        // Obtener todos los operadores con sus clientes
        $operators = User::where('role', 'operator')
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            })
            ->with(['clients' => function ($query) {
                if ($this->filterStatus) {
                    $query->where('status', $this->filterStatus);
                }
                $query->orderBy('assigned_at', 'desc');
            }])
            ->withCount([
                'clients as total_clients',
                'clients as active_clients' => function ($query) {
                    $query->whereIn('status', ['assigned', 'contacted']);
                },
                'clients as completed_today' => function ($query) {
                    $query->where('status', 'completed')
                        ->whereDate('updated_at', today());
                }
            ])
            ->get();

        // Estadísticas generales
        $stats = [
            'total_operators' => User::where('role', 'operator')->count(),
            'active_operators' => User::where('role', 'operator')
                ->whereHas('clients', function ($query) {
                    $query->whereIn('status', ['assigned', 'contacted']);
                })
                ->count(),
            'clients_in_queue' => Client::where('status', 'waiting')
                ->whereNull('assigned_to')
                ->count(),
            'clients_being_attended' => Client::whereIn('status', ['assigned', 'contacted'])
                ->whereNotNull('assigned_to')
                ->count(),
        ];

        return view('livewire.operators-monitor', [
            'operators' => $operators,
            'stats' => $stats,
        ]);
    }
}
