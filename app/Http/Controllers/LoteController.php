<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use App\Http\Requests\StoreLoteRequest;
use App\Http\Requests\DistribuicaoRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

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
        return view('lotes.index', compact('lotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('criar-lote');
        return view('lotes.store');
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
            'numero_lote'       => 'required|min:6|max:8|unique:lotes',
            'fabricante'        => 'required|max:30',
            'numero_vacinas'    => 'required|gt:0|integer',
            'dose_unica'        => '',
            'inicio_periodo'    => 'required|integer|gte:0',
            'fim_periodo'       => 'required|gte:inicio_periodo|integer|gte:1',
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
                "dose_unica" => "Intervalo para segunda dose deve ser preenchido."
            ])->withInput();

        }elseif($request->dose_unica && $request->inicio_periodo != null && $request->fim_periodo != null){
            return redirect()->back()->withErrors([
                "inicio_periodo" => "Intervalo deve ser vazio.",
                "fim_periodo"    => "Intervalo deve ser vazio."
            ])->withInput();
        }

        $data = $request->all();
        $lote = Lote::create($data);

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
        return view('lotes.edit', compact('lote'));
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

        $this->isChecked($request, 'dose_unica');

        $data = $request->all();
        $lote = Lote::findOrFail($id);
        $lote->update($data);

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
        if (true) {
            return redirect()->back()
                            ->withErrors([
                                "message" => "Este lote não pode ser apagado."
                            ])->withInput();
        }
        $lote->delete();

        return redirect()->route('lotes.index')->with('message', 'Lote excluído com sucesso!');

    }

    public function distribuir($id)
    {
        Gate::authorize('distribuir-lote');
        $lote = Lote::findOrFail($id);
        // $postos = PostoVacinacao::orderBy('vacinas_disponiveis')->get();
        $postos = PostoVacinacao::all();
        return view('lotes.distribuicao', compact('lote', 'postos'));
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
            return redirect()->route('lotes.index')->with('message', 'Soma das vacinas maior que a quantidade do lote!');
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
        $lote   = Lote::findOrFail($request->lote_id);
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

        if ($posto->getVacinasDisponivel($request->lote_id) > $request->quantidade) {
            $posto->subVacinaEmLote($request->lote_id, $request->quantidade) ;
            $lote->numero_vacinas += $request->quantidade;
            $lote->save();
        }elseif($posto->getVacinasDisponivel($request->lote_id) == $request->quantidade){
            $lote->numero_vacinas += $request->quantidade;
            $lote->save();
            $posto->lotes()->detach($lote);
        }else{
            return redirect()->back()
                        ->withErrors([
                            "quantidade" => "Quantidade a devolver deve ser menor que a quantidade de vacinas disponíveis."
                        ])->withInput();
        }
        return back()->with(['message' => "Devolução realizada com sucesso!"]);
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
