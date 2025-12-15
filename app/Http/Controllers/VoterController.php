<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use App\Services\RegistraduriaService;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    protected $registraduriaService;

    public function __construct(RegistraduriaService $registraduriaService)
    {
        $this->registraduriaService = $registraduriaService;
    }

    /**
     * Mostrar listado de votantes
     */
    public function index(Request $request)
    {
        $query = Voter::query();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('cedula', 'like', "%{$search}%")
                  ->orWhere('municipio', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $voters = $query->orderBy('created_at', 'desc')->paginate(15);

        // Estadísticas
        $stats = [
            'total' => Voter::count(),
            'activos' => Voter::where('estado', 'activo')->count(),
            'hoy' => Voter::whereDate('created_at', today())->count(),
        ];

        return view('voters.index', compact('voters', 'stats'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('voters.create');
    }

    /**
     * Guardar nuevo votante
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:voters,cedula',
            'departamento' => 'nullable|string|max:255',
            'municipio' => 'nullable|string|max:255',
            'puesto_votacion' => 'nullable|string|max:255',
            'direccion_puesto' => 'nullable|string',
            'mesa' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:20',
            'notas' => 'nullable|string',
        ], [
            'cedula.unique' => 'Esta cédula ya está registrada en el sistema.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'cedula.required' => 'La cédula es obligatoria.',
        ]);

        // Crear el votante con estado 'pending' para la consulta
        $validated['consulta_status'] = 'pending';
        $voter = Voter::create($validated);

        // Encolar el job para consultar la información en segundo plano
        \App\Jobs\ProcessVoterConsultaJob::dispatch($voter);

        return redirect()->route('voters.index')
            ->with('success', 'Persona registrada correctamente. La información de votación se está consultando en segundo plano.');
    }

    /**
     * Mostrar detalle de un votante
     */
    public function show(Voter $voter)
    {
        return view('voters.show', compact('voter'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Voter $voter)
    {
        return view('voters.edit', compact('voter'));
    }

    /**
     * Actualizar votante
     */
    public function update(Request $request, Voter $voter)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:voters,cedula,' . $voter->id,
            'departamento' => 'nullable|string|max:255',
            'municipio' => 'nullable|string|max:255',
            'puesto_votacion' => 'nullable|string|max:255',
            'direccion_puesto' => 'nullable|string',
            'mesa' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:20',
            'notas' => 'nullable|string',
            'estado' => 'nullable|in:activo,inactivo',
        ]);

        $voter->update($validated);

        return redirect()->route('voters.index')
            ->with('success', 'Información actualizada correctamente.');
    }

    /**
     * Eliminar votante
     */
    public function destroy(Voter $voter)
    {
        $voter->delete();

        return redirect()->route('voters.index')
            ->with('success', 'Registro eliminado correctamente.');
    }

    /**
     * Consultar cédula en la Registraduría (AJAX)
     */
    public function consultarCedula(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string|min:5|max:15',
        ]);

        $result = $this->registraduriaService->consultarCedula($request->cedula);

        return response()->json($result);
    }

    /**
     * Mostrar mapa con lugares de votación
     */
    public function map()
    {
        // Obtener todos los votantes con información de votación
        $voters = Voter::whereNotNull('puesto_votacion')
            ->whereNotNull('direccion_puesto')
            ->select('id', 'nombre', 'apellido', 'cedula', 'departamento', 'municipio', 'puesto_votacion', 'direccion_puesto', 'mesa')
            ->get();

        return view('voters.map', compact('voters'));
    }
}
