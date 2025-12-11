<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TrabajadorController extends Controller
{
    /**
     * Mostrar lista de trabajadores
     */
    public function index()
    {
        $trabajadores = User::where('role', 'trabajador')
            ->latest()
            ->paginate(15);

        return view('trabajadores.index', compact('trabajadores'));
    }

    /**
     * Mostrar formulario para crear trabajador
     */
    public function create()
    {
        return view('trabajadores.create');
    }

    /**
     * Guardar nuevo trabajador
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
            'role' => 'trabajador',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador creado exitosamente');
    }

    /**
     * Mostrar formulario para editar trabajador
     */
    public function edit(User $trabajador)
    {
        // Solo permitir editar trabajadores
        if ($trabajador->role !== 'trabajador') {
            abort(403, 'No puedes editar este usuario');
        }

        return view('trabajadores.edit', compact('trabajador'));
    }

    /**
     * Actualizar trabajador
     */
    public function update(Request $request, User $trabajador)
    {
        // Solo permitir editar trabajadores
        if ($trabajador->role !== 'trabajador') {
            abort(403, 'No puedes editar este usuario');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $trabajador->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $trabajador->name = $validated['name'];
        $trabajador->email = $validated['email'];

        if (!empty($validated['password'])) {
            $trabajador->password = Hash::make($validated['password']);
        }

        $trabajador->save();

        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador actualizado exitosamente');
    }

    /**
     * Eliminar trabajador
     */
    public function destroy(User $trabajador)
    {
        // Solo permitir eliminar trabajadores
        if ($trabajador->role !== 'trabajador') {
            abort(403, 'No puedes eliminar este usuario');
        }

        $trabajador->delete();

        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador eliminado exitosamente');
    }
}
