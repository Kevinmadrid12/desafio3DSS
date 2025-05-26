<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TutorController;

// Rutas públicas
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('auth')->group(function () { 
    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
});

    Route::middleware('auth')->group(function () {
    // Rutas de administrador
    Route::middleware('can:admin')->group(function () {
        Route::resource('grupos', GrupoController::class);
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::post('/reportes/generar', [ReporteController::class, 'generar'])->name('reportes.generar');
        Route::get('/admin/dashboard/export/pdf', [DashboardController::class, 'exportPdf'])->name('admin.dashboard.export.pdf');

        // Rutas para listar estudiantes y tutores (accesibles por admin)
        Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
        Route::get('/tutores', [TutorController::class, 'index'])->name('tutores.index');

    });

    // Ruta para el perfil del usuario autenticado
    Route::get('/perfil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    
    // Rutas de tutor
    Route::middleware('can:tutor')->group(function () {
        Route::get('/tutor/dashboard', [TutorController::class, 'dashboard'])->name('tutor.dashboard');
        Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
        Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
    });
    
    // Rutas comunes
    Route::get('/estudiantes/{codigo}', [EstudianteController::class, 'show'])->name('estudiantes.show');
    Route::get('/tutores/{codigo}', [TutorController::class, 'show'])->name('tutores.show');

    Route::middleware(['check.attendance.time']) 
        ->prefix('tutor/asistencia')
        ->name('tutor.asistencia.')
        ->group(function () {
            Route::get('/crear', [AttendanceController::class, 'create'])->name('create');
            Route::post('/', [AttendanceController::class, 'store'])->name('store');
        });
});