<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CandidatoController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/', function () {
        return redirect('/candidatos');
    });
    
    Route::get('/candidatos', [CandidatoController::class, 'index'])->name('candidatos.index');
    Route::get('/candidatos/{id}/curriculum', [CandidatoController::class, 'descargarCurriculum'])->name('candidatos.descargar-curriculum');
});
