<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Etapa;
use App\Models\Candidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

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

    public function createUser(Request $request)
    {
        Gate::authorize('criar-user');
        $data = $request->all();

        $data['password'] = Hash::make($data['password']);
        // dd($data);

        $user = User::create($data);

        return redirect()->route('dashboard')->with(['mensagem' => "Usuário criado!"]);
    }


}
