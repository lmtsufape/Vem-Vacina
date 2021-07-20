{{-- @dd($rota) --}}
<form method="GET" action={{ route($rota) }}>
    <div class="row">
        <div class="col-sm-10">
            <div class="row">
                <div class="col-md-3">
                    <input type="checkbox" name="nome_check" id="nome_check_input" onclick="mostrarFiltro(this, 'nome_check')" @if($request->nome_check != null && $request->nome_check) checked @endif>
                    <label>Por nome</label>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" name="cpf_check" id="cpf_check_input" onclick="mostrarFiltro(this, 'cpf_check')" @if($request->cpf_check != null && $request->cpf_check) checked @endif>
                    <label>Por CPF</label>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" name="sus_check" id="sus_check_input" onclick="mostrarFiltro(this, 'sus_check')" @if($request->sus_check != null && $request->sus_check) checked @endif>
                    <label>Por cartão SUS</label>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" name="data_check" id="data_check_input" onclick="mostrarFiltro(this, 'data_check')" @if($request->data_check != null && $request->data_check) checked @endif>
                    <label>Por data de agendamento</label>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" name="data_vacinado_check" id="data_vacinado_check_input" onclick="mostrarFiltro(this, 'data_vacinado_check')" @if($request->data_vacinado_check != null && $request->data_vacinado_check) checked @endif>
                    <label>Por data de Vacinado</label>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" name="mes_check" id="mes_check_input" onclick="mostrarFiltro(this, 'mes_check')" @if($request->mes_check != null && $request->mes_check) checked @endif>
                    <label>Por mês</label>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" name="dose_check" id="dose_check_input" onclick="mostrarFiltro(this, 'dose_check')" @if($request->dose_check != null && $request->dose_check) checked @endif>
                    <label>Por dose</label>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" name="outro" id="outro" @if($request->outro != null && $request->outro) checked @endif>
                    <label>É acamado</label>
                </div>
                {{-- <div class="col-md-3">
                    <input type="checkbox" name="campo_check" id="campo_check_input" @if($request->campo_check != null && $request->campo_check) checked @endif onclick="mostrarFiltro(this, 'campo_check')">
                    <label>Campo</label>
                </div> --}}
                {{-- <div class="col-md-3">
                    <input type="checkbox" name="ordem_check" id="ordem_check_input" @if($request->ordem_check != null && $request->ordem_check) checked @endif onclick="mostrarFiltro(this, 'ordem_check')">
                    <label>Ordem</label>
                </div> --}}
                <div class="col-md-3">
                    <input type="checkbox" name="ponto_check" id="ponto_check_input" @if($request->ponto_check != null && $request->ponto_check) checked @endif onclick="mostrarFiltro(this, 'ponto_check')">
                    <label>Ponto</label>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" name="tipo_check" id="tipo_check_input" @if($request->tipo_check != null && $request->tipo_check) checked @endif onclick="mostrarFiltro(this, 'tipo_check')">
                    <label>Tipo</label>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" name="publico_check" id="publico_check_input" @if($request->publico_check != null && $request->publico_check) checked @endif onclick="mostrarFiltro(this, 'publico_check')">
                    <label>Público</label>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" name="qtd_check" id="qtd_check_input" @if($request->qtd_check != null && $request->qtd_check) checked @endif onclick="mostrarFiltro(this, 'qtd_check')">
                    <label>Quantidade</label>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" name="posicao_check" id="posicao_check" @if($request->posicao_check != null && $request->posicao_check) checked @endif>
                    <label>Posição</label>
                </div>
            </div>
            <div class="row">
                <div id="nome_check" class="col-md-3" style="@if($request->nome_check != null && $request->nome_check) display: block; @else display: none; @endif">
                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite o nome" @if($request->nome != null) value="{{$request->nome}}" @endif>
                </div>
                <div id="cpf_check" class="col-md-3" style="@if($request->cpf_check != null && $request->cpf_check) display: block; @else display: none; @endif">
                    <input type="text" class="form-control cpf" name="cpf" id="cpf" placeholder="Digite o CPF"  @if($request->cpf != null) value="{{$request->cpf}}" @endif>
                </div>
                <div id="sus_check" class="col-md-3" style="@if($request->sus_check != null && $request->sus_check) display: block; @else display: none; @endif">
                    <input type="text" class="form-control sus" name="sus" id="sus" placeholder="Digite o SUS"  @if($request->sus != null) value="{{$request->sus}}" @endif>
                </div>
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
                <div id="campo_check" class="col-md-3" @if($request->campo_check != null && $request->campo_check) style="display: block;" @else style="display: none;" @endif >
                    <select id="campo" name="campo" class="form-control">
                        <option value="">-- campo --</option>
                        <option @if($request->campo == "cpf") selected @endif value="cpf">cpf</option>
                        <option @if($request->campo == "nome_completo") selected @endif value="nome_completo">nome</option>
                        <option @if($request->campo == "chegada") selected @endif value="chegada">dia</option>
                    </select>
                </div>

                <div id="ordem_check" class="col-md-3" @if($request->ordem_check != null && $request->ordem_check) style="display: block;" @else style="display:none;" @endif>
                    <select id="ordem" name="ordem" class="form-control">
                        <option value="">-- ordem --</option>
                        <option @if($request->ordem == "asc") selected @endif value="asc">Crescente</option>
                        <option @if($request->ordem == "desc") selected @endif value="desc">Descrescente</option>
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
                <div id="tipo_check" class="col-md-3" @if($request->tipo_check != null && $request->tipo_check) style="display: block;" @else style="display:none;" @endif>
                    <select id="tipo" name="tipo" class="form-control">
                        <option value="">-- tipo --</option>
                            <option @if($request->tipo == "Aprovado") selected @endif value="{{ "Aprovado" }}">{{ "Aprovado" }}</option>
                            <option @if($request->tipo == "Reprovado") selected @endif value="{{ "Reprovado" }}">{{ "Reprovado" }}</option>
                            <option @if($request->tipo == "Vacinado") selected @endif value="{{ "Vacinado" }}">{{ "Vacinado" }}</option>
                            <option @if($request->tipo == "Não Analisado") selected @endif value="{{ "Não Analisado" }}">{{ "Não Analisado" }}</option>
                    </select>
                </div>
                <div id="publico_check" class="col-md-3" @if($request->publico_check != null && $request->publico_check) style="display: block;" @else style="display:none;" @endif>
                    <select id="publico" name="publico" class="form-control">
                        <option value="">-- Público --</option>
                        @foreach ($publicos as $publico)
                            <option @if($request->publico == $publico->id) selected @endif value="{{ $publico->id }}">{{ $publico->texto_home }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="qtd_check" class="col-md-3" @if($request->qtd_check != null && $request->qtd_check) style="display: block;" @else style="display:none;" @endif>
                    <select id="qtd" name="qtd" class="form-control">
                        <option @if($request->qtd == "10") selected @endif value="10">10</option>
                        <option @if($request->qtd == "20") selected @endif value="20">20</option>
                        <option @if($request->qtd == "100") selected @endif value="100">100</option>
                        <option @if($request->qtd == "200") selected @endif value="200">200</option>
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
                    <a href={{ route($rota) }}><button type="button" class="btn btn-secondary" style="width: 100%;">Limpar filtros</button></a>
                </div>
            </div>
        </div>
    </div>
</form>
