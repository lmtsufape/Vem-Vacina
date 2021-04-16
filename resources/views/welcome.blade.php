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
                        <div class="container" style="padding-top: 10px;;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row" style="text-align: center;">
                                        <div class="col-md-12" style="margin-top: 20px;margin-bottom: 10px;">
                                            <img src="{{asset('/img/logo_vem_vacina.png')}}" alt="Orientação" width="300px">
                                        </div>
                                        <div class="col-md-12 style_card_apresentacao_subtitulo">A plataforma “Vem Vacina Garanhuns” é a ferramenta oficial da Secretaria de Saúde de Garanhuns, desenvolvida em parceria com a Universidade Federal do Agreste de Pernambuco, para cadastro e agendamento da vacinação contra a Covid-19.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        @if ($etapas != null)
                                            <div class="col-md-12 style_card_apresentacao_grupos_a_serem_vacinados" >GRUPOS A SEREM VACINADOS NESTA ETAPA:</div>
                                            <div class="col-md-12 style_card_apresentacao_idade">
                                                @php
                                                    $primeiro = 0;
                                                @endphp
                                                @foreach ($etapas as $i => $etapa)
                                                    @if ($etapa->exibir_na_home)
                                                        @if ($etapa->tipo == $tipos[0])
                                                            @if ($primeiro != 0) <hr> @endif
                                                            {{$etapa->inicio_intervalo}}
                                                            <span class="style_card_apresentacao_a_anos">
                                                                a
                                                            </span>{{$etapa->fim_intervalo}}
                                                            <span class="style_card_apresentacao_a_anos">
                                                                anos
                                                            </span>
                                                        @elseif($etapa->tipo == $tipos[1] || $etapa->tipo == $tipos[2])
                                                            @if ($primeiro != 0) <hr> @endif
                                                            <span class="style_card_apresentacao_a_anos" style="position: relative; bottom: 10px;">
                                                                {{$etapa->texto_home}}
                                                            </span>
                                                        @endif
                                                        @php
                                                            $primeiro++;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="col-md-12 style_card_apresentacao_grupos_a_serem_vacinados" >ETAPA ATUAL NÃO DEFINIDA</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-bottom: 32px;">
                                    <div class="row">
                                        <div class="col-md-12 style_card_apresentacao_solicitar_vacina">SOLICITAR A VACINAÇÃO</div>
                                        <div class="col-md-12 style_card_apresentacao_solicitar_vacina_subtitulo" style="text-align: justify;">O município segue em conformidade com as recomendações do Ministério da Saúde e Secretaria Estadual de Saúde (SES), para definição dos públicos prioritários.
                                            {{-- <p>
                                                <br>
                                                <strong>INFORME:</strong> O cadastro para <strong>fila de espera</strong> voltado ao público de <strong>65 a 69 anos</strong>, foi temporariamente encerrado. Todos os idosos de <strong>65 a 69 anos</strong> já cadastrados serão agendados para vacinação, de acordo com a ordem de inscrição e disponibilidade de doses. Os mesmos serão informados, através dos dados disponibilizados, sobre data, horário e local da vacinação.
                                            </p> --}}
                                        </div>
                                        @auth
                                            <a href="{{route('solicitacao.candidato')}}" class="btn btn-success style_card_apresentacao_botao" style="color:white; @if($vacinasDisponiveis == 0) pointer-events: none; background-color: rgb(107, 224, 107); border-color: rgb(107, 224, 107); @endif">@if($vacinasDisponiveis == 0)VAGAS ESGOTADAS! AGUARDE NOVA REMESSA @else QUERO SOLICITAR MINHA VACINA @endif</a>
                                        @else
                                            <a href="{{route('solicitacao.candidato')}}" class="btn btn-success style_card_apresentacao_botao" style="color:white; @if($vacinasDisponiveis == 0 || $config->botao_solicitar_agendamento) pointer-events: none; background-color: rgb(107, 224, 107); border-color: rgb(107, 224, 107); @endif" >@if($vacinasDisponiveis == 0 || $config->botao_solicitar_agendamento)VAGAS ESGOTADAS! AGUARDE NOVA REMESSA @else QUERO SOLICITAR MINHA VACINA @endif</a>
                                        @endauth
                                        @if($config->botao_fila_de_espera)
                                            <a href="{{$config->link_do_form_fila_de_espera}}" class="btn btn-danger style_card_apresentacao_botao" style="color:white;" target=”_blank”>SOLICITAR AGENDAMENTO NA LISTA DE ESPERA</a>
                                        @endif
                                        <a href="#" class="btn btn-primary style_card_apresentacao_botao" style="color:white;" data-toggle="modal" data-target="#modalChecarAgendamento">CONSULTAR AGENDAMENTO</a>
                                        {{-- <div class="col-md-12"  style="text-align: center;line-height: 19px;font-size: 15px;margin-top: 1rem;"><a href="#"  style="color: #000000;">Consultar agendamento.</a></div> --}}
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <!-- grupos a serem vacinados nesta etapa -->
                @if ($etapas != null && count($etapas) > 0)
                    @foreach ($etapas as $etapa)
                        @if ($etapa->exibir_na_home)
                            <div class="row justify-content-center">
                                <div class="col-md-9 style_card_medio">
                                    @if ($etapa->tipo == $tipos[0])
                                        <div class="card-header style_card_medio_titulo" style="border-top-left-radius: 12px;border-top-right-radius: 12px;">
                                            GRUPOS A SEREM VACINADOS NESTA ETAPA:
                                        </div>
                                        <div class="container" style="padding-top: 10px;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row style_card_divisao_horizontal" >
                                                        <div class="col-md-12 style_card_medio_conteudo">{{$etapa->inicio_intervalo}} a {{$etapa->fim_intervalo}} anos</div>
                                                        <div class="col-md-12 style_card_medio_legenda">FAIXA ETÁRIA</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row style_card_divisao style_card_divisao_horizontal" style="height: 90%;">
                                                        <div class="col-md-12 style_card_medio_conteudo">{{intval(count($etapa->candidatos)/2)}}</div>
                                                        <div class="col-md-12 style_card_medio_legenda">PESSOAS CADASTRADAS NESTA FAIXA ETÁRIA</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row style_card_divisao" style="height: 90%;">
                                                        <div class="col-md-12 style_card_medio_conteudo">{{ intval( $etapa->total_pessoas_vacinadas_pri_dose + $etapa->total_pessoas_vacinadas_seg_dose )  }}</div>
                                                        <div class="col-md-12 style_card_medio_legenda">TOTAL DE PESSOAS VACINADAS</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($etapa->tipo == $tipos[1])
                                        <div class="card-header style_card_medio_titulo" style="border-top-left-radius: 12px;border-top-right-radius: 12px;">
                                            GRUPOS A SEREM VACINADOS NESTA ETAPA:
                                        </div>
                                        <div class="container" style="padding-top: 10px;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row style_card_divisao_horizontal" >
                                                        <div class="col-md-12 style_card_medio_conteudo">
                                                            @if ($etapa->texto_home != null)
                                                                {{$etapa->texto_home}}
                                                            @else
                                                                {{$etapa->texto}}
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12 style_card_medio_legenda">PÚBLICO ALVO</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row style_card_divisao style_card_divisao_horizontal" style="height: 90%;">
                                                        <div class="col-md-12 style_card_medio_conteudo">{{intval(count($etapa->candidatos)/2)}}</div>
                                                        <div class="col-md-12 style_card_medio_legenda">PESSOAS CADASTRADAS NESTE PÚBLICO</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row style_card_divisao" style="height: 90%;">
                                                        <div class="col-md-12 style_card_medio_conteudo">{{ intval($etapa->total_pessoas_vacinadas_pri_dose + $etapa->total_pessoas_vacinadas_seg_dose) }}</div>
                                                        <div class="col-md-12 style_card_medio_legenda">TOTAL DE PESSOAS VACINADAS NESTE PÚBLICO</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($etapa->tipo == $tipos[2])
                                        <div class="card-header style_card_medio_titulo" style="border-top-left-radius: 12px;border-top-right-radius: 12px;">
                                            GRUPOS A SEREM VACINADOS NESTA ETAPA:
                                        </div>
                                        <div class="container" style="padding-top: 10px;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row style_card_divisao_horizontal" >
                                                        <div class="col-md-12 style_card_medio_conteudo">
                                                            @if ($etapa->texto_home != null)
                                                                {{$etapa->texto_home}}
                                                            @else
                                                                {{$etapa->texto}}
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12 style_card_medio_legenda">PÚBLICO ALVO</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row style_card_divisao style_card_divisao_horizontal" style="height: 90%;">
                                                        <div class="col-md-12 style_card_medio_conteudo">{{intval(count($etapa->candidatos)/2)}}</div>
                                                        <div class="col-md-12 style_card_medio_legenda">PESSOAS CADASTRADAS NESTE PÚBLICO</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row style_card_divisao" style="height: 90%;">
                                                        <div class="col-md-12 style_card_medio_conteudo">{{ intval($etapa->total_pessoas_vacinadas_pri_dose + $etapa->total_pessoas_vacinadas_seg_dose) }}</div>
                                                        <div class="col-md-12 style_card_medio_legenda">TOTAL DE PESSOAS VACINADAS NESTE PÚBLICO</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="row justify-content-center">
                        <div class="col-md-9 style_card_medio">
                            <div class="card-header style_card_medio_titulo" style="border-top-left-radius: 12px;border-top-right-radius: 12px;">
                                ETAPA ATUAL NÃO DEFINIDA
                            </div>
                            <div class="container" style="padding-top: 10px;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row style_card_divisao_horizontal" >
                                            <div class="col-md-12 style_card_medio_conteudo">ETAPA ATUAL NÃO DEFINIDA</div>
                                            <div class="col-md-12 style_card_medio_legenda">FAIXA ETÁRIA</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row style_card_divisao style_card_divisao_horizontal" style="height: 90%;">
                                            <div class="col-md-12 style_card_medio_conteudo">ETAPA ATUAL NÃO DEFINIDA</div>
                                            <div class="col-md-12 style_card_medio_legenda">PESSOAS CADASTRADAS NESTA FAIXA ETÁRIA</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row style_card_divisao" style="height: 90%;">
                                            <div class="col-md-12 style_card_medio_conteudo">ETAPA ATUAL NÃO DEFINIDA</div>
                                            <div class="col-md-12 style_card_medio_legenda">TOTAL DE PESSOAS VACINADAS</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="container" style="margin-bottom: 2rem;">
                <div class="row justify-content-center">
                    <!-- pessoas cadastradas -->
                    <div class="style_card_menor">
                        <div class="card_menor">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">PESSOAS CADASTRADAS</div>
                            <div class="container" style="padding-top: 10px;;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 style_card_menor_conteudo">{{intval($quantPessoasCadastradas/2)}}</div>
                                            <div class="col-md-12 style_card_menor_legenda">TOTAL</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- primeira dose -->
                    <div class="style_card_menor">
                        <div class="card_menor">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">1º DOSE</div>
                            <div class="container" style="padding-top: 10px;;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 style_card_menor_conteudo">{{ intval($quantPessoasPriDose) }}</div>
                                            <div class="col-md-12 style_card_menor_legenda">TOTAL DE PESSOAS VACINADAS</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- segunda dose -->
                    <div class="style_card_menor">
                        <div class="card_menor">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">2º DOSE</div>
                            <div class="container" style="padding-top: 10px;;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 style_card_menor_conteudo">{{ intval($quantPessoasSegDose) }}</div>
                                            <div class="col-md-12 style_card_menor_legenda">TOTAL DE PESSOAS VACINADAS</div>
                                        </div>
                                    </div>
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
                        <div class="col-12" style="margin-bottom: 45px; color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;"><img src="{{asset('img/logo_rede_sociais.png')}}" alt="LMTS" width="20px"> Redes Sociais</div>
                        <a href="https://www.facebook.com/PrefeituradeGaranhuns/" target="_blank"><img src="{{asset('img/facebook.png')}}" alt="LMTS" width="55px"> </a>
                        <a href="https://twitter.com/garanhunspref" target="_blank"><img src="{{asset('img/twitter.png')}}" alt="LMTS" width="55px"> </a>
                        <a href="https://www.instagram.com/prefgaranhuns/" target="_blank"><img src="{{asset('img/instagram.png')}}" alt="LMTS" width="55px"> </a>
                        <a href="https://www.youtube.com/channel/UCHNqCIPyK42cjWUgO85C7Yg" target="_blank"><img src="{{asset('img/youtube.png')}}" alt="LMTS" width="43px" height="43x" style="margin-top: 4.5px;margin-left: 4px;"></a>
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group justify-content-center" style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                        <div style="color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;"><img src="{{asset('img/logo_fale_conosco.png')}}" alt="LMTS" width="15px"> Fale Conosco</div>
                        <div style="color:#fff; font-size: 30px; font-weight: 600; font-family: Arial, Helvetica, sans-serif; margin-top:20px">(87) 3762-1252</div>
                        <div style="color:#fff; font-size: 18px; font-weight: 100; font-family: Arial, Helvetica, sans-serif; margin-top:6px">agendamentovacinacovidgus@gmail.com</div>

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
    </body>
    <!-- Modal checar agendamento -->
    <div class="modal fade" id="modalChecarAgendamento" tabindex="-1" aria-labelledby="modalChecarAgendamentoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalChecarAgendamentoLabel"><div class="col-md-12 style_titulo_campo">Consultar agendamento</div></h5>
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
                                <label for="inputCPF" class="style_titulo_input">CPF <span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                <input type="text" class="form-control style_input cpf @error('cpf') is-invalid @enderror" id="inputCPF" placeholder="Ex.: 000.000.000-00" name="cpf" value="{{old('cpf')}}">

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
                                <label for="inputData" class="style_titulo_input">DATA DE NASCIMENTO <span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                <input type="date" class="form-control style_input @error('data_de_nascimento') is-invalid @enderror" id="inputData" placeholder="dd/mm/aaaa" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" name="data_de_nascimento" value="{{old('data_de_nascimento')}}">

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
                                <button type="submit" class="btn btn-success" style="width: 100%;" form="consultar_agendamento">Consultar</button>
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
            $(document).ready(function() {
                $("#modalChecarAgendamento").modal('show');
            });
        </script>
    @endif
</x-guest-layout>
