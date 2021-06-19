<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Lista de agendamentos') }}
                </h2>
                <a href="{{ route('dashboard') }}">
                    <small>Atualizar página <i class="fas fa-redo"></i> </small>
                </a>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{route('solicitacao.candidato')}}">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Fazer agendamento
                    </button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <form method="GET" action="{{route('dashboard')}}">
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
                                    <a href="{{route('dashboard')}}"><button type="button" class="btn btn-secondary" style="width: 100%;">Limpar filtros</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    @if(session('mensagem'))
                    <div class="col-md-12">
                        <div class="alert alert-success" role="alert">
                            <p>{{session('mensagem')}}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <br>
                <span class="badge badge-success">Aprovado</span>
                <span class="badge badge-danger">Reprovado</span>
                <span class="badge badge-warning">Fila de Espera</span>
                <span class="badge badge-info">Vacinado</span>

                <div class="table-responsive">
                    <table class="table table-condensed"  id="myTable">

                        <tbody class="panel">
                          <div class="accordion" id="accordionExample">
                            @foreach ($candidatos as $i => $candidato)
                            <div class="card">
                              <div class="card-header  @if ($candidato->aprovacao == $candidato_enum[3]) bg-info @elseif($candidato->aprovacao == $candidato_enum[0]) bg-warning @elseif($candidato->aprovacao == $candidato_enum[1]) bg-success @elseif($candidato->aprovacao == $candidato_enum[2]) bg-danger @endif " id="headingOne">
                                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">

                                        <div class="col-sm-8">

                                                <button class="btn btn-white btn-block text-left @if ($candidato->aprovacao != $candidato_enum[0]) text-white @elseif($candidato->aprovacao == $candidato_enum[0]) text-dark  @endif " type="button" data-toggle="collapse" data-target="#collapse{{ $i }}" aria-expanded="true" aria-controls="collapseOne">
                                                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                                                        <div class="col ">
                                                            <span  class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" >
                                                                <strong>    {{ "CPF : " }}   </strong> {{ $candidato->cpf }}
                                                            </span>
                                                        </div>
                                                        <div class="col ">
                                                            <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" >
                                                                <strong> {{ " - Dose: " }}</strong> {{$candidato->dose}}
                                                            </span>
                                                        </div>
                                                        <div class="col col-6">
                                                            <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$candidato->nome_completo}}" style="width: 100%;">
                                                                <strong>   {{ "- Nome: "}} </strong>  {{$candidato->nome_completo}}
                                                                </span>
                                                        </div>
                                                    </div>

                                                </button>

                                        </div>
                                        <div class="col-sm ">
                                            <div>
                                                @can('confirmar-vaga-candidato')
                                                    @if($candidato->lote_id)
                                                        @if ($candidato->aprovacao != null && $candidato->aprovacao == $candidato_enum[3] )
                                                          <div class="row  align-items-end">
                                                              <div class="col-md-12 mt-2 text-center">
                                                                  <span class=" text-white " >Vacinado</span>
                                                              </div>
                                                          </div>

                                                        @else
                                                            <form method="POST" action="{{route('update.agendamento', ['id' => $candidato->id])}}">
                                                                @csrf
                                                                <select onchange="this.form.submit()" id="confirmacao_{{$candidato->id}}" class="form-control" name="confirmacao" required>
                                                                    <option value="" selected disabled>selecione</option>
                                                                    <option value="{{$candidato_enum[1]}}" @if($candidato->aprovacao == $candidato_enum[1]) selected @endif>Confirmar</option>
                                                                    <option value="{{$candidato_enum[2]}}" @if($candidato->aprovacao == $candidato_enum[2]) selected @endif>Reprovado</option>
                                                                    <option value="Ausente" >Ausente</option>
                                                                    {{-- <option value="restaurar" >Restaurar</option> --}}
                                                                </select>
                                                            </form>
                                                        @endif
                                                    @endif
                                                @endcan
                                            </div>
                                        </div>
                                        <div class="col-sm  text-center">
                                            @can('whatsapp-candidato')
                                                @if ($candidato->aprovacao != null && $candidato->aprovacao != $candidato_enum[3])
                                                    <a href="https://api.whatsapp.com/send?phone=55{{$candidato->getWhatsapp()}}&text={{$candidato->getMessagemWhatsapp()}}" class="text-center text-white"  target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>
                                                @else
                                                    <a class="text-center"  target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>
                                                @endif
                                            @endcan
                                        </div>

                                    </div>
                                </div>


                              <div id="collapse{{ $i }}" class="collapse " aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="container">
                                            <div class="modal-body">
                                                @component('candidato.component_editar', ['candidato' => $candidato,'candidato_enum' =>$candidato_enum])

                                                @endcomponent
                                                {{-- @livewire('editar-candidato', ['candidato' => $candidato]) --}}
                                                <br>
                                                <div class="row">
                                                    <h4>Agendado para</h4>
                                                </div>
                                                <div >
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="posto_{{$candidato->id}}">Ponto</label>
                                                            <input id="posto_{{$candidato->id}}" type="text" class="form-control" disabled value="@if($candidato->posto != null){{$candidato->posto->nome}}@endif">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="dose_{{$candidato->id}}">Dose</label>
                                                            <input id="dose_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->dose}}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="data_{{$candidato->id}}">Data</label>
                                                            <input id="data_{{$candidato->id}}" type="text" class="form-control" disabled value="@if($candidato->posto != null){{date('d/m/Y',strtotime($candidato->chegada))}}@endif">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="chegada_{{$candidato->id}}">Horário de chegada</label>
                                                            <input id="chegada_{{$candidato->id}}" type="text" class="form-control" disabled value="@if($candidato->posto != null){{date('H:i',strtotime($candidato->chegada))}}@endif">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="saida_{{$candidato->id}}">Horário de saida</label>
                                                            <input id="saida_{{$candidato->id}}" type="text" class="form-control" disabled value="{{date('H:i',strtotime($candidato->saida))}}">
                                                        </div>
                                                    </div>

                                                </div>
                                                <br>
                                                @can('reagendar')
                                                <div class="row " id="agendado_para_{{$candidato->id}}" style="display: block;">
                                                        <div class="col-md-6">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <button id="btn_edit_{{$candidato->id}}" type="button" class="btn btn-primary" style="width: 100%;" onclick="reagendar({{$candidato->id}}, true)">Reagendar</button>
                                                        </div>
                                                    </div>
                                                @endcan
                                                <br>
                                                <div class="row">
                                                    <h4>Informações do público</h4>
                                                </div>
                                                <div class="row">
                                                    @if ($candidato->etapa->tipo == $tipos[0] || $candidato->etapa->tipo == $tipos[1] )
                                                        <div class="col-md-12">
                                                            <label for="">Público</label>
                                                            <input type="text" class="form-control" value="{{$candidato->etapa->texto}}" disabled>
                                                        </div>
                                                    @elseif($candidato->etapa->tipo == $tipos[2])
                                                        <div class="col-md-6">
                                                            <label for="">Público</label>
                                                            <input type="text" class="form-control" value="{{$candidato->etapa->texto}}" disabled>
                                                        </div>
                                                        {{-- @if($candidato->id > 10)
                                                        {{dd(App\Models\OpcoesEtapa::find((integer)$candidato->etapa_resultado))}}
                                                        @endif --}}
                                                        @if(App\Models\OpcoesEtapa::find($candidato->etapa_resultado) != null)
                                                            <div class="col-md-6">
                                                                <label for="">Opção selecionada</label>
                                                                <input type="text" class="form-control" value="{{App\Models\OpcoesEtapa::find($candidato->etapa_resultado)->opcao}}" disabled>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                                <br>
                                                @php
                                                    $lote = App\Models\LotePostoVacinacao::find($candidato->lote_id);
                                                    if($lote != null){
                                                        $lote = $lote->lote;
                                                    }
                                                @endphp
                                                @if ($lote != null)
                                                    <div class="row">
                                                        <h4>Lote</h4>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="fabricante_{{$candidato->id}}">fabricante</label>
                                                            <input id="fabricante_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$lote->fabricante ?? "Indefinido"}}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="lote_{{$candidato->id}}">Nº do lote</label>
                                                            <input id="lote_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$lote->numero_lote ?? "Indefinido"}}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="dose_unica_{{$candidato->id}}">Dose única</label>
                                                            <input id="dose_unica_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$lote->dose_unica ? "Sim" : "Não"}}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="tempo_{{$candidato->id}}">Tempo para segunda dose</label>
                                                            <input id="tempo_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$lote->dose_unica ?  " - " : $lote->inicio_periodo ." dias"  }}">
                                                        </div>
                                                    </div>
                                                @endif
                                                <br>
                                                @if ($candidato->outrasInfo != null && count($candidato->outrasInfo) > 0)
                                                    <div class="row">
                                                        <h4>Outras informações</h4>
                                                    </div>
                                                    <div class="row">
                                                        @foreach ($candidato->etapa->outrasInfo as $outraInfo)
                                                            <div class="col-md-6">
                                                                <input id="outra_{{$outraInfo->id}}" type="checkbox" disabled @if($candidato->outrasInfo->contains('id', $outraInfo->id)) checked @endif>
                                                                <label for="outra_{{$outraInfo->id}}">{{$outraInfo->campo}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <br>
                                                <div class="row">
                                                    <h4>Contato</h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="telefone_{{$candidato->id}}">Telefone</label>
                                                        <input id="telefone_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->telefone}}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="whatsapp_{{$candidato->id}}">Whatsapp</label>
                                                        <input id="whatsapp_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->whatsapp}}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="email_{{$candidato->id}}">E-mail</label>
                                                        <input id="email_{{$candidato->id}}" type="email" class="form-control" disabled value="{{$candidato->email}}">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <h4>Endereço</h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="cep_{{$candidato->id}}">CEP</label>
                                                        <input id="cep_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->cep}}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="cidade_{{$candidato->id}}">Cidade</label>
                                                        <input id="cidade_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->cidade}}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="bairro_{{$candidato->id}}">Bairro</label>
                                                        <input id="bairro_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->bairro}}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="logradouro_{{$candidato->id}}">Rua</label>
                                                        <input id="logradouro_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->logradouro}}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="numero_residencia_{{$candidato->id}}">Número da residência</label>
                                                        <input id="numero_residencia_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->numero_residencia}}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="complemento_{{$candidato->id}}">Complemento</label>
                                                        <textarea id="complemento_{{$candidato->id}}" type="text" class="form-control" disabled rows="3">{{$candidato->complemento_endereco ?? " "}}</textarea>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="badge badge-dark text-wrap text-left" style="width: 16rem;">
                                                            Criado:{{ date('d/m/Y \à\s  H:i\h', strtotime($candidato->created_at)) }}<br>
                                                            Atualizado:{{date('d/m/Y \à\s  H:i\h', strtotime($candidato->updated_at)) }}<br>
                                                            Deletado:{{ $candidato->deleted_at ?  date('d/m/Y \à\s  H:i\h', strtotime($candidato->deleted_at)): "" }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>


                                                <div id="editar_agendado_para_{{$candidato->id}}" style="display: none;">
                                                    <form id="form_editar_agendado_para_{{$candidato->id}}" action="{{route('agendamento.posto.update', ['id' => $candidato->id])}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="edit_agendamento_id" value="{{$candidato->id}}">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="posto_vacinacao_{{$candidato->id}}" class="style_titulo_input">PONTO DE VACINAÇÃO<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
                                                                <select id="posto_vacinacao_{{$candidato->id}}" class="form-control style_input @error('posto_vacinacao_'.$candidato->id) is-invalid @enderror" name="posto_vacinacao_{{$candidato->id}}" required onchange="selecionar_posto(this, {{$candidato->id}})">
                                                                    <option selected disabled>-- Selecione o ponto --</option>
                                                                    @foreach($candidato->etapa->pontos as $posto)
                                                                        <option value="{{$posto->id}}">{{$posto->nome}}</option>
                                                                    @endforeach
                                                                </select>

                                                                @error('posto_vacinacao_'.$candidato->id)
                                                                <div id="validationServer05Feedback" class="invalid-feedback">
                                                                    <strong>{{$message}}</strong>
                                                                </div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-md-6" id="seletor_data_{{$candidato->id}}"></div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12" id="seletor_horario_{{$candidato->id}}"></div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-md-6">
                                                                <button type="button" class="btn btn-secondary" style="width: 100%;" onclick="reagendar({{$candidato->id}}, false)">Cancelar</button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button type="submit" class="btn btn-success" style="width: 100%;" form="form_editar_agendado_para_{{$candidato->id}}">Salvar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                            @endforeach
                          </div>
                        </tbody>
                    </table>
                    @if ($request != null && $request->outro == false)
                        <div class="row">
                            <div class="col-sm-12">
                                {{ $candidatos->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- @foreach ($candidatos as $i => $candidato)
        <!-- Modal -->
            <div class="modal fade" id="visualizar_candidato_{{$candidato->id}}" tabindex="-1" aria-labelledby="visualizar_candidato_{{$candidato->id}}_label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="visualizar_candidato_{{$candidato->id}}_label">Visualizar {{$candidato->nome_completo}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="container">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-10">
                                    <h4>Informações do público</h4>
                                </div>
                                @can('editar-candidato')
                                    <div class="col-2">
                                        <a class="btn btn-info" href="{{ route('candidato.form_edit', ['id' => $candidato->id]) }}">Editar</a>
                                    </div>
                                @endcan

                            </div>
                            <div class="row">
                                @if ($candidato->etapa->tipo == $tipos[0] || $candidato->etapa->tipo == $tipos[1] )
                                    <div class="col-md-12">
                                        <label for="">Público</label>
                                        <input type="text" class="form-control" value="{{$candidato->etapa->texto}}" disabled>
                                    </div>
                                @elseif($candidato->etapa->tipo == $tipos[2])
                                    <div class="col-md-6">
                                        <label for="">Público</label>
                                        <input type="text" class="form-control" value="{{$candidato->etapa->texto}}" disabled>
                                    </div>
                                    @if(App\Models\OpcoesEtapa::find($candidato->etapa_resultado) != null)
                                        <div class="col-md-6">
                                            <label for="">Opção selecionada</label>
                                            <input type="text" class="form-control" value="{{App\Models\OpcoesEtapa::find($candidato->etapa_resultado)->opcao}}" disabled>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <br>
                            @php
                                $lote = App\Models\LotePostoVacinacao::find($candidato->lote_id);
                                if($lote != null){
                                    $lote = $lote->lote;
                                }
                            @endphp
                            @if ($lote != null)
                                <div class="row">
                                    <h4>Lote</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="fabricante_{{$candidato->id}}">fabricante</label>
                                        <input id="fabricante_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$lote->fabricante ?? "Indefinido"}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lote_{{$candidato->id}}">Nº do lote</label>
                                        <input id="lote_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$lote->numero_lote ?? "Indefinido"}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dose_unica_{{$candidato->id}}">Dose única</label>
                                        <input id="dose_unica_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$lote->dose_unica ? "Sim" : "Não"}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tempo_{{$candidato->id}}">Tempo para segunda dose</label>
                                        <input id="tempo_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$lote->dose_unica ?  " - " : $lote->inicio_periodo ." dias"  }}">
                                    </div>
                                </div>
                            @endif
                            <br>
                            <div class="row">
                                <h4>Informações pessoais</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="nome_{{$candidato->id}}">Nome completo</label>
                                    <input id="nome_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->nome_completo}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="data_nacimento_{{$candidato->id}}">Data de nascimento</label>
                                    <input id="data_nacimento_{{$candidato->id}}" type="date" class="form-control" disabled value="{{$candidato->data_de_nascimento}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="cpf_{{$candidato->id}}">CPF</label>
                                    <input id="cpf_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->cpf}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                <a target="_blank" href="https://servicos.receita.fazenda.gov.br/Servicos/CPF/ConsultaSituacao/ConsultaPublica.asp?CPF={{$candidato->cpf}}&NASCIMENTO={{$candidato->data_de_nascimento_dmY()}}">Validar data de nascimento e CPF</a>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="n_cartao_sus_{{$candidato->id}}">Número do cartão do SUS</label>
                                    <input id="n_cartao_sus_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->numero_cartao_sus}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="sexo_{{$candidato->id}}">Sexo</label>
                                    <input id="sexo_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->sexo}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="nome_mae_{{$candidato->id}}">Nome completo da mãe</label>
                                    <input id="nome_mae_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->nome_da_mae}}">
                                </div>
                            </div>
                            <br>
                            @if ($candidato->outrasInfo != null && count($candidato->outrasInfo) > 0)
                                <div class="row">
                                    <h4>Outras informações</h4>
                                </div>
                                <div class="row">
                                    @foreach ($candidato->etapa->outrasInfo as $outraInfo)
                                        <div class="col-md-6">
                                            <input id="outra_{{$outraInfo->id}}" type="checkbox" disabled @if($candidato->outrasInfo->contains('id', $outraInfo->id)) checked @endif>
                                            <label for="outra_{{$outraInfo->id}}">{{$outraInfo->campo}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <br>
                            <div class="row">
                                <h4>Contato</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="telefone_{{$candidato->id}}">Telefone</label>
                                    <input id="telefone_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->telefone}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="whatsapp_{{$candidato->id}}">Whatsapp</label>
                                    <input id="whatsapp_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->whatsapp}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email_{{$candidato->id}}">E-mail</label>
                                    <input id="email_{{$candidato->id}}" type="email" class="form-control" disabled value="{{$candidato->email}}">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h4>Endereço</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="cep_{{$candidato->id}}">CEP</label>
                                    <input id="cep_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->cep}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="cidade_{{$candidato->id}}">Cidade</label>
                                    <input id="cidade_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->cidade}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="bairro_{{$candidato->id}}">Bairro</label>
                                    <input id="bairro_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->bairro}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="logradouro_{{$candidato->id}}">Rua</label>
                                    <input id="logradouro_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->logradouro}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="numero_residencia_{{$candidato->id}}">Número da residência</label>
                                    <input id="numero_residencia_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->numero_residencia}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="complemento_{{$candidato->id}}">Complemento</label>
                                    <textarea id="complemento_{{$candidato->id}}" type="text" class="form-control" disabled rows="3">{{$candidato->complemento_endereco ?? " "}}</textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h4>Agendado para</h4>
                            </div>
                            <div id="agendado_para_{{$candidato->id}}" style="display: block;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="posto_{{$candidato->id}}">Ponto</label>
                                        <input id="posto_{{$candidato->id}}" type="text" class="form-control" disabled value="@if($candidato->posto != null){{$candidato->posto->nome}}@endif">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dose_{{$candidato->id}}">Dose</label>
                                        <input id="dose_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->dose}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="data_{{$candidato->id}}">Data</label>
                                        <input id="data_{{$candidato->id}}" type="text" class="form-control" disabled value="@if($candidato->posto != null){{date('d/m/Y',strtotime($candidato->chegada))}}@endif">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="chegada_{{$candidato->id}}">Horário de chegada</label>
                                        <input id="chegada_{{$candidato->id}}" type="text" class="form-control" disabled value="@if($candidato->posto != null){{date('H:i',strtotime($candidato->chegada))}}@endif">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="saida_{{$candidato->id}}">Horário de saida</label>
                                        <input id="saida_{{$candidato->id}}" type="text" class="form-control" disabled value="{{date('H:i',strtotime($candidato->saida))}}">
                                    </div>
                                </div>
                                <br>
                                @can('reagendar')
                                    <div class="row">
                                        <div class="col-md-6">
                                        </div>

                                        <div class="col-md-6">
                                            <button id="btn_edit_{{$candidato->id}}" type="button" class="btn btn-primary" style="width: 100%;" onclick="reagendar({{$candidato->id}}, true)">Reagendar</button>
                                        </div>
                                    </div>
                                @endcan
                            </div>

                            <div id="editar_agendado_para_{{$candidato->id}}" style="display: none;">
                                <form id="form_editar_agendado_para_{{$candidato->id}}" action="{{route('agendamento.posto.update', ['id' => $candidato->id])}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="edit_agendamento_id" value="{{$candidato->id}}">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="posto_vacinacao_{{$candidato->id}}" class="style_titulo_input">PONTO DE VACINAÇÃO<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
                                            <select id="posto_vacinacao_{{$candidato->id}}" class="form-control style_input @error('posto_vacinacao_'.$candidato->id) is-invalid @enderror" name="posto_vacinacao_{{$candidato->id}}" required onchange="selecionar_posto(this, {{$candidato->id}})">
                                                <option selected disabled>-- Selecione o ponto --</option>
                                                @foreach($candidato->etapa->pontos as $posto)
                                                    <option value="{{$posto->id}}">{{$posto->nome}}</option>
                                                @endforeach
                                            </select>

                                            @error('posto_vacinacao_'.$candidato->id)
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6" id="seletor_data_{{$candidato->id}}"></div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12" id="seletor_horario_{{$candidato->id}}"></div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-secondary" style="width: 100%;" onclick="reagendar({{$candidato->id}}, false)">Cancelar</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success" style="width: 100%;" form="form_editar_agendado_para_{{$candidato->id}}">Salvar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        <!-- Fim modal visualizar agendamento -->
            <!-- Modal confirmar vacinação -->
                <div class="modal fade" id="vacinar_candidato_{{$candidato->id}}" tabindex="-1" aria-labelledby="vacinar_candidato_{{$candidato->id}}_label" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="vacinar_candidato_{{$candidato->id}}_label">Confirmar vacinação de {{$candidato->nome_completo}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <form id="vacinado_{{$candidato->id}}" action="{{route('candidato.vacinado', ['id' => $candidato->id])}}" method="POST">
                                @csrf
                                Deseja confirmar que esse candidato foi vacinado?(CPF:{{ $candidato->cpf }})
                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" form="vacinado_{{$candidato->id}}" onclick="desabilitar(this, 'vacinado_'+{{$candidato->id}})">Sim</button>
                        </div>
                    </div>
                    </div>
                </div>
            <!-- Fim modal confirmar vacinação -->
        @if ($candidato->aprovacao != null && $candidato->aprovacao == $candidato_enum[3])
            <!-- Modal cancelar vacina -->
                <div class="modal fade" id="cancelar_vacinado_candidato_{{$candidato->id}}" tabindex="-1" aria-labelledby="vacinar_candidato_{{$candidato->id}}_label" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="vacinar_candidato_{{$candidato->id}}_label">Desfazer vacinação de {{$candidato->nome_completo}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <form id="cancelar_vacinado_{{$candidato->id}}" action="{{route('desfazer.vacinado', ['id' => $candidato->id])}}" method="POST">
                            @csrf
                            Tem certeza que deseja desfazer a vacinação desse agendamento?
                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger" form="cancelar_vacinado_{{$candidato->id}}" onclick="desabilitar(this, 'cancelar_vacinado_'+{{$candidato->id}})">Sim</button>
                        </div>
                    </div>
                    </div>
                </div>
            <!-- Modal cancelar vacina -->
        @endif
    @endforeach --}}

@if(old('edit_agendamento_id') != null)
    <script>
        $(document).ready(function() {
            $('#visualizar_candidato_{{old('edit_agendamento_id')}}').modal('show');
            $('#btn_edit_{{old('edit_agendamento_id')}}').click();
        })
    </script>
@endif
<script>
    function mostrarFiltro(check, id) {
        if(check.checked) {
            document.getElementById(id).style.display = "block";
        } else {
            document.getElementById(id).style.display = "none";
        }
    }

    function selecionar_posto(posto_selecionado, id) {
        document.getElementById('seletor_data_'+id).innerHTML = "";
        document.getElementById('seletor_horario_'+id).innerHTML = "";
        $.ajax({
            url: "{{route('dias.posto.ajax')}}",
            method: 'GET',
            type: 'GET',
            data: {
                posto_id: posto_selecionado.value,
            },
            statusCode: {
                404: function() {
                    alert("Nenhum posto encontrado");
                }
            },
            success: function(data){
                console.log(data);
                var htmlDatas = "";
                var htmlHorarios ="";
                if (data != null) {
                    htmlDatas += `<label for="dia_vacinacao_${id}" class="style_titulo_input">DIA DA VACINAÇÃO<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
                            <select id="dia_vacinacao_${id}" class="form-control style_input" name="dia_vacinacao_${id}" required onchange="selecionar_dia_vacinacao(this, ${id})"><option selected disabled>-- Selecione o dia --</option>`;
                    $.each(data, function(i, obj) {
                        htmlDatas += `<option value="${i}">${i}</option>`;
                    });
                    htmlDatas += `</select>`;

                    $.each(data, function(i, obj) {
                        htmlHorarios += `<div class="seletor_horario_dia_div_${id}"  id="seletor_horario_dia_${i}_${id}" style="display:none;">
                                    <div class="row horario_vacina_div">
                                        <div class="form-group col-md-12" style="width: 100%;">
                                            <label for="dia_vacinacao" class="style_titulo_input">HORÁRIO DA VACINAÇÃO<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
                                            <select id="select_horario_input_${i}_${id}" name="hora_${id}" class="form-control style_input">
                                                <option selected disabled>-- Selecione o horário --</option>`;
                        $.each(obj, function(c, obj_include) {
                            var data_horario = (new Date(obj_include)).toString();
                            htmlHorarios += `<option value="${data_horario.substring(16,21).split(':').join(':')}">${data_horario.substring(16,21).split(':').join(':')}</option>`;
                        });

                        htmlHorarios += `</select>
                                        </div>
                                    </div>
                                </div>`;
                    });
                }
                $('#seletor_data_'+id).append(htmlDatas);
                $('#seletor_horario_'+id).append(htmlHorarios);
            },
            error:function(data){
                alert('Houve algum erro, entre em contato com a administração do site.');
            },
        })
    }

    function selecionar_dia_vacinacao(select_dia, id) {
        var divHorarios = document.getElementById('seletor_horario_'+id);
        var divHoras = document.getElementById("seletor_horario_dia_"+select_dia.value+"_"+id);

        for (var i = 0; i < divHorarios.children.length; i++) {
            var inputHoras = divHorarios.children[i].children[0].children[0].children[1];
            if (divHoras == divHorarios.children[i]) {
                divHorarios.children[i].style.display = "";
                inputHoras.setAttribute('name', "horario_vacinacao_"+id);
                inputHoras.required = true;
            } else {
                divHorarios.children[i].style.display ="none";
                inputHoras.selectedIndex = 0;
                inputHoras.setAttribute('name', "");
                inputHoras.required = false;
            }
        }

    }

    function reagendar(id, bool) {
        if (bool) {
            document.getElementById("editar_agendado_para_"+id).style.display = "block";
            document.getElementById("agendado_para_"+id).style.display = "none";
        } else {
            document.getElementById("editar_agendado_para_"+id).style.display = "none";
            document.getElementById("agendado_para_"+id).style.display = "block";
        }
    }

    function desabilitar(btn, idForm) {
        btn.disabled = true;
        var form = document.getElementById(idForm);
        form.submit();
    }


    /*
    function filtrar() {
        $.ajax({
            url: "{{route('agendamentos.filtro.ajax')}}",
            method: 'GET',
            type: 'GET',
            data: {
                nome_check: document.getElementById('nome_check_input').checked,
                cpf_check: document.getElementById('cpf_check_input').checked,
                data_check: document.getElementById('data_check_input').checked,
                dose_check: document.getElementById('dose_check_input').checked,
                outro: document.getElementById('outro').checked,
                aprovado: document.getElementById('aprovado').checked,
                reprovado: document.getElementById('reprovado').checked,
                nome: document.getElementById('nome').value,
                cpf: document.getElementById('cpf').value,
                data: document.getElementById('data').value,
                dose: document.getElementById('dose').value,
                field: document.getElementById('field').value,
                order: document.getElementById('order').value,
            },
            statusCode: {
                404: function() {
                    alert("Nenhum posto encontrado");
                }
            },
            success: function(data){
                console.log(data);
                 var html = "";
                if (data != null) {
                    if (data.length > 0) {
                        $.each(data, function(i, obj) {
                            html += ``
                        })
                    }
                }
                document.getElementById('agendamentos').innerHTML = "";
                $('#agendamentos').append(html);
            },
            error:function(data){
                console.log('erro');
                alert('Erro'.data);
            },
        })
    }*/
</script>
</x-app-layout>
