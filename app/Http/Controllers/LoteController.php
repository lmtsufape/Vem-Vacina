<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use App\Http\Requests\StoreLoteRequest;
use App\Http\Requests\DistribuicaoRequest;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        return view('lotes.store');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoteRequest $request)
    {

        $this->isChecked($request, 'segunda_dose');

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
        $this->isChecked($request, 'segunda_dose');

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
        $lote = Lote::findOrFail($id);
        $lote->delete();

        return redirect()->route('lotes.index')->with('message', 'Lote excluído com sucesso!');

    }

    public function distribuir($id)
    {
        $lote = Lote::findOrFail($id);
        $postos = PostoVacinacao::all();
        return view('lotes.distribuicao', compact('lote', 'postos'));
    }

    public function calcular(DistribuicaoRequest $request)
    {
        $lote_id = $request->lote;
        $lote = Lote::find($lote_id);
        $postos = PostoVacinacao::whereIn('id', array_keys($request->posto))->get();

        if(array_sum($request->posto) > $lote->numero_vacinas){
            return redirect()->route('lotes.index')->with('message', 'Soma das vacinas maior que a quantidade do lote!');
        }


        foreach($request->posto as $key => $value){
            $posto = PostoVacinacao::find($key);
            $lote->numero_vacinas -= $value;
            $lote->save();
            // dd($posto->lotes->find($lote_id) == null);
            $posto->lotes()->syncWithoutDetaching($lote);

            $posto->lotes->find($lote_id)->pivot->qtdVacina += $value;
            $posto->vacinas_disponiveis += $value;
            $posto->vacinas_disponiveis->save();

            $posto->lotes->find($lote_id)->pivot->save();

        }

        return redirect()->route('lotes.index')->with('message', 'Lote distribuído com sucesso!');
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
