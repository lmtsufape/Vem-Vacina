<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatoController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get("/solicitar", [CandidatoController::class, 'solicitar'])->name("solicitacao.candidato");
Route::post("/solicitar/enviar", [CandidatoController::class, 'enviar_solicitacao'])->name("solicitacao.candidato.enviar");
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
