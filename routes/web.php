<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\PostoVacinacaoController;
use App\Http\Controllers\EtapaController;
use App\Http\Controllers\ExportController;
use App\Http\Livewire\StoreLote;

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
})->name('index');

Route::get('/dashboard',  [CandidatoController::class, 'show'])->middleware(['auth'])->name('dashboard');

Route::get("/solicitar", [CandidatoController::class, 'solicitar'])->name("solicitacao.candidato");
Route::post("/solicitar/enviar", [CandidatoController::class, 'enviar_solicitacao'])->name("solicitacao.candidato.enviar");
Route::get("/agendamento/{id}", [CandidatoController::class, 'ver'])->name("agendamento.ver");
Route::post("/agendamento/{id}/confirmacao", [CandidatoController::class, 'update'])->name("update.agendamento")->middleware(['auth']);
Route::post("/agendamento/{id}/confirmar-vacinacao", [CandidatoController::class, 'vacinado'])->name('candidato.vacinado');

Route::get("/dowload/{id}/frente-rg", [CandidatoController::class, 'dowloadFrenteRg'])->name('download.frente');
Route::get("/dowload/{id}/verso-rg", [CandidatoController::class, 'dowloadVersoRg'])->name('download.verso');

Route::get("/horarios/{id_posto}", [PostoVacinacaoController::class, 'horarios'] )->name("posto.horarios");

Route::get("/cep/{cep}", function($cep) {
    //TODO: mover isso pra um controller
    $results = simplexml_load_file("http://cep.republicavirtual.com.br/web_cep.php?formato=xml&cep=" . $cep);
    return response()->json($results);
});


Route::resource('/postos', PostoVacinacaoController::class);
Route::resource('/lotes', LoteController::class);
Route::get('/lotes/distribuir/{lote}', [ LoteController::class, 'distribuir'])->name('lotes.distribuir');
Route::post('/lotes/calcular', [ LoteController::class, 'calcular'])->name('lotes.calcular');

Route::post('/etapas/definir-etapa-atual', [EtapaController::class, 'definirEtapa'])->name('etapas.definirEtapa');
Route::get('/etapas', [EtapaController::class, 'index'])->name('etapas.index');
Route::get('/etapas/adicionar', [EtapaController::class, 'create'])->name('etapas.create');
Route::post('/etapas/salvar', [EtapaController::class, 'store'])->name('etapas.store');
Route::post('/etapas/{id}/excluir', [EtapaController::class, 'destroy'])->name('etapas.destroy');
Route::post('/etapas/{id}/atualizar', [EtapaController::class, 'update'])->name('etapas.update');

Route::get('exportar/candidato/', [ExportController::class, 'exportCandidato'])->name('export.candidato');
Route::get('exportar/lote', [ExportController::class, 'exportLote'])->name('export.lote');
Route::get('exportar/postos', [ExportController::class, 'exportPosto'])->name('export.posto');
Route::get('exportar/index', [ExportController::class, 'index'])->name('export.index');

require __DIR__.'/auth.php';
