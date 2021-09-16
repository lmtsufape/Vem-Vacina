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
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 ">

                        <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">

                                <button class="btn btn-white btn-block text-left @if ($candidato->aprovacao != $candidato_enum[0]) text-white @elseif($candidato->aprovacao == $candidato_enum[0]) text-dark  @endif " type="button" data-toggle="collapse" data-target="#collapse{{ $i }}" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1">

                                        <div class="col col-sm col-md-12 col-lg-3 col-xl-3">
                                            <span  class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" >
                                                <strong>    {{ " " }}   </strong> {{ $candidato->cpf }}
                                            </span>
                                        </div>
                                        <div class="col-8 col-sm-8 col-md-12 col-lg-2 col-xl-2">
                                            <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" >
                                                <strong> {{ "" }}</strong> {{$candidato->dose}}
                                            </span>
                                        </div>
                                        <div class="col-8 col-sm-8 col-md-12 col-lg-6 col-xl-6">
                                            <span class="d-inline-block text-truncate text-capitalize font-weight-bolder" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$candidato->nome_completo}}" style="width: 23rem;">
                                                <strong>   {{ "Nome: "}} </strong>  {{$candidato->nome_completo}}
                                                </span>
                                        </div>
                                        <div class="col-8 col-sm-8 col-md-12 col-lg col-xl">
                                            <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$candidato->nome_completo}}" >
                                                <strong>   {{ ""}} </strong>  {{$candidato->posto ? $candidato->posto->nome : ""}}
                                                </span>
                                        </div>
                                    </div>

                                </button>

                        </div>
                        <div class="col-8 col-sm-8 col-md-8 col-lg-2 col-xl-2">
                            <div>
                                @can('confirmar-vaga-candidato')

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
                                                    @if($candidato->lote_id)
                                                        <option value="{{$candidato_enum[1]}}" @if($candidato->aprovacao == $candidato_enum[1]) selected @endif>Confirmar</option>
                                                    @endif
                                                    <option value="{{$candidato_enum[2]}}" @if($candidato->aprovacao == $candidato_enum[2]) selected @endif>Reprovado</option>
                                                    <option value="Ausente" >Ausente</option>
                                                    {{-- <option value="restaurar" >Restaurar</option> --}}
                                                </select>
                                            </form>
                                        @endif

                                @endcan
                            </div>
                        </div>
                        <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1  text-center">
                            @can('whatsapp-candidato')
                                @if ($candidato->dose == "1ª Dose" &&  $candidato->aprovacao != null && $candidato->aprovacao != $candidato_enum[3])
                                    <a href="https://api.whatsapp.com/send?phone=55{{$candidato->getWhatsapp()}}&text={{$candidato->getMessagemWhatsapp()}}" class="text-center text-white"  target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>  
                                @elseif($candidato->dose == "2ª Dose")
                                    <a href="https://api.whatsapp.com/send?phone=55{{$candidato->getWhatsapp()}}&text={{$candidato->getMessagemSegundaDose()}}" class="text-center text-white"  target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>
                                @else
                                    <a class="text-center"  target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>
                                @endif
                            @endcan
                        </div>

                    </div>
                </div>


              <div id="collapse{{ $i }}"
              @if (session('candidato_id', '0') == $candidato->id)
                class="collapse show" autofocus
              @else
                class="collapse "
              @endif
              aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card">
                    <div class="card-body ">
                        <div class="container">
                            <div class="modal-body">
                                @can('posicao-fila')
                                    <div class="row">
                                        <h5> <strong>{{ "#" . ($candidatos->firstItem() + $loop->index) }}</strong> </h5>
                                    </div>
                                @endcan
                                @component('candidato.component_editar', ['candidato' => $candidato,'candidato_enum' =>$candidato_enum])

                                @endcomponent
                                {{-- @livewire('editar-candidato', ['candidato' => $candidato]) --}}
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                    <a target="_blank" href="https://servicos.receita.fazenda.gov.br/Servicos/CPF/ConsultaSituacao/ConsultaPublica.asp?CPF={{$candidato->cpf}}&NASCIMENTO={{$candidato->data_de_nascimento_dmY()}}">Validar data de nascimento e CPF</a>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <h4>
                                        @can('reagendar-data')
                                            <a href="{{ route('candidato.form_edit', ['id' => $candidato->id]) }}">
                                                Agendado para <i class="fas fa-edit"></i>
                                            </a>
                                        @else
                                            Agendado para
                                        @endcan
                                    </h4>
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
                                            <input
                                            @if (session('candidato_id', '0') == $candidato->id)
                                                autofocus
                                            @endif id="data_{{$candidato->id}}" type="text" class="form-control"  value="@if($candidato->posto != null){{date('d/m/Y',strtotime($candidato->chegada))}}@endif">
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
