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
                                            <img src="{{asset('/img/logo_programa_1.png')}}" alt="Orientação" width="300px"> 
                                        </div>
                                        <div class="col-md-12 style_card_apresentacao_subtitulo">A campanha de vacinação contra a Covid-19 segue atualmente em Garanhuns, para idosos acima de 75 anos e trabalhadores da saúde.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        @if ($etapa != null)
                                            <div class="col-md-12 style_card_apresentacao_grupos_a_serem_vacinados" >GRUPOS A SEREM VACINADOS NESTA ETAPA:</div>
                                            <div class="col-md-12 style_card_apresentacao_idade">{{$etapa->inicio_intervalo}}<span class="style_card_apresentacao_a_anos"> à </span>{{$etapa->fim_intervalo}}<span class="style_card_apresentacao_a_anos"> anos</span></div>
                                        @else
                                            <div class="col-md-12 style_card_apresentacao_grupos_a_serem_vacinados" >ETAPA ATUAL NÃO DEFINIDA</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-bottom: 32px;">
                                    <div class="row">
                                        <div class="col-md-12 style_card_apresentacao_solicitar_vacina">SOLICITAR A VACINAÇÃO</div>
                                        <div class="col-md-12 style_card_apresentacao_solicitar_vacina_subtitulo" style="text-align: justify;">O município segue em conformidade com as recomendações do Ministério da Saúde e Secretaria Estadual de Saúde (SES), para definição dos públicos prioritários.</div>
                                        <a href="{{route('solicitacao.candidato')}}" class="btn btn-success style_card_apresentacao_botao" style="color:white;">QUERO SOLICITAR MINHA VACINA</a>
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
                <div class="row justify-content-center">
                    <!-- grupos a serem vacinados nesta etapa -->
                    <div class="col-md-9 style_card_medio">
                    @if ($etapa != null)
                        <div class="card-header style_card_medio_titulo" style="border-top-left-radius: 12px;border-top-right-radius: 12px;">GRUPOS A SEREM VACINADOS NESTA ETAPA:</div>
                            <div class="container" style="padding-top: 10px;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row style_card_divisao_horizontal" >
                                            <div class="col-md-12 style_card_medio_conteudo">{{$etapa->inicio_intervalo}} à {{$etapa->fim_intervalo}} anos</div>
                                            <div class="col-md-12 style_card_medio_legenda">FAIXA ETÁRIA</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row style_card_divisao style_card_divisao_horizontal" style="height: 90%;">
                                            <div class="col-md-12 style_card_medio_conteudo">{{count($etapa->candidatos)}}</div>
                                            <div class="col-md-12 style_card_medio_legenda">PESSOAS CADASTRADAS NESTA FAIXA ETÁRIA</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row style_card_divisao" style="height: 90%;">
                                            <div class="col-md-12 style_card_medio_conteudo">{{$etapa->total_pessoas_vacinadas_pri_dose + $etapa->total_pessoas_vacinadas_seg_dose}}</div>
                                            <div class="col-md-12 style_card_medio_legenda">TOTAL DE PESSOAS VACINADAS</div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    @else 
                        <div class="card-header style_card_medio_titulo" style="border-top-left-radius: 12px;border-top-right-radius: 12px;">ETAPA ATUAL NÃO DEFINIDA</div>
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
                    @endif
                </div>
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
                                            <div class="col-md-12 style_card_menor_conteudo">{{$quantPessoasCadastradas}}</div>
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
                                            <div class="col-md-12 style_card_menor_conteudo">{{$quantPessoasPriDose}}</div>
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
                                            <div class="col-md-12 style_card_menor_conteudo">{{$quantPessoasSegDose}}</div>
                                            <div class="col-md-12 style_card_menor_legenda">TOTAL DE PESSOAS VACINADAS</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9"  style="text-align: center;line-height: 19px;font-size: 15px;margin-top: 1rem;margin-bottom: 2rem;"><a href="http://lmts.uag.ufrpe.br/" style="color: #909090;">Programa de vacinação criado pelo Laboratório Multidisciplinar de Tecnologias Sociais - LMTS com o apoio da Universidade Federal do Agreste de Pernambuco - UFAPE.</a></div>
                </div>
            </div>


        <!-- rodapé -->
        <div style="background-color:#BDC3C7; display: flex; flex-wrap: wrap; justify-content: center;padding-bottom:5rem">
            <div class="row" style="margin-top:1rem;text-align:center">
                <hr class="col-md-12" size = 7 style="background-color:#fff">
                <div class="col-md-4">
                    <div class="row justify-content-center" style="text-align:center; margin-bottom:2rem;">
                        <div class="col-12" style="margin-bottom: 10px; color:#fff;">Desenvolvido por:</div>
                        <img src="{{asset('/img/logo_lmts_p_branco.png')}}" alt="LMTS" width="200px"> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row justify-content-center" style="text-align:center; margin-bottom:2rem;">
                        <div class="col-12" style="color:#fff;">Apoio:</div>
                        <img src="{{asset('/img/logo_ufape_branco.png')}}" alt="UFAPE" width="240px"> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row justify-content-center" style="text-align:center">
                        <div class="col-12" style="margin-bottom: 2rem; color:#fff;">Redes sociais:</div>
                        <img src="{{asset('/img/logo_facebook_branco.png')}}" width="40px" height="40px" style="margin-left: 10px; margin-right: 10px;">
                        <img src="{{asset('/img/logo_instagram_branco.png')}}" width="40px" height="40px" style="margin-left: 10px; margin-right: 10px;">
                        <img src="{{asset('/img/logo_twitter_branco.png')}}" width="40px" height="40px" style="margin-left: 10px; margin-right: 10px;">
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
                                <label for="inputCPF" class="style_titulo_input">CPF <span class="style_subtitulo_input">(obrigatório)</span> </label>
                                <input type="text" class="form-control style_input cpf @error('cpf') is-invalid @enderror" id="inputCPF" placeholder="Ex.: 000.000.000-00" name="cpf" value="{{old('cpf')}}">
                            
                                @error('cpf')
                                <div id="validationServer05Feedback" class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="dose" class="style_titulo_input">QUAL A DOSE? <span class="style_subtitulo_input">(obrigatório)</span></label>
                                <select id="dose" class="form-control style_input @error('dose') is-invalid @enderror" name="dose" required>
                                    <option selected disabled>-- Selecione a dose --</option>
                                    <option @if(old('dose') == $doses[0]) selected @endif value="{{$doses[0]}}">{{$doses[0]}}</option>
                                    <option @if(old('dose') == $doses[1]) selected @endif value="{{$doses[1]}}">{{$doses[1]}}</option>
                                </select>
                                
                                @error('dose')
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