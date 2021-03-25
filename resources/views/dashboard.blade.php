<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de agendamentos') }}
            @php
                $filtros =  array('Candidatos pendentes',
                      'Candidatos aprovados',
                      'Candidatos reprovados',
                      'Candidatos vacinados',
                      'Agendamentos do dia')
            @endphp
            @isset($filtro)
                @foreach ($filtros as $key => $item)
                    @if ( $filtro == $loop->iteration)
                        {{ " - " .$item }}
                    @endif
                @endforeach
            @endisset
        </h2>
        <a href="{{ route('dashboard') }}">
            <small>Atualizar página <i class="fas fa-redo"></i> </small>
        </a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <form method="GET" action="{{route('dashboard')}}">
                    <div class="row">
                        <div class="col-sm-9">
                            <select name="filtro" class="form-control" id="filtro">
                                <option value="">-- Selecione o filtro --</option>
                                <option value="1" @if(isset($filtro) && $filtro == "1") selected @endif>Candidatos pendentes</option>
                                <option value="2" @if(isset($filtro) && $filtro == "2") selected @endif>Candidatos aprovados</option>
                                <option value="3" @if(isset($filtro) && $filtro == "3") selected @endif>Candidatos reprovados</option>
                                <option value="4" @if(isset($filtro) && $filtro == "4") selected @endif>Candidatos vacinados</option>
                                <option value="5" @if(isset($filtro) && $filtro == "5") selected @endif>Agendamentos do dia</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button class="btn btn-primary" style="width: 100%;">Filtrar</button>
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
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome
                                    <a href="{{ route('candidato.order', ['field' => 'nome_completo' ,'order'=> 'ASC']) }}">
                                        <i class="fas fa-arrow-circle-down"></i>
                                    </a>
                                    <a href="{{ route('candidato.order', ['field' => 'nome_completo' ,'order'=> 'DESC']) }}">
                                        <i class="fas fa-arrow-circle-up"></i>
                                    </a>
                                </th>
                                <th scope="col">CPF
                                    <a href="{{ route('candidato.order', ['field' => 'cpf' ,'order'=> 'ASC']) }}">
                                        <i class="fas fa-arrow-circle-down"></i>
                                    </a>
                                    <a href="{{ route('candidato.order', ['field' => 'cpf' ,'order'=> 'DESC']) }}">
                                        <i class="fas fa-arrow-circle-up"></i>
                                    </a>
                                </th>
                                <th scope="col">Dia
                                    <a href="{{ route('candidato.order', ['field' => 'chegada' ,'order'=> 'ASC']) }}">
                                        <i class="fas fa-arrow-circle-down"></i>
                                    </a>
                                    <a href="{{ route('candidato.order', ['field' => 'chegada' ,'order'=> 'DESC']) }}">
                                        <i class="fas fa-arrow-circle-up"></i>
                                    </a>
                                </th>
                                <th scope="col">Horário</th>
                                <th scope="col">Visualizar</th>
                                @can('confirmar-vaga-candidato')
                                    <th scope="col">Resultado</th>
                                @endcan
                                @can('vacinado-candidato')
                                    <th scope="col" class="text-center">Confirmar vacinação</th>
                                @endcan
                                @can('whatsapp-candidato')
                                    <th scope="col" class="text-center">Link</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidatos as $i => $candidato)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$candidato->nome_completo}}" style="max-width: 150px;">
                                        {{$candidato->nome_completo}}
                                      </span>
                                </td>
                                <td>{{$candidato->cpf}}</td>
                                <td>{{date('d/m/Y',strtotime($candidato->chegada))}}</td>
                                <td>{{date('H:i',strtotime($candidato->chegada))}} - {{date('H:i',strtotime($candidato->saida))}}</td>
                                <td data-toggle="modal" data-target="#visualizar_candidato_{{$candidato->id}}">
                                    <a href="#"><img src="{{asset('img/icons/eye-regular.svg')}}" alt="Visualizar" width="25px;"></a>
                                </td>
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
                                                @if ($candidato->lote != null)
                                                    <div class="row">
                                                        <h4>Lote</h4>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="nome_{{$candidato->id}}">fabricante</label>
                                                            <input id="nome_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->lote->fabricante ?? "Indefinido"}}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="nome_{{$candidato->id}}">Nº do lote</label>
                                                            <input id="nome_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->lote->numero_lote ?? "Indefinido"}}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="nome_{{$candidato->id}}">Segunda dose</label>
                                                            <input id="nome_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->lote->dose_unica ? "Sim" : "Não"}}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="nome_{{$candidato->id}}">Tempo para segunda dose</label>
                                                            <input id="nome_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->lote->dose_unica ?  " - " : $candidato->lote->inicio_periodo ." dias"  }}">
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
                                                        <textarea id="complemento_{{$candidato->id}}" type="text" class="form-control" disabled rows="3">{{$candidato->numero_residencia}}</textarea>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <h4>Agendado para</h4>
                                                </div>
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
                                                Deseja confirmar que esse candidato foi vacinado?
                                           </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary" form="vacinado_{{$candidato->id}}">Salvar</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <!-- Fim modal confirmar vacinação -->
                                <td>
                                    @if ($candidato->aprovacao != null && $candidato->aprovacao == $candidato_enum[3])
                                        Vacinado
                                    @else
                                        @can('confirmar-vaga-candidato')
                                        <form method="POST" action="{{route('update.agendamento', ['id' => $candidato->id])}}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <select onchange="myFunction()" id="confirmacao_{{$candidato->id}}" class="form-control" name="confirmacao" required>
                                                        <option value="" selected disabled>selecione</option>
                                                        <option value="{{$candidato_enum[1]}}" @if($candidato->aprovacao == $candidato_enum[1]) selected @endif>Confirmar</option>
                                                        <option value="{{$candidato_enum[2]}}" @if($candidato->aprovacao == $candidato_enum[2]) selected @endif>Reprovado</option>
                                                        <option value="Ausente" >Ausente</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">

                                                        <button class="btn btn-success">Salvar</button>

                                                </div>
                                            </div>
                                        </form>
                                        @endcan
                                    @endif
                                </td>

                                <td style="text-align: center;">
                                    @can('vacinado-candidato')
                                        <button data-toggle="modal" data-target="#vacinar_candidato_{{$candidato->id}}" class="btn btn-primary" @if ($candidato->aprovacao != null && $candidato->aprovacao == $candidato_enum[3]) disabled @endif>Vacinado</button>
                                    @endcan
                                </td>
                                <td>
                                    @can('whatsapp-candidato')
                                        @if ($candidato->aprovacao != null && $candidato->aprovacao == $candidato_enum[1])
                                            <a href="https://api.whatsapp.com/send?phone=55{{$candidato->getWhatsapp()}}&text=Sua vacinação foi aprovada e será realizada no Ponto de Vacinação escolhido no momento do cadastro, dia {{date('d/m/Y \à\s  H:i \h', strtotime($candidato->chegada))}}. Aguardamos você!" class="text-center"  target="_blank"><i class="fab fa-whatsapp"></i></a>
                                        @elseif($candidato->aprovacao != null && $candidato->aprovacao == $candidato_enum[2])
                                            <a href="https://api.whatsapp.com/send?phone=55{{$candidato->getWhatsapp()}}&text=Seu agendamento foi reprovado." class="text-center"  target="_blank"><i class="fab fa-whatsapp"></i></a>
                                        @else
                                            <a class="text-center"  target="_blank"><i class="fab fa-whatsapp"></i></a>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
<script>
    function myFunction() {
        console.log(event);
    // var txt;
    // var person = prompt("Please enter your name:", "Harry Potter");
    // if (person == null || person == "") {
    //     txt = "User cancelled the prompt.";
    // } else {
    //     txt = "Hello " + person + "! How are you today?";
    // }
    // document.getElementById("demo").innerHTML = txt;
    }
</script>
