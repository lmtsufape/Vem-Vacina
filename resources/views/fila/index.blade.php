<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Lista de Espera') }}

                </h2>

            </div>
            <div class="col-md-4" id="Distribuir" class="col-md-4" style="text-align: right;">
                <a  class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" href="{{route('fila.painel',)}}">
                       Novo Distribuir agendamentos
                </a>
            </div>
            <div class="col-md-4" id="Distribuir" class="col-md-4" style="text-align: right;">
                <a  class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" href="{{route('fila.distribuir',)}}">
                        Distribuir agendamentos
                </a>
            </div>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <form method="GET" action="{{route('fila.index')}}">
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
                                {{-- <div class="col-md-3">
                                    <input type="checkbox" name="data_check" id="data_check_input" onclick="mostrarFiltro(this, 'data_check')" @if($request->data_check != null && $request->data_check) checked @endif>
                                    <label>Por data de agendamento</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="dose_check" id="dose_check_input" onclick="mostrarFiltro(this, 'dose_check')" @if($request->dose_check != null && $request->dose_check) checked @endif>
                                    <label>Por dose</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="outro" id="outro" @if($request->outro != null && $request->outro) checked @endif>
                                    <label>É acamado</label>
                                </div> --}}
                                {{-- <div class="col-md-3">
                                    <input type="checkbox" name="aprovado" id="aprovado" @if($request->aprovado != null && $request->aprovado) checked @endif>
                                    <label>Aprovados</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="reprovado" id="reprovado" @if($request->reprovado != null && $request->reprovado) checked @endif>
                                    <label>Reprovados</label>
                                </div> --}}
                                <div class="col-md-3">
                                    <input type="checkbox" name="campo_check" id="campo_check_input" onclick="mostrarFiltro(this, 'campo_check')">
                                    <label>Campo</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="ordem_check" id="ordem_check_input" onclick="mostrarFiltro(this, 'ordem_check')">
                                    <label>Ordem</label>
                                </div>
                                {{-- <div class="col-md-3">
                                    <input type="checkbox" name="ponto_check" id="ponto_check_input" onclick="mostrarFiltro(this, 'ponto_check')">
                                    <label>Ponto</label>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div id="nome_check" class="col-md-3" style="@if($request->nome_check != null && $request->nome_check) display: block; @else display: none; @endif">
                                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite o nome" @if($request->nome != null) value="{{$request->nome}}" @endif>
                                </div>
                                <div id="cpf_check" class="col-md-3" style="@if($request->cpf_check != null && $request->cpf_check) display: block; @else display: none; @endif">
                                    <input type="text" class="form-control cpf" name="cpf" id="cpf" placeholder="Digite o CPF"  @if($request->cpf != null) value="{{$request->cpf}}" @endif>
                                </div>
                                <div id="data_check" class="col-md-3" style="@if($request->data_check != null && $request->data_check) display: block; @else display: none; @endif">
                                    <input type="date" class="form-control" name="data" id="data" @if($request->data != null) value="{{$request->data}}" @endif>
                                </div>
                                <div id="dose_check" class="col-md-3" style="@if($request->dose_check != null && $request->dose_check) display: block; @else display: none; @endif">
                                    <select id="dose" name="dose" class="form-control">
                                        <option value="">-- Dose --</option>
                                        <option @if($request->dose == $doses[0]) selected @endif value="{{$doses[0]}}">1ª dose</option>
                                        <option @if($request->data == $doses[1]) selected @endif value="{{$doses[1]}}">2ª dose</option>
                                    </select>
                                </div>
                                <div id="campo_check" class="col-md-3" style="display: none;">
                                    <select id="campo" name="campo" class="form-control">
                                        <option value="">-- campo --</option>
                                        <option value="cpf">cpf</option>
                                        <option value="nome_completo">nome</option>
                                        <option value="chegada">dia</option>
                                    </select>
                                </div>
                                <div id="ordem_check" class="col-md-3" style="display: none;">
                                    <select id="ordem" name="ordem" class="form-control">
                                        <option value="">-- ordem --</option>
                                        <option value="asc">Crescente</option>
                                        <option value="desc">Descrescente</option>
                                    </select>
                                </div>
                                <div id="ponto_check" class="col-md-3" style="display: none;">
                                    <select id="ponto" name="ponto" class="form-control">
                                        <option value="">-- ponto --</option>
                                        @foreach ($postos as $posto)
                                            <option value="{{ $posto->id }}">{{ $posto->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Filtrar</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    @if(session('mensagem'))
                    <div class="col-md-12">
                        <div class="alert alert-{{session('class')}}" role="alert">
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
                                <th scope="col">Nome</th>
                                <th scope="col">CPF</th>
                                <th scope="col">Idade</th>
                                <th scope="col">Público</th>
                                <th scope="col">Ver</th>
                                @can('whatsapp-candidato')
                                    <th scope="col" >Link</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody id="agendamentos">
                            @foreach ($candidatos as $i => $candidato)
                            <tr>
                                <td>{{ $candidato->id }}</td>
                                <td>
                                    <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$candidato->nome_completo}}" style="max-width: 150px;">
                                        {{$candidato->nome_completo}}
                                      </span>
                                </td>
                                <td>{{$candidato->cpf}}</td>
                                <td>{{$candidato->idade}}</td>
                                <td>{{$candidato->etapa->texto_home}}</td>
                                {{-- <td>{{date('d/m/Y',strtotime($candidato->chegada))}}</td>
                                <td>{{date('H:i',strtotime($candidato->chegada))}} - {{date('H:i',strtotime($candidato->saida))}}</td> --}}
                                <td data-toggle="modal" data-target="#visualizar_candidato_{{$candidato->id}}">
                                    <a href="#"><img src="{{asset('img/icons/eye-regular.svg')}}" alt="Visualizar" width="25px;"></a>
                                </td>
                                {{-- <td>
                                    @if ($candidato->aprovacao != null && $candidato->aprovacao == $candidato_enum[3])
                                        Vacinado
                                    @else
                                        @can('confirmar-vaga-candidato')
                                        <form method="POST" action="{{route('update.agendamento', ['id' => $candidato->id])}}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 px-0">
                                                    <select onchange="this.form.submit()" id="confirmacao_{{$candidato->id}}" class="form-control" name="confirmacao" required>
                                                        <option value="" selected disabled>selecione</option>
                                                        <option value="{{$candidato_enum[1]}}" @if($candidato->aprovacao == $candidato_enum[1]) selected @endif>Confirmar</option>
                                                        <option value="{{$candidato_enum[2]}}" @if($candidato->aprovacao == $candidato_enum[2]) selected @endif>Reprovado</option>
                                                        <option value="Ausente" >Ausente</option>
                                                        <option value="restaurar" >Restaurar</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                        @endcan
                                    @endif
                                </td> --}}


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
                    {{ $candidatos->links() }}
                </div>

            </div>
        </div>
    </div>
    @foreach ($candidatos as $i => $candidato)
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
                                    <label for="nome_{{$candidato->id}}">Dose única</label>
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
                        <div id="agendado_para_{{$candidato->id}}" style="display: block;">
                            <div class="row">

                                <div class="col-md-6">
                                    <label for="dose_{{$candidato->id}}">Dose</label>
                                    <input id="dose_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->dose}}">
                                </div>
                            </div>


                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <button id="btn_edit_{{$candidato->id}}" type="button" class="btn btn-primary" style="width: 100%;" onclick="reagendar({{$candidato->id}}, true)">Reagendar</button>
                                </div>
                            </div>
                        </div>

                        <div id="editar_agendado_para_{{$candidato->id}}" style="display: none;">
                            <form id="form_editar_agendado_para_{{$candidato->id}}" action="{{route('agendamento.posto.update', ['id' => $candidato->id])}}" method="POST">
                                @csrf
                                <input type="hidden" name="edit_agendamento_id" value="{{$candidato->id}}">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="posto_vacinacao" class="style_titulo_input">PONTO DE VACINAÇÃO<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
                                        <select id="posto_vacinacao" class="form-control style_input @error('posto_vacinacao_'.$candidato->id) is-invalid @enderror" name="posto_vacinacao_{{$candidato->id}}" required onchange="selecionar_posto(this, {{$candidato->id}})">
                                            <option selected disabled>-- Selecione o ponto --</option>
                                            @foreach($postos as $posto)
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

    @endforeach
</x-app-layout>
@if(old('edit_agendamento_id') != null)
    <script>
        $(document).ready(function() {
            $('#visualizar_candidato_{{old('edit_agendamento_id')}}').modal('show');
            $('#btn_edit_{{old('edit_agendamento_id')}}').click();
        })
    </script>
@endif
<script>
    const buttonDistribuir = document.querySelector("#Distribuir > a")
    buttonDistribuir.addEventListener('click', (e)=>{
        // console.log(e.target)
        e.target.setAttribute("class", "disabled");
        e.target.innerText = "Aguarde...";

    });
</script>

<script>
    function myFunction(event) {
        console.log(event);

    }

    function mostrarFiltro(check, id) {
        if(check.checked) {
            document.getElementById(id).style.display = "block";
        } else {
            document.getElementById(id).style.display = "none";
        }
    }

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
                // var html = "";
                // if (data != null) {
                //     if (data.length > 0) {
                //         $.each(data, function(i, obj) {
                //             html += ``
                //         })
                //     }
                // }
                // document.getElementById('agendamentos').innerHTML = "";
                // $('#agendamentos').append(html);
            },
            error:function(data){
                console.log('erro')
                alert('Erro'.data);
            },
        })
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
                    })
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
                        })

                        htmlHorarios += `</select>
                                        </div>
                                    </div>
                                </div>`;
                    })
                }
                $('#seletor_data_'+id).append(htmlDatas)
                $('#seletor_horario_'+id).append(htmlHorarios);
            },
            error:function(data){
                console.log('erro')
                alert('Erro'.data);
            },
        })
    }

    function selecionar_dia_vacinacao(select_dia, id) {
        var divHorarios = document.getElementById('seletor_horario_'+id);
        for (var i = 0; i < divHorarios.children.length; i++) {
            var divHoras = document.getElementById("seletor_horario_dia_"+select_dia.value+"_"+id);
            var inputHoras = document.getElementById("select_horario_input_"+select_dia.value+"_"+id);
            if (divHoras == divHorarios.children[i]) {
                divHoras.style.display = "block";
                inputHoras.setAttribute('name', "hora_"+id);
                inputHoras.name = "horario_vacinacao_"+id;
                inputHoras.id = "horario_vacinacao_"+id;
                inputHoras.required = true;
            } else {
                divHorarios.children[i].style="display:none";
                inputHoras.options.selectedIndex = 0;
                inputHoras.name = "";
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
</script>
