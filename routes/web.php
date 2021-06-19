<?php

use App\Http\Controllers\AdminController;
use App\Http\Livewire\StoreLote;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\EtapaController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PostoVacinacaoController;
use App\Http\Controllers\EstatisticaController;
use App\Models\Candidato;

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

Route::get('/', [WelcomeController::class, 'index'])->name('index');

Route::get('/teste', function() {
    DB::enableQueryLog();
    $result = DB::select(DB::raw('select p.nome, lp.posto_vacinacao_id, "qtdVacina", count(c.*) as "Quantidade de candidatos", ("qtdVacina" - count(c.*)) as "Vacinas disponiveis",lp.id as "lote_pivot_id"
    from posto_vacinacaos p
    inner join lote_posto_vacinacao lp
    on p.id = lp.posto_vacinacao_id
    inner join candidatos c
    on c.lote_id = lp.id
    group by lp.id, "qtdVacina", lp.posto_vacinacao_id, p.nome;'));
    // $result = DB::select(DB::raw('select   nome_completo,count(nome_completo) as "QUANTIDAD DE REGISTROS" ,cpf
    // from candidatos
    // where cpf in
    //     (select c.cpf
    //     from candidatos c
    //     group by c.cpf
    //     having count(cpf) > 2)
    // group by nome_completo, cpf'));

    return response($result );

    // return view('sobre');

});

Route::get("/solicitar", [CandidatoController::class, 'solicitar'])->name("solicitacao.candidato");
Route::post("/solicitar/enviar", [CandidatoController::class, 'enviar_solicitacao'])->name("solicitacao.candidato.enviar");
// Route::get("/agendamento/{id}", [CandidatoController::class, 'ver'])->name("agendamento.ver");
Route::post("/consultar-agendamento", [CandidatoController::class, 'consultar'])->name("agendamento.consultar");
Route::get("/todos-os-postos", [PostoVacinacaoController::class, 'todosOsPostos'])->name("postos");

// Não mudar horarios e cep sem testar tudo no form de solicitar
Route::get("/horarios/{id_posto}", [PostoVacinacaoController::class, 'horarios'] )->name("posto.horarios");
Route::get("/cep/{cep}", function($cep) {
    //TODO: mover isso pra um controller
    $results = simplexml_load_file("http://cep.republicavirtual.com.br/web_cep.php?formato=xml&cep=" . $cep);
    return response()->json($results);
});
Route::get("/candidato/comprovante", [CandidatoController::class, 'comprovante'])->name('candidato.comprovante');
Route::get("/anexo/{name}", [WelcomeController::class, 'baixarAnexo'])->name('baixar.anexo');
Route::get('/sobre', [WelcomeController::class, 'sobre'])->name('sobre');

Route::middleware(['auth'])->group(function () {
    Route::get("/real", function() {

        return view('fila.fila_tempo_real');
    });

    Route::get('/admin/form',  [AdminController::class, 'userForm'])->name('admin.form.user');
    Route::post('/admin/create/user',  [AdminController::class, 'createUser'])->name('admin.create.user');
    Route::get('/dashboard',  [CandidatoController::class, 'show'])->name('dashboard');
    Route::post("/agendamento/{id}/confirmacao", [CandidatoController::class, 'update'])->name("update.agendamento");
    Route::post("/agendamento/{id}/confirmar-vacinacao", [CandidatoController::class, 'vacinado'])->name('candidato.vacinado');
    Route::get("/agendamento/confirmar-vacinacao", [CandidatoController::class, 'vacinadoAjax'])->name('candidato.vacinado.ajax');
    Route::post("/agendamento/{id}/desfazer-vacinacao", [CandidatoController::class, 'desfazerVacinado'])->name('desfazer.vacinado');
    Route::get("/agendamento/desfazer/vacinacao", [CandidatoController::class, 'desmarcarVacinadoAjax'])->name('vacinado.desmarcar.ajax');
    Route::get("/agendamento/form/edit/{id}", [CandidatoController::class, 'form_edit'])->name('candidato.form_edit');
    Route::post("/agendamento/editar", [CandidatoController::class, 'editar'])->name('candidato.editar');
    Route::get("/candidato/lote", [CandidatoController::class, 'CandidatoLote'])->name('candidato.candidatoLote');
    Route::get("/candidato/order/{field}/campo/{order}", [CandidatoController::class, 'ordenar'])->name('candidato.order');
    Route::get("/candidato/filtro/{field}/tipo/{tipo}", [CandidatoController::class, 'filtro'])->name('candidato.filtro');

    Route::get("/agendamentos/todos",       [CandidatoController::class, 'todos'])->name('candidato.todos');
    Route::get("/agendamentos/pendentes",       [CandidatoController::class, 'pendentes'])->name('candidato.pendentes');
    Route::get("/agendamentos/aprovados",       [CandidatoController::class, 'aprovados'])->name('candidato.aprovados');
    Route::get("/agendamentos/vacinados",       [CandidatoController::class, 'vacinados'])->name('candidato.vacinados');
    Route::get("/agendamentos/primeira/dose",   [CandidatoController::class, 'primeiraDose'])->name('candidato.primeira.dose');
    Route::get("/agendamentos/segunda/dose",    [CandidatoController::class, 'segundaDose'])->name('candidato.segunda.dose');
    Route::get("/agendamentos/dose/unica",      [CandidatoController::class, 'doseUnica'])->name('candidato.dose.unica');
    Route::get("/agendamentos/pontos",          [CandidatoController::class, 'pontos'])->name('candidato.pontos');
    Route::get("/agendamentos/fila",          [CandidatoController::class, 'fila'])->name('candidato.fila.espera');
    Route::get("/agendamentos/reprovados",          [CandidatoController::class, 'reprovados'])->name('candidato.reprovados');
    Route::get("/agendamentos", [CandidatoController::class, 'filtroAjax'])->name('agendamentos.filtro.ajax');

    Route::post("/agendamentos/import", [ImportController::class, 'store'])->name('candidato.import.store');

    Route::resource('/postos',PostoVacinacaoController::class );
    Route::get('/pontos/new', [PostoVacinacaoController::class, 'index_novo'])->name('postos.index.new');
    Route::resource('/lotes', LoteController::class);
    Route::get('/lotes/distribuir/{lote}', [ LoteController::class, 'distribuir'])->name('lotes.distribuir');
    Route::post('/lotes/calcular', [ LoteController::class, 'calcular'])->name('lotes.calcular');
    Route::post('/lotes/alterarQuantidadeVacina', [ LoteController::class, 'alterarQuantidadeVacina'])->name('lotes.alterarQuantidadeVacina');

    Route::get('/etapas/definir-etapa-atual', [EtapaController::class, 'definirEtapa'])->name('etapas.definirEtapa');
    Route::get('/etapas', [EtapaController::class, 'index'])->name('etapas.index');
    Route::get('/etapas/adicionar', [EtapaController::class, 'create'])->name('etapas.create');
    Route::post('/etapas/salvar', [EtapaController::class, 'store'])->name('etapas.store');
    Route::get('/etapas/{id}/editar', [EtapaController::class, 'edit'])->name('etapas.edit');
    Route::post('/etapas/{id}/excluir', [EtapaController::class, 'destroy'])->name('etapas.destroy');
    Route::post('/etapas/{id}/atualizar', [EtapaController::class, 'update'])->name('etapas.update');

    Route::get('exportar/candidato/', [ExportController::class, 'exportCandidato'])->name('export.candidato');
    Route::get('exportar/lote', [ExportController::class, 'exportLote'])->name('export.lote');
    Route::get('exportar/postos', [ExportController::class, 'exportPosto'])->name('export.posto');
    Route::get('exportar/postos/candidato', [ExportController::class, 'exportPostoCandidato'])->name('export.exportPostoCandidato');
    Route::get('exportar/index', [ExportController::class, 'exportPostoCandidato'])->name('export.index');
    Route::get('exportar/listaCandidato', [ExportController::class, 'listarCandidato'])->name('export.candidatos');
    Route::post('exportar/gerar', [ExportController::class, 'gerar'])->name('export.gerar');
    Route::get('/exportar/agendamentos/posto/{id}', [ExportController::class,'agendamentosDoPosto'])->name('export.agendamentos.posto');
    Route::get('/configuracoes', [ConfiguracaoController::class, 'index'])->name('config.index');
    Route::get('/configuracoes/salvar', [ConfiguracaoController::class, 'update'])->name('config.update');
    Route::post('/configuracoes/aprovar', [ConfiguracaoController::class, 'aprovarAgendamentos'])->name('config.agendados.aprovados');
    Route::post('/importar/vacinados', [ImportController::class, 'storeVacinados'])->name('candidato.import.store.vacinados');

    Route::get('/posto/dias-disponiveis', [PostoVacinacaoController::class, 'diasPorPosto'])->name('dias.posto.ajax');
    Route::post('/agentamento/{id}/reagendar', [CandidatoController::class, 'reagendar'])->name('agendamento.posto.update');

    Route::get('/fila/index', [FilaController::class, 'index'])->name('fila.index');
    Route::post('/fila/{id}/agendar', [FilaController::class, 'reagendar'])->name('fila.agendar');
    Route::get('/fila/distribuir', [FilaController::class, 'distribuirVacina'])->name('fila.distribuir');
    Route::get('/fila/painel', [FilaController::class, 'painel'])->name('fila.painel');
    // Route::get('/fila/distribuir', [FilaController::class, 'distribuirJob'])->name('fila.distribuir');

    Route::get('/estatisticas', [EstatisticaController::class, 'index'])->name('estatistica.index');
});


require __DIR__.'/auth.php';
