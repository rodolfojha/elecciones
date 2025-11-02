<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Ruta de bienvenida
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile/edit', function () {
        return redirect('/dashboard');
    })->name('profile.edit');
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Rutas de clientes
    Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{client}', [App\Http\Controllers\ClientController::class, 'show'])->name('clients.show');
    Route::patch('/clients/{client}/status', [App\Http\Controllers\ClientController::class, 'updateStatus'])->name('clients.update-status');
    Route::get('/completed', [App\Http\Controllers\ClientController::class, 'completed'])->name('clients.completed');
    
    // Ruta de historial
    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');
});

// Rutas solo para administradores
Route::middleware(['auth', App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
    // Gestión de operadores
    Route::resource('users', App\Http\Controllers\UserController::class);
    
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
