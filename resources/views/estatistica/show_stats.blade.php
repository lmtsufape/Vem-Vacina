@php
    use Carbon\Carbon;    
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-10">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Estatísticas por ponto :') }}
                    {{  $ponto ? $ponto->nome : "Indefinido" }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col-sm-12">
                {{-- <form action="{{ route('estatistica.showStats') }}" method="get">
                    <select class="custom-select" style="height: 200px" name="publicos[]" multiple>
                        @foreach ($todosPublicos as $publico)
                            <option value="{{ $publico->id }}" >{{ $publico->texto_home }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary mt-1">
                        Ver
                    </button>

                </form>
                <br> --}}
                <form method="GET" action={{ route('estatistica.showStats') }}>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="row">
                                {{-- <div class="col-md-3">
                                    <input type="checkbox" name="data_check" id="data_check_input" onclick="mostrarFiltro(this, 'data_check')" @if($request->data_check != null && $request->data_check) checked @endif>
                                    <label>Por data de agendamento</label>
                                </div> --}}
                                <div class="col-md-3">
                                    <input type="checkbox" name="data_vacinado_check" id="data_vacinado_check_input" onclick="mostrarFiltro(this, 'data_vacinado_check')" @if($request->data_vacinado_check != null && $request->data_vacinado_check) checked @endif>
                                    <label>Por data de Vacinado</label>
                                </div>
                                {{-- <div class="col-md-3">
                                    <input type="checkbox" name="mes_check" id="mes_check_input" onclick="mostrarFiltro(this, 'mes_check')" @if($request->mes_check != null && $request->mes_check) checked @endif>
                                    <label>Por mês</label>
                                </div> --}}
                                {{-- <div class="col-md-3">
                                    <input type="checkbox" name="dose_check" id="dose_check_input" onclick="mostrarFiltro(this, 'dose_check')" @if($request->dose_check != null && $request->dose_check) checked @endif>
                                    <label>Por dose</label>
                                </div> --}}
                                {{-- <div class="col-md-3">
                                    <input type="checkbox" name="ponto_check" id="ponto_check_input" @if($request->ponto_check != null && $request->ponto_check) checked @endif onclick="mostrarFiltro(this, 'ponto_check')">
                                    <label>Ponto</label>
                                </div> --}}
                                <div class="col-md-3">
                                    <input type="checkbox" name="publico_check" id="publico_check_input" @if($request->publico_check != null && $request->publico_check) checked @endif onclick="mostrarFiltro(this, 'publico_check')">
                                    <label>Público</label>
                                </div>
                            </div>
                            <div class="row">
                                <div id="data_check" class="col-md-3" style="@if($request->data_check != null && $request->data_check) display: block; @else display: none; @endif">
                                    <input type="date" class="form-control" name="data" id="data" @if($request->data != null) value="{{$request->data}}" @endif>
                                </div>
                                <div id="data_vacinado_check" class="col-md-3" style="@if($request->data_vacinado_check != null && $request->data_vacinado_check) display: block; @else display: none; @endif">
                                    <input type="date" class="form-control" name="data_vacinado" id="data_vacinado" @if($request->data_vacinado != null) value="{{$request->data_vacinado}}" @endif>
                                </div>
                                <div id="mes_check" class="col-md-3" style="@if($request->mes_check != null && $request->mes_check) display: block; @else display: none; @endif">
                                    <input type="month" class="form-control" name="mes" id="mes" @if($request->mes != null) value="{{$request->mes}}" @endif>
                                </div>
                                <div id="dose_check" class="col-md-3" style="@if($request->dose_check != null && $request->dose_check) display: block; @else display: none; @endif">
                                    <select id="dose" name="dose" class="form-control">
                                        <option value="">-- Dose --</option>
                                        <option @if($request->dose == $doses[0]) selected @endif value="{{$doses[0]}}">1ª dose</option>
                                        <option @if($request->dose == $doses[1]) selected @endif value="{{$doses[1]}}">2ª dose</option>
                                    </select>
                                </div>
                                <div id="ponto_check" class="col-md-3" @if($request->ponto_check != null && $request->ponto_check) style="display: block;" @else style="display:none;" @endif>
                                    <select id="ponto" name="ponto" class="form-control">
                                        <option value="">-- ponto --</option>
                                        @foreach ($postos as $posto)
                                            <option @if($request->ponto == $posto->id) selected @endif value="{{ $posto->id }}">{{ $posto->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- @if(array_key_exists( $key, $publicos->toArray()) && $publicos[$key]->id == $publico->id ) selected @endif  --}}
                                <div id="publico_check" class="col-md-6" @if($request->publico_check != null && $request->publico_check) style="display: block;" @else style="display:none;" @endif>
                                    <select id="publico" name="publico[]" class="form-control" multiple>
                                        @foreach ($todosPublicos as $key => $publico)
                                            <option value="{{ $publico->id }}">{{ $publico->texto_home }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <div class="col-md-12" style="margin-bottom: 5px;">
                                    <button type="submit" class="btn btn-primary" style="width: 100%;">Filtrar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href={{ route('estatistica.showStats') }}><button type="button" class="btn btn-secondary" style="width: 100%;">Limpar filtros</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Público</th>
                            <th scope="col">Ponto</th>
                            <th scope="col">Vacinados</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            
                            $amanha = (new Carbon($request->data_vacinado))->addDays(1);
                            $hoje = (new Carbon($request->data_vacinado));
                           
                        @endphp
                        @foreach ($publicos as $publico)
                            <tr>
                                <td>
                                    {{$publico->texto_home}}
                                </td>
                                
                                <td>
                                    {{$ponto->nome}}
                                </td>
                                <td>
                                    {{$publico->candidatos->where('aprovacao', 'Vacinado')->where('updated_at','>=',$hoje)
                                        ->where('updated_at','<', $amanha)->where('posto_vacinacao_id', $ponto->id)->count()}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function mostrarFiltro(check, id) {
            if(check.checked) {
                document.getElementById(id).style.display = "block";
            } else {
                document.getElementById(id).style.display = "none";
            }
        }
    </script>
</x-app-layout>
