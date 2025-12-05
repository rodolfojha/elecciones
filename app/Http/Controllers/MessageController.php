<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    /**
     * Mostrar la página principal de mensajes
     */
    public function index()
    {
        // Obtener clientes completados con sus teléfonos
        $query = Client::where('status', 'completed')
            ->whereNotNull('phone')
            ->where('phone', '!=', '');
        
        // Si es operador, solo ver sus propios clientes
        if (!auth()->user()->isAdmin()) {
            $query->where('assigned_to', auth()->id());
        }
        
        $completedClients = $query->select('id', 'phone', 'first_name', 'last_name')
            ->orderBy('phone')
            ->get();
        
        // Obtener el último mensaje si existe
        $lastMessage = Message::with(['user', 'completedClients'])
            ->latest()
            ->first();
        
        return view('messages.index', compact('completedClients', 'lastMessage'));
    }


    /**
     * Guardar un mensaje para los clientes completados seleccionados
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'frequency' => 'required|integer|min:1',
            'client_ids' => 'required|array|min:1',
            'client_ids.*' => 'exists:clients,id',
        ]);

        DB::beginTransaction();
        try {
            // Borrar el mensaje anterior si existe (junto con sus relaciones)
            $oldMessage = Message::latest()->first();
            if ($oldMessage) {
                // Eliminar relaciones primero
                DB::table('message_completed_clients')->where('message_id', $oldMessage->id)->delete();
                // Luego eliminar el mensaje
                $oldMessage->delete();
            }
            
            // Crear el nuevo mensaje
            $message = Message::create([
                'content' => $request->content,
                'frequency' => $request->frequency,
                'user_id' => auth()->id(),
            ]);

            // Asociar los clientes completados seleccionados al mensaje
            $message->completedClients()->attach($request->client_ids);

            DB::commit();

            Log::info("Mensaje guardado ID: {$message->id} con " . count($request->client_ids) . " clientes completados");

            return redirect()->route('messages.index')
                ->with('success', 'Mensaje guardado correctamente para ' . count($request->client_ids) . ' cliente(s) completado(s).');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar mensaje: ' . $e->getMessage());
            
            return redirect()->route('messages.index')
                ->with('error', 'Error al guardar el mensaje: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalles del mensaje
     */
    public function show()
    {
        $message = Message::with(['user', 'completedClients'])->latest()->first();
        
        if (!$message) {
            return redirect()->route('messages.index')
                ->with('error', 'No hay mensaje guardado.');
        }
        
        return view('messages.show', compact('message'));
    }

    /**
     * Eliminar el mensaje actual
     */
    public function destroy()
    {
        $message = Message::latest()->first();
        
        if ($message) {
            DB::beginTransaction();
            try {
                // Eliminar relaciones primero
                DB::table('message_completed_clients')->where('message_id', $message->id)->delete();
                // Luego eliminar el mensaje
                $message->delete();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('messages.index')
                    ->with('error', 'Error al eliminar el mensaje: ' . $e->getMessage());
            }
        }

        return redirect()->route('messages.index')
            ->with('success', 'Mensaje eliminado correctamente.');
    }
}
