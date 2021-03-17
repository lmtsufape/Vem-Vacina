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
                                        <div class="col-md-12 style_card_apresentacao_subtitulo">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 style_card_apresentacao_grupos_a_serem_vacinados" >GRUPOS A SEREM VACINADOS NESTA ETAPA:</div>
                                        <div class="col-md-12 style_card_apresentacao_idade">80<span class="style_card_apresentacao_a_anos"> à </span>85<span class="style_card_apresentacao_a_anos"> anos</span></div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-bottom: 32px;">
                                    <div class="row">
                                        <div class="col-md-12 style_card_apresentacao_solicitar_vacina">SOLICITAR A VACINAÇÃO</div>
                                        <div class="col-md-12 style_card_apresentacao_solicitar_vacina_subtitulo">Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI.</div>
                                        <a href="{{route('solicitacao.candidato')}}" class="btn btn-success style_card_apresentacao_botao" style="color:white;">QUERO SOLICITAR MINHA VACINA</a>
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
                    <div class="card-header style_card_medio_titulo" style="border-top-left-radius: 12px;border-top-right-radius: 12px;">GRUPOS A SEREM VACINADOS NESTA ETAPA:</div>
                        <div class="container" style="padding-top: 10px;;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row style_card_divisao_horizontal" >
                                        <div class="col-md-12 style_card_medio_conteudo">80 à 85 anos</div>
                                        <div class="col-md-12 style_card_medio_legenda">FAIXA ETÁRIA</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row style_card_divisao style_card_divisao_horizontal" style="height: 90%;">
                                        <div class="col-md-12 style_card_medio_conteudo">254</div>
                                        <div class="col-md-12 style_card_medio_legenda">PESSOAS CADASTRADAS NESTA FAIXA ETÁRIA</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row style_card_divisao" style="height: 90%;">
                                        <div class="col-md-12 style_card_medio_conteudo">102</div>
                                        <div class="col-md-12 style_card_medio_legenda">TOTAL DE PESSOAS VACINADAS</div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
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
                                            <div class="col-md-12 style_card_menor_conteudo">6534</div>
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
                                            <div class="col-md-12 style_card_menor_conteudo">4365</div>
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
                                            <div class="col-md-12 style_card_menor_conteudo">1434</div>
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
</x-guest-layout>