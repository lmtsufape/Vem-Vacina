<x-guest-layout>
    <body style="background-color: #FBFBFB;">
    <div style="padding-bottom: 0rem;padding-top: 1rem;; margin-top: -15%;">
        <img src="{{asset('/img/cabecalho_1.png')}}" alt="Orientação" width="100%">
        <div class="container">
            <img src="{{asset('/img/cabecalho_2.png')}}" alt="Orientação" width="100%">
        </div>
    </div>
    <div class="container" style="margin-bottom: 1rem;;">
        <div class="row justify-content-center">
            <!-- covid-19 programa de vacinacao -->
            <div class="col-md-9 style_card_apresentacao">
                @if ($agendamentos != null && count($agendamentos) > 0)
                    <div class="container" style="padding-top: 10px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" style="text-align: center;">
                                    <div class="col-md-12" style="margin-top: 20px;margin-bottom: 10px;">
                                        <img src="{{asset('/img/logo_vem_vacina.png')}}" alt="Orientação" width="300px">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 style_titulo_campo" style="font-size: 32px;">{{$status}}</div>
                                    <div class="col-md-12">
                                        <hr class="style_linha_campo">
                                    </div>
                                    <div class="col-md-12"
                                         style="font-size: 15px; margin-bottom: 15px; text-align: justify;">
                                        <p>
                                            Sr(a) {{$agendamentos[0]->nome_completo}},
                                        </p>
                                        {{-- {{dd($agendamentos[0]->aprovacao)}} --}}
                                        @if($agendamentos[0]->aprovacao == $aprovacao_enum[0] && $agendamentos[0]->chegada == null )
                                            <p>
                                                @if (env('ATIVAR_FILA', false) == true)
                                                    Informamos que a sua solicitação foi recebida com sucesso e será
                                                    <strong>PROCESSADA</strong>. Aguarde a confirmação da Secretaria de
                                                    Saúde,indicando
                                                    agendamento com data, local e horário para vacinação.
                                                @else
                                                    Informamos que a sua solicitação de agendamento para vacinação foi
                                                    recebida com sucesso e se encontra na
                                                    <strong>FILA DE ESPERA</strong>.
                                                @endif


                                            </p>

                                        @elseif($agendamentos[0]->aprovacao == $aprovacao_enum[1])
                                            <p>
                                                Informamos que a sua solicitação de agendamento para vacinação foi
                                                <strong>APROVADA</strong> pela Secretaria Municipal de Saúde de
                                                Garanhuns - PE.
                                            </p>
                                            @if($agendamentos[0]->posto->nome != 'Domicílio')
                                                <p>
                                                    A seguir, encontram-se o dia, horário e local de aplicação da
                                                    primeira e segunda dose para que registre ou imprima:
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <span class="style_titulo_input" style="font-size: 32px;">Sr(a). <span class="style_titulo_campo" style="font-size: 32px;">{{$agendamentos[0]->nome_completo}}</span>, anote as informações para não esquecer!</span>
                            </div>
                        </div> --}}
                        @foreach($agendamentos as $agendamento)
                            @if(isset($agendamento->posto->nome) && $agendamento->posto->nome == 'Domicílio' && $agendamento->dose != "2ª Dose")
                                <div class="justify-content-center destaque-pri-dose">
                                    <div class="row">
                                        <div class="col-md-12">{{$agendamento->dose}}</div>
                                        {{-- <div class="col-md-6">Status: {{$agendamentos[0]->aprovacao}}</div> --}}
                                        <div class="col-md-12">
                                            <hr class="style_linha_dose">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            Local:
                                            {{$agendamento->posto->nome}}
                                        </div>
                                    </div>
                                </div>
                            @elseif(isset($agendamento->posto->nome))
                                <div class="justify-content-center destaque-pri-dose">
                                    <div class="row">
                                        @if($agendamento->dose == "1ª Dose")
                                            <div class="col-md-12">1ª Dose</div>
                                        @elseif($agendamento->dose == "2ª Dose")
                                            <div class="col-md-12">2ª Dose</div>
                                        @elseif($agendamento->dose == "3ª Dose")
                                            <div class="col-md-12">DOSE DE REFORÇO</div>
                                        @elseif($agendamento->dose == "4ª Dose")
                                            <div class="col-md-12">SEGUNDA DOSE DE REFORÇO</div>
                                        @elseif($agendamento->dose_id != null)
                                            <div class="col-md-12">{{$agendamento->getDose->nome}}</div>
                                        @else
                                            <div class="col-md-12">DOSE ÚNICA</div>
                                        @endif
                                        {{-- <div class="col-md-6">Status: {{$agendamentos[0]->aprovacao}}</div> --}}
                                        <div class="col-md-12">
                                            <hr class="style_linha_dose">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            Local<br>
                                            {{$agendamento->posto->nome}}
                                        </div>
                                        <div class="col-md-3">
                                            Data<br>
                                            {{date('d/m/Y',strtotime($agendamento->chegada))}}
                                        </div>
                                        <div class="col-md-3">
                                            Hora<br>
                                            {{date('H:i',strtotime($agendamento->chegada))}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if($agendamentos[0]->aprovacao == $aprovacao_enum[0])
                            <br>
                            <div class="row" style="text-align: justify;">
                                <div class="col-md-12">A verificação da confirmação, ou não, de seu agendamento poderá
                                    ser realizada de três formas: a) por meio do próprio site, no campo
                                    "Consultar
                                    agendamento"; b) por comunicação feito por e-mail, caso tenha cadastrado; c) por
                                    comunicação feita no Whatsapp, caso tenha cadastrado.
                                </div>
                            </div>
                        @endif
                        <div class="row" style="text-align: center;">
                            <div class="col-md-12">
                                <span class="style_titulo_campo" style="font-size: 32px;">AVISO</span>
                            </div>
                        </div>
                        @if($agendamentos[0]->aprovacao == $aprovacao_enum[0])
                            <div class="row" style="text-align: justify;">
                                <div class="col-md-12">Além disso, fica atento a seu e-mail, whatsapp ou telefone, para
                                    a confirmação do agendamento por parte da Secretaria de Saúde. Ou caso
                                    prefira,
                                    acesse novamente a página principal do sistema, e clique em "Consultar agendamento"
                                </div>
                            </div>
                            <br>
                            <div class="row" style="text-align: center;">
                                <div class="col-md-12">Nós não iremos, em momento algum, solicitar dados de cartão de
                                    crédito, senhas bancárias ou quaisquer confirmações por SMS. Cuidado com
                                    golpes!
                                </div>
                            </div>
                        @elseif($agendamentos[0]->aprovacao == $aprovacao_enum[1])
                            <div class="row" style="text-align: justify;">
                                <div class="col-md-12">Lembramos que para que seja realização a aplicação da vacina,
                                    deve-se apresentar documento de identificação com foto (RG/CPF), cartão do SUS
                                    e
                                    comprovante de residência no nome da pessoa que vai ser vacinada.<br><br>
                                    Em caso de crianças com comorbidade, a Secretaria de Saúde solicita a apresentação
                                    de documento oficial com foto e CPF dos pais ou responsáveis; cartão do SUS
                                    (CNS), cartão de vacina da criança, laudo médico indicando a comorbidade, além da
                                    presença do pai ou responsável legal no ato da vacinação.
                                </div>
                            </div>
                        @endif
                        <br>
                        <div class="row" style="text-align: justify;">
                            <div class="col-md-12">Agradecemos a sua atenção e ficamos à disposição para outros
                                esclarecimentos que sejam necessários!
                            </div>
                        </div>
                        <br>
                        <div class="row" style="text-align: justify;">
                            <div class="col-md-12">Secretaria Municipal de Saúde (Garanhuns - PE)</div>
                        </div>
                        <hr class="style-linha-divisora-red">
                        <div class="row">
                            <div class="col-md-12 style_titulo_campo"><span
                                    style="font-size: 28px;">Outras informações</span></div>
                        </div>
                        <br>
                        <div class="row" style="text-align: justify;">
                            <div class="col-md-12">
                                <p>
                                    Para outras informações ou dúvidas não sanadas nos canais acima, tais como:
                                    dificuldades ou problemas técnicos para uso no sistema, esclarecimento de dúvidas
                                    quanto
                                    a faixa etária, favor entrar em contato pelo e-mail, telefone ou whatsapp
                                    disponibilizados:
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="style_titulo_input">E-mail:</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                agendamentovacinacovidgus@gmail.com
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="style_titulo_input">Telefones / Whatsapp:</span>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 32px;">
                            <div class="col-md-12">
                                (87) 3762-1252<br>
                                (87) 9.8835-4998 (Whatsapp)
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <!-- rodapé -->
    <div style="background-color:#313561; display: flex; flex-wrap: wrap;">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <div class="row justify-content-center"
                         style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                        <div class="col-12"
                             style="margin-bottom: 45px; color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;">
                            <img src="{{asset('img/logo_rede_sociais.png')}}"
                                 alt="LMTS" width="20px"> Redes Sociais
                        </div>
                        <a href="https://www.facebook.com/PrefeituradeGaranhuns/" target="_blank"><img
                                src="{{asset('img/facebook.png')}}" alt="LMTS" width="55px"> </a>
                        <a href="https://twitter.com/garanhunspref" target="_blank"><img
                                src="{{asset('img/twitter.png')}}" alt="LMTS" width="55px"> </a>
                        <a href="https://www.instagram.com/prefgaranhuns/" target="_blank"><img
                                src="{{asset('img/instagram.png')}}" alt="LMTS" width="55px"> </a>
                        <a href="https://www.youtube.com/channel/UCHNqCIPyK42cjWUgO85C7Yg" target="_blank"><img
                                src="{{asset('img/youtube.png')}}" alt="LMTS" width="43px" height="43x"
                                style="margin-top: 4.5px;margin-left: 4px;"></a>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group justify-content-center"
                         style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                        <div style="color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;"><img
                                src="{{asset('img/logo_fale_conosco.png')}}" alt="LMTS" width="15px"> Fale Conosco
                        </div>
                        <div
                            style="color:#fff; font-size: 30px; font-weight: 600; font-family: Arial, Helvetica, sans-serif; margin-top:20px">
                            (87) 3762-1252
                        </div>
                        <div
                            style="color:#fff; font-size: 18px; font-weight: 100; font-family: Arial, Helvetica, sans-serif; margin-top:6px">
                            agendamentovacinacovidgus@gmail.com
                        </div>

                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group justify-content-center"
                         style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                        <div style="color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;">Desenvolvido
                            por:
                        </div>
                        <div class="btn-group">
                            <div style="margin-top: 21px;margin-right: 15px;"><a href="http://ufape.edu.br/"
                                                                                 target="_blank"><img
                                        src="{{asset('img/logo_ufape.png')}}" alt="LMTS" width="165px"> </a>
                            </div>
                            <div style="margin-top: 35px;"><a href="http://lmts.uag.ufrpe.br/" target="_blank"><img
                                        src="{{asset('img/logo_lmts.png')}}" alt="LMTS" width="140px"> </a></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="text-align: center; margin-bottom: 2rem;margin-top: 1rem;">
                    <a href="https://garanhuns.pe.gov.br/mapa-do-site/" target="_blank"
                       style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">MAPA DO SITE</a>
                    <a href="https://garanhuns.pe.gov.br/teclas-de-acessibilidade/" target="_blank"
                       style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">TECLAS DE
                        ACESSIBILIDADE</a>
                    <a href="https://garanhuns.pe.gov.br/telefones-uteis/" target="_blank"
                       style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">TELEFONES
                        ÚTEIS</a>

                </div>
            </div>
        </div>
    </div>

    <!--x rodapé x-->
    </body>
    <!-- Modal checar agendamento -->
    <div class="modal fade" id="modalChecarAgendamento" tabindex="-1" aria-labelledby="modalChecarAgendamentoLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalChecarAgendamentoLabel">
                        <div class="col-md-12 style_titulo_campo">Consultar agendamento</div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="consultar_agendamento" action="{{route('agendamento.consultar')}}" method="POST">
                        @csrf
                        <div class="container">
                            <input type="hidden" name="consulta" value="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="inputCPF" class="style_titulo_input">CPF <span
                                            class="style_subtitulo_input">*(obrigatório)</span> </label>
                                    <input type="text"
                                           class="form-control style_input cpf @error('cpf') is-invalid @enderror"
                                           id="inputCPF" placeholder="Ex.: 000.000.000-00" name="cpf"
                                           value="{{old('cpf')}}">

                                    @error('cpf')
                                    <div id="validationServer05Feedback" class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    {{-- <label for="dose" class="style_titulo_input">QUAL A DOSE? <span class="style_subtitulo_input">*(obrigatório)</span></label>
                                    <select id="dose" class="form-control style_input @error('dose') is-invalid @enderror" name="dose" required>
                                        <option selected disabled>-- Selecione a dose --</option>
                                        <option @if(old('dose') == $doses[0]) selected @endif value="{{$doses[0]}}">{{$doses[0]}}</option>
                                        <option @if(old('dose') == $doses[1]) selected @endif value="{{$doses[1]}}">{{$doses[1]}}</option>
                                    </select>

                                    @error('dose')
                                    <div id="validationServer05Feedback" class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                    @enderror --}}
                                    <label for="inputData" class="style_titulo_input">DATA DE NASCIMENTO <span
                                            class="style_subtitulo_input">*(obrigatório)</span> </label>
                                    <input type="date"
                                           class="form-control style_input @error('data_de_nascimento') is-invalid @enderror"
                                           id="inputData" placeholder="dd/mm/aaaa"
                                           pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" name="data_de_nascimento"
                                           value="{{old('data_de_nascimento')}}">

                                    @error('data_de_nascimento')
                                    <div id="validationServer05Feedback" class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success" style="width: 100%;"
                                            form="consultar_agendamento">Consultar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim modal checar agendamento -->
    @if (old('consulta') != null)
        <script>
            $(document).ready(function () {
                $("#modalChecarAgendamento").modal('show');
            });
        </script>
    @endif
</x-guest-layout>
