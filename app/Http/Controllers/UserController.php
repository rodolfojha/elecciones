<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Mostrar lista de operadores
     */
    public function index()
    {
        $users = User::where('role', 'operator')
            ->withCount(['clients as total_clients'])
            ->withCount(['clients as active_clients' => function ($query) {
                $query->whereIn('status', ['assigned', 'contacted']);
            }])
            ->withCount(['clients as completed_clients' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->latest()
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Mostrar formulario para crear operador
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Guardar nuevo operador
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'operator',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Operador creado exitosamente');
    }

    /**
     * Mostrar formulario para editar operador
     */
    public function edit(User $user)
    {
        // Solo permitir editar operadores
        if ($user->role !== 'operator') {
            abort(403, 'No puedes editar este usuario');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Actualizar operador
     */
    public function update(Request $request, User $user)
    {
        // Solo permitir editar operadores
        if ($user->role !== 'operator') {
            abort(403, 'No puedes editar este usuario');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Operador actualizado exitosamente');
    }

    /**
     * Eliminar operador
     */
    public function destroy(User $user)
    {
        // Solo permitir eliminar operadores
        if ($user->role !== 'operator') {
            abort(403, 'No puedes eliminar este usuario');
        }

        // Verificar si tiene clientes asignados
        $activeClients = $user->clients()->whereIn('status', ['assigned', 'contacted'])->count();
        
        if ($activeClients > 0) {
            return back()->with('error', 'No se puede eliminar el operador porque tiene clientes activos asignados');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Operador eliminado exitosamente');
    }

    /**
     * Mostrar estadísticas del operador
     */
    public function show(User $user)
    {
        // Solo permitir ver operadores
        if ($user->role !== 'operator') {
            abort(403);
        }

        $stats = [
            'total_clients' => $user->clients()->count(),
            'active_clients' => $user->clients()->whereIn('status', ['assigned', 'contacted'])->count(),
            'completed_clients' => $user->clients()->where('status', 'completed')->count(),
            'today_calls' => $user->clients()->whereDate('assigned_at', today())->count(),
        ];

        $recentClients = $user->clients()
            ->latest('assigned_at')
            ->limit(10)
            ->get();

        return view('users.show', compact('user', 'stats', 'recentClients'));
    }
}

