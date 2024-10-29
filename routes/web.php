<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TorneioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;

// Rotas de autenticação
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas para o perfil do usuário e pagamento
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [AuthController::class, 'editProfile'])->name('perfil.edit');
    Route::post('/perfil', [AuthController::class, 'updateProfile'])->name('perfil.update');
    Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/principal', function () {
        return view('pagina.index'); 
    });
});

// Rotas protegidas para torneios (após pagamento)
Route::middleware(['auth', 'check.paid'])->group(function () {
    
});

    Route::get('/torneios/criar', [TorneioController::class, 'create'])->name('torneios.create');
    Route::post('/torneios/store', [TorneioController::class, 'store'])->name('torneios.store');


// Rotas protegidas para edição, exclusão e pesquisa de torneios
Route::middleware('auth')->group(function () {
    Route::get('/torneios', [TorneioController::class, 'index'])->name('torneios.index');
    Route::get('/torneios/pesquisar', [TorneioController::class, 'pesquisar'])->name('torneios.pesquisar');
    Route::get('/torneios/{id}', [TorneioController::class, 'show'])->name('torneios.show');
    Route::get('/torneios/{id}/edit', [TorneioController::class, 'edit'])->name('torneios.edit');
    Route::post('/torneios/{id}', [TorneioController::class, 'update'])->name('torneios.update');
    Route::delete('/torneios/{id}', [TorneioController::class, 'destroy'])->name('torneios.destroy');
    Route::post('/torneios/{id}/salvar-resultados', [TorneioController::class, 'salvarResultados'])->name('torneios.salvarResultados');
});

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

// Rota inicial
Route::get('/', function () {
    return view('inicial.index'); 
});
