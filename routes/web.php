<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImovelController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Home');
// });

Route::prefix('imoveis')->group(function () {
    Route::get('/', [ImovelController::class, 'exibirImoveis'])->name('imoveis.index');
    Route::post('/', [ImovelController::class, 'criarImovel']);
    Route::put('/{id}', [ImovelController::class, 'atualizarImovel']);

    Route::get('/create', [ImovelController::class, 'create']);
    Route::delete('/{id}', [ImovelController::class, 'removerImovel']);
    Route::get('/{imovel}/edit', [ImovelController::class, 'edit']);
});
