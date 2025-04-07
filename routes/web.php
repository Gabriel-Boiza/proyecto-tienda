<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta para usuarios sin acceso
Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');

// Dashboard routes with middleware
Route::middleware(['auth'])->group(function () {
    // General dashboard for all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin dashboard - only for users with admin role
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])
        ->middleware('role:admin')
        ->name('admin.dashboard');
    
    // Editor dashboard - only for users with editor role
    Route::get('/editor/dashboard', [DashboardController::class, 'editorDashboard'])
        ->middleware('role:editor')
        ->name('editor.dashboard');
});
