<?php

namespace App\Jobs;

use App\Models\Voter;
use App\Services\RegistraduriaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessVoterConsultaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $voter;
    public $timeout = 300; // 5 minutos timeout
    public $tries = 3; // Intentar 3 veces si falla

    /**
     * Create a new job instance.
     */
    public function __construct(Voter $voter)
    {
        $this->voter = $voter;
    }

    /**
     * Execute the job.
     */
    public function handle(RegistraduriaService $registraduriaService): void
    {
        try {
            Log::info("Procesando consulta en segundo plano para cédula: {$this->voter->cedula}");
            
            // Marcar como procesando
            $this->voter->update(['consulta_status' => 'processing']);
            
            // Realizar la consulta
            $resultado = $registraduriaService->consultarCedula($this->voter->cedula);
            
            if ($resultado['success']) {
                // Actualizar el votante con la información obtenida
                $this->voter->update([
                    'departamento' => $resultado['data']['departamento'] ?? null,
                    'municipio' => $resultado['data']['municipio'] ?? null,
                    'puesto_votacion' => $resultado['data']['puesto_votacion'] ?? null,
                    'direccion_puesto' => $resultado['data']['direccion_puesto'] ?? null,
                    'mesa' => $resultado['data']['mesa'] ?? null,
                    'consulta_status' => 'completed',
                    'consulta_completed_at' => now(),
                ]);
                
                Log::info("Consulta completada exitosamente para cédula: {$this->voter->cedula}");
            } else {
                // Marcar como fallida
                $this->voter->update([
                    'consulta_status' => 'failed',
                    'consulta_error' => $resultado['message'] ?? 'Error desconocido',
                ]);
                
                Log::warning("Consulta fallida para cédula: {$this->voter->cedula}");
            }
            
        } catch (\Exception $e) {
            Log::error("Error procesando consulta para cédula {$this->voter->cedula}: " . $e->getMessage());
            
            $this->voter->update([
                'consulta_status' => 'failed',
                'consulta_error' => $e->getMessage(),
            ]);
            
            throw $e; // Re-lanzar para que Laravel reintente el job
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Job fallido definitivamente para cédula {$this->voter->cedula}: " . $exception->getMessage());
        
        $this->voter->update([
            'consulta_status' => 'failed',
            'consulta_error' => 'Falló después de múltiples intentos: ' . $exception->getMessage(),
        ]);
    }
}
