<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TorneioController;
use App\Http\Controllers\AdminController;

// Rotas de autenticação
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rotas para o perfil do usuário
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [AuthController::class, 'editProfile'])->name('perfil.edit');
    Route::post('/perfil', [AuthController::class, 'updateProfile'])->name('perfil.update');
});

// Rotas para Torneios
Route::get('/torneios', [TorneioController::class, 'index'])->name('torneios.index');
Route::get('/torneios/criar', [TorneioController::class, 'create'])->name('torneios.create');
Route::post('/torneios/store', [TorneioController::class, 'store'])->name('torneios.store');
Route::get('/torneios/{id}', [TorneioController::class, 'show'])->name('torneios.show');
Route::get('/torneios/{id}/edit', [TorneioController::class, 'edit'])->name('torneios.edit');
Route::post('/torneios/{id}', [TorneioController::class, 'update'])->name('torneios.update');
Route::delete('/torneios/{id}', [TorneioController::class, 'destroy'])->name('torneios.destroy');
Route::post('/torneios/{id}/salvar-resultados', [TorneioController::class, 'salvarResultados'])->name('torneios.salvarResultados');
Route::get('/pesquisar-torneio', [TorneioController::class, 'pesquisar'])->name('torneios.pesquisar');

// Rotas para Admin
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/torneios', [AdminController::class, 'index'])->name('admin.torneios.index');
    Route::delete('/admin/torneios/{id}', [AdminController::class, 'destroy'])->name('admin.torneios.destroy');
    Route::get('/admin/usuarios', [AdminController::class, 'usuariosIndex'])->name('admin.usuarios.index');
    Route::get('/admin/usuarios/{id}/edit', [AdminController::class, 'editUsuario'])->name('admin.usuarios.edit');
    Route::post('/admin/usuarios/{id}', [AdminController::class, 'updateUsuario'])->name('admin.usuarios.update');
    Route::delete('/admin/usuarios/{id}', [AdminController::class, 'destroyUsuario'])->name('admin.usuarios.destroy');
});

// Rotas para a página inicial
Route::get('/principal', function () {
    return view('pagina.index'); 
});

Route::get('/', function () {
    return view('inicial.index'); 
});
