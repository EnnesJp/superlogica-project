<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImovelController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ImovelController::class, 'exibirImoveis'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('imoveis')->group(function () {
        Route::post('/', [ImovelController::class, 'criarImovel']);
        Route::put('/{id}', [ImovelController::class, 'atualizarImovel']);

        Route::get('/create', [ImovelController::class, 'create']);
        Route::get('{id}/view', [ImovelController::class, 'detalhesImovel'])->name('imoveis.view');
        Route::delete('/{id}', [ImovelController::class, 'removerImovel']);
        Route::get('/{id}/edit', [ImovelController::class, 'edit']);

        Route::get('/{id}/sell', [ImovelController::class, 'vendeImovel']);
        Route::get('/{id}/rent', [ImovelController::class, 'alugaImovel']);
    });
});

require __DIR__.'/auth.php';
