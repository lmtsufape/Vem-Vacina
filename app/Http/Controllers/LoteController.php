<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Etapa;
use App\Models\Candidato;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreLoteRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DistribuicaoRequest;
use App\Models\LotePostoVacinacao;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('ver-lote');

        $lotes = Lote::paginate(10);
        $tipos = Etapa::TIPO_ENUM;
        return view('lotes.index', compact('lotes', 'tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('criar-lote');

        $etapas = Etapa::where('tipo', '!=', Etapa::TIPO_ENUM[3])->orderBy('id')->get();
        $pontos = PostoVacinacao::all();
        return view('lotes.store')->with(['etapas' => $etapas,
                                           'tipos' => Etapa::TIPO_ENUM,]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('criar-lote');
        $rules = [
            'numero_lote'       => 'required|min:6|max:12|unique:lotes',
            'fabricante'        => 'required|max:30',
            'numero_vacinas'    => 'required|gt:0|integer',
            'dose_unica'        => '',
            'inicio_periodo'    => 'nullable|gte:0',
            'fim_periodo'       => 'nullable|gte:inicio_periodo|gte:1',
            'data_fabricacao'   => 'nullable|before:data_validade',
            'data_validade'     => 'nullable|after:data_fabricacao',
        ];

        $messages = [
            'inicio_periodo.gte:inicio_periodo' => 'O número digitado deve ser maior ou igual ao inicio do periodo.',
            'inicio_periodo.gte:0' => 'O número digitado deve ser maior ou igual ao inicio do periodo.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages );

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $this->isChecked($request, 'dose_unica');
;
        if(!$request->dose_unica && $request->numero_vacinas % 2 != 0) {
            return redirect()->back()->withErrors([
                "numero_vacinas" => "Número tem que ser par."
            ])->withInput();

        }
        if(!$request->dose_unica && $request->inicio_periodo == null && $request->fim_periodo == null) {
            return redirect()->back()->withErrors([
                "inicio_periodo" => "Intervalo para segunda dose deve ser preenchido.",
                "fim_periodo"    => "Intervalo para segunda dose deve ser preenchido."
            ])->withInput();

        }elseif($request->dose_unica && $request->inicio_periodo != null && $request->fim_periodo != null){
            return redirect()->back()->withErrors([
                "inicio_periodo" => "Intervalo deve ser vazio.",
                "fim_periodo"    => "Intervalo deve ser vazio."
            ])->withInput();
        }

        $data = $request->all();
        $lote = Lote::create($data);

        $lote->etapas()->sync($request->etapa_id);

        return redirect()->route('lotes.index')->with('message', 'Lote criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('editar-lote');

        $lote = Lote::findOrFail($id);
        $tipos = Etapa::TIPO_ENUM;
        $etapas = Etapa::all();
        return view('lotes.edit', compact('lote', 'tipos', 'etapas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('editar-lote');

        $rules = [
            'numero_lote'       => 'required|min:6|max:12',
            'fabricante'        => 'required|max:30',
            'numero_vacinas'    => 'required|gte:0|integer',
            'dose_unica'        => '',
            'inicio_periodo'    => 'nullable|gte:0',
            'fim_periodo'       => 'nullable|gte:inicio_periodo|gte:1',
            'data_fabricacao'   => 'nullable|before:data_validade',
            'data_validade'     => 'nullable|after:data_fabricacao',
        ];

        $messages = [
            'inicio_periodo.gte:inicio_periodo' => 'O número digitado deve ser maior ou igual ao inicio do periodo.',
            'inicio_periodo.gte:0' => 'O número digitado deve ser maior ou igual ao inicio do periodo.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages );

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $this->isChecked($request, 'dose_unica');

        if(!$request->dose_unica && $request->numero_vacinas % 2 != 0) {
            return redirect()->back()->withErrors([
                "numero_vacinas" => "Número tem que ser par."
            ])->withInput();

        }
        if(!$request->dose_unica && $request->inicio_periodo == null && $request->fim_periodo == null) {
            return redirect()->back()->withErrors([
                "inicio_periodo" => "Intervalo para segunda dose deve ser preenchido.",
                "fim_periodo"    => "Intervalo para segunda dose deve ser preenchido."
            ])->withInput();

        }elseif($request->dose_unica && $request->inicio_periodo != null && $request->fim_periodo != null){
            return redirect()->back()->withErrors([
                "inicio_periodo" => "Intervalo deve ser vazio.",
                "fim_periodo"    => "Intervalo deve ser vazio."
            ])->withInput();
        }

        $data = $request->all();
        // dd($request->all());
        $lote = Lote::findOrFail($id);
        $lote->update($data);
        $lote->etapas()->sync($request->etapa_id);

        return redirect()->route('lotes.index')->with('message', 'Lote editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('apagar-lote');
        $lote = Lote::findOrFail($id);
        if ($lote->postos->count()) {
            return redirect()->back()
                            ->withErrors([
                                "message" => "Existe ponto(s) de vacinação associados com esse lote."
                            ])->withInput();
        }
        if ($lote->numero_vacinas > 0) {
            return redirect()->back()
                            ->withErrors([
                                "message" => "Este lote contém vacinas."
                            ])->withInput();
        }
        $lote->delete();

        return redirect()->route('lotes.index')->with('message', 'Lote excluído com sucesso!');

    }

    public function distribuir($id)
    {
        Gate::authorize('distribuir-lote');
        $lote = Lote::findOrFail($id);
        if ($lote->etapas->count() == 0) {
            return redirect()->back()
                    ->withErrors([
                        "message" => "Lote sem público associado."
                    ]);
        }
        $lotes_pivot = LotePostoVacinacao::all();
        // $postos = PostoVacinacao::orderBy('vacinas_disponiveis')->get();
        $postos = PostoVacinacao::all();
        $candidatos = Candidato::all();
        return view('lotes.distribuicao', compact('lote', 'postos', 'lotes_pivot', 'candidatos'));
    }

    public function calcular(Request $request)
    {
        Gate::authorize('distribuir-lote');
        $rules = [
            'posto.*' => 'gte:0|integer'
        ];
        $messages = [
            'posto.*.gte' => 'O número digitado deve ser maior ou igual a 0.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages );


        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $lote_id = $request->lote;
        $lote = Lote::find($lote_id);
        $postos = PostoVacinacao::whereIn('id', array_keys($request->posto))->get();

        if(array_sum($request->posto) > $lote->numero_vacinas){
            return redirect()->back()
                    ->withErrors([
                        "message" => "Soma das vacinas maior que a quantidade do lote!"
                    ])->withInput();
        }


        foreach($request->posto as $key => $value){
            if ($value > 0) {
                $posto = PostoVacinacao::find($key);
                $lote->numero_vacinas -= $value;
                $lote->save();
                $posto->lotes()->syncWithoutDetaching($lote);
                $posto->lotes->find($lote_id)->pivot->qtdVacina += $value;
                $posto->lotes->find($lote_id)->pivot->save();
            }

        }

        return redirect()->route('lotes.index')->with('message', 'Lote distribuído com sucesso!');
    }

    public function alterarQuantidadeVacina(Request $request)
    {
        Gate::authorize('distribuir-lote');

        try {
        $lote_original   = Lote::findOrFail($request->lote_original_id);
        $posto  = PostoVacinacao::find($request->posto_id);

        $rules = [
            'quantidade' => 'gte:1|integer'
        ];
        $messages = [
            'quantidade.gte' => 'O número digitado deve ser maior ou igual a 0.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages );

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $lotes_pivot = LotePostoVacinacao::where("posto_vacinacao_id", $posto->id)->where('id', $request->lote_id)->first();
        $qtdCandidato = Candidato::where('posto_vacinacao_id', $posto->id )->where('lote_id', $request->lote_id)->count();
        if(($lotes_pivot->qtdVacina - $qtdCandidato) > 0 && ($lotes_pivot->qtdVacina - $qtdCandidato) >= $request->quantidade){
            // dd(($lotes_pivot->qtdVacina - $qtdCandidato) == $request->quantidade);
            if (($lotes_pivot->qtdVacina - $qtdCandidato) > $request->quantidade) {
                $lotes_pivot->qtdVacina -= $request->quantidade;
                $lote_original->numero_vacinas += $request->quantidade;
                $lote_original->save();
                $lotes_pivot->save();
            }elseif(($lotes_pivot->qtdVacina - $qtdCandidato) == $request->quantidade){
                $lotes_pivot->qtdVacina -= $request->quantidade;
                $lote_original->numero_vacinas += $request->quantidade;
                $lote_original->save();
                $lotes_pivot->save();
                if(Candidato::where('posto_vacinacao_id', $posto->id )->count() == 0){
                    $posto->lotes()->detach($lote_original);
                    $posto->refresh();
                }
            }else{
                return redirect()->back()
                            ->withErrors([
                                "quantidade" => "Quantidade a devolver deve ser menor que a quantidade de vacinas disponíveis."
                            ])->withInput();
            }
        }else{
            return redirect()->back()
                        ->withErrors([
                            "quantidade" => "Quantidade a devolver deve ser menor que a quantidade de vacinas disponíveis."
                        ])->withInput();
        }


        return back()->with(['message' => "Devolução realizada com sucesso!"])->withInput();
        } catch (\Throwable $th) {
            return back()->with(['message' => $th->getMessage()]);
        }

    }

    private function isChecked($request ,$field)
    {
        if(!$request->has($field))
        {
            $request->merge([$field => false]);
        }else{
            $request->merge([$field => true]);
        }
    }

}
