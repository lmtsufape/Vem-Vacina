<x-guest-layout>

    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}


    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    

    <div style="padding-bottom: 0rem;padding-top: 1rem;; margin-top: -15%; background-color: #fff;"> 
        <img src="img/cabecalho_1.png" alt="Orientação" width="100%"> 
        <div class="container">
            <img src="img/cabecalho_2.png" alt="Orientação" width="100%">
        </div>
    </div>
    <div class="container" style="margin-bottom: 1rem;background-color: #fff;">
        <div class="row justify-content-center">
            <!-- cadastro -->
            <div class="col-md-9 style_card_apresentacao">
                <div class="container" style="padding-top: 10px;;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row" style="text-align: center;">
                                <div class="col-md-12" style="margin-top: 20px;margin-bottom: 10px;">
                                    <img src="img/logo_programa_1.png" alt="Orientação" width="300px"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 style_titulo_campo">Solicitar vacinação</div>
                        <div class="col-md-12"><hr class="style_linha_campo"></div>
                        <div class="col-md-12" style="font-size: 15px; margin-bottom: 15px; text-align: justify;">Por meio desta ferramenta será efetuado o cadastro e agendamento da vacinação para o público-alvo. Idosos acamados ou com dificuldade de locomoção devem realizar esta indicação no ato de cadastro e aguardar a ligação da Secretaria de Saúde, para aplicação da vacina em domicílio. </div>
                        <div class="col-md-12 style_titulo_campo" style="margin-bottom: 10px;">Informações pessoais</div>
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('solicitacao.candidato.enviar') }}" enctype="multipart/form-data">
                                @csrf
                                @if (old('publico') != null)
                                    @foreach ($publicos as $publico)
                                        @if ($publico->exibir_no_form)
                                            @if ($publico->tipo == $tipos[0])
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="defaultCheck2" name="publicos[]" value="{{$publico->id}}" @if(in_array($publico->id, old('publico'))) checked @endif>
                                                    <label class="form-check-label style_titulo_input" for="defaultCheck2">{{mb_strtoupper($publico->texto)}}</label>
                                                </div>
                                            @elseif ($publico->tipo == $tipos[1])
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="defaultCheck2" name="publicos[]" value="{{$publico->id}}" @if(in_array($publico->id, old('publico'))) checked @endif>
                                                    <label class="form-check-label style_titulo_input" for="defaultCheck2">{{mb_strtoupper($publico->texto)}}</label>
                                                </div>
                                            @elseif ($publico->tipo == $tipos[2])
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="defaultCheck2" onclick="funcaoMostrarOpcoes(this, {{$publico->id}})" name="publicos[]" value="{{$publico->id}}" @if(in_array($publico->id, old('publico'))) checked @endif>
                                                    <label class="form-check-label style_titulo_input" for="defaultCheck2">{{mb_strtoupper($publico->texto)}}</label>

                                                    <div id="divPublico_{{$publico->id}}" @if (in_array($publico->id, old('publico'))) style="display: block;" @else style="display: none;" @endif>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="inputProfissao" class="style_titulo_input" style="font-weight: normal;">Qual tipo de {{mb_strtolower($publico->texto)}}(caso {{$publico->texto}})</label>
                                                                <select class="form-control @error('publico_opcao_'.$publico->id) is-invalid @enderror" id="publico_opcao_{{$publico->id}}" name="publico_opcao_{{$publico->id}}"> 
                                                                    <option value="" seleceted disabled>-- Selecione o tipo --</option>
                                                                    @foreach ($publico->opcoes()->orderBy('opcao')->get() as $opcao)
                                                                        <option value="{{$opcao->id}}" @if(old('publico_opcao_'.$publico->id) == $opcao->id) selected @endif>{{$opcao->opcao}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('publico_opcao_'.$publico->id)
                                                                <div id="validationServer05Feedback" class="invalid-feedback">
                                                                    <strong>{{$message}}</strong>
                                                                </div>
                                                                @enderror
                                                                {{-- <small>Obs.: Lista conforme OFÍCIO CIRCULAR Nº 57/2021/SVS/MS do Ministério da Saúde, de 12 de março de 2021.</small> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                @else
                                @foreach ($publicos as $publico)
                                    @if ($publico->exibir_no_form) 
                                        @if ($publico->tipo == $tipos[0])
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck2" name="publicos[]" value="{{$publico->id}}">
                                                <label class="form-check-label style_titulo_input" for="defaultCheck2">{{mb_strtoupper($publico->texto)}}</label>
                                            </div>
                                        @elseif ($publico->tipo == $tipos[1])
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck2" name="publicos[]" value="{{$publico->id}}">
                                                <label class="form-check-label style_titulo_input" for="defaultCheck2">{{mb_strtoupper($publico->texto)}}</label>
                                            </div>
                                        @elseif ($publico->tipo == $tipos[2])
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck2" onclick="funcaoMostrarOpcoes(this, {{$publico->id}})" name="publicos[]" value="{{$publico->id}}">
                                                <label class="form-check-label style_titulo_input" for="defaultCheck2">{{mb_strtoupper($publico->texto)}}</label>

                                                <div id="divPublico_{{$publico->id}}" @if (old('publico_'.$publico->id)) style="display: block;" @else style="display: none;" @endif>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="inputProfissao" class="style_titulo_input" style="font-weight: normal;">Qual tipo de {{mb_strtolower($publico->texto)}}(caso {{$publico->texto}})</label>
                                                            <select class="form-control" id="publico_opcao_{{$publico->id}}" name="publico_opcao_{{$publico->id}}"> 
                                                                <option value="" seleceted disabled>-- Selecione o tipo --</option>
                                                                @foreach ($publico->opcoes()->orderBy('opcao')->get() as $opcao)
                                                                    <option value="{{$opcao->id}}">{{$opcao->opcao}}</option>
                                                                @endforeach
                                                            </select>
                                                            {{-- <small>Obs.: Lista conforme OFÍCIO CIRCULAR Nº 57/2021/SVS/MS do Ministério da Saúde, de 12 de março de 2021.</small> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                                @endif
                                <br>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputNome" class="style_titulo_input">NOME COMPLETO<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                        <input type="text" class="form-control style_input @error('nome_completo') is-invalid @enderror" id="inputNome" placeholder="Digite seu nome completo" name="nome_completo" value="{{old('nome_completo')}}" maxlength="65"> 
                                        
                                        @error('nome_completo')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputData" class="style_titulo_input">DATA DE NASCIMENTO<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                        <input type="date" class="form-control style_input @error('data_de_nascimento') is-invalid @enderror" id="inputData" placeholder="dd/mm/aaaa" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" name="data_de_nascimento" value="{{old('data_de_nascimento')}}">
                                        
                                        @error('data_de_nascimento')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputCPF" class="style_titulo_input">CPF<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                        <input type="text" class="form-control style_input cpf @error('cpf') is-invalid @enderror" id="inputCPF" placeholder="Ex.: 000.000.000-00" name="cpf" value="{{old('cpf')}}">
                                    
                                        @error('cpf')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div> 
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCartaoSUS" class="style_titulo_input">NÚMERO DO CARTÃO SUS </label>
                                        <input type="text" class="form-control style_input sus @error('número_cartão_sus') is-invalid @enderror" id="inputCartaoSUS" placeholder="000 0000 0000 0000" name="número_cartão_sus" value="{{old('número_cartão_sus')}}">
                                    
                                        @error('número_cartão_sus')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputSexo" class="style_titulo_input">SEXO<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                        <select id="inputSexo" class="form-control style_input @error('sexo') is-invalid @enderror" name="sexo">
                                            <option selected disabled>-- Selecione o sexo --</option>
                                            @foreach($sexos as $sexo)
                                                <option value="{{$sexo}}" @if (old('sexo') == $sexo) selected @endif>{{$sexo}}</option>
                                            @endforeach
                                        </select>

                                        @error('sexo')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div> 
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputNomeMae" class="style_titulo_input">NOME COMPLETO DA MÃE<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                        <input type="text" class="form-control style_input @error('nome_da_mãe') is-invalid @enderror" id="inputNomeMae" placeholder="Digite o nome completo da mãe" name="nome_da_mãe" value="{{old('nome_da_mãe')}}" maxlength="65">
                                        
                                        @error('nome_da_mãe')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="style_titulo_campo" style="margin-bottom: -2px;">Outras informações</div>
                                    <div style="font-size: 15px; margin-bottom: 15px;">(Informe se o idoso é acamado ou possui dificuldade de locomoção)</div>
                                </div>

                                
                                <div class="form-check">
                                    <input class="form-check-input @error('paciente_dificuldade_locomocao') is-invalid @enderror" type="checkbox" id="defaultCheck0" name="paciente_dificuldade_locomocao" @if(old('paciente_dificuldade_locomocao')) checked @endif>
                                    <label class="form-check-label style_titulo_input" for="defaultCheck0">PACIENTE ESTÁ COM DIFICULDADE DE LOCOMOÇÃO</label>
                                    
                                    @error('paciente_dificuldade_locomocao')
                                    <div id="validationServer05Feedback" class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                    @enderror
                                </div>

                                 
                                <div class="form-check">
                                    <input class="form-check-input @error('paciente_acamado') is-invalid @enderror" type="checkbox" id="defaultCheck1" name="paciente_acamado" @if(old('paciente_acamado')) checked @endif>
                                    <label class="form-check-label style_titulo_input" for="defaultCheck1">PACIENTE ESTÁ ACAMADO </label>
                                    
                                    @error('paciente_acamado')
                                    <div id="validationServer05Feedback" class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                    @enderror
                                </div>


                                
                                <div class="form-check">
                                    <input class="form-check-input @error('paciente_agente_de_saude') is-invalid @enderror" type="checkbox" id="defaultCheck2" onclick="funcaoVinculoComAEquipeDeSaudade(this)" name="paciente_agente_de_saude" @if(old('paciente_agente_de_saude')) checked @endif>
                                    <label class="form-check-label style_titulo_input" for="defaultCheck2">PACIENTE TEM VÍNCULO COM A EQUIPE DE SAÚDE DA FAMÍLIA (AGENTE DE SAÚDE)</label>
                                    
                                    @error('paciente_agente_de_saude')
                                    <div id="validationServer05Feedback" class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                    @enderror
                                    
                                    <div class="form-group" style="@if(old('paciente_agente_de_saude')) display: block; @else display: none; @endif" id="id_div_nomeDaUnidade">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="inputNomeUnidade" class="style_titulo_input" style="font-weight: normal;">Qual o nome da sua unidade (caso tenha vínculo) </label>
                                                <input type="text" class="form-control @error('unidade_caso_agente_de_saude') is-invalid @enderror" id="inputNomeUnidade" placeholder="Digite o nome da sua unidade" name="unidade_caso_agente_de_saude" value="{{old('unidade_caso_agente_de_saude')}}">
                                                
                                                @error('unidade_caso_agente_de_saude')
                                                <div id="validationServer05Feedback" class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="style_titulo_campo" style="margin-top: 8px; margin-bottom: -2px;">Contato</div>
                                    <div style="font-size: 15px; margin-bottom: 15px;">(Informe o telefone, whatsapp ou e-mail para contato que confirmaremos o agendamento da data e horário de aplicação da vacina)</div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputTelefone" class="style_titulo_input">TELEFONE<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
                                        <input type="text" class="form-control style_input celular @error('telefone') is-invalid @enderror" id="inputTelefone" placeholder="Digite o número do seu telefone" name="telefone" value="{{old('telefone')}}">
                                    
                                        @error('telefone')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputCelular" class="style_titulo_input">WHATSAPP </label>
                                        <input type="text" class="form-control style_input celular @error('whatsapp') is-invalid @enderror" id="inputCelular" placeholder="Digite o número do seu whatsapp" name="whatsapp" value="{{old('whatsapp')}}">
                                    
                                        @error('whatsapp')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div> 
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail" class="style_titulo_input">E-MAIL</label>
                                        <input type="email" class="form-control style_input" id="inputEmail" placeholder="Digite o seu e-mail" name="email" value="{{old('email')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="style_titulo_campo" style="margin-top: 8px; margin-bottom: -2px;">Endereço</div>
                                    <div style="font-size: 15px; margin-bottom: 15px;">(Informe seu endereço, rua, número, se casa ou apartamento, CEP e bairro)</div>
                                </div>

                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCEP" class="style_titulo_input">CEP</label>
                                        <input type="text" class="form-control style_input cep @error('cep') is-invalid @enderror" id="inputCEP" placeholder="Digite o CEP" name="cep" value="{{old('cep')}}" onkeydown="buscar_CEP(this, event)" onchange="requisitar_preenchimento_cep(this.value)">
                                        
                                        @error('cep')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div> 
                                </div>
 
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCidade" class="style_titulo_input">CIDADE<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                        <input id="inputCidade" class="form-control style_input @error('cidade') is-invalid @enderror" name="cidade" value="@if(old('cidade') != null){{old('cidade')}}@else{{"Garanhuns"}}@endif" disabled> 
                                        
                                        @error('cidade')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div> 
                                    <div class="form-group col-md-6">
                                        <label for="inputBairro" class="style_titulo_input">BAIRRO<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                        <input id="inputBairro" class="form-control style_input @error('bairro') is-invalid @enderror" name="bairro" value="{{old('bairro')}}">
                                        
                                        @error('bairro')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputrua" class="style_titulo_input">RUA<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
                                        <input type="text" class="form-control style_input @error('rua') is-invalid @enderror" id="inputrua" placeholder="Digite o nome da rua, avenida, travessa..." name="rua" value="{{old('rua')}}">
                                        
                                        @error('rua')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div> 
                                    <div class="form-group col-md-6">
                                        <label for="inputNumeroResidencia" class="style_titulo_input">NÚMERO DA RESIDÊNCIA<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
                                        <input type="text" class="form-control style_input @error('número_residencial') is-invalid @enderror" id="inputNumeroResidencia" placeholder="Digite o nome da residência" name="número_residencial" value="{{old('número_residencial')}}">
                                        
                                        @error('número_residencial')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div> 
                                </div>
                               
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputComplemento" class="style_titulo_input">COMPLEMENTO </label>
                                        <textarea type="text" class="form-control style_input @error('complemento_endereco') is-invalid @enderror" id="inputComplemento" placeholder="" rows="3" name="complemento_endereco">{{old('complemento_endereco')}}</textarea>
                                        
                                        @error('complemento_endereco')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="style_titulo_campo" style="margin-top: 8px; margin-bottom: -2px;">Local da vacinação</div>
                                    <div style="font-size: 15px; margin-bottom: 15px;">(Escolha o local, dia e horário que você quer se vacinar)</div>
                                </div>

                                <!-- informações do atendimento -->
                                <!-- um select que vai ser selecionado a posto de atendimento -->
                                <!-- depois que for selecionado, vai ser baixado o html com a lista dos dias e horarios de possiveis atendimentos -->
                                <!-- quando o usuario escolher, e enviar, a vaga da lista já pode ter sido tomada -->
                                <!-- então o controller deve avisar isso ao usuario e pedir pra escolher outro horario dos novos disposiveis -->

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="posto_vacinacao" class="style_titulo_input">ESCOLHA O POSTO DE VACINAÇÃO MAIS PRÓXIMA DA SUA CASA<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
                                        <select id="posto_vacinacao" class="form-control style_input @error('posto_vacinacao') is-invalid @enderror" name="posto_vacinacao" required onchange="selecionar_posto(this)">
                                            <option selected disabled>-- Selecione o posto --</option>
                                            @foreach($postos as $posto)
                                                @if(old('profissional_da_saúde') || old('paciente_agente_de_saude'))
                                                    @if ($posto->para_profissional_da_saude)
                                                        <option value="{{$posto->id}}">{{$posto->nome}}</option>
                                                    @endif
                                                @elseif($posto->para_idoso)
                                                    <option value="{{$posto->id}}">{{$posto->nome}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        
                                        @error('posto_vacinacao')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div> 
                                    <div class="form-group col-md-6">
                                        {{-- <label for="dose" class="style_titulo_input">QUAL A DOSE?<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
                                        <select id="dose" class="form-control style_input @error('dose') is-invalid @enderror" name="dose" required>
                                            <option selected disabled>-- Selecione a dose --</option>
                                            <option value="{{$doses[0]}}">{{$doses[0]}}</option>
                                            <option value="{{$doses[1]}}">{{$doses[1]}}</option>
                                        </select>
                                        
                                        @error('dose')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror --}}
                                    </div>
                                </div>

                                <div id="seletor_horario"></div>
                                
                                <div><hr></div>

                                
                                <div class="col-md-12" style="margin-bottom: 30px;">
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <!--<div class="col-md-6" style="padding:3px">
                                                     <button class="btn btn-light" style="width: 100%;margin: 0px;">Cancelar</button>
                                                     </div>-->
                                                <div class="col-md-12" style="padding:3px">
                                                    <button class="btn btn-success" style="width: 100%;">Enviar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- rodapé -->
    <div style="background-color:#313561; display: flex; flex-wrap: wrap;">
        <div class="container">
            <div class="row">
              <div class="col-sm">
                <div class="row justify-content-center" style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                    <div class="col-12" style="margin-bottom: 45px; color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;"><img src="img/logo_rede_sociais.png" alt="LMTS" width="20px"> Redes Sociais</div>
                    <a href="https://www.facebook.com/PrefeituradeGaranhuns/" target="_blank"><img src="{{asset('img/facebook.png')}}" alt="LMTS" width="55px"> </a>
                    <a href="https://twitter.com/garanhunspref" target="_blank"><img src="{{asset('img/twitter.png')}}" alt="LMTS" width="55px"> </a>
                    <a href="https://www.instagram.com/prefgaranhuns/" target="_blank"><img src="{{asset('img/instagram.png')}}" alt="LMTS" width="55px"> </a>
                    <a href="https://www.youtube.com/channel/UCHNqCIPyK42cjWUgO85C7Yg" target="_blank"><img src="{{asset('img/youtube.png')}}" alt="LMTS" width="43px" height="43x" style="margin-top: 4.5px;margin-left: 4px;"></a>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group justify-content-center" style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                    <div style="color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;"><img src="{{asset('img/logo_fale_conosco.png')}}" alt="LMTS" width="15px"> Fale Conosco</div>
                    <div style="color:#fff; font-size: 30px; font-weight: 600; font-family: Arial, Helvetica, sans-serif; margin-top:43px">(87) 3762-7000</div>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group justify-content-center" style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                    <div style="color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;">Desenvolvido por:</div>
                    <div class="btn-group">
                        <div style="margin-top: 21px;margin-right: 15px;"><a href="http://ufape.edu.br/" target="_blank"><img src="{{asset('img/logo_ufape.png')}}" alt="LMTS" width="165px"> </a></div>
                        <div style="margin-top: 35px;"><a href="http://lmts.uag.ufrpe.br/" target="_blank"><img src="{{asset('img/logo_lmts.png')}}" alt="LMTS" width="140px"> </a></div>
                    </div>
                </div>
              </div>
              <div class="col-sm-12" style="text-align: center; margin-bottom: 2rem;margin-top: 1rem;">
                <a href="https://garanhuns.pe.gov.br/mapa-do-site/" target="_blank" style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">MAPA DO SITE</a>
                <a href="https://garanhuns.pe.gov.br/teclas-de-acessibilidade/" target="_blank" style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">TECLAS DE ACESSIBILIDADE</a>
                <a href="https://garanhuns.pe.gov.br/telefones-uteis/" target="_blank" style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">TELEFONES ÚTEIS</a>

              </div>
            </div>
          </div>
    </div>
    
    <!--x rodapé x-->


    <script>
     function checkbox_visibilidade(div_alvo, checkbox) {
         if(checkbox.checked) {
             div_alvo.style.display = "block";
         } else {
             div_alvo.style.display = "none";
         }
     }
     
     
     function buscar_CEP(input, evt) {
         let theEvent = evt || window.event;

         if(evt.keyCode == 8) {
             theEvent.returnValue = true;
             return;
         }
         
         let key = "";
         if (theEvent.type === 'paste') {
         } else {
             // Handle key press
             key = theEvent.keyCode || theEvent.which;
             key = String.fromCharCode(key);
         }
         var regex = /[0-9]|\./;
         if( !regex.test(key) ) {
             theEvent.returnValue = false;
             if(theEvent.preventDefault) theEvent.preventDefault();
             return;
         }
         
         // enquanto não tiver suficiente, deixa preencher
         if(input.value.length < 7) {
             theEvent.returnValue = true;
             return;
         }
         
         // caso já esteja preenchido, não adiciona mais numeros
         if(input.value.length === 8) {
             theEvent.returnValue = false;
             return;
         }

         // colocou o ultimo valor do cep
         theEvent.returnValue = true;
         
         
         // pega o valor do cep
         let cep = input.value + key;

         requisitar_preenchimento_cep(cep);
         
     }


     function requisitar_preenchimento_cep(cep) {

         if(!cep) {return;}
         
         cep = cep.match(/\d+/g, '').join("");
         
         if(cep.length != 8) {return;}
         
         let url = window.location.toString().replace("solicitar", "cep/" + cep);
         console.log(url);

         fetch(url).then((resposta) => {
             return resposta.json();
         }).then((json) => {
             
             if(json.resultado != 1) {
                 // todo: erro
                 return;
             }
             
            //  document.getElementById("inputCidade").value = json.cidade;
             document.getElementById("inputBairro").value = json.bairro;
             document.getElementById("inputrua").value = json.tipo_logradouro + " " + json.logradouro;
             
         });
     }

     function funcaoVinculoComAEquipeDeSaudade(input){
        if(document.getElementById("id_div_nomeDaUnidade").style.display == "none"){
            document.getElementById("id_div_nomeDaUnidade").style.display = "block";
            document.getElementById("inputNomeUnidade").value = "";
        }else{
            document.getElementById("id_div_nomeDaUnidade").style.display = "none";
            document.getElementById("inputNomeUnidade").value = "";
            document.getElementById("inputNomeUnidade").placeholder = "Digite o nome da sua unidade (caso tenha vínculo)";
            
            
        }
        postoPara(input);
     }

     function funcaoMostrarOpcoes(input, id) {
        if(document.getElementById("divPublico_"+id).style.display == "none"){
            document.getElementById("divPublico_"+id).style.display = "block";
            document.getElementById("publico_opcao_"+id).value = "";
        }else{
            document.getElementById("divPublico_"+id).style.display = "none";
            document.getElementById("publico_opcao_"+id).value = "";
        }
        postoPara(input);
     }

     
     function selecionar_posto(posto_selecionado) {
         let id_posto = posto_selecionado.value;
         let div_seletor_horararios = document.getElementById("seletor_horario");
         div_seletor_horararios.innerHTML = "Buscando horários disponíveis...";
         let url = "http://" + document.location.host + "/horarios/" + id_posto;

         // Mágia de programação funcional
         fetch(url).then((dados) => {
             if(dados.status != 200) {
                 div_seletor_horararios.innerHTML = "Ocorreu um erro, tente novamente mais tarde";
             } else {
                 return dados.body;
             }
         }).then(rb => {
             const reader = rb.getReader();
             return new ReadableStream({
                 start(controller) {
                     function push() {
                         reader.read().then( ({done, value}) => {
                             if (done) {
                                 controller.close();
                                 return;
                             }
                             controller.enqueue(value);
                             push();
                         })
                     }
                     push();
                 }
             });
         }).then(stream => {
             return new Response(stream, { headers: { "Content-Type": "text/html" } }).text();
         }).then(result => {
             div_seletor_horararios.innerHTML = result;
         });

     }



     function selecionar_dia_vacinacao(select_dia) {
         Array.from(document.getElementsByClassName("seletor_horario_dia_div")).forEach((div) => {
             div.style.display = "none";
             let select_horarios = div.children[0].children[0].children[1];
             select_horarios.name = "";
             select_horarios.required = false;
         });

         if(!select_dia.value) {return;}
         let div = document.getElementById("seletor_horario_dia_" + select_dia.value);
         let select_horarios = div.children[0].children[0].children[1];
         div.style.display = "block";
         select_horarios.name = "horario_vacinacao";
         select_horarios.id = "horario_vacinacao";
         select_horarios.required = true;
     }
     
    function postoPara(input) {
        valor = input.checked;
        $.ajax({
            url: "{{route('postos')}}",
            method: 'get',
            type: 'get',
            statusCode: {
                404: function() {
                    alert("Nenhum posto encontrado");
                }
            },
            success: function(data){
                
                if (data != null) {
                    var option = '<option selected disabled>-- Selecione o posto --</option>';
                    if (data.length > 0) {
                        $.each(data, function(i, obj) {
                            if (obj.para_profissional_da_saude && valor) {
                                option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
                            } else if (valor == false && obj.para_idoso) {
                                option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
                            }
                        })
                    } 
                    
                    document.getElementById("posto_vacinacao").innerHTML = option;
                }
            }
        })
        
              
    }
     
    </script>


</x-guest-layout>
