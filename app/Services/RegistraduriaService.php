<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class RegistraduriaService
{
    protected $scriptPath;
    protected $pythonPath;
    protected $requestDir;
    protected $responseDir;
    
    public function __construct()
    {
        $this->scriptPath = storage_path('app/scripts/consulta_cedula_2captcha.py');
        $this->pythonPath = storage_path('app/scripts/venv/bin/python');
        $this->requestDir = storage_path('app/scripts/requests');
        $this->responseDir = storage_path('app/scripts/responses');
        
        // Crear directorios si no existen
        if (!File::exists($this->requestDir)) {
            File::makeDirectory($this->requestDir, 0755, true);
        }
        if (!File::exists($this->responseDir)) {
            File::makeDirectory($this->responseDir, 0755, true);
        }
    }
    
    /**
     * Consultar información de votación por cédula usando el servicio de Python
     */
    public function consultarCedula(string $cedula): array
    {
        try {
            // Limpiar la cédula (solo números)
            $cedula = preg_replace('/[^0-9]/', '', $cedula);
            
            if (empty($cedula) || strlen($cedula) < 5) {
                return [
                    'success' => false,
                    'message' => 'Cédula inválida. Debe tener al menos 5 dígitos.',
                    'data' => null
                ];
            }

            // Verificar que existe el script
            if (!file_exists($this->scriptPath)) {
                Log::error('Script de consulta no encontrado: ' . $this->scriptPath);
                return [
                    'success' => false,
                    'message' => 'Error de configuración del servidor',
                    'data' => null
                ];
            }

            // Verificar que existe el entorno virtual de Python
            if (!file_exists($this->pythonPath)) {
                Log::error('Python no encontrado: ' . $this->pythonPath);
                return [
                    'success' => false,
                    'message' => 'Error de configuración del servidor (Python)',
                    'data' => null
                ];
            }

            // Asegurar que el servicio esté corriendo
            $this->iniciarServicio();

            // Generar ID único para esta consulta
            $requestId = uniqid('req_', true);
            $requestFile = $this->requestDir . '/' . $requestId . '.json';
            $responseFile = $this->responseDir . '/' . $requestId . '.json';

            // Crear archivo de request
            $requestData = [
                'id' => $requestId,
                'cedula' => $cedula,
                'timestamp' => now()->toIso8601String()
            ];

            file_put_contents($requestFile, json_encode($requestData, JSON_PRETTY_PRINT));

            Log::info('Consulta de cédula enviada', ['cedula' => $cedula, 'request_id' => $requestId]);

            // Esperar respuesta (máximo 5 minutos)
            $maxWait = 300; // 5 minutos
            $waitInterval = 2; // Verificar cada 2 segundos
            $elapsed = 0;

            while ($elapsed < $maxWait) {
                if (file_exists($responseFile)) {
                    // Leer respuesta
                    $responseContent = file_get_contents($responseFile);
                    $response = json_decode($responseContent, true);

                    // Limpiar archivo de respuesta
                    @unlink($responseFile);

                    if ($response && isset($response['success'])) {
                        Log::info('Consulta de cédula completada', [
                            'cedula' => $cedula,
                            'success' => $response['success']
                        ]);

                        return $response;
                    }
                }

                sleep($waitInterval);
                $elapsed += $waitInterval;
            }

            // Timeout - limpiar request
            @unlink($requestFile);

            return [
                'success' => false,
                'message' => 'Tiempo de espera agotado. El servicio puede estar ocupado. Intente de nuevo.',
                'data' => null
            ];

        } catch (\Exception $e) {
            Log::error('Error consultando cédula: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error al procesar la consulta: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Iniciar el servicio de Python si no está corriendo
     */
    protected function iniciarServicio(): void
    {
        $pidFile = storage_path('app/scripts/service.pid');
        
        // Verificar si el servicio ya está corriendo
        if (file_exists($pidFile)) {
            $pid = (int) trim(file_get_contents($pidFile));
            
            // Verificar si el proceso sigue activo
            if ($pid > 0 && $this->isProcessRunning($pid)) {
                return; // Ya está corriendo
            }
        }

        // Iniciar el servicio en segundo plano
        $command = sprintf(
            'cd %s && nohup %s %s > %s/service.log 2>&1 & echo $!',
            escapeshellarg(storage_path('app/scripts')),
            escapeshellarg($this->pythonPath),
            escapeshellarg($this->scriptPath),
            escapeshellarg(storage_path('app/scripts'))
        );

        $pid = trim(shell_exec($command));
        
        if ($pid && is_numeric($pid)) {
            file_put_contents($pidFile, $pid);
            Log::info('Servicio de consulta iniciado', ['pid' => $pid]);
            
            // Esperar un poco para que el navegador se inicie
            sleep(5);
        } else {
            Log::error('No se pudo iniciar el servicio de consulta');
        }
    }

    /**
     * Verificar si un proceso está corriendo
     */
    protected function isProcessRunning(int $pid): bool
    {
        try {
            $result = shell_exec("ps -p $pid -o pid=");
            return !empty(trim($result));
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Detener el servicio
     */
    public function detenerServicio(): bool
    {
        $pidFile = storage_path('app/scripts/service.pid');
        
        if (!file_exists($pidFile)) {
            return false;
        }

        $pid = (int) trim(file_get_contents($pidFile));
        
        if ($pid > 0 && $this->isProcessRunning($pid)) {
            exec("kill $pid");
            @unlink($pidFile);
            Log::info('Servicio de consulta detenido', ['pid' => $pid]);
            return true;
        }

        @unlink($pidFile);
        return false;
    }
}
