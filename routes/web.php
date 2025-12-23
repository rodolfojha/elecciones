<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Ruta de bienvenida
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');
Route::post('/messages/execute-python-script', function (Request $request) {
    try {
        // Rutas
        // Detectar sistema operativo y definir binario de Python
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        
        if ($isWindows) {
            // En Windows local usamos el python del sistema
            // Puedes ajustar esto si usas un venv local específico
            $pythonBinary = 'python'; 
        } else {
            // En VPS Linux usamos el entorno virtual
            $venvPath = storage_path('app/venv');
            $pythonBinary = $venvPath . '/bin/python';
        }

        $pythonScriptPath = storage_path('app/enviar_mensajes.py');
        $processFile = storage_path('app/proceso.json');
        
        // Verificar si ya hay un proceso en ejecución
        if (file_exists($processFile)) {
            $processData = json_decode(file_get_contents($processFile), true);
            if ($processData && isset($processData['pid'])) {
                // Verificar si el proceso sigue activo
                // En Windows la verificación de procesos es diferente, por simplicidad en local omitimos check estricto o usamos tasklist
                if (!$isWindows && posix_getpgid($processData['pid'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ya hay un proceso en ejecución (PID: ' . $processData['pid'] . ')'
                    ], 409);
                }
            }
        }
        
        // Verificaciones (solo en Linux verificamos path absoluto del binario, en Windows confiamos en PATH)
        if (!$isWindows && !file_exists($pythonBinary)) {
            return response()->json([
                'success' => false,
                'message' => 'Virtual environment no encontrado en: ' . $pythonBinary
            ], 404);
        }
        
        if (!file_exists($pythonScriptPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Script Python no encontrado en: ' . $pythonScriptPath
            ], 404);
        }
        
        // Verificar que exista el archivo de configuración
        $configFile = storage_path('app/datos.json');
        if (!file_exists($configFile)) {
            return response()->json([
                'success' => false,
                'message' => 'No hay configuración guardada. Guarda la configuración primero.'
            ], 404);
        }
        
        // Inicializar archivos de progreso
        $currentFile = storage_path('app/actual.txt');
        $maxFile = storage_path('app/maximo.txt');
        file_put_contents($currentFile, "0");
        file_put_contents($maxFile, "0");
        
        // Ejecutar el script en segundo plano
        if ($isWindows) {
             // Windows: start /B corre en background
             // Usamos wmic para obtener el PID es más complejo, pero start /B devuelve el control.
             // Para obtener PID en Windows desde PHP es truculento sin extensiones.
             // Usaremos popen para intentar capturarlo o simplemente no traquear PID en Windows local.
             $command = "start /B " . $pythonBinary . " " . escapeshellarg($pythonScriptPath);
             pclose(popen($command, "r"));
             $pid = 1234; // Dummy PID para local windows por ahora
        } else {
            // Linux
            $command = "cd " . escapeshellarg(storage_path('app')) . " && " . 
                       escapeshellarg($pythonBinary) . " " . escapeshellarg($pythonScriptPath) . " > /dev/null 2>&1 & echo $!";
            $pid = trim(shell_exec($command));
        }
        
        // Guardar información del proceso
        $processData = [
            'pid' => (int)$pid,
            'started_at' => now()->toISOString(),
            'command' => $command,
            'status' => 'running'
        ];
        
        file_put_contents($processFile, json_encode($processData, JSON_PRETTY_PRINT));
        
        \Log::info('Script Python iniciado', ['pid' => $pid]);
        
        return response()->json([
            'success' => true,
            'message' => 'Proceso iniciado correctamente',
            'pid' => $pid
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error iniciando script Python: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
});
Route::post('/messages/cancel-process', function (Request $request) {
    try {
        $processFile = storage_path('app/proceso.json');
        
        if (!file_exists($processFile)) {
            return response()->json([
                'success' => false,
                'message' => 'No hay proceso en ejecución'
            ], 404);
        }
        
        $processData = json_decode(file_get_contents($processFile), true);
        
        if (!$processData || !isset($processData['pid'])) {
            return response()->json([
                'success' => false,
                'message' => 'Archivo de proceso corrupto'
            ], 500);
        }
        
        $pid = $processData['pid'];
        
        // Terminar el proceso
        $killed = posix_kill($pid, 15); // SIGTERM
        
        if ($killed) {
            // Esperar un poco y forzar kill si es necesario
            sleep(2);
            if (posix_getpgid($pid)) {
                posix_kill($pid, 9); // SIGKILL
            }
            
            // Eliminar archivo de proceso
            unlink($processFile);
            
            \Log::info('Proceso cancelado', ['pid' => $pid]);
            
            return response()->json([
                'success' => true,
                'message' => 'Proceso cancelado correctamente (PID: ' . $pid . ')'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo terminar el proceso (PID: ' . $pid . ')'
            ], 500);
        }
        
    } catch (\Exception $e) {
        \Log::error('Error cancelando proceso: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
});

Route::get('/messages/process-status', function () {
    try {
        $processFile = storage_path('app/proceso.json');
        $currentFile = storage_path('app/actual.txt');
        $maxFile = storage_path('app/maximo.txt');
        
        $status = [
            'is_running' => false,
            'current' => 0,
            'max' => 0,
            'progress' => 0,
            'pid' => null,
            'started_at' => null
        ];
        
        // Verificar proceso
        if (file_exists($processFile)) {
            $processData = json_decode(file_get_contents($processFile), true);
            if ($processData && isset($processData['pid'])) {
                $pid = $processData['pid'];
                $isRunning = posix_getpgid($pid);
                
                $status['is_running'] = $isRunning;
                $status['pid'] = $pid;
                $status['started_at'] = $processData['started_at'] ?? null;
                
                // Si el proceso no está corriendo, limpiar archivo
                if (!$isRunning) {
                    unlink($processFile);
                }
            }
        }
        
        // Leer progreso actual
        if (file_exists($currentFile)) {
            $current = file_get_contents($currentFile);
            $status['current'] = intval(trim($current));
        }
        
        // Leer máximo
        if (file_exists($maxFile)) {
            $max = file_get_contents($maxFile);
            $status['max'] = intval(trim($max));
        }
        
        // Calcular progreso
        if ($status['max'] > 0) {
            $status['progress'] = round(($status['current'] / $status['max']) * 100);
        }
        
        return response()->json([
            'success' => true,
            'status' => $status
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
});
// Rutas para el guardado en JSON
Route::post('/messages/save-configuration', function (Request $request) {
    try {
        $data = $request->all();
        
        // Intentar diferentes rutas con permisos
        $possiblePaths = [
            storage_path('app/datos.json'), // Storage de Laravel
            base_path('datos.json'), // Raíz del proyecto Laravel
            '/tmp/datos.json', // Directorio temporal
            public_path('datos.json') // Directorio público
        ];
        
        $filePath = null;
        foreach ($possiblePaths as $path) {
            $dir = dirname($path);
            if (is_writable($dir) || is_writable(dirname($dir))) {
                $filePath = $path;
                break;
            }
        }
        
        if (!$filePath) {
            // Si ninguna ruta tiene permisos, usar storage por defecto
            $filePath = storage_path('app/datos.json');
        }
        
        // Guardar en JSON
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
        
        return response()->json([
            'success' => true, 
            'message' => 'Configuración guardada correctamente en: ' . $filePath
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false, 
            'message' => 'Error al guardar: ' . $e->getMessage()
        ], 500);
    }
});

Route::get('/messages/get-saved-data', function () {
    try {
        // Buscar en diferentes ubicaciones posibles
        $possiblePaths = [
            storage_path('app/datos.json'),
            base_path('datos.json'),
            '/tmp/datos.json',
            public_path('datos.json'),
            '/home/ubuntu/bot/datos.json' // La original por si acaso
        ];
        
        $filePath = null;
        $data = null;
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $filePath = $path;
                break;
            }
        }
        
        if ($filePath && file_exists($filePath)) {
            $content = file_get_contents($filePath);
            $data = json_decode($content, true);
            
            return response()->json([
                'success' => true, 
                'data' => $data,
                'path' => $filePath
            ]);
        } else {
            return response()->json([
                'success' => true, 
                'data' => null,
                'message' => 'No existe archivo de configuración'
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false, 
            'message' => 'Error al cargar: ' . $e->getMessage()
        ], 500);
    }
});
// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas de Registro de Personas (Voters) - Solo para trabajadores y admin
    Route::middleware([App\Http\Middleware\CheckRole::class . ':admin,trabajador'])->group(function () {
        Route::get('/voters/export', [App\Http\Controllers\VoterController::class, 'export'])->name('voters.export');
        Route::resource('voters', App\Http\Controllers\VoterController::class);
        Route::post('/voters/consultar-cedula', [App\Http\Controllers\VoterController::class, 'consultarCedula'])->name('voters.consultar-cedula');
        Route::get('/voters-map', [App\Http\Controllers\VoterController::class, 'map'])->name('voters.map');
    });
    
    // Configuración del perfil
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    
    Route::get('/profile/edit', function () {
        return redirect()->route('settings.index');
    })->name('profile.edit');
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Rutas de clientes
    Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{client}', [App\Http\Controllers\ClientController::class, 'show'])->name('clients.show');
    Route::patch('/clients/{client}/status', [App\Http\Controllers\ClientController::class, 'updateStatus'])->name('clients.update-status');
    Route::get('/completed', [App\Http\Controllers\ClientController::class, 'completed'])->name('clients.completed');
    
    // Ruta de historial
    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');
    
    // Rutas de mensajes
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/show', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages', [App\Http\Controllers\MessageController::class, 'destroy'])->name('messages.destroy');
});

// Rutas solo para administradores
Route::middleware(['auth', App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
    // Gestión de operadores
    Route::resource('users', App\Http\Controllers\UserController::class);
    
    // Gestión de trabajadores
    Route::resource('trabajadores', App\Http\Controllers\TrabajadorController::class)
        ->parameters(['trabajadores' => 'trabajador']);
    
    // Gestión de cursos
    Route::resource('courses', App\Http\Controllers\CourseController::class);
    Route::post('courses/{course}/materials', [App\Http\Controllers\CourseController::class, 'uploadMaterial'])->name('courses.materials.upload');
    Route::delete('courses/{course}/materials/{material}', [App\Http\Controllers\CourseController::class, 'deleteMaterial'])->name('courses.materials.delete');
    
    // Monitoreo de operadores
    Route::get('/monitor', function () {
        return view('monitor.index');
    })->name('monitor.index');
});

// Rutas para administradores y operadores
Route::middleware(['auth', App\Http\Middleware\CheckRole::class . ':admin,operator'])->group(function () {
    // Aquí irán las rutas accesibles para ambos roles
});


