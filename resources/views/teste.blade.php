@foreach ($candidatos as $i => $candidato)
                                <tr  data-toggle="collapse" data-target="#demo{{ $candidato->id }}" >
                                    <tr>
                                        <td>{{ $candidato->id }}</td>
                                        <td>
                                            <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$candidato->nome_completo}}" style="max-width: 150px;">
                                                {{$candidato->nome_completo}}
                                              </span>
                                        </td>
                                        <td>{{$candidato->cpf}}</td>
                                        <td>{{ $candidato->chegada ? date('d/m/Y',strtotime($candidato->chegada)) : "Indefinido" }}</td>
                                        <td>{{ $candidato->chegada ? date('H:i',strtotime($candidato->chegada)) ."-". date('H:i',strtotime($candidato->saida)) : "Indefinido" }}</td>
                                        <td>
                                            {{ $candidato->chegada ?  $candidato->dose : "Indefinido" }}
                                        </td>
                                        <td>
                                            <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$candidato->nome_completo}}" style="max-width: 150px;">
                                                {{$candidato->posto->nome ?? "Indefinido"}}
                                              </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#visualizar_candidato_{{$candidato->id}}" aria-expanded="true" aria-controls="collapseOne">
                                                <img src="{{asset('img/icons/eye-regular.svg')}}" alt="Visualizar" width="25px;">
                                            </button>
                                        </td>
                                        <tr >
                                            <div id="visualizar_candidato_{{$candidato->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#agendamentos">
                                                <div class="card-body">
                                                        <div>
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
                                        </tr>
                                        @can('confirmar-vaga-candidato')
                                        <td>
                                            @if($candidato->lote_id)
                                                @if ($candidato->aprovacao != null && $candidato->aprovacao == $candidato_enum[3])
                                                    Vacinado
                                                @else

                                                    <form method="POST" action="{{route('update.agendamento', ['id' => $candidato->id])}}">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12 px-0">
                                                                <select onchange="this.form.submit()" id="confirmacao_{{$candidato->id}}" class="form-control" name="confirmacao" required>
                                                                    <option value="" selected disabled>selecione</option>
                                                                    <option value="{{$candidato_enum[1]}}" @if($candidato->aprovacao == $candidato_enum[1]) selected @endif>Confirmar</option>
                                                                    <option value="{{$candidato_enum[2]}}" @if($candidato->aprovacao == $candidato_enum[2]) selected @endif>Reprovado</option>
                                                                    <option value="Ausente" >Ausente</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </form>

                                                @endif
                                            @endif
                                        </td>
                                        @endcan
                                        @can('vacinado-candidato')
                                        <td style="text-align: center;" class="pl-4">
                                            @if($candidato->lote_id)
                                                    <button data-toggle="modal" data-target="#vacinar_candidato_{{$candidato->id}}" class="btn btn-primary" @if ($candidato->aprovacao != null && $candidato->aprovacao == $candidato_enum[3]) disabled @endif><i class="fas fa-syringe"></i></button>
                                                    @if ($candidato->aprovacao != null && $candidato->aprovacao == $candidato_enum[3])
                                                        <button  class="btn btn-danger " data-toggle="modal" data-target="#cancelar_vacinado_candidato_{{$candidato->id}}"><i class="far fa-times-circle"></i></button>
                                                    @endif
                                                    @endif
                                                </td>
                                        @endcan
                                        @can('whatsapp-candidato')
                                        <td>
                                                @if ($candidato->aprovacao != null && $candidato->aprovacao != $candidato_enum[3])
                                                    <a href="https://api.whatsapp.com/send?phone=55{{$candidato->getWhatsapp()}}&text={{$candidato->getMessagemWhatsapp()}}" class="text-center"  target="_blank"><i class="fab fa-whatsapp"></i></a>
                                                @else
                                                    <a class="text-center"  target="_blank"><i class="fab fa-whatsapp"></i></a>
                                                @endif
                                            </td>
                                        @endcan
                                    </tr>
                                </tr>
                                <tr id="demo{{ $candidato->id }}" class="collapse ">
                                    <td colspan="5" class="hiddenRow">
                                        <div id="visualizar_candidato_{{$candidato->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#agendamentos">
                                            <div class="card-body">
                                                <div>
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
                                    </td>
                                </tr>
                            @endforeach
