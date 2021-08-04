<?php

namespace App\Http\Controllers;

use DateInterval;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Etapa;
use App\Models\Candidato;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use App\Models\LotePostoVacinacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Notifications\CandidatoAtualizado;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{

    public function userForm(Request $request)
    {
        Gate::authorize('criar-user');
        return view('admin.criar_user');
    }
    public function posicaoFila(Request $request)
    {
        Gate::authorize('posicao-fila');

        $query = Candidato::query()->where('aprovacao', Candidato::APROVACAO_ENUM[0]);

        if ($request->publico_check) {
            if ($request->publico != null) {
                $query->where('etapa_id', $request->publico);
            }
        }

        $agendamentos = $query->oldest()->get();
        // dd($agendamentos->get());
        $posicao = 0;
        $total = $query->oldest()->count();
        $agendamento = null;
        foreach ($agendamentos as $key => $value) {
            $posicao++;
            if($request->cpf == $value->cpf || $request->nome ==  $value->nome_completo ){
                $agendamento = $value;
                break;
            }

        }


        return view('admin.show_posicao_fila')->with(['candidato' => $agendamento,
                                                'posicao' => $posicao,
                                                'total' => $total,
                                                'publicos' => Etapa::orderBy('texto_home')->get(),
                                                'request' => $request]);
    }
    public function editarListaData(Request $request)
    {
        Gate::authorize('posicao-fila');

        if ($request->tipo == "Não Analisado") {
            $query = Candidato::query()->where('aprovacao', Candidato::APROVACAO_ENUM[0]);
        }else if ($request->tipo == "Aprovado") {
            $query = Candidato::query()->where('aprovacao', Candidato::APROVACAO_ENUM[1]);
        }else if ($request->tipo == "Reprovado") {
            $query = Candidato::query()->onlyTrashed()->where('aprovacao', Candidato::APROVACAO_ENUM[2]);
        }else if ($request->tipo == "Vacinado") {
            $query = Candidato::query()->where('aprovacao', Candidato::APROVACAO_ENUM[3]);
        }else{
            $query = Candidato::query()->whereIn('aprovacao', [Candidato::APROVACAO_ENUM[1], Candidato::APROVACAO_ENUM[3]]);
        }

        if ($request->nome_check && $request->nome != null) {
            $query->where('nome_completo', 'ilike', '%' . $request->nome . '%');
        }

        if ($request->ponto_check && $request->ponto != null) {
            $query->where('posto_vacinacao_id', $request->ponto);
        }

        if ($request->cpf_check && $request->cpf != null) {
            $query->where('cpf', 'ilike', '%'.$request->cpf.'%');
        }

        if ($request->data_check && $request->data != null) {
            $amanha = (new Carbon($request->data))->addDays(1);
            $hoje = (new Carbon($request->data));
            $query->where([['chegada','>=',$hoje], ['chegada','<=', $amanha]]);
        }
        if ($request->data_vacinado_check && $request->data_vacinado != null) {
            $amanha = (new Carbon($request->data_vacinado))->addDays(1);
            $hoje = (new Carbon($request->data_vacinado));
            $query->where([['updated_at','>=',$hoje], ['updated_at','<=', $amanha]]);
        }
        if ($request->dose_check && $request->dose != null) {
            $query->where('dose',$request->dose);
        }
        if ($request->aprovado) {
            $query->where('aprovacao', Candidato::APROVACAO_ENUM[1]);
        }

        if ($request->duplicado) {
            $query->where('cpf', Candidato::APROVACAO_ENUM[0]);
        }
        if ($request->publico_check) {
            if ($request->publico != null) {
                $query->where('etapa_id', $request->publico);
            }
        }
        if ($request->sus_check) {
            if ($request->sus) {
                $query->where('numero_cartao_sus', 'ilike', '%'.$request->sus.'%');
            }
        }
        if ($request->ordem_check && $request->ordem != null) {
            if($request->campo != null){
                $query->orderBy($request->campo, $request->ordem);
            }else{
                $query->orderBy('nome_completo', $request->ordem);
            }
        }
        if ($request->campo_check && $request->campo != null) {
            $query->orderBy($request->campo);
        }
        if ($request->outro) {
            $agendamentos = $query->get();
        } else {
            $agendamentos = $query->orderBy('created_at')->with(['etapa','outrasInfo', 'lote', 'resultado', 'posto'])->paginate(200);
        }
        if ($request->outro) {
            $agendamentosComOutrasInfo = collect();

            foreach ($agendamentos as $agendamento) {
                $outros = $agendamento->outrasInfo;
                if($outros != null && count($outros) > 0) {
                    $agendamentosComOutrasInfo->push($agendamento);
                }
            }

            if ($agendamentosComOutrasInfo->count() > 0) {
                $agendamentos = $agendamentosComOutrasInfo;
            } else {
                $agendamentos = collect();
            }
        }
        return view('admin.editar_data_lista')->with(['candidatos' => $agendamentos,
                                                    'candidato_enum' => Candidato::APROVACAO_ENUM,
                                                    'tipos' => Etapa::TIPO_ENUM,
                                                    'postos' => PostoVacinacao::all(),
                                                    'doses' => Candidato::DOSE_ENUM,
                                                    'publicos' => Etapa::orderBy('texto_home')->get(),
                                                    'request' => $request]);
    }

    public function updateListaData(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'chegada' => 'required',
        ]);
        set_time_limit(180);
        try {
            Gate::authorize('editar-candidato');

            $candidatos = Candidato::whereIn('id', $request->ids)->get();


            foreach ($candidatos as $key => $candidato) {
                DB::beginTransaction();

                if($candidato->aprovacao != "Aprovado"){
                    return back()->with(['message' => "Não permitido"]);
                }
                $datetime_chegada = Carbon::createFromFormat("Y-m-d H:i", $request->chegada. " " .  date("H:i", strtotime($candidato->chegada)));

                $candidato->update([
                    'chegada'         => $datetime_chegada,
                    'saida'         => $datetime_chegada->copy()->modify('+2 minutes'),
                ]);
                if($candidato->dose == "1ª Dose" && Candidato::where('cpf',$candidato->cpf)->where('id', '!=',$candidato->id)->first() != null){
                    $lote = LotePostoVacinacao::findOrFail($candidato->lote_id)->lote;
                    $candidato2 = Candidato::where('cpf',$candidato->cpf)->where('id', '!=',$candidato->id)->first();
                    $datetime_chegada_segunda_dose = $datetime_chegada->add(new DateInterval('P'.$lote->inicio_periodo.'D'));
                    $candidato2->update([
                        'chegada'         => $datetime_chegada_segunda_dose,
                        'saida'         => $datetime_chegada_segunda_dose->copy()->modify('+2 minutes'),
                    ]);
                }

                if($candidato->email != null){
                    Notification::send($candidato, new CandidatoAtualizado($candidato));
                    sleep(1);
                }

                DB::commit();
            }


            return back()->with(['message' => "Atualizado com sucesso"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with(['message' => $th->getMessage()]);
        }
    }

    public function createUser(Request $request)
    {
        Gate::authorize('criar-user');
        $data = $request->all();

        $data['password'] = Hash::make($data['password']);
        // dd($data);

        $user = User::create($data);

        return redirect()->route('dashboard')->with(['mensagem' => "Usuário criado!"]);
    }
    
    public function listUser(Request $request)
    {
        Gate::authorize('criar-user');
        
        $users = User::all();

        return view('admin.users', compact('users'));
    }
    public function editUser($id)
    {
        Gate::authorize('criar-user');
        
        $user = User::find($id);
        $pontos = PostoVacinacao::where('status', '!=', 'arquivado')->orderBy('nome')->get();

        return view('admin.edit_user', compact('user', 'pontos'));
    }
    public function updateUser(Request $request, $id)
    {
        Gate::authorize('criar-user'); 

        $user = User::find($id);
        $pontos = PostoVacinacao::whereIn('id', $request->pontos)->pluck('id');
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->pontos()->sync($pontos->toArray());

        // dd($user->pontos);

        return redirect()->route('admin.list.user')->with(['mensagem' => "Usuário atualizado!"]);
        // return redirect()->route('dashboard')->with(['mensagem' => "Usuário atualizado!"]);
    }

    public function arquivadosPonto()
    {
        $pontos = PostoVacinacao::where('status', 'arquivado')->get();
        return view('admin.pontos.arquivados', compact('pontos'));
    }

    

}
